<?php

class Users extends CI_Controller {

	private $permisos;
	private $issa;

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->issa = $this->permisos_lib->isSuperAdmin();
	}
	
	function index(){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'results' => $this->sudaca_backend_md->users_getAll()
		);

		// Set default values for nullable fields in results
		if ($vista_interna['results']) {
			foreach ($vista_interna['results'] as $user) {
				$user->foto = $user->foto ?? '';
				$user->telefono = $user->telefono ?? '';
				$user->phone = $user->phone ?? '';
			}
		}

		$vista_externa = array(			
			'title' => ucwords("users"),
			'contenido_main' => $this->load->view('backend/users/users_list', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	function add(){
		if ($this->input->post('enviar_form')){
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');

			// Initialize additional data
			$additional_data = array(
				'name' => ucwords(strtolower($this->input->post('nombre'))),
				'surname' => ucwords(strtolower($this->input->post('apellido'))),
				'telefono' => $this->input->post('telefono'),
				'phone' => $this->input->post('celular'),            
				'active' => $this->input->post('active'),
				'idioma' => 'spanish',
				'template' => $this->input->post('template')
			);

			// Handle photo upload
			if (!empty($_FILES['foto']['name'])) {
				$img = $this->backend_lib->imagen_upload('foto', 'users');
				if ($img) {
					$additional_data['foto'] = $img;
				}
			}

			$group_us = $this->input->post('group');
			$group = array($group_us);
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			redirect(base_url("backend/users"), 'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'grupos' => $this->sudaca_backend_md->groups_getAll()
		);

		$vista_externa = array(			
			'title' => ucwords("users"),
			'contenido_main' => $this->load->view('backend/users/users_add', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$id = $this->input->post('id');
			$user = $this->ion_auth->user($id)->row();

			// Initialize data array first
			$data = array(
				'name' => ucwords(strtolower($this->input->post('nombre'))),
				'surname' => ucwords(strtolower($this->input->post('apellido'))),
				'telefono' => $this->input->post('telefono'),
				'phone' => $this->input->post('celular'),
				'active' => $this->input->post('active'),
			);

			// Handle photo upload
			if (!empty($_FILES['foto']['name'])) {
				$img = $this->backend_lib->imagen_upload('foto', 'users');
				if ($img) {
					$data['foto'] = $img;
				}
			}

			$this->ion_auth->update($user->id_user, $data);
			$this->ion_auth->remove_from_group(NULL, $user->id_user);
			$this->ion_auth->add_to_group($this->input->post('group'), $user->id_user);

			redirect(base_url("backend/users"), 'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'grupos' => $this->sudaca_backend_md->groups_getAll(),
			'result' => $this->codegen_model->row('users','*','id_user = '.$id),
			'group_user' => $this->codegen_model->row('users_groups','*','id_user = "'.$id.'" ORDER BY id_group DESC'),
		);

		// Handle null values more gracefully
		if ($vista_interna['result']) {
			$vista_interna['result']->telefono = $vista_interna['result']->telefono ?? '';
			$vista_interna['result']->phone = $vista_interna['result']->phone ?? '';
			// Only set foto to empty if it's actually null/undefined
			if (!isset($vista_interna['result']->foto)) {
				$vista_interna['result']->foto = '';
			}
		}

		$vista_externa = array(			
			'title' => ucwords("users"),
			'contenido_main' => $this->load->view('backend/users/users_edit', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->codegen_model->row('users','*','id_user = '.$id)
		);

		$vista_externa = array(			
			'title' => ucwords("users"),
			'contenido_main' => $this->load->view('backend/users/users_view', $vista_interna, true)
		);		
		
		$this->load->view('template/view', $vista_externa);
	}
	
	function delete($ID){
		// Initialize default permissions if $this->permisos is not an object
		$permisos_efectivos = new stdClass();
		$permisos_efectivos->insert = 0;
		$permisos_efectivos->update = 0;
		$permisos_efectivos->delete = 0;
		
		// If permissions are properly loaded, use them
		if (is_object($this->permisos)) {
			$permisos_efectivos = $this->permisos;
		}
		
		// Set default response
		$response = array(
			'success' => false,
			'message' => 'No tienes permisos para eliminar este usuario',
			'csrf_hash' => $this->security->get_csrf_hash()
		);
		
		// Check for delete permission
		if ($permisos_efectivos->delete == 1) {
			try {
				// Check if user exists
				$user = $this->codegen_model->row('users', '*', 'id_user = ' . $ID);
				if (!$user) {
					$response['message'] = 'Usuario no encontrado';
					$this->output->set_status_header(404);
				} else {
					// Prepare data for soft delete - using only existing columns
					$data_update = array(
						'active' => 0,
						'last_login' => NULL,
						'last_activity' => NULL
					);

					$result = $this->codegen_model->edit('users', $data_update, 'id_user', $ID);
					
					if ($result) {
						// Also deactivate user's group associations
						$this->db->where('id_user', $ID)
								->update('users_groups', array('active' => 0));

						$response = array(
							'success' => true,
							'message' => 'Usuario eliminado correctamente',
							'csrf_hash' => $this->security->get_csrf_hash()
						);
					} else {
						$response['message'] = 'Error al eliminar el usuario';
						$this->output->set_status_header(500);
					}
				}
			} catch (Exception $e) {
				$response['message'] = 'Error al eliminar el usuario: ' . $e->getMessage();
				$this->output->set_status_header(500);
				log_message('error', 'Error deleting user: ' . $e->getMessage());
			}
		} else {
			$this->output->set_status_header(403);
		}

		// Always return JSON for this endpoint
		$this->output->set_content_type('application/json')
					 ->set_output(json_encode($response));
	}

	function cambiar_password($id)
	{
		if ($this->input->post('enviar_form')) {
			$password = $this->input->post('password');
			$repetir_password = $this->input->post('repetir_password');
			
			// Server-side validation
			if (empty($password) || empty($repetir_password)) {
				$this->session->set_flashdata('error', 'Ambos campos de contraseña son requeridos');
				redirect(current_url());
			}
			
			// Verify passwords match
			if ($password !== $repetir_password) {
				$this->session->set_flashdata('error', 'Las contraseñas no coinciden');
				redirect(current_url());
			}
			
			// Verify password length
			if (strlen($password) < 6) {
				$this->session->set_flashdata('error', 'La contraseña debe tener al menos 6 caracteres');
				redirect(current_url());
			}

			try {
				// Get the user
				$user = $this->ion_auth->user($id)->row();
				if (!$user) {
					$this->session->set_flashdata('error', 'Usuario no encontrado');
					redirect(current_url());
				}

				// Change the password using Ion Auth's native method
				if ($this->ion_auth->update($user->id, array('password' => $password))) {
					$this->session->set_flashdata('success', 'Contraseña actualizada correctamente');
					redirect(base_url('backend/users'));
				} else {
					$this->session->set_flashdata('error', 'Error al actualizar la contraseña');
					redirect(current_url());
				}
			} catch (Exception $e) {
				$this->session->set_flashdata('error', 'Error al actualizar la contraseña: ' . $e->getMessage());
				redirect(current_url());
			}
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'result' => $this->codegen_model->row('users','*','id_user = '.$id)
		);

		$vista_externa = array(            
			'title' => ucwords("users"),
			'contenido_main' => $this->load->view('backend/users/users_password', $vista_interna, true)
		);        
		
		$this->load->view('template/backend', $vista_externa);
	}

	function validarSi() {
		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed', 403);
			return;
		}

		// Get the CSRF token from the header or post data
		$csrf_token = $this->input->get_request_header('X-CSRF-TOKEN') ?? $this->input->post($this->security->get_csrf_token_name());
		
		if (!$csrf_token || $csrf_token !== $this->security->get_csrf_hash()) {
			$response = array(
				'status' => 'error',
				'message' => 'Invalid security token',
				'csrf_hash' => $this->security->get_csrf_hash()
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}

		$username = $this->input->post('username');
		$result = $this->codegen_model->row('users', 'username', 'username = "' . $username . '"');
		
		$response = array(
			'exists' => $result ? true : false,
			'csrf_hash' => $this->security->get_csrf_hash()
		);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function validarEmail() {
		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed', 403);
			return;
		}

		// Get the CSRF token from the header or post data
		$csrf_token = $this->input->get_request_header('X-CSRF-TOKEN') ?? $this->input->post($this->security->get_csrf_token_name());
		
		if (!$csrf_token || $csrf_token !== $this->security->get_csrf_hash()) {
			$response = array(
				'status' => 'error',
				'message' => 'Invalid security token',
				'csrf_hash' => $this->security->get_csrf_hash()
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}

		$email = $this->input->post('email');
		$result = $this->codegen_model->row('users', 'email', 'email = "' . $email . '"');
		
		$response = array(
			'exists' => $result ? true : false,
			'csrf_hash' => $this->security->get_csrf_hash()
		);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

}