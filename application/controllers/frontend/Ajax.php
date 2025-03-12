<?php

class Ajax extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('codegen_model');
		
		// Add CORS headers for AJAX requests
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");

		$method = $_SERVER['REQUEST_METHOD'];
		if ($method == "OPTIONS") {
			die();
		}
	}	

	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	public function changePassword()
	{
		if(!$this->session->userdata('customer_id'))
        {
            redirect(base_url('login'),'refresh');   
        }
		$data['success'] = false;
		$id_customer = $this->session->userdata('customer_id');
		$contraseña = $this->input->post('contraseña');
		
		if($contraseña){
			// Server-side validation
			if (strlen($contraseña) < 8 || !preg_match('/[A-Z]/', $contraseña) || !preg_match('/[!@#$%^&*]/', $contraseña)) {
				$data['message'] = 'La nueva contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).';
				echo json_encode($data);
				return;
			}
			
			$param = array(
				'password' => sha1($contraseña),
			);
			$this->codegen_model->edit('customers',$param, 'customer_id',$id_customer);
			$data['success'] = true;
			$data['message'] = 'Contraseña cambiada con éxito.';
		}
		echo json_encode($data);
	}

	function getProvince()
    {
        $response = array(
            'success' => false,
            'provinces' => '',
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

	function login()
	{	
		$response['success'] = false;
		$response['message'] = 'Email/contraseña incorrecta';		

		// Validate CSRF token
		if ($this->input->post($this->security->get_csrf_token_name()) !== $this->security->get_csrf_hash()) {
			$response['message'] = 'Error de seguridad. Por favor, intente nuevamente.';
			echo json_encode($response);
			return;
		}

		$user = $this->input->post('email');
		$password = sha1($this->input->post('password'));
		
		$login = $this->codegen_model->row('customers','*','email="'.$user.'" AND password = "'.$password.'" AND active="'.ACTIVE.'"');
			
		if($login)
		{
			$data = array(
				'customer_id' => $login->customer_id,
				'name' => $login->person_contact,
				'email' => $login->email,
			);
			$this->session->set_userdata($data);

			$response['success'] = true;
		}

		echo json_encode($response);
	}

	public function validateCurrentPassword()
	{
		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			echo json_encode(['valid' => false, 'message' => 'Invalid request method']);
			return;
		}
		
		if(!$this->session->userdata('customer_id'))
		{
			echo json_encode(['valid' => false, 'message' => 'User not logged in']);
			return;
		}
		
		$current_password = $this->input->post('current_password');
		$customer_id = $this->session->userdata('customer_id');
		
		// Get the customer's current password from the database
		$customer = $this->codegen_model->row('customers', 'password', 'customer_id = "' . $customer_id . '"');
		
		// Check if the provided password matches the stored password
		$is_valid = ($customer && sha1($current_password) === $customer->password);
		
		echo json_encode(['valid' => $is_valid]);
	}
}
