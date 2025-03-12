<?php

class Destinations extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('destination_model','destination');
        $this->load->model('province_model','province');
	}	
	
	function index() {

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->destination->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Destinos"),
			'contenido_main' => $this->load->view('components/ecommerce/destinations/destinations_list', $vista_interna, true)
		);		

		$this->load->view('template/backend', $vista_externa);

	}

	function add(){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'postal_code' => $this->input->post('postal_code'),
                'province_id' => $this->input->post('province')
			);
			$this->destination->insert($data);
			redirect(base_url('ecommerce/destinations'),'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
            'provinces' => $this->province->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Destinos"),
			'contenido_main' => $this->load->view('components/ecommerce/destinations/destinations_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
				'name' => $this->input->post('name'),
				'postal_code' => $this->input->post('postal_code'),
                'province_id' => $this->input->post('province')
			);
			$this->destination->edit($data, $id);
			redirect(base_url('ecommerce/destinations'),'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->destination->find($id),
            'provinces' => $this->province->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Destinos"),
			'contenido_main' => $this->load->view('components/ecommerce/destinations/destinations_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->destination->find($id),
		);

		$vista_externa = array(			
			'title' => ucwords("Destinos"),
			'contenido_main' => $this->load->view('components/ecommerce/destinations/destinations_view', $vista_interna, true)
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
			
			$this->destination->edit($data, $id);
			
			$response['success'] = true;
			$response['message'] = 'Destino eliminado exitosamente';
		} catch (Exception $e) {
			$response['message'] = 'Ocurrió un error al eliminar el destino';
		}

		echo json_encode($response);
	}

}
