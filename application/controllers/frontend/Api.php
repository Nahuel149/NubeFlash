<?php

class Api extends CI_Controller {

	private $email_config;

	function __construct() {
		parent::__construct();
		// Disable CSRF for API endpoints
		$this->config->set_item('csrf_protection', FALSE);
		
		// Set CORS headers
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");

		$method = $_SERVER['REQUEST_METHOD'];

		// Handle preflight requests
		if ($method == "OPTIONS") {
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
			header("HTTP/1.1 200 OK");
			die();
		}

		$this->load->model('tariff_model','tariff');
		$this->load->model('order_model','order');

		// Load email configurations
		$this->email_config = [
			'remitente' => $this->codegen_model->row('configurations', 'value', 'key_id = "remitente"'),
			'email_pedidos' => $this->codegen_model->row('configurations', 'value', 'key_id = "email_pedidos"'),
			'email_admin' => $this->codegen_model->row('configurations', 'value', 'key_id = "email"')
		];
	}	

	/**
	 * Get email configuration value safely
	 */
	private function get_email_config($key) {
		if (isset($this->email_config[$key]) && is_object($this->email_config[$key])) {
			return $this->email_config[$key]->value;
		}
		// Return default values if configuration is missing
		switch ($key) {
			case 'remitente':
				return 'La Nube';
			case 'email_pedidos':
			case 'email_admin':
				return CORREO_QA;
			default:
				return null;
		}
	}

    public function getCustomer()
    {
        $data = json_decode(file_get_contents('php://input'));

        $response = array(
            'success' => false,
            'data' => array()
        );
        $user = $data->user;
        $token = $data->token;

        $customer = $this->codegen_model->row('customers','*','email = "'.$user.'" AND active = "'.ACTIVE.'"');
        if($customer)
        {
            $validate_token = $this->codegen_model->row('token_customers','*','token = "'.$token.'" AND customer_id = "'.$customer->customer_id.'"');
            if($validate_token)
            {
                $response['success'] = true;
                $response['data']['customer'] = $customer;
            }else{
                $response['success'] = false;
                $response['data']['message'] = 'Token is invalid';
            }
        }else{
            $response['success'] = false;
            $response['data']['message'] = 'Client no exists';
        }

        header('Content-Type: application/json');

		echo json_encode($response, JSON_PRETTY_PRINT);

    }

    public function getShippingCost()
    {
        header('Content-Type: application/json');
        
        $raw_input = file_get_contents('php://input');
        error_log('Raw input: ' . $raw_input);
        
        $data = json_decode($raw_input);
        error_log('Decoded data: ' . print_r($data, true));
        
        $response = array(
            'status' => 'Error',
            'data' => array(),
        );
        
        if ($data === null) {
            $response['data']['message'] = 'Invalid JSON data received';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }
        
        #required 
        $token = isset($data->token) ? $data->token : null;
        $postalCode = isset($data->data_client->postal_code) ? $data->data_client->postal_code : null;
        
        if (!$token || !$postalCode) {
            $response['data']['message'] = 'Missing required fields: token or postal_code';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        // Verificar el token
        $validateToken = $this->codegen_model->row('token_customers','*','token = "'.$token.'"');
        if($validateToken) {
            // Convert direct dimensions to items array format
            $volume = isset($data->volume) ? floatval($data->volume) : 0;
            $weight = isset($data->weight) ? floatval($data->weight) : 0;
            
            if ($volume > 0 && $weight > 0) {
                // Calculate volume from dimensions if provided
                $calculated_volume = 0;
                if (isset($data->long) && isset($data->width) && isset($data->high)) {
                    $calculated_volume = floatval($data->long) * floatval($data->width) * floatval($data->high);
                }

                // Verify volume matches if dimensions were provided
                if ($calculated_volume > 0 && $calculated_volume != $volume) {
                    $response['status'] = 'Error';
                    $response['data']['message'] = 'Lanubeflash response: Volume Invalid';
                    echo json_encode($response, JSON_PRETTY_PRINT);
                    return;
                }

                // Get customer
                $customer = $this->codegen_model->row('customers','*','customer_id = "'.$validateToken->customer_id.'"');
                
                // Search for tariff
                $tariff = $this->tariff->getShippingCost([
                    'postal_code' => $postalCode,
                    'weight' => $weight,
                    'volume' => $volume,
                ]);

                if ($tariff) {
                    if ($tariff->country_id == $customer->country_id) {
                        $response['status'] = 'Success';
                        $response['data']['price_item'] = $tariff->tariff_price;
                    } else {
                        $response['status'] = 'Error';
                        $response['data']['message'] = "Lanubeflash response: Country doesn't match";
                    }
                } else {
                    $response['status'] = 'Error';
                    $response['data']['message'] = 'Lanubeflash response: Tariff no exists';
                }
            } else {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Invalid weight or volume';
            }
        } else {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Token is invalid';
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function sendOrder() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'));

        $response = array(
            'status' => 'Error',
            'data' => array()
        );
        
        if ($data === null) {
            $response['data']['message'] = 'Invalid JSON data received';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }
        
        $token = isset($data->token) ? $data->token : null;
        $postalCode = isset($data->data_client->postal_code) ? $data->data_client->postal_code : null;

        if (!$token || !$postalCode) {
            $response['data']['message'] = 'Missing required fields: token or postal_code';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        // Updated validation to check both token existence and active status
        $validateToken = $this->codegen_model->row('token_customers','*','token = "'.$token.'" AND active = 1');
        if($validateToken) {
            // Convert direct dimensions to items array format for backwards compatibility
            $volume = isset($data->volume) ? floatval($data->volume) : 0;
            $weight = isset($data->weight) ? floatval($data->weight) : 0;
            
            if ($volume > 0 && $weight > 0) {
                // Calculate volume from dimensions if provided
                $calculated_volume = 0;
                if (isset($data->long) && isset($data->width) && isset($data->high)) {
                    $calculated_volume = floatval($data->long) * floatval($data->width) * floatval($data->high);
                }

                // Verify volume matches if dimensions were provided
                if ($calculated_volume > 0 && $calculated_volume != $volume) {
                    $response['status'] = 'Error';
                    $response['data']['message'] = 'Lanubeflash response: Volume Invalid';
                    echo json_encode($response, JSON_PRETTY_PRINT);
                    return;
                }

                // Create single item array for backwards compatibility
                $items = array([
                    'long' => isset($data->long) ? floatval($data->long) : 0,
                    'high' => isset($data->high) ? floatval($data->high) : 0,
                    'width' => isset($data->width) ? floatval($data->width) : 0,
                    'weight' => $weight,
                    'qty' => 1
                ]);

                // Get tariff
                $tariff = $this->tariff->getShippingCost([
                    'postal_code' => $postalCode,
                    'weight' => $weight,
                    'volume' => $volume,
                ]);
                
                if($tariff) {
                    // Generate order number
                    $order_number = 'ORD-' . date('Ymd') . '-' . substr(uniqid(), -8);
                    
                    // Create order
                    $data_orden = array(
                        'customer_id' => $validateToken->customer_id,
                        'tariff_id' => $tariff->tariff_id,
                        'order_number' => $order_number,
                        'items' => json_encode($items),
                        'client'=> $data->data_client->client,
                        'reference'=> $data->data_client->reference,
                        'shipping_data'=> json_encode($data->data_client->shipping_data),
                        'postal_code' => $postalCode,
                        'weight' => $weight,
                        'volume' => $volume,
                        'status_id' => PENDING,
                    );
                    $order_id = $this->order->insert($data_orden);
                    
                    // Send emails
                    $customer = $this->codegen_model->row('customers','*','customer_id = "' . $validateToken->customer_id . '"');

                    try {
                        $data_envio = [
                            'title' => 'Nuevo pedido',
                            'client' => $data_orden['client'],
                            'postal_code' => $data_orden['postal_code'],
                            'volume' => $data_orden['volume'],
                            'weight' => $data_orden['weight'],
                            'store' => $data->data_client->shipping_data->store->name,
                            'email' => $data->data_client->shipping_data->email,
                            'province' => $data->data_client->shipping_data->province,
                            'city' => $data->data_client->shipping_data->city,
                            'address' => $data->data_client->shipping_data->address,
                            'telephone' => $data->data_client->shipping_data->telephone,
                            'price' => $tariff->tariff_price
                        ];

                        $remitente = $this->get_email_config('remitente');
                        $email_pedidos = $this->get_email_config('email_pedidos');
                        $email_admin = $this->get_email_config('email_admin');

                        // Send emails with error handling
                        try {
                            // Send to customer
                            $this->frontend_lib->enviarEmail(
                                $data_envio,
                                'frontend/email/nuevo_pedido',
                                'Nuevo pedido',
                                $customer->email,
                                CORREO_QA,
                                $remitente
                            );

                            // Send to orders email
                            if ($email_pedidos) {
                                $this->frontend_lib->enviarEmail(
                                    $data_envio,
                                    'frontend/email/nuevo_pedido',
                                    'Nuevo pedido',
                                    $email_pedidos,
                                    CORREO_QA,
                                    $remitente
                                );
                            }

                            // Send to admin
                            if ($email_admin) {
                                $data_envio['message'] = 'Se ha realizado un nuevo pedido';
                                $this->frontend_lib->enviarEmail(
                                    $data_envio,
                                    'frontend/email/nuevo_pedido',
                                    'Nuevo pedido',
                                    $email_admin,
                                    CORREO_QA,
                                    $remitente
                                );
                            }
                        } catch (Exception $e) {
                            // Log email error but don't stop the order process
                            log_message('error', 'Error sending order emails: ' . $e->getMessage());
                        }

                        // Response
                        $response['status'] = 'Success';
                        $response['data']['code_tracking'] = sha1($order_id.'lanube-envios');
                    } catch (Exception $e) {
                        $response['status'] = 'Error';
                        $response['data']['message'] = 'Error processing order: ' . $e->getMessage();
                    }
                } else {
                    $response['status'] = 'Error';
                    $response['data']['message'] = 'Lanubeflash response: Tariff no exists';
                }
            } else {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Invalid weight or volume';
            }
        } else {
            // Check if token exists but is inactive
            $inactiveToken = $this->codegen_model->row('token_customers','*','token = "'.$token.'" AND active = 0');
            if ($inactiveToken) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Token has been revoked';
            } else {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Token is invalid';
            }
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}