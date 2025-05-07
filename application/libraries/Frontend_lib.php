<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frontend_lib{
	
	public function __construct(){
		
	}

	public function __get($var){
		return get_instance()->$var;
	}	

	public function configuraciones($array){
		$configuraciones = array();

		// Set default values for required fields
		$configuraciones['title'] = isset($array['title']) ? $array['title'] : '';
		$configuraciones['autor'] = ' Elfiko';
		$configuraciones['copyright'] = '2018';
		$configuraciones['descripcion'] = ''; // Default empty value
		$configuraciones['keywords'] = ''; // Default empty value

		if (!empty($array['og_title'])) {
			$configuraciones['og_title'] = $array['og_title'];
		}
		if (!empty($array['og_description'])) {
			$configuraciones['og_description'] = $array['og_description'];
		}
		if (!empty($array['og_image'])) {
			$configuraciones['og_image'] = $array['og_image'];
		}

		$query = $this->codegen_model->get('configurations', '*', '');
		foreach ($query as $f) {
			switch ($f->key_id) {
				case 'keywords':
					$configuraciones[$f->key_id] = $f->value . ' ' . (isset($array['metadata']) ? $array['metadata'] : '');
					break;

				case 'descripcion':
					$configuraciones[$f->key_id] = $f->value . ' ' . (isset($array['description']) ? $array['description'] : '');
					break;
				
				default:
					$configuraciones[$f->key_id] = $f->value;
					break;
			}			
		}

		return $configuraciones;
	}

	public function loadIdioma(){
		if ($this->session->userdata('idioma')) {
			return $this->session->userdata('idioma');
		}else{
			$sesion_data = array('idioma' => 'spanish');
            $this->session->set_userdata($sesion_data);
            return $this->session->userdata('idioma');
		}
	}

	public function validarSession(){
		if (!$this->session->userdata('cliente_id')){
			redirect(base_url().'registrarse');
		}else{
			$this->log('read', '');
		}
	}

	public function log(){
		$level = 'INFO';
		$msj = $this->uri->uri_string().": fue accedida por el usuario ".$this->session->userdata('cliente_usuario');
  
  		$filepath = 'application/logs/frontend/log-'.date('Y-m-d').'.php';
  		$message  = '';

  		if ( ! file_exists($filepath)){
   			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
  		}

  		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE) ){
   			return FALSE;
  		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date('Y-m-d H:i:s'). ' --> '.$msj."\n";

  		flock($fp, LOCK_EX);
  		fwrite($fp, $message);
  		flock($fp, LOCK_UN);
  		fclose($fp);

  		@chmod($filepath, FILE_WRITE_MODE);
	}

	public function enviarEmail($data, $vista, $titulo, $email_destino, $email_origen, $remitente, $email_bcc = null){
		// Inicializar libreria
		$this->load->library('email');

		$datos['dato'] = $data;
		// Cargar mensaje
		$mensaje = $this->load->view($vista, $datos, true);
	
		// Datos de envio email
		$this->email->to($email_destino);
		$this->email->from($email_origen, $remitente);
		$this->email->subject($titulo);
		$this->email->message($mensaje);

		// Add BCC if provided
		if ($email_bcc && !empty(trim($email_bcc))) {
			$this->email->bcc($email_bcc);
		}

		// Enviar email y verificar si hubo error
		if (!$this->email->send(FALSE)) { // Pass FALSE to prevent clearing attachments on failure
			$message = "ERROR EMAIL => Email: $vista, \n  Título: $titulo \n Destino: $email_destino \n Origen: $email_origen \n Remitente: $remitente \n BCC: $email_bcc \n Datos: " . json_encode($data);
			log_message('error', $message);
            log_message('error', 'Email Debugging Info: ' . $this->email->print_debugger());
		}
	}

        public function enviarEmailPedido($mensaje, $titulo, $email_destino, $email_origen, $remitente){
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);		
		$this->email->from($email_origen, $remitente);
		$this->email->to($email_destino);
		$this->email->subject($titulo);
		$this->email->message($mensaje);
		$this->email->send();	
	}

}