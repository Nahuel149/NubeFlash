<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->load->model('faq_model','faq');
	}	

	function index() {

		$filters = array(
			'where' => array(
				'active' => ACTIVE,
			)
		);

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->faq->get($filters),
		);

		$vista_externa = array(
			'title' => ucwords("preguntas y respuestas"),
			'contenido_main' => $this->load->view('components/ecommerce/faqs/faqs_list', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);

	}

	function add() {
		if ($this->input->post('enviar_form')){
			$data = array(
				'question' => $this->input->post('pregunta'),
				'answer' => $this->input->post('respuesta')
			);
			$this->faq->add($data);
			redirect(base_url('ecommerce/faqs'),'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
		);

		$vista_externa = array(			
			'title' => ucwords("preguntas y respuestas"),
			'contenido_main' => $this->load->view('components/ecommerce/faqs/faqs_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id) {
		if ($this->input->post('enviar_form')){
			$data = array(
				'question' => $this->input->post('pregunta'),
				'answer' => $this->input->post('respuesta')
			);

			$filters = array(
				'where' => array(
					'id_faq' => $id,
				),
			);

			$this->faq->edit($data, $filters);
			redirect(base_url('ecommerce/faqs'),'refresh');
		}
		$pregunta= array(
			'where' => array(
				'id_faq' => $id
			)
		);
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->faq->find($pregunta)
		);
		
		$vista_externa = array(			
			'title' => ucwords("preguntas y respuestas"),
			'contenido_main' => $this->load->view('components/ecommerce/faqs/faqs_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id) {

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->faq->find($id),
		);

		$vista_externa = array(			
			'title' => ucwords("preguntas y respuestas"),
			'contenido_main' => $this->load->view('components/ecommerce/faqs/faqs_view', $vista_interna, true)
		);		  
   
		$this->load->view('template/view', $vista_externa);
	}
	
	function delete($id) {
		$filters = array(
			'where' => array(
				'id_faq' => $id,
			),
		);

		$data = array(
			'active'	=> 0,
		);

		$this->faq->edit($data, $filters);
	}

}

/* End of file Preguntas_respuestas.php */
/* Location: ./application/controllers/ecommerce/Preguntas_respuestas.php */