<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends CI_Controller {

	private $permisos;
	private $issa;

	public function __construct() {
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}
		$this->permisos = $this->permisos_lib->control();
		$this->issa = $this->permisos_lib->isSuperAdmin();
		$this->load->model('logs_model');
		$this->load->model('sudaca_md');
		$this->load->model('auditoria_model');

		$this->load->helper('directory');
		$this->load->helper('file');
		$this->load->library('zip');
		$this->load->helper('download');
	}	
	
	public function index() {
		$user = $this->ion_auth->user()->row();
		
		// Get filters from POST or default values
		$filters = array(
			'date_from' => $this->input->post('date_from') ?: date('Y-m-d', strtotime('-30 days')),
			'date_to' => $this->input->post('date_to') ?: date('Y-m-d'),
			'log_type' => $this->input->post('log_type') ?: 'activity_logs'
		);
		
		// Get user for activity logs
		$user_id = $this->input->post('user_id') ?: $user->id;
		
		// Get activity logs using the same method as dashboard's ultimos_accesos
		$activity_logs = $this->sudaca_md->getUltimosAccesos($user_id, 100); // Get more logs (100)
		
		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'login_attempts' => ($filters['log_type'] == 'login_attempts') ? $this->logs_model->get_login_attempts($filters) : array(),
			'login_errors' => ($filters['log_type'] == 'login_errors') ? $this->logs_model->get_login_errors($filters) : array(),
			'activity_logs' => $activity_logs,
			'filters' => $filters
		);
		
		$vista_externa = array(
			'title' => ucwords("Registros del Sistema"),
			'contenido_main' => $this->load->view('backend/logs/logs_list', $vista_interna, true)
		);
		
		$this->load->view('template/backend', $vista_externa);
	}

	public function export() {
		if (!$this->permisos->export) {
			show_error('No tiene permisos para exportar registros del sistema.');
		}
		
		$filters = array(
			'date_from' => $this->input->get('date_from') ?: date('Y-m-d', strtotime('-30 days')),
			'date_to' => $this->input->get('date_to') ?: date('Y-m-d'),
			'log_type' => $this->input->get('log_type') ?: 'activity_logs'
		);
		
		// Get user for activity logs
		$user = $this->ion_auth->user()->row();
		$user_id = $this->input->get('user_id') ?: $user->id;
		
		if ($filters['log_type'] == 'activity_logs') {
			$logs = $this->sudaca_md->getUltimosAccesos($user_id, 1000); // Get more logs for export
		} else {
			$logs = ($filters['log_type'] == 'login_attempts') ? 
					$this->logs_model->get_login_attempts($filters) : 
					$this->logs_model->get_login_errors($filters);
		}
		
		// Load PHPSpreadsheet library
		require_once APPPATH . 'third_party/phpspreadsheet/autoload.php';
		
		try {
			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			
			// Set headers based on log type
			if ($filters['log_type'] == 'login_attempts') {
				$sheet->setCellValue('A1', 'ID');
				$sheet->setCellValue('B1', 'IP');
				$sheet->setCellValue('C1', 'Usuario');
				$sheet->setCellValue('D1', 'Fecha');
				$sheet->setCellValue('E1', 'Estado');
				
				// Add data
				$row = 2;
				foreach ($logs as $log) {
					$sheet->setCellValue('A' . $row, $log->id);
					$sheet->setCellValue('B' . $row, $log->ip_address);
					$sheet->setCellValue('C' . $row, $log->login);
					$sheet->setCellValue('D' . $row, date('d/m/Y H:i:s', $log->time));
					$sheet->setCellValue('E' . $row, $log->active ? 'Activo' : 'Inactivo');
					$row++;
				}
			} else if ($filters['log_type'] == 'activity_logs') {
				$sheet->setCellValue('A1', 'Fecha');
				$sheet->setCellValue('B1', 'Acción');
				$sheet->setCellValue('C1', 'Descripción');
				$sheet->setCellValue('D1', 'IP');
				
				// Add data
				$row = 2;
				foreach ($logs as $log) {
					$sheet->setCellValue('A' . $row, date('d/m/Y H:i:s', strtotime($log->created_at)));
					$sheet->setCellValue('B' . $row, $log->action);
					$sheet->setCellValue('C' . $row, $log->description);
					$sheet->setCellValue('D' . $row, $log->ip_address);
					$row++;
				}
			} else {
				$sheet->setCellValue('A1', 'ID');
				$sheet->setCellValue('B1', 'Usuario');
				$sheet->setCellValue('C1', 'IP');
				$sheet->setCellValue('D1', 'Fecha');
				
				// Add data
				$row = 2;
				foreach ($logs as $log) {
					$sheet->setCellValue('A' . $row, $log->id_login);
					$sheet->setCellValue('B' . $row, $log->user);
					$sheet->setCellValue('C' . $row, $log->ip_address);
					$sheet->setCellValue('D' . $row, $log->date);
					$row++;
				}
			}
			
			// Auto-size columns
			foreach (range('A', 'F') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}
			
			// Create Excel file
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			
			// Set headers for download
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="system_logs.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer->save('php://output');
		} catch (Exception $e) {
			log_message('error', 'PHPSpreadsheet error: ' . $e->getMessage());
			show_error('Error al generar el archivo Excel. Por favor, inténtelo de nuevo más tarde.');
		}
	}

	function txt($archivo){		
		$cadena = read_file('./application/logs/backend/'.$archivo.'.php');
		$array = array("<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>" => ''); 
        $value = str_replace(array_keys($array), array_values($array), $cadena);
        $fecha = 'log-'.date('Y-m-d_h-m-s');
        $archivo_nombre = $fecha.'.txt';
		$nombre = $archivo_nombre;
		$this->zip->add_data($nombre, $value);
		$this->zip->archive('./uploads/zip/'.$fecha.'.zip'); 
		$this->zip->download($fecha.'.zip');
	}

	function zip(){
		$logs = $this->dir_map_sort(directory_map('./application/logs/backend/'));
		$desde = $this->input->post('fecha_desde');
		$hasta = $this->input->post('fecha_hasta');
		$archivo_descarga = 'log-'.date('Y-m-d_h-m-s');
		foreach ($logs as $f) {
			$array_breadcrumb = array('log-' => '', '.php' => ''); 
            $archivo = str_replace(array_keys($array_breadcrumb), array_values($array_breadcrumb), $f);

			if ($archivo >= $desde && $archivo <= $hasta) {
				$cadena = read_file('./application/logs/backend/'.$archivo.'.php');
				$array = array("<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>" => ''); 
				$value = str_replace(array_keys($array), array_values($array), $cadena);
        		$archivo_nombre = 'log-'.$archivo.'.txt';
				$this->zip->add_data($archivo_nombre, $value);
			}
		}	
        
		$this->zip->archive('./uploads/zip/'.$archivo_descarga.'.zip'); 
		$this->zip->download($archivo_descarga.'.zip');

		redirect(base_url().'logs');
	}

	function dir_map_sort($array){
	    $items = array();
	    foreach ($array as $key => $val){
	        if (is_array($val)){
	            $items[$key] = (!empty($array)) ? dir_map_sort($val) : $val; 
	        }else{
	            $items[$val] = $val;
	        }
	    }
	    ksort($items);
	    return $items;
	}
	
}

/* End of file categorias.php */
/* Location: ./system/application/controllers/logs.php */