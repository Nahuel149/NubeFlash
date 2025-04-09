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

    /**
     * Validates a token against the token_customers table
     * Checks both full token strings and hash parts
     * 
     * @param string $submitted_token The token to validate
     * @return array An array with status ('valid', 'revoked' or 'invalid') and token record if found
     */
    private function _validateApiToken($submitted_token) {
        // Escape the token to prevent SQL injection
        $safe_token = $this->db->escape_str($submitted_token);
        
        // Build the WHERE conditions to check multiple token formats
        $conditions = [];
        
        // 1. Exact match for token or token_dev
        $conditions[] = "token = '" . $safe_token . "'";
        $conditions[] = "token_dev = '" . $safe_token . "'";
        
        // 2. Check if token is the hash part of a prefixed token (tk_name_HASH)
        $conditions[] = "(token LIKE '%\_%' AND SUBSTRING_INDEX(token, '_', -1) = '" . $safe_token . "')";
        
        // 3. Check hash part of token_dev
        // Case A: 'Dev-HASH' format
        $conditions[] = "(token_dev LIKE 'Dev-%' AND SUBSTRING(token_dev, 5) = '" . $safe_token . "')";
        // Case B: 'Dev-tk_name_HASH' format
        $conditions[] = "(token_dev LIKE 'Dev-%\_%' AND SUBSTRING_INDEX(token_dev, '_', -1) = '" . $safe_token . "')";
        
        // Combine conditions for active tokens
        $where_clause_active = "active = 1 AND (" . implode(" OR ", $conditions) . ")";
        
        // Check for active tokens with any of the formats
        $active_token = $this->codegen_model->row('token_customers', '*', $where_clause_active);
        
        if ($active_token) {
            return ['status' => 'valid', 'record' => $active_token];
        }
        
        // If no active token found, check for inactive tokens
        $where_clause_inactive = "active = 0 AND (" . implode(" OR ", $conditions) . ")";
        $inactive_token = $this->codegen_model->row('token_customers', '*', $where_clause_inactive);
        
        if ($inactive_token) {
            return ['status' => 'revoked', 'record' => $inactive_token];
        }
        
        // No token found
        return ['status' => 'invalid'];
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
            // Use the new token validation helper
            $token_validation = $this->_validateApiToken($token);
            
            if($token_validation['status'] === 'valid' && $token_validation['record']->customer_id == $customer->customer_id)
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
        $data = json_decode(file_get_contents('php://input'));

        $response = array(
            'status' => 'Error',
            'data' => array()
        );

        // Check required fields
        if (!isset($data->token)) {
            $response['data']['message'] = 'Lanubeflash response: Token is required';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        // Get postal code
        $postalCode = isset($data->data_client->postal_code) ? $data->data_client->postal_code : null;
        if (empty($postalCode)) {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Postal Code is required';
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        // Use the new token validation helper
        $token_validation = $this->_validateApiToken($data->token);

        if($token_validation['status'] === 'valid') {
            // Validate required parameters
            if (!isset($data->weight) || !is_numeric($data->weight)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Weight (in grams) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->depth) || !is_numeric($data->depth)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Depth (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->width) || !is_numeric($data->width)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Width (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->height) || !is_numeric($data->height)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Height (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }
            
            // Extract dimensions
            $weight = floatval($data->weight);
            $depth = floatval($data->depth);
            $width = floatval($data->width);
            $height = floatval($data->height);

            // Calculate volume in cubic centimeters
            $volume_cm3 = $depth * $width * $height;

            // Get customer using token_validation which already has the validated token
            $customer = $this->codegen_model->row('customers','*','customer_id = "'.$token_validation['record']->customer_id.'"');
            
            // Search for tariff
            $tariff = $this->tariff->getShippingCost([
                'postal_code' => $postalCode,
                'weight' => $weight,
                'volume' => $volume_cm3,
            ]);

            if ($tariff) {
                if ($tariff->country_id == $customer->country_id) {
                    $response['status'] = 'Success';
                    $response['data']['price_item'] = $tariff->tariff_price;
                    $response['data']['calculated_volume_cm3'] = $volume_cm3;
                } else {
                    $response['status'] = 'Error';
                    $response['data']['message'] = "Lanubeflash response: Country doesn't match";
                }
            } else {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: No tariff available for this shipping';
            }
        } else if($token_validation['status'] === 'revoked') {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Token has been revoked';
        } else {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Invalid token';
        }

        header('Content-Type: application/json');
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

        // Use the new token validation helper
        $token_validation = $this->_validateApiToken($token);
        
        if($token_validation['status'] === 'valid') {
            // Validate required parameters
            if (!isset($data->weight) || !is_numeric($data->weight)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Weight (in grams) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->depth) || !is_numeric($data->depth)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Depth (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->width) || !is_numeric($data->width)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Width (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!isset($data->height) || !is_numeric($data->height)) {
                $response['status'] = 'Error';
                $response['data']['message'] = 'Lanubeflash response: Height (in centimeters) is required and must be numeric';
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }
            
            // Extract dimensions
            $weight = floatval($data->weight);
            $depth = floatval($data->depth);
            $width = floatval($data->width);
            $height = floatval($data->height);

            // Calculate volume in cubic centimeters
            $volume = $depth * $width * $height;

            // Get customer
            $customer = $this->codegen_model->row('customers','*','customer_id = "'.$token_validation['record']->customer_id.'"');
            
            if($customer) {
                // Get tariff
                $tariff = $this->tariff->getShippingCost([
                    'postal_code' => $postalCode,
                    'weight' => $weight,
                    'volume' => $volume
                ]);
                
                if($tariff) {
                    // Add country validation similar to getShippingCost method
                    if ($tariff->country_id != $customer->country_id) {
                        $response['status'] = 'Error';
                        $response['data']['message'] = "Lanubeflash response: Country doesn't match";
                        echo json_encode($response, JSON_PRETTY_PRINT);
                        return; // Stop execution if country doesn't match
                    }

                    // Generate order number
                    $order_number = 'ORD-' . date('Ymd') . '-' . substr(uniqid(), -8);
                    
                    // Initialize items variable to prevent undefined notice
                    $items = []; 

                    // Create order
                    $data_orden = array(
                        'customer_id' => $token_validation['record']->customer_id,
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
                    $customer = $this->codegen_model->row('customers','*','customer_id = "' . $token_validation['record']->customer_id . '"');

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
                $response['data']['message'] = 'Lanubeflash response: Customer no exists';
            }
        } else if($token_validation['status'] === 'revoked') {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Token has been revoked';
        } else {
            $response['status'] = 'Error';
            $response['data']['message'] = 'Lanubeflash response: Invalid token';
        }
        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}