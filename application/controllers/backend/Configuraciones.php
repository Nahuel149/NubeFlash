<?php

class Configuraciones extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Load required libraries and helpers
		$this->load->library('ion_auth');
		$this->load->helper(['url', 'form']);
		$this->load->model('Codegen_model');
		
		// Check if user is logged in
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}

		// Debug user info
		$user = $this->ion_auth->user()->row();
		$groups = $this->ion_auth->get_users_groups()->result();
		echo "<!-- User Info: " . print_r($user, true) . " -->";
		echo "<!-- User Groups: " . print_r($groups, true) . " -->";
	}	
	
	function index() {
		// Debug permissions
		$user = $this->ion_auth->user()->row();
		$menu = $this->Codegen_model->row('menus', '*', 'link = "backend/configuraciones"');
		if ($menu) {
			$permisos = $this->Codegen_model->permisos_efectivos($menu->id_menu, $user->id_user);
			echo "<!-- Permissions: " . print_r($permisos, true) . " -->";
		} else {
			echo "<!-- Menu not found for backend/configuraciones -->";
		}

		// Load configurations
		$configuraciones = $this->Codegen_model->get('configurations','*','enabled = "1" ORDER BY ordering');
		echo "<!-- Configurations: " . print_r($configuraciones, true) . " -->";

		$vista_interna = array(
			'configuraciones' => $configuraciones,
			'user' => $user
		);

		$vista_externa = array(			
			'title' => ucwords("Configuraciones del Sistema"),
			'contenido_main' => $this->load->view('backend/configuraciones/configuraciones', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	function edit($id = NULL) {
		if ($id === NULL) {
			redirect('backend/configuraciones');
		}

		// Debug permissions for edit
		$user = $this->ion_auth->user()->row();
		$menu = $this->Codegen_model->row('menus', '*', 'link = "backend/configuraciones/edit"');
		if ($menu) {
			$permisos = $this->Codegen_model->permisos_efectivos($menu->id_menu, $user->id_user);
			echo "<!-- Edit Permissions: " . print_r($permisos, true) . " -->";
		} else {
			echo "<!-- Menu not found for backend/configuraciones/edit -->";
		}

		// Get configuration
		$configuration = $this->Codegen_model->get('configurations', '*', 'id_configuration = ' . $id);
		
		if (empty($configuration)) {
			redirect('backend/configuraciones');
		}

		// Check if form was submitted
		if ($this->input->post('enviar_form')) {
			$data = array(
				'value' => $this->input->post('value')
			);

			$this->Codegen_model->edit('configurations', $data, 'id_configuration', $id);
			redirect('backend/configuraciones');
		}

		// Load configuration for editing
		$vista_interna = array(
			'configuracion' => $configuration[0],
			'user' => $user
		);

		$vista_externa = array(			
			'title' => ucwords("Editar Configuración"),
			'contenido_main' => $this->load->view('backend/configuraciones/edit', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}
}

/* End of file configuraciones.php */
/* Location: ./system/application/controllers/configuraciones.php */