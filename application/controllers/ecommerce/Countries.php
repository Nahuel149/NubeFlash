<?php

class Countries extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('country_model','country');
	}	
	
	function index() {

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->country->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Paises"),
			'contenido_main' => $this->load->view('components/ecommerce/countries/countries_list', $vista_interna, true)
		);		

		$this->load->view('template/backend', $vista_externa);

	}

	function add(){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'code' => strtoupper(substr($this->input->post('name'), 0, 3))
			);
			$this->country->insert($data);
			redirect(base_url('ecommerce/countries'),'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
		);

		$vista_externa = array(			
			'title' => ucwords("Paises"),
			'contenido_main' => $this->load->view('components/ecommerce/countries/countries_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'code' => strtoupper(substr($this->input->post('name'), 0, 3))
			);
			$this->country->edit($data, $id);
			redirect(base_url('ecommerce/countries'),'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->country->find($id)
		);

		$vista_externa = array(			
			'title' => ucwords("Paises"),
			'contenido_main' => $this->load->view('components/ecommerce/countries/countries_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->country->find($id),
		);

		$vista_externa = array(			
			'title' => ucwords("Paises"),
			'contenido_main' => $this->load->view('components/ecommerce/countries/countries_view', $vista_interna, true)
		);		  
   
		$this->load->view('template/view', $vista_externa);
	}
	
	function delete($id){
		$response = array(
			'success' => false,
			'message' => '',
			'csrf_hash' => $this->security->get_csrf_hash()
		);

		try {
			$data = array(
				'active' => 0
			);
			
			$this->country->edit($data, $id);
			
			$response['success'] = true;
			$response['message'] = 'País eliminado exitosamente';
		} catch (Exception $e) {
			$response['message'] = 'Ocurrió un error al eliminar el país';
		}

		echo json_encode($response);
	}

}
