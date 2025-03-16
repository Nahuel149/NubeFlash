<?php 
	if ($this->ion_auth->logged_in()){
		$this->load->view('backend/dashboard/dashboard_estructura');
		$this->load->view('backend/dashboard/dashboard_js');
	}
	else redirect(site_url('backend/auth/login'), 'refresh');
?>