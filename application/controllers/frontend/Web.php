<?php

class Web extends CI_Controller {

	function __construct() {
		parent::__construct();		
		$this->load->model('customer_model','customer');
		$this->load->model('destination_model','destination');
        $this->load->model('province_model','province');
        $this->load->model('country_model','country');
		$this->load->model('faq_model','faq');
	}

	public function index() {
		$filters = array(
			'where' => array(
				'active' => ACTIVE,
			)
		);
		$vista_interna = array(
			'preguntas_frecuentes'	=>	$this->faq->get($filters),
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/public/index', $vista_interna, true),	
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
		);

		$this->load->view('template/frontend', $vista_externa);
	}

	public function login()
	{
		// Check if user is already logged in
		if($this->session->userdata('customer_id')) {
			redirect(base_url('mi-perfil'),'refresh');
		}

		if($this->input->post())
		{	
			// Validate CSRF token
			if ($this->input->post($this->security->get_csrf_token_name()) !== $this->security->get_csrf_hash()) {
				$this->session->set_flashdata('error', 'Error de seguridad. Por favor, intente nuevamente.');
				redirect(base_url('login'),'refresh');
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

				redirect(base_url('mi-perfil'),'refresh');
			}else{
				
				$this->session->set_flashdata('error', 'Email/contraseña incorrecta');
				redirect(base_url('login'),'refresh');
			}
		}

		$vista_interna = array(
			// 'sliders' => $this->slider->get(),
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/public/login', $vista_interna, true),	
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
		);

		$this->load->view('template/frontend', $vista_externa);
	}

	public function register() {
		if ($this->input->post()) {
			// Load form validation library if not already loaded
			if (!$this->load->is_loaded('form_validation')) {
				$this->load->library('form_validation');
			}
			
			// Set validation rules for password
			$this->form_validation->set_rules(
				'password',
				'contraseña',
				'required|regex_match[/^(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/]',
				array(
					'required' => 'El campo %s es obligatorio.',
					'regex_match' => 'La contraseña debe tener al menos 8 caracteres, 1 letra mayúscula y 1 símbolo (por ejemplo, !@#$%^&*).'
				)
			);
			
			// Run validation
			if ($this->form_validation->run() == FALSE) {
				// Validation failed, load the form with errors
				$vista_interna = array(
					'countries' => $this->country->get(),
				);
				
				$vista_config  = array(
					'metadata' => '',
					'title' => '',
					'description' => '',
				);
				
				$vista_externa = array(
					'contenido_main' => $this->load->view('frontend/public/register', $vista_interna, true),	
					'configuracion' => $this->frontend_lib->configuraciones($vista_config),
					'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
				);
				
				$this->load->view('template/frontend', $vista_externa);
				return;
			}
		
			// Verificamos la validación del captcha
			if ($this->input->post('g-recaptcha-response')) {
				// Verificar captcha
				$token = $this->input->post('g-recaptcha-response');
				$verificado = $this->verificarToken($token, CAPTCHA_SECRET);
				
				// Verificar si el captcha es correcto
				if($verificado) {
					if ($this->input->post('re-password') == $this->input->post('password')) {
						$exists_email = $this->codegen_model->row('customers','*','email="'.$this->input->post('email').'" AND active="'.ACTIVE.'"');
						if (!$exists_email) {
							// Use the location field to store the manually entered destination
							$location_text = $this->input->post('destination_text');
							
							$data = array(
								'social_reason' => $this->input->post('social_reason'),
								'fiscal_identifier' => $this->input->post('fiscal_identifier'),
								'person_contact' => $this->input->post('person_contact'),
								'telephone' => $this->input->post('telephone'),
								'email' => $this->input->post('email'),
								'password' => sha1($this->input->post('password')),
								'country_id' => $this->input->post('country'),
								'province_id' => $this->input->post('province'),
								'destination_id' => null, // Set to NULL since we're using a text field
								'location' => $location_text // Use existing location field to store text input
							);
							
							$customer = $this->customer->insert($data);
							
							$token = sha1($customer.uniqid());
							$data_token = array(
								'token' => $token,
								'token_dev' => 'Dev-'.$token,
								'customer_id' => $customer,
							);
							$this->codegen_model->add('token_customers',$data_token);
		
							$datosStore = array(
								'name' 	=> 	$data['person_contact'],
								'email' 	=> 	$data['email'],
								'enterprise' 	=>	$data['social_reason'],
							);
		
							$configuracion = $this->codegen_model->row('configurations','*','id_configuration = 3');
							$remitente = $this->codegen_model->row('configurations','*','id_configuration = 1');
		
							$this->frontend_lib->enviarEmail($datosStore, 'frontend/email/register_nube', 'Confirmación de cuenta.', $datosStore['email'], CORREO_QA, $remitente->value);
							$this->frontend_lib->enviarEmail($datosStore, 'frontend/email/register', 'Confirmación de cuenta.', $configuracion->value, CORREO_QA, $remitente->value);
		
							$this->session->set_flashdata('success', 'Se registró con éxito. Por favor, revise su correo electrónico para la confirmación.<br>Inicie sesión con su correo y contraseña usando el botón "LOGIN / REGISTRATE"');
						} else {
							$this->session->set_flashdata('error', 'Este correo electronico ya existe');
						}
					} else {
						$this->session->set_flashdata('error', 'Las contraseñas no coinciden');
					}
					redirect(base_url('registro'),'refresh');
				} else {
					$this->session->set_flashdata('error', 'Verifica que no eres un robot.');
					redirect(base_url('registro'), 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Verifica que no eres un robot.');
				redirect(base_url('registro'), 'refresh');
			}
		}

		$vista_interna = array(
            'countries' => $this->country->get(),
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/public/register', $vista_interna, true),	
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
		);

		$this->load->view('template/frontend', $vista_externa);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('index'),'refresh');
	}
	public function documentation()
	{
		$vista_interna = array(
			
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/public/apisdocumentation', $vista_interna, true),	
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
		);

		$this->load->view('template/frontend', $vista_externa);
	}

	public function contacto() {
		// Verificar si es metodo post
		if ($this->input->post()) {
			// Validación del lado del servidor
			$this->load->library('form_validation');
			
			// Configurar reglas de validación
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('enterprise', 'Empresa', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('telephone', 'Teléfono', 'trim|required|callback_validate_phone');
			$this->form_validation->set_rules('message', 'Mensaje', 'trim|required|max_length[1000]');
			
			// Si la validación falla
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect(base_url('index#section_contacto'), 'refresh');
				return;
			}
		
			// Verificamos la validación del captcha
			if ($this->input->post('g-recaptcha-response')) {
				// Verificar captcha
				$token = $this->input->post('g-recaptcha-response');
				$verificado = $this->verificarToken($token, CAPTCHA_SECRET);

				// Verificar si el captcha es correcto
				if($verificado) {
					$datos = array(
						'name' => $this->input->post('name'),
						'enterprise' => $this->input->post('enterprise'),
						'email' => $this->input->post('email'),
						'telephone' => $this->input->post('telephone'),
						'message' => $this->input->post('message'),
					);
					
					$configuracion = $this->codegen_model->row('configurations','*','id_configuration = 3');
					$remitente = $this->codegen_model->row('configurations','*','id_configuration = 1');
		
					$this->frontend_lib->enviarEmail($datos, 'frontend/email/contact', 'Nuevo contacto', $configuracion->value, CORREO_QA, $remitente->value);
					$this->session->set_flashdata('contactoProcesado', 'Procesado');
		
					redirect(base_url('index#section_contacto'), 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Verifica que no eres un robot.');
					redirect(base_url('index#section_contacto'), 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Verifica que no eres un robot.');
				redirect(base_url('index#section_contacto'), 'refresh');
			}
		}

		$vista_interna = array(
			
		);

		$vista_config  = array(
			'metadata' => '',
			'title' => '',
			'description' => '',
		);

		$vista_externa = array(
			'contenido_main' => $this->load->view('frontend/public/contacto', $vista_interna, true),	
			'configuracion' => $this->frontend_lib->configuraciones($vista_config),
			'configurations' => $this->codegen_model->get('configurations','*','id_configuration > 0'),
		);

		$this->load->view('template/frontend', $vista_externa);
	}

	public function verificarToken($token, $claveSecreta) {
		# La API en donde verificamos el token
		$url = "https://www.google.com/recaptcha/api/siteverify";
		# Los datos que enviamos a Google
		$datos = [
			"secret" => $claveSecreta,
			"response" => $token,
		];
		// Crear opciones de la petición HTTP
		$opciones = array(
			"http" => array(
				"header" => "Content-type: application/x-www-form-urlencoded\r\n",
				"method" => "POST",
				"content" => http_build_query($datos), # Agregar el contenido definido antes
			),
		);
		# Preparar petición
		$contexto = stream_context_create($opciones);
		# Hacerla
		$resultado = file_get_contents($url, false, $contexto);
		# Si hay problemas con la petición (por ejemplo, que no hay internet o algo así)
		# entonces se regresa false. Este NO es un problema con el captcha, sino con la conexión
		# al servidor de Google
		if ($resultado === false) {
			# Error haciendo petición
			return false;
		}
	
		# En caso de que no haya regresado false, decodificamos con JSON
		# https://parzibyte.me/blog/2018/12/26/codificar-decodificar-json-php/
	
		$resultado = json_decode($resultado);
		# La variable que nos interesa para saber si el usuario pasó o no la prueba
		# está en success
		$pruebaPasada = $resultado->success;
		
		return $pruebaPasada;
   }

	public function pdf($filename = '')
	{
		// Define allowed PDF files
		$allowed_pdfs = [
			'politicas' => 'La Nube - Políticas de Privacidad.pdf',
			'terminos' => '4. LaNube - Términos y condiciones v. 06.03.2023-1.pdf'
		];
		
		// Log the requested filename
		log_message('debug', 'PDF requested: ' . $filename);
		
		// Check if the requested file is allowed
		if (!array_key_exists($filename, $allowed_pdfs)) {
			log_message('error', 'PDF not allowed: ' . $filename);
			show_404();
			return;
		}
		
		// Get the actual filename
		$actual_filename = $allowed_pdfs[$filename];
		$file_path = FCPATH . 'assets/public/' . $actual_filename;
		
		// Log the file path
		log_message('debug', 'PDF file path: ' . $file_path);
		
		// Check if file exists
		if (!file_exists($file_path)) {
			log_message('error', 'PDF file not found in public folder: ' . $file_path);
			
			// Try the frontend/web/pdf folder
			if ($filename == 'politicas') {
				$file_path = FCPATH . 'assets/frontend/web/pdf/politicas/La Nube - Políticas de Privacidad.pdf';
			} else if ($filename == 'terminos') {
				$file_path = FCPATH . 'assets/frontend/web/pdf/terminos/4. LaNube - Términos y condiciones.pdf';
			}
			
			log_message('debug', 'Trying alternative path: ' . $file_path);
			
			if (!file_exists($file_path)) {
				log_message('error', 'PDF file not found in alternative location: ' . $file_path);
				show_404();
				return;
			}
		}
		
		// Set headers and serve the file
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
		header('Cache-Control: public, max-age=86400');
		
		// Output the file contents
		readfile($file_path);
		exit;
	}

	public function serve_pdf($filename)
	{
		// URL decode the filename
		$filename = urldecode($filename);
		
		// Security check - only allow PDF files
		if (!preg_match('/\.pdf$/i', $filename)) {
			log_message('error', 'Invalid file extension: ' . $filename);
			show_404();
			return;
		}
		
		// Try the public folder first
		$file_path = FCPATH . 'assets/public/' . $filename;
		
		// Log the file path for debugging
		log_message('debug', 'Trying to serve PDF file from public folder: ' . $file_path);
		
		// If not found, try to find it in the frontend/web/pdf folder
		if (!file_exists($file_path)) {
			log_message('debug', 'PDF not found in public folder, trying to find it in frontend/web/pdf');
			
			// Check if it's the privacy policy
			if (stripos($filename, 'politica') !== false || stripos($filename, 'privacidad') !== false) {
				$file_path = FCPATH . 'assets/frontend/web/pdf/politicas/La Nube - Políticas de Privacidad.pdf';
			}
			// Check if it's the terms and conditions
			else if (stripos($filename, 'termino') !== false || stripos($filename, 'condicion') !== false) {
				$file_path = FCPATH . 'assets/frontend/web/pdf/terminos/4. LaNube - Términos y condiciones.pdf';
			}
			
			log_message('debug', 'Trying alternative path: ' . $file_path);
		}
		
		// Check if file exists
		if (!file_exists($file_path)) {
			log_message('error', 'PDF file not found in any location: ' . $file_path);
			show_404();
			return;
		}
		
		// Set headers and serve the file
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
		header('Cache-Control: public, max-age=86400');
		
		// Output the file contents
		readfile($file_path);
		exit;
	}

	public function politicas_pdf()
	{
		// Try the public folder first
		$file_path = FCPATH . 'assets/public/La Nube - Políticas de Privacidad.pdf';
		
		// If not found, try the frontend/web/pdf folder
		if (!file_exists($file_path)) {
			log_message('debug', 'Políticas PDF not found in public folder, trying alternative location');
			$file_path = FCPATH . 'assets/frontend/web/pdf/politicas/La Nube - Políticas de Privacidad.pdf';
		}
		
		if (!file_exists($file_path)) {
			log_message('error', 'Políticas PDF file not found in any location');
			show_404();
			return;
		}
		
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="Politicas_de_Privacidad.pdf"');
		header('Cache-Control: public, max-age=86400');
		readfile($file_path);
		exit;
	}
	
	public function terminos_pdf()
	{
		// Try the public folder first
		$file_path = FCPATH . 'assets/public/4. LaNube - Términos y condiciones v. 06.03.2023-1.pdf';
		
		// If not found, try the frontend/web/pdf folder
		if (!file_exists($file_path)) {
			log_message('debug', 'Términos PDF not found in public folder, trying alternative location');
			$file_path = FCPATH . 'assets/frontend/web/pdf/terminos/4. LaNube - Términos y condiciones.pdf';
		}
		
		if (!file_exists($file_path)) {
			log_message('error', 'Términos PDF file not found in any location');
			show_404();
			return;
		}
		
		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="Terminos_y_Condiciones.pdf"');
		header('Cache-Control: public, max-age=86400');
		readfile($file_path);
		exit;
	}

	// Función de validación personalizada para el teléfono
	public function validate_phone($phone) {
		// El teléfono solo puede contener números y un + al inicio
		if (!preg_match('/^\+?[0-9]+$/', $phone)) {
			$this->form_validation->set_message('validate_phone', 'El campo {field} solo puede contener números y un signo + al inicio.');
			return FALSE;
		}
		return TRUE;
	}
}