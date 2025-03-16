<?php

class Provinces extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('province_model','province');
		$this->load->model('country_model','country');
	}	
	
	function index() {

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->province->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Provincias"),
			'contenido_main' => $this->load->view('components/ecommerce/provinces/provinces_list', $vista_interna, true)
		);		

		$this->load->view('template/backend', $vista_externa);

	}

	function add(){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'country_id' => $this->input->post('country'),
				'code' => strtoupper(substr($this->input->post('name'), 0, 5))
			);
			$this->province->insert($data);
			redirect(base_url('ecommerce/provinces'),'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'countries' => $this->country->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Provincias"),
			'contenido_main' => $this->load->view('components/ecommerce/provinces/provinces_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'country_id' => $this->input->post('country'),
				'code' => strtoupper(substr($this->input->post('name'), 0, 5))
			);
			$this->province->edit($data, $id);
			redirect(base_url('ecommerce/provinces'),'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->province->find($id),
			'countries' => $this->country->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Provincias"),
			'contenido_main' => $this->load->view('components/ecommerce/provinces/provinces_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->province->find($id),
		);

		$vista_externa = array(			
			'title' => ucwords("Provincias"),
			'contenido_main' => $this->load->view('components/ecommerce/provinces/provinces_view', $vista_interna, true)
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
			
			$this->province->edit($data, $id);
			
			$response['success'] = true;
			$response['message'] = 'Provincia eliminada exitosamente';
		} catch (Exception $e) {
			$response['message'] = 'Ocurrió un error al eliminar la provincia';
		}

		echo json_encode($response);
	}

}
