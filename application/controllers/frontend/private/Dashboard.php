<?php

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('order_model', 'order');
	}

	public function index()
	{
		if (!$this->session->userdata('customer_id')) {
			redirect(base_url('login'), 'refresh');
		}

		$user = $this->codegen_model->row('token_customers', 'token', 'customer_id = "' . $this->session->userdata('customer_id') . '"');
		$customer = $this->codegen_model->row('customers', '*', 'customer_id = "' . $this->session->userdata('customer_id') . '"');
		$vista_interna = array(
			'token' => $user->token,
			'customer' => $customer,
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/private/dashboard', $vista_interna, true),
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
			'image_header' => 'dashboard.png'
		);

		$this->load->view('template/private', $vista_externa);
	}
	public function profile()
	{
		if (!$this->session->userdata('customer_id')) {
			if ($this->input->is_ajax_request()) {
				echo json_encode([
					'success' => false, 
					'message' => 'Su sesión ha expirado. Por favor inicie sesión nuevamente.',
					$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
				]);
				return;
			}
			redirect(base_url('login'), 'refresh');
		}

		if ($this->input->post()) {
			try {
				// Validate required fields
				$required_fields = ['name', 'telephone', 'address', 'business_hours'];
				foreach ($required_fields as $field) {
					if (empty($this->input->post($field))) {
						if ($this->input->is_ajax_request()) {
							echo json_encode([
								'success' => false,
								'message' => 'Los campos Nombre, Teléfono, Dirección y Horario de atención son requeridos.',
								$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
							]);
							return;
						}
						$this->session->set_flashdata('error', 'Los campos Nombre, Teléfono, Dirección y Horario de atención son requeridos.');
						redirect(base_url('mi-perfil'));
						return;
					}
				}

				// Validate phone number format
				if (!preg_match('/^[+]?[0-9]{10,15}$/', $this->input->post('telephone'))) {
					if ($this->input->is_ajax_request()) {
						echo json_encode([
							'success' => false,
							'message' => 'El número de teléfono debe contener entre 10 y 15 dígitos, opcionalmente con un + al inicio.',
							$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
						]);
						return;
					}
					$this->session->set_flashdata('error', 'El número de teléfono debe contener entre 10 y 15 dígitos, opcionalmente con un + al inicio.');
					redirect(base_url('mi-perfil'));
					return;
				}

				// Validate business hours length
				if (strlen($this->input->post('business_hours')) > 100) {
					if ($this->input->is_ajax_request()) {
						echo json_encode([
							'success' => false,
							'message' => 'El horario de atención no puede exceder los 100 caracteres.',
							$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
						]);
						return;
					}
					$this->session->set_flashdata('error', 'El horario de atención no puede exceder los 100 caracteres.');
					redirect(base_url('mi-perfil'));
					return;
				}

				$this->codegen_model->edit('customers', array(
					'person_contact'    => $this->input->post('name'),
					'telephone'         => $this->input->post('telephone'),
					'social_reason'     => $this->input->post('social_reason'),
					'fiscal_identifier' => $this->input->post('id_fiscal'),
					'address'          => $this->input->post('address'),
					'business_hours'    => $this->input->post('business_hours'),
				), 'customer_id', $this->session->userdata('customer_id'));

				if ($this->input->is_ajax_request()) {
					echo json_encode([
						'success' => true, 
						'message' => 'Los datos han sido actualizados correctamente.',
						$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
					]);
					return;
				}

				$this->session->set_flashdata('success', 'Los datos han sido actualizados correctamente.');
				redirect(base_url('mi-perfil'));
				return;

			} catch (Exception $e) {
				if ($this->input->is_ajax_request()) {
					echo json_encode([
						'success' => false, 
						'message' => 'Ha ocurrido un error al actualizar los datos: ' . $e->getMessage(),
						$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
					]);
					return;
				}
				$this->session->set_flashdata('error', 'Ha ocurrido un error al actualizar los datos: ' . $e->getMessage());
				redirect(base_url('mi-perfil'));
				return;
			}
		}

		$customer = $this->codegen_model->row('customers', '*', 'customer_id = "' . $this->session->userdata('customer_id') . '"');
		$vista_interna = array(
			'customer' => $customer
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/private/perfil', $vista_interna, true),
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
			'image_header' => 'profile.png'
		);

		$this->load->view('template/private', $vista_externa);
	}
	public function token()
	{
		if (!$this->session->userdata('customer_id')) {
			redirect(base_url('login'), 'refresh');
		}

		$tokens = $this->codegen_model->get('token_customers', 'token,token_dev,created_at', 'customer_id = "' . $this->session->userdata('customer_id') . '" AND active = 1', 'created_at DESC');
		$customer = $this->codegen_model->row('customers', '*', 'customer_id = "' . $this->session->userdata('customer_id') . '"');
		$vista_interna = array(
			'tokens' => $tokens,
			'customer' => $customer,
		);
		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/private/token', $vista_interna, true),
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
			'image_header' => 'token.png'
		);

		$this->load->view('template/private', $vista_externa);
	}
	public function orders()
	{
		if (!$this->session->userdata('customer_id')) {
			redirect(base_url('login'), 'refresh');
		}
		$params = array(
			'where' => array('customer_id' => $this->session->userdata('customer_id')),
		);
		$orders = $this->order->get($params);

		$vista_interna = array(
			'orders' => $orders
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/private/orders', $vista_interna, true),
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
			'image_header' => 'orders.png'
		);

		$this->load->view('template/private', $vista_externa);
	}

	/**
	 * Get order details via AJAX
	 */
	public function get_order_details()
	{
		if (!$this->session->userdata('customer_id')) {
			echo json_encode(['success' => false, 'message' => 'Su sesión ha expirado. Por favor inicie sesión nuevamente.']);
			return;
		}

		$order_id = $this->input->post('order_id');
		
		// Verify the order belongs to the current customer
		$order = $this->order->find($order_id);
		
		if (!$order || $order->customer_id != $this->session->userdata('customer_id')) {
			echo json_encode(['success' => false, 'message' => 'Pedido no encontrado o no tiene permisos para verlo.']);
			return;
		}

		// Format the order data for display
		$orderData = [
			'order_id' => $order->order_id,
			'order_number' => $order->order_number,
			'client' => $order->client,
			'reference' => $order->reference,
			'created_at' => date('d/m/Y H:i:s', strtotime($order->created_at)),
			'destination' => $order->destination,
			'postal_code' => $order->postal_code,
			'country' => $order->country,
			'province' => $order->province,
			'price' => $order->price,
			'tracking_number' => $order->tracking_number,
			'status' => $order->status,
			'weight' => $order->weight,
			'volume' => $order->volume,
			'shipping_data' => json_decode($order->shipping_data, true),
			'items' => json_decode($order->items, true)
		];

		// Include the CSRF token in the response
		$response = [
			'success' => true, 
			'data' => $orderData,
			$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
		];

		echo json_encode($response);
	}

	/**
	 * Update order via AJAX
	 */
	public function update_order()
	{
		if (!$this->session->userdata('customer_id')) {
			echo json_encode([
				'success' => false, 
				'message' => 'Su sesión ha expirado. Por favor inicie sesión nuevamente.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
			return;
		}

		$order_id = $this->input->post('order_id');
		
		// Verify the order belongs to the current customer
		$order = $this->order->find($order_id);
		
		if (!$order || $order->customer_id != $this->session->userdata('customer_id')) {
			echo json_encode([
				'success' => false, 
				'message' => 'Pedido no encontrado o no tiene permisos para editarlo.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
			return;
		}

		// Only allow updating certain fields
		$data = [
			'client' => $this->input->post('client'),
			'reference' => $this->input->post('reference'),
			'tracking_number' => $this->input->post('tracking_number')
		];

		try {
			$this->order->edit($data, $order_id);
			echo json_encode([
				'success' => true, 
				'message' => 'Pedido actualizado correctamente.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
		} catch (Exception $e) {
			echo json_encode([
				'success' => false, 
				'message' => 'Error al actualizar el pedido: ' . $e->getMessage(),
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
		}
	}

	/**
	 * Delete order via AJAX
	 */
	public function delete_order()
	{
		if (!$this->session->userdata('customer_id')) {
			echo json_encode([
				'success' => false, 
				'message' => 'Su sesión ha expirado. Por favor inicie sesión nuevamente.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
			return;
		}

		$order_id = $this->input->post('order_id');
		
		// Verify the order belongs to the current customer
		$order = $this->order->find($order_id);
		
		if (!$order || $order->customer_id != $this->session->userdata('customer_id')) {
			echo json_encode([
				'success' => false, 
				'message' => 'Pedido no encontrado o no tiene permisos para eliminarlo.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
			return;
		}

		// Soft delete by setting active = 0
		$data = [
			'active' => 0
		];

		try {
			$this->order->edit($data, $order_id);
			echo json_encode([
				'success' => true, 
				'message' => 'Pedido eliminado correctamente.',
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
		} catch (Exception $e) {
			echo json_encode([
				'success' => false, 
				'message' => 'Error al eliminar el pedido: ' . $e->getMessage(),
				$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
			]);
		}
	}
}
