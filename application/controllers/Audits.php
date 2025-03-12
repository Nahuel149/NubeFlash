<?php

class Audits extends CI_Controller {

	private $permisos;
	
	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
	}	
	
	function index(){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->codegen_model->get('audits','*','')
		);

		$vista_externa = array(			
			'title' => ucwords("audits"),
			'contenido_main' => $this->load->view('components/audits/audits_list', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	function add(){
		if ($this->input->post('enviar_form')){
			$data = array(
					'id_user' => $this->input->post('id_user'),
					'query' => $this->input->post('query'),
					'date' => $this->input->post('date'),
					'active' => $this->input->post('active'),
					'created_at' => $this->input->post('created_at'),
					'updated_at' => $this->input->post('updated_at'),
					'deleted_at' => $this->input->post('deleted_at'),
					'create_by' => $this->input->post('create_by'),
					'update_by' => $this->input->post('update_by'),
					'delete_by' => $this->input->post('delete_by')
				);
			$this->codegen_model->add('audits',$data);
			redirect(base_url().'audits');
		}		  
   
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos
		);

		$vista_externa = array(			
			'title' => ucwords("audits"),
			'contenido_main' => $this->load->view('components/audits/audits_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id){
		if ($this->input->post('enviar_form')){
			$data = array(
					'id_user' => $this->input->post('id_user'),
					'query' => $this->input->post('query'),
					'date' => $this->input->post('date'),
					'active' => $this->input->post('active'),
					'created_at' => $this->input->post('created_at'),
					'updated_at' => $this->input->post('updated_at'),
					'deleted_at' => $this->input->post('deleted_at'),
					'create_by' => $this->input->post('create_by'),
					'update_by' => $this->input->post('update_by'),
					'delete_by' => $this->input->post('delete_by')
				);
			$this->codegen_model->edit('audits',$data,'id_audit',$this->input->post('id_audit'));
			redirect(base_url().'audits');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->codegen_model->row('audits','*','id_audit = '.$id)
		);

		$vista_externa = array(			
			'title' => ucwords("audits"),
			'contenido_main' => $this->load->view('components/audits/audits_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->codegen_model->row('audits','*','id_audit = '.$id)
		);

		$vista_externa = array(			
			'title' => ucwords("audits"),
			'contenido_main' => $this->load->view('components/audits/audits_view', $vista_interna, true)
		);		  
   
		$this->load->view('template/view', $vista_externa);
	}

	function json($id){
		$json = $this->codegen_model->row('audits','*','id_audit = '.$id);
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}

	function json_all(){
		$json = $this->codegen_model->get('audits','*','');
		if($json) echo json_encode($json);
		else echo json_encode(array('status' => 'none'));
	}
	
	function delete($id){
		$this->codegen_model->delete('audits','id_audit',$id);             
	}
}

/* End of file audits.php */
/* Location: ./system/application/controllers/audits.php */