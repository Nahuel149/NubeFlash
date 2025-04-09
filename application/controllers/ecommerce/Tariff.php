<?php

class Tariff extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
        $this->load->model('tariff_model','tariff');
		$this->load->model('destination_model','destination');
        $this->load->model('province_model','province');
        $this->load->model('country_model','country');
	}	
	
	function index() {

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'results' => $this->tariff->get()
		);

		$vista_externa = array(			
			'title' => ucwords("Tarifas"),
			'contenido_main' => $this->load->view('components/ecommerce/tariff/tariff_list', $vista_interna, true)
		);		

		$this->load->view('template/backend', $vista_externa);

	}

	function add(){
		if ($this->input->post('enviar_form')){
			// Determine province_id and province_name_manual based on form submission
            $province_id = null;
            $province_name_manual = null;
            if ($this->input->post('province_manual')) {
                // Manual province was entered
                $province_name_manual = trim($this->input->post('province_manual'));
            } elseif ($this->input->post('province') && $this->input->post('province') !== 'other') {
                // Valid province ID was selected
                $province_id = $this->input->post('province');
            }
            
            // Determine destination_id and destination_name_manual based on form submission
            $destination_id = null;
            $destination_name_manual = null;
            if ($this->input->post('destination_manual')) {
                // Manual destination was entered
                $destination_name_manual = trim($this->input->post('destination_manual'));
            } elseif ($this->input->post('destination') && $this->input->post('destination') !== 'other') {
                // Valid destination ID was selected
                $destination_id = $this->input->post('destination');
            }
            
            // Get postal_code_manual (if entered)
            $postal_code_manual = trim($this->input->post('postal_code_manual'));
            
			$data = array(
                'country_id' => $this->input->post('country'),
                'province_id' => $province_id,
                'province_name_manual' => $province_name_manual,
                'destination_id' => $destination_id,
                'destination_name_manual' => $destination_name_manual,
                'postal_code_manual' => $postal_code_manual,
                'weight' => $this->input->post('weight'),
                'volume' => $this->input->post('volume'),
                'tariff_price' => $this->input->post('tariff_price'),
                'create_by' => $this->session->userdata('user_id')
			);
			$this->tariff->insert($data);
			redirect(base_url('ecommerce/tariff'),'refresh');
		}	

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
            'countries' => $this->country->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Tarifas"),
			'contenido_main' => $this->load->view('components/ecommerce/tariff/tariff_add', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}	

	function edit($id = null){
		// Check if ID is provided
		if ($id === null) {
			$this->session->set_flashdata('error', 'No se especificó una tarifa para editar');
			redirect(base_url('ecommerce/tariff'),'refresh');
			return;
		}

		// Try to find the tariff
		$tariff = $this->tariff->find($id);
		if (!$tariff) {
			$this->session->set_flashdata('error', 'La tarifa especificada no existe');
			redirect(base_url('ecommerce/tariff'),'refresh');
			return;
		}

		if ($this->input->post('enviar_form')){
            // Determine province_id and province_name_manual based on form submission
            $province_id = null;
            $province_name_manual = null;
            if ($this->input->post('province_manual')) {
                // Manual province was entered
                $province_name_manual = trim($this->input->post('province_manual'));
            } elseif ($this->input->post('province') && $this->input->post('province') !== 'other') {
                // Valid province ID was selected
                $province_id = $this->input->post('province');
            }
            
            // Determine destination_id and destination_name_manual based on form submission
            $destination_id = null;
            $destination_name_manual = null;
            if ($this->input->post('destination_manual')) {
                // Manual destination was entered
                $destination_name_manual = trim($this->input->post('destination_manual'));
            } elseif ($this->input->post('destination') && $this->input->post('destination') !== 'other') {
                // Valid destination ID was selected
                $destination_id = $this->input->post('destination');
            }
            
            // Get postal_code_manual (if entered)
            $postal_code_manual = trim($this->input->post('postal_code_manual'));
            
			$data = array(
				'country_id' => $this->input->post('country'),
                'province_id' => $province_id,
                'province_name_manual' => $province_name_manual,
                'destination_id' => $destination_id,
                'destination_name_manual' => $destination_name_manual,
                'postal_code_manual' => $postal_code_manual,
                'weight' => $this->input->post('weight'),
                'volume' => $this->input->post('volume'),
                'tariff_price' => $this->input->post('tariff_price'),
                'update_by' => $this->session->userdata('user_id')
			);
			$this->tariff->edit($data, $id);
			$this->session->set_flashdata('success', 'Tarifa actualizada exitosamente');
			redirect(base_url('ecommerce/tariff'),'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $tariff,
            'countries' => $this->country->get(),
		);

		$vista_externa = array(			
			'title' => ucwords("Tarifas"),
			'contenido_main' => $this->load->view('components/ecommerce/tariff/tariff_edit', $vista_interna, true)
		);		  
   
		$this->load->view('template/backend', $vista_externa);
	}

	function view($id){
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'result' => $this->tariff->find($id),
		);

		$vista_externa = array(			
			'title' => ucwords("Tarifas"),
			'contenido_main' => $this->load->view('components/ecommerce/tariff/tariff_view', $vista_interna, true)
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
				'active' => 0,
				'deleted_at' => date('Y-m-d H:i:s'),
				'delete_by' => $this->session->userdata('user_id')
			);
			
			$this->tariff->edit($data, $id);
			
			$response['success'] = true;
			$response['message'] = 'Tarifa eliminada exitosamente';
		} catch (Exception $e) {
			$response['message'] = 'Ocurrió un error al eliminar la tarifa';
		}

		echo json_encode($response);
	}

    function getProvince()
    {
        $response = array(
            'success' => false,
            'provinces' => '',
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $country_id = $this->input->post('country_id');
        if($country_id > 0)
        {
            $provinces = $this->codegen_model->get('provinces','*','country_id="'.$country_id.'" AND active="'.ACTIVE.'"');
            $response['success'] = true;
            $response['provinces'] = $provinces;
        }

        echo json_encode($response);
    }

    function getDestination()
    {
        $response = array(
            'success' => false,
            'destinations' => '',
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $province_id = $this->input->post('province_id');
        if($province_id > 0)
        {
            $destinations = $this->codegen_model->get('destinations','*','province_id = "'.$province_id.'" AND active = "'.ACTIVE.'"');

            $response['success'] = true;
            $response['destinations'] = $destinations;
        }

        echo json_encode($response);
    }

}
