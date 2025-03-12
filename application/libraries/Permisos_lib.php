<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permisos_lib
{
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('codegen_model');
		$this->CI->load->model('sudaca_backend_md');
	}

	public function __call($method, $arguments)
	{
		if (!method_exists( $this->ion_auth_model, $method) )
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}

		return call_user_func_array( array($this->ion_auth_model, $method), $arguments);
	}

	public function __get($var)
	{
		return get_instance()->$var;
	}

	public function control(){		
		// urls
		$link = $this->CI->uri->segment(2);
		$link_total = $this->CI->uri->segment(1).'/'.$this->CI->uri->segment(2);

		// controla la session
		if(!$this->CI->session->userdata('user_id')) {
			redirect(base_url().'backend/auth/login', 'refresh');
		}

		// For ecommerce routes, create a default permissions object with all permissions enabled
		if($this->CI->uri->segment(1) == 'ecommerce') {
			$permisos = new stdClass();
			$permisos->insert = 1;
			$permisos->update = 1;
			$permisos->delete = 1;
			$permisos->read = 1;
			return $permisos;
		}

		// Skip permission check for dashboard and users list
		if($link == 'dashboard' || ($this->CI->uri->segment(1) == 'backend' && $link == 'users')) {
			$permisos = new stdClass();
			$permisos->insert = 1;
			$permisos->update = 1;
			$permisos->delete = 1;
			$permisos->read = 1;
			return $permisos;
		}

		// valida los permisos
		$grupo = $this->CI->sudaca_backend_md->permisos_buscarGrupo($this->CI->session->userdata('user_id'));
		if (!$grupo) {
			redirect('backend/dashboard', 'refresh');
		}

		$menu = $this->CI->sudaca_backend_md->permisos_buscarPermiso($link, $grupo->id_group);
		if ($menu) {
			if($menu->read == 0){
				redirect('backend/dashboard', 'refresh');	
			}
		} else {
			redirect('backend/dashboard', 'refresh');
		}

		// registra log
		$this->CI->backend_lib->log();
		
		// retorna permisos
		$menu = $this->CI->sudaca_backend_md->permisos_getByLink($link_total);
		return $permisos = $this->CI->codegen_model->permisos_efectivos($menu->id_menu, $this->CI->session->userdata('user_id'));
	}

	public function isSuperAdmin(){
		$user_row = $this->CI->ion_auth->user()->row();
       	if (!$this->CI->ion_auth->in_group(1, $user_row->id_user)) return 0;
       	else return 1;
	}

	public function isPublicista(){
		$user_row = $this->CI->ion_auth->user()->row();
       	if (!$this->CI->ion_auth->in_group(5, $user_row->id)) return 0;
       	else return 1;
	}
}