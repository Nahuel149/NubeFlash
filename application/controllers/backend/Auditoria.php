<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auditoria extends CI_Controller {

	private $permisos;
	private $issa;

	public function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}
		$this->permisos = $this->permisos_lib->control();
		$this->issa = $this->permisos_lib->isSuperAdmin();
		$this->load->model('auditoria_model');
	}	
	
	public function index() {
		$user = $this->ion_auth->user()->row();
		
		// Get filters from POST or default values
		$filters = array(
			'date_from' => $this->input->post('date_from') ?: date('Y-m-d', strtotime('-30 days')),
			'date_to' => $this->input->post('date_to') ?: date('Y-m-d'),
			'user_id' => $this->input->post('user_id'),
			'action' => $this->input->post('action')
		);

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'logs' => $this->auditoria_model->get_activity_logs($filters),
			'users' => $this->ion_auth->users()->result(),
			'filters' => $filters
		);

		$vista_externa = array(
			'title' => ucwords("Registros de Actividad"),
			'contenido_main' => $this->load->view('backend/auditoria/auditoria_list', $vista_interna, true)
		);

		$this->load->view('template/backend', $vista_externa);
	}

	public function export() {
		if (!$this->permisos->export) {
			show_error('No tiene permisos para exportar registros de actividad.');
		}

		$filters = array(
			'date_from' => $this->input->get('date_from') ?: date('Y-m-d', strtotime('-30 days')),
			'date_to' => $this->input->get('date_to') ?: date('Y-m-d'),
			'user_id' => $this->input->get('user_id'),
			'action' => $this->input->get('action')
		);

		$logs = $this->auditoria_model->get_activity_logs($filters);
		
		// Load PHPSpreadsheet library
		require_once APPPATH . 'third_party/PHPSpreadsheet/vendor/autoload.php';
		
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		// Set headers
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'Usuario');
		$sheet->setCellValue('C1', 'Acción');
		$sheet->setCellValue('D1', 'Descripción');
		$sheet->setCellValue('E1', 'IP');
		$sheet->setCellValue('F1', 'Fecha');
		
		// Add data
		$row = 2;
		foreach ($logs as $log) {
			$sheet->setCellValue('A' . $row, $log->activity_id);
			$sheet->setCellValue('B' . $row, $log->username);
			$sheet->setCellValue('C' . $row, $log->action);
			$sheet->setCellValue('D' . $row, $log->description);
			$sheet->setCellValue('E' . $row, $log->ip_address);
			$sheet->setCellValue('F' . $row, $log->created_at);
			$row++;
		}
		
		// Auto-size columns
		foreach (range('A', 'F') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}
		
		// Create Excel file
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		
		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="activity_logs.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
	}
}

/* End of file auditoria.php */
/* Location: ./system/application/controllers/auditoria.php */