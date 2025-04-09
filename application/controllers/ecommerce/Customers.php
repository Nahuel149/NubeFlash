<?php

class Customers extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('status_model', 'status');
		$this->load->model('customer_model', 'customer');
		$this->load->model('order_model', 'order');
		$this->load->model('destination_model', 'destination');
		$this->load->model('province_model', 'province');
		$this->load->model('country_model', 'country');
	}

	function index()
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}

		$vista_interna = array(
			'permisos_efectivos' => $permisos_efectivos,
			'results' => $this->customer->get()
		);

		$vista_externa = array(
			'title' => ucwords("Clientes"),
			'contenido_main' => $this->load->view('components/ecommerce/customers/customers_list', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	function add()
	{
		if ($this->input->post('enviar_form')) {
			$data = array(
				'social_reason' => $this->input->post('social_reason'),
				'fiscal_identifier' => $this->input->post('fiscal_identifier'),
				'person_contact' => $this->input->post('person_contact'),
				'telephone' => $this->input->post('telephone'),
				'email' => $this->input->post('email'),
				'country_id' => $this->input->post('country'),
				'province_id' => $this->input->post('province'),
				'destination_id' => $this->input->post('destination'),
				'password' => sha1($this->input->post('password')),
				'created_by' => $this->session->userdata('user_id'),
				'address'	=>	$this->input->post('address'),
				'business_hours'	=>	$this->input->post('business_hours'),
			);
			$customer = $this->customer->insert($data);

			$token = sha1($customer . uniqid());
			$data_token = array(
				'token' => $token,
				'token_dev' => 'Dev-' . $token,
				'customer_id' => $customer,
			);
			$this->codegen_model->add('token_customers', $data_token);
			redirect(base_url('ecommerce/customers'), 'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'countries' => $this->country->get(),
		);

		$vista_externa = array(
			'title' => ucwords("Clientes"),
			'contenido_main' => $this->load->view('components/ecommerce/customers/customers_add', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	function edit($id)
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}

		// Check if user has update permission
		if ($permisos_efectivos->update != 1) {
			if ($this->input->is_ajax_request()) {
				$response = [
					'success' => false,
					'message' => 'No tiene permisos para editar clientes.',
					'csrf_hash' => $this->security->get_csrf_hash()
				];
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
				return;
			}
			$this->session->set_flashdata('error', 'No tiene permisos para editar clientes.');
			redirect(base_url('ecommerce/customers'), 'refresh');
		}

		if ($this->input->post('enviar_form')) {
			try {
				$data = array(
					'social_reason' => $this->input->post('social_reason'),
					'fiscal_identifier' => $this->input->post('fiscal_identifier'),
					'person_contact' => $this->input->post('person_contact'),
					'telephone' => $this->input->post('telephone'),
					'email' => $this->input->post('email'),
					'country_id' => $this->input->post('country'),
					'update_by' => $this->session->userdata('user_id'),
					'address' => $this->input->post('address'),
					'business_hours' => $this->input->post('business_hours'),
					'updated_at' => date('Y-m-d H:i:s')  // This will be handled by DEFAULT_GENERATED, so we can remove it
				);

				// Debug input values
				log_message('debug', 'Customer edit POST values: ' . json_encode($_POST));
				log_message('debug', 'province value: "' . $this->input->post('province') . '"');
				log_message('debug', 'province_manual value: "' . $this->input->post('province_manual') . '"');
				log_message('debug', 'destination value: "' . $this->input->post('destination') . '"');
				log_message('debug', 'destination_manual value: "' . $this->input->post('destination_manual') . '"');
				log_message('debug', 'province === "other"? ' . ($this->input->post('province') === 'other' ? 'true' : 'false'));
				log_message('debug', 'destination === "other"? ' . ($this->input->post('destination') === 'other' ? 'true' : 'false'));

				// Handle "Other" option for province
				if ($this->input->post('province') === 'other' || !empty($this->input->post('province_manual'))) {
					$data['province_id'] = NULL;
					$data['province_name_manual'] = $this->input->post('province_manual');
					log_message('debug', 'Using province_manual: ' . $this->input->post('province_manual'));
				} else {
					$data['province_id'] = $this->input->post('province') ?: null;
					$data['province_name_manual'] = NULL;
					log_message('debug', 'Using province_id: ' . $this->input->post('province'));
				}
				
				// Handle "Other" option for destination
				if ($this->input->post('destination') === 'other' || !empty($this->input->post('destination_manual'))) {
					$data['destination_id'] = NULL;
					$data['destination_name_manual'] = $this->input->post('destination_manual');
					log_message('debug', 'Using destination_manual: ' . $this->input->post('destination_manual'));
				} else {
					$data['destination_id'] = $this->input->post('destination') ?: null;
					$data['destination_name_manual'] = NULL;
					log_message('debug', 'Using destination_id: ' . $this->input->post('destination'));
				}
				
				// Debug data before filtering
				log_message('debug', 'Customer edit data before filtering: ' . json_encode($data));
				
				// Remove null or empty values to prevent overwriting with empty data, except for social_reason and fiscal_identifier
				$data = array_filter($data, function($value, $key) {
					if ($key === 'social_reason' || $key === 'fiscal_identifier' || 
						$key === 'province_id' || $key === 'province_name_manual' || 
						$key === 'destination_id' || $key === 'destination_name_manual') {
						return true; // Always keep these fields, even if empty
					}
					return $value !== null && $value !== '';
				}, ARRAY_FILTER_USE_BOTH);
				
				// Debug data after filtering
				log_message('debug', 'Customer edit data after filtering: ' . json_encode($data));

				// Validate password if provided
				$password = $this->input->post('password');
				if (!empty($password)) {
					// Check password requirements
					if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
						if ($this->input->is_ajax_request()) {
							$response = [
								'success' => false,
								'message' => 'La contraseña debe tener al menos 8 caracteres, 1 mayúscula y 1 símbolo (!@#$%^&*)',
								'csrf_hash' => $this->security->get_csrf_hash()
							];
							$this->output->set_content_type('application/json')->set_output(json_encode($response));
							return;
						}
						$this->session->set_flashdata('error', 'La contraseña debe tener al menos 8 caracteres, 1 mayúscula y 1 símbolo (!@#$%^&*)');
						redirect(current_url(), 'refresh');
						return;
					}
					$data['password'] = sha1($password);
				}

				$result = $this->customer->edit($data, $id);

				if ($this->input->is_ajax_request()) {
					$response = [
						'success' => true,
						'message' => 'Cliente actualizado exitosamente.',
						'csrf_hash' => $this->security->get_csrf_hash()
					];
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
					return;
				}
				
				$this->session->set_flashdata('success', 'Cliente actualizado exitosamente.');
				redirect(base_url('ecommerce/customers'), 'refresh');
				
			} catch (Exception $e) {
				if ($this->input->is_ajax_request()) {
					$response = [
						'success' => false,
						'message' => 'Error al actualizar el cliente: ' . $e->getMessage(),
						'csrf_hash' => $this->security->get_csrf_hash()
					];
					$this->output->set_content_type('application/json')->set_output(json_encode($response));
					return;
				}
				$this->session->set_flashdata('error', 'Error al actualizar el cliente: ' . $e->getMessage());
				redirect(current_url(), 'refresh');
			}
		}

		$vista_interna = array(
			'permisos_efectivos' => $permisos_efectivos,
			'result' => $this->customer->find($id),
			'countries' => $this->country->get(),
		);

		$vista_externa = array(
			'title' => ucwords("Clientes"),
			'contenido_main' => $this->load->view('components/ecommerce/customers/customers_edit', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	function view($id)
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}

		$vista_interna = array(
			'permisos_efectivos' => $permisos_efectivos,
			'result' => $this->customer->find($id),
		);

		$vista_externa = array(
			'title' => ucwords("Clientes"),
			'contenido_main' => $this->load->view('components/ecommerce/customers/customers_view', $vista_interna, true)
		);

		$this->load->view('template/view', $vista_externa);
	}

	function delete($id)
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}
		
		// Set default response - used for both AJAX and non-AJAX requests for consistency
		$response = array(
			'success' => false,
			'message' => 'No tienes permisos para eliminar este registro'
		);
		
		// Check for delete permission
		if ($permisos_efectivos->delete == 1) {
			try {
				// Prepare data for soft delete - only use existing columns
				$data = array(
					'active' => 0  // Using only the active column for soft delete
				);
				
				// Perform the update
				$result = $this->customer->edit($data, $id);
				
				if ($result) {
					$response['success'] = true;
					$response['message'] = 'Registro eliminado correctamente';
				} else {
					$response['message'] = 'Error al eliminar el registro. No se encontró el cliente o no se aplicaron cambios.';
				}
			} catch (Exception $e) {
				$response['message'] = 'Error al eliminar el registro: ' . $e->getMessage();
				log_message('error', 'Error deleting customer ID ' . $id . ': ' . $e->getMessage());
			}
		}
		
		// Handle the response based on request type
		if ($this->input->is_ajax_request()) {
			// Return JSON response for AJAX requests
			$this->output
				->set_status_header($response['success'] ? 200 : 400)
				->set_content_type('application/json')
				->set_output(json_encode($response));
		} else {
			// For non-AJAX requests, set flash message and redirect
			if ($response['success']) {
				$this->session->set_flashdata('success', $response['message']);
			} else {
				$this->session->set_flashdata('error', $response['message']);
			}
			
			redirect(base_url().'ecommerce/customers', 'refresh');
		}
	}

	function changeStatus() {
        $error = false;
        $message = "";
		$data = array();
		$status_id = $this->input->post('status_id');
		$order_id = $this->input->post('order_id');

		if (!empty($status_id) && !empty($order_id)) {
			$this->order->edit([
				'status_id' => $status_id,
			], $order_id);
			$message = 'Se ha modificado el estado del pedido';
		} else {
			$error = true;
			$message = 'No se ha podido cambiar el estado';
		}

		// Response
        echo json_encode([
            'error' => $error,
            'message' => $message,
            'data' => $data
        ]);
	}

	function shippingCustomer($id)
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}

		$params = array(
			'where' => array('customer_id' => $id),
		);
		$vista_interna = array(
			'permisos_efectivos' => $permisos_efectivos,
			'results' => $this->order->get($params),
			'statuses' => $this->status->get(['name' => 'asc'], [], true)
		);

		$vista_externa = array(
			'title' => ucwords("Pedidos"),
			'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_list', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	function viewShippingCustomer($id)
	{
		$order = $this->order->find($id);
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $order,
			'shipping_data' => json_decode($order->shipping_data, true),
			'customer' => $this->customer->find($order->customer_id)
		);

		$vista_externa = array(
			'title' => ucwords("Pedidos"),
			'contenido_main' => $this->load->view('components/ecommerce/shipping/shipping_view', $vista_interna, true)
		);

		$this->load->view('template/view', $vista_externa);
	}

	function getProvince()
	{
		$response = array(
			'success' => false,
			'provinces' => array(),
			'message' => '',
			'csrf_hash' => $this->security->get_csrf_hash()
		);

		try {
			$country_id = $this->input->post('country_id');
			if ($country_id > 0) {
				// Fix: Use proper query format for codegen_model
				$where = sprintf("country_id = %d AND active = 1", (int)$country_id);
				$provinces = $this->codegen_model->get('provinces', '*', $where);
				
				if ($provinces) {
					$response['success'] = true;
					$response['provinces'] = $provinces;
				} else {
					$response['message'] = 'No se encontraron provincias para el país seleccionado';
				}
			} else {
				$response['message'] = 'ID de país inválido';
			}
		} catch (Exception $e) {
			$response['message'] = 'Error al obtener provincias: ' . $e->getMessage();
			log_message('error', 'Error getting provinces: ' . $e->getMessage());
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	function getDestination()
	{
		$response = array(
			'success' => false,
			'destinations' => array(),
			'message' => '',
			'csrf_hash' => $this->security->get_csrf_hash()
		);

		try {
			$province_id = $this->input->post('province_id');
			if ($province_id > 0) {
				// Fix: Use proper query format for codegen_model
				$where = sprintf("province_id = %d AND active = 1", (int)$province_id);
				$destinations = $this->codegen_model->get('destinations', '*', $where);
				
				if ($destinations) {
					$response['success'] = true;
					$response['destinations'] = $destinations;
				} else {
					$response['message'] = 'No se encontraron localidades para la provincia seleccionada';
				}
			} else {
				$response['message'] = 'ID de provincia inválido';
			}
		} catch (Exception $e) {
			$response['message'] = 'Error al obtener localidades: ' . $e->getMessage();
			log_message('error', 'Error getting destinations: ' . $e->getMessage());
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	function view_tokens($id)
	{
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}

		// Get customer details
		$customer = $this->customer->get(['id' => $id]);
		if (empty($customer)) {
			$this->session->set_flashdata('error', 'Cliente no encontrado');
			redirect(base_url('ecommerce/customers'), 'refresh');
		}

		// Get customer tokens
		$tokens = $this->codegen_model->get('token_customers', '*', 'customer_id = ' . $id, 'created_at DESC');

		$vista_interna = array(
			'permisos_efectivos' => $permisos_efectivos,
			'customer' => $customer[0],
			'tokens' => $tokens
		);

		$vista_externa = array(
			'title' => ucwords("Tokens del Cliente: " . $customer[0]->social_reason),
			'contenido_main' => $this->load->view('components/ecommerce/customers/customers_tokens', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	function revoke_token($token_id)
	{
		// Check if token exists and belongs to a customer
		$token = $this->codegen_model->row('token_customers', '*', 'token_id = ' . $token_id);
		if (!$token) {
			$this->session->set_flashdata('error', 'Token no encontrado');
			redirect(base_url('ecommerce/customers'), 'refresh');
		}

		// Update token status
		$data = array('active' => 0);
		$this->codegen_model->edit('token_customers', $data, 'token_id', $token_id);

		// Add to activity log
		$log_data = array(
			'id_user' => $this->session->userdata('user_id'),
			'action' => 'REVOKE_TOKEN',
			'description' => 'Token revoked for customer ID: ' . $token->customer_id,
			'ip_address' => $this->input->ip_address()
		);
		$this->codegen_model->add('activity_log', $log_data);

		$this->session->set_flashdata('success', 'Token revocado exitosamente');
		redirect(base_url('ecommerce/customers/view_tokens/' . $token->customer_id), 'refresh');
	}

	function generate_token($customer_id)
	{
		// Check if customer exists
		$customer = $this->customer->get(['id' => $customer_id]);
		if (empty($customer)) {
			$this->session->set_flashdata('error', 'Cliente no encontrado');
			redirect(base_url('ecommerce/customers'), 'refresh');
		}

		// Generate new token
		$token = sha1($customer_id . uniqid());
		$data_token = array(
			'token' => $token,
			'token_dev' => 'Dev-' . $token,
			'customer_id' => $customer_id,
			'active' => 1
		);
		$this->codegen_model->add('token_customers', $data_token);

		// Add to activity log
		$log_data = array(
			'id_user' => $this->session->userdata('user_id'),
			'action' => 'GENERATE_TOKEN',
			'description' => 'New token generated for customer ID: ' . $customer_id,
			'ip_address' => $this->input->ip_address()
		);
		$this->codegen_model->add('activity_log', $log_data);

		$this->session->set_flashdata('success', 'Token generado exitosamente');
		redirect(base_url('ecommerce/customers/view_tokens/' . $customer_id), 'refresh');
	}
}
