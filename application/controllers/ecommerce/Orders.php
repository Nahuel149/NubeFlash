<?php

class Orders extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('order_model', 'order');
        $this->load->model('customer_model', 'customer');
        $this->load->model('status_model', 'status');
        $this->load->model('destination_model', 'destination');
        $this->load->model('province_model', 'province');
        $this->load->model('country_model', 'country');
        $this->load->model('codegen_model');
    }

    function index()
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->order->get(),
            'statuses' => $this->status->get(['name' => 'asc'], [], true)
        );

        $vista_externa = array(
            'title' => ucwords("Pedidos"),
            'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $order = $this->order->find($id);
        $customer = $this->customer->find($order->customer_id);
        
        // Decode shipping data and ensure all required fields exist
        $shipping_data = json_decode($order->shipping_data, true) ?: [];
        
        // Set default store data if missing
        if (!isset($shipping_data['store'])) {
            $shipping_data['store'] = [
                'name' => isset($customer->social_reason) ? $customer->social_reason : '-',
                'email' => isset($customer->email) ? $customer->email : '-',
                'country' => '-', // Country is not directly accessible from customer
                'telephone' => isset($customer->telephone) ? $customer->telephone : '-',
                'domain' => '#', // Website/domain is not stored in customer table
            ];
        }
        
        // Set default customer data if missing
        if (!isset($shipping_data['email'])) {
            $shipping_data['email'] = isset($customer->email) ? $customer->email : '-';
        }
        if (!isset($shipping_data['telephone'])) {
            $shipping_data['telephone'] = isset($customer->telephone) ? $customer->telephone : '-';
        }
        if (!isset($shipping_data['address'])) {
            $shipping_data['address'] = isset($customer->address) ? $customer->address : '-';
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $order,
            'shipping_data' => $shipping_data,
            'customer' => $customer
        );

        $vista_externa = array(
            'title' => ucwords("Detalle de Pedido"),
            'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_view', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);
    }

    function add()
    {
        if ($this->input->post('enviar_form')) {
            $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'tariff_id' => $this->input->post('tariff_id'),
                'status_id' => $this->input->post('status_id'),
                'order_number' => $this->input->post('order_number'),
                'total_amount' => $this->input->post('total_amount'),
                'tracking_number' => $this->input->post('tracking_number'),
                'items' => $this->input->post('items'),
                'client' => $this->input->post('client'),
                'reference' => $this->input->post('reference'),
                'shipping_data' => $this->input->post('shipping_data'),
                'postal_code' => $this->input->post('postal_code'),
                'weight' => $this->input->post('weight'),
                'volume' => $this->input->post('volume')
            );

            $order_id = $this->order->insert($data);
            redirect(base_url() . 'ecommerce/orders');
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'customers' => $this->customer->get(),
            'statuses' => $this->status->get(['name' => 'asc'], [], true)
        );

        $vista_externa = array(
            'title' => ucwords("Agregar Pedido"),
            'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_add', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function edit($id)
    {
        // Debug information
        log_message('debug', 'Edit method called for order ID: ' . $id);
        log_message('debug', 'POST data: ' . print_r($_POST, true));
        
        if ($this->input->post('enviar_form')) {
            log_message('debug', 'Processing form submission');
            $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'tariff_id' => $this->input->post('tariff_id'),
                'status_id' => $this->input->post('status_id'),
                'order_number' => $this->input->post('order_number'),
                'total_amount' => $this->input->post('total_amount'),
                'tracking_number' => $this->input->post('tracking_number'),
                'items' => $this->input->post('items'),
                'client' => $this->input->post('client'),
                'reference' => $this->input->post('reference'),
                'shipping_data' => $this->input->post('shipping_data'),
                'postal_code' => $this->input->post('postal_code'),
                'weight' => $this->input->post('weight'),
                'volume' => $this->input->post('volume')
            );
            
            log_message('debug', 'Data to update: ' . print_r($data, true));
            
            try {
                $this->order->edit($data, $id);
                log_message('debug', 'Order updated successfully');
                redirect(base_url() . 'ecommerce/orders');
            } catch (Exception $e) {
                log_message('error', 'Error updating order: ' . $e->getMessage());
                // Set flash message for error
                $this->session->set_flashdata('error', 'Error al actualizar el pedido: ' . $e->getMessage());
            }
        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->order->find($id),
            'customers' => $this->customer->get(),
            'statuses' => $this->status->get(['name' => 'asc'], [], true)
        );

        $vista_externa = array(
            'title' => ucwords("Editar Pedido"),
            'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function delete($id)
    {
        $data = array(
            'active' => 0
        );
        
        $this->order->edit($data, $id);
        redirect(base_url() . 'ecommerce/orders');
    }

    function changeStatus() 
    {
        $error = false;
        $message = "";
        $data = array();
        $status_id = $this->input->post('status_id');
        $order_id = $this->input->post('order_id');

        if (!empty($status_id) && !empty($order_id)) {
            try {
                $this->order->edit([
                    'status_id' => $status_id,
                ], $order_id);
                $message = 'Se ha modificado el estado del pedido';

                // Fetch order details for email
                $order = $this->order->find($order_id);
                if ($order) {
                    $customer = $this->customer->find($order->customer_id);
                    log_message('debug', 'Customer data for order ID ' . $order_id . ': ' . print_r($customer, true));
                    
                    // Extract email from shipping_data when available
                    $shipping_data_json = $order->shipping_data;
                    $notification_email = $customer->email; // Default to customer account email
                    
                    // Try to get email from shipping_data if it exists
                    if (!empty($shipping_data_json)) {
                        $shipping_data = json_decode($shipping_data_json, true);
                        if (isset($shipping_data['email']) && !empty($shipping_data['email'])) {
                            // Use shipping email instead of customer account email
                            $notification_email = $shipping_data['email'];
                            log_message('debug', 'Using shipping data email ' . $notification_email . ' instead of account email ' . $customer->email . ' for order ID ' . $order_id);
                        }
                    }
                    
                    if ($customer && !empty($notification_email)) {
                        $status_details = $this->status->find($status_id);
                        $new_status_name = $status_details ? $status_details->name : 'Desconocido';

                        // Prepare email data
                        $email_data = [
                            'title' => 'Actualización de Estado de tu Pedido',
                            // Use social_reason for customer name, fallback to 'Cliente'
                            'customer_name' => isset($customer->social_reason) && !empty($customer->social_reason) ? $customer->social_reason : (isset($customer->name) && !empty($customer->name) ? $customer->name : 'Cliente'),
                            'order_number' => $order->order_number,
                            'new_status' => $new_status_name,
                            'store_name' => $this->codegen_model->row('configurations', 'value', 'key_id = "nombre_sistema"')->value ?: 'NubeFlash', // Fetch Nombre Sistema
                            'tracking_link' => $order->tracking_number ? base_url('tracking/' . $order->tracking_number) : base_url() // Link to tracking page or home
                        ];

                        // Load Frontend_lib if not already loaded
                        if (!isset($this->frontend_lib)) {
                            $this->load->library('frontend_lib');
                        }
                        
                        // Get email configuration using codegen_model directly
                        $config_email_soporte = $this->codegen_model->row('configurations', 'value', 'key_id = "email_soporte"');
                        $config_email_admin = $this->codegen_model->row('configurations', 'value', 'key_id = "email_admin"');
                        $config_remitente = $this->codegen_model->row('configurations', 'value', 'key_id = "email_remitente"'); // This is used as From Name by Frontend_lib
                        $config_nombre_sistema = $this->codegen_model->row('configurations', 'value', 'key_id = "nombre_sistema"');

                        $email_from_address = $config_email_soporte ? $config_email_soporte->value : ($config_email_admin ? $config_email_admin->value : 'noreply@example.com');
                        // Use Nombre Sistema as the sender name if available, otherwise the remitente email as a fallback name
                        $sender_name = $config_nombre_sistema ? $config_nombre_sistema->value : ($config_remitente ? $config_remitente->value : 'NubeFlash');

                        // Send email with corrected parameters
                        try {
                            $this->frontend_lib->enviarEmail(
                                $email_data, // $data
                                'frontend/email/order_status_update', // $vista
                                'Tu pedido ' . $order->order_number . ' ha sido actualizado - ' . $email_data['store_name'], // $titulo
                                $notification_email, // $email_destino - USING NOTIFICATION EMAIL HERE
                                $email_from_address, // $email_origen (From Email)
                                $sender_name, // $remitente (From Name)
                                (defined('CORREO_QA') && CORREO_QA ? CORREO_QA : null) // $email_bcc (New 7th argument)
                            );
                            log_message('info', 'Email de actualización de estado enviado a ' . $notification_email . ' para el pedido ' . $order_id . (defined('CORREO_QA') && CORREO_QA ? ' (BCC: ' . CORREO_QA . ')' : ''));
                        } catch (Exception $e) {
                            log_message('error', 'Error al enviar email de actualización de estado: ' . $e->getMessage() . ' para el pedido ' . $order_id);
                        }
                    } else {
                        log_message('warn', 'No se pudo enviar email: Cliente no encontrado o sin email para pedido ' . $order_id);
                    }
                } else {
                    log_message('warn', 'No se pudo enviar email: Pedido no encontrado ' . $order_id);
                }

            } catch (Exception $e) {
                $error = true;
                $message = 'Error al modificar el estado: ' . $e->getMessage();
            }
        } else {
            $error = true;
            $message = 'No se ha podido cambiar el estado. Faltan parámetros.';
        }

        // Check if it's an AJAX request
        if ($this->input->is_ajax_request()) {
            // Return JSON for AJAX calls
            echo json_encode([
                'error' => $error,
                'message' => $message,
                'data' => $data
            ]);
        } else {
            // Set flash message for regular form submission
            if (!$error) {
                $this->session->set_flashdata('success', $message);
            } else {
                $this->session->set_flashdata('error', $message);
            }
            
            // Redirect back to the orders list
            redirect(base_url() . 'ecommerce/orders');
        }
    }

    function customerOrders($customer_id) 
    {
        $params = array(
            'where' => array('customer_id' => $customer_id),
        );
        
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results' => $this->order->get($params),
            'statuses' => $this->status->get(['name' => 'asc'], [], true)
        );

        $vista_externa = array(
            'title' => ucwords("Pedidos del Cliente"),
            'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }
} 