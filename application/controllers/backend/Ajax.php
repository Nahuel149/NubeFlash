<?php

class Ajax extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}
	}	
	
	function deleteIMG(){
		$data = array('imagen' => "");
		$tabla = $this->input->post('tabla');
		$id = $this->input->post('id');
		$this->codegen_model->edit($tabla,$data,'id',$id);
	}

	function deleteFoto(){
		if (!$this->ion_auth->logged_in()) {
			$this->output->set_status_header(403);
			echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
			return;
		}

		$id = $this->input->post('id');
		if (!$id) {
			$this->output->set_status_header(400);
			echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
			return;
		}

		// Get current user
		$user = $this->ion_auth->user()->row();
		
		// Check if user is admin or owns the photo
		if (!$this->ion_auth->is_admin() && $user->id_user != $id) {
			$this->output->set_status_header(403);
			echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
			return;
		}

		try {
			// Get current user data to verify image exists
			$current_user = $this->codegen_model->row('users', '*', 'id_user = ' . $id);
			if (!$current_user) {
				throw new Exception('Usuario no encontrado');
			}

			// Delete physical file if exists
			if (!empty($current_user->avatar)) {
				$file_path = FCPATH . 'uploads/users/' . $current_user->avatar;
				if (file_exists($file_path)) {
					unlink($file_path);
				}
			}

			// Update database
			$data = array('avatar' => '');
			$this->codegen_model->edit('users', $data, 'id_user', $id);
			
			$this->output->set_content_type('application/json');
			echo json_encode(['status' => 'success', 'message' => 'Imagen eliminada correctamente']);
		} catch (Exception $e) {
			$this->output->set_status_header(500);
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}

	function cambiarValor(){
		$id = $this->input->post('id');
		$tabla = $this->input->post('tabla');
		$campo = $this->input->post('campo');
		$contenido = $this->codegen_model->row($tabla, 'id, '.$campo,'id = '.$id);
		switch ($contenido->$campo) {
			case 0:
				echo $valor = 1;
				break;
			
			case 1:
				echo $valor = 0;
				break;
		}
		$data = array($campo => $valor);
		$this->codegen_model->edit($tabla,$data,'id',$id);
	}
}

/* End of file auditoria.php */
/* Location: ./system/application/controllers/ajax.php */