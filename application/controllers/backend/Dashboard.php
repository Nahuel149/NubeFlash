<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	private $permisos;
	private $issa;

	function __construct() {
		parent::__construct();
		$this->permisos = $this->permisos_lib->control();
		$this->issa = $this->permisos_lib->isSuperAdmin();
		$this->load->model('sudaca_md');
	}

	public function index(){
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}
		
		$user = $this->ion_auth->user()->row();

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa
		);

		$vista_externa = array(			
			'title' => ucwords("bienvenido ".$user->surname.', '.$user->name),
			'contenido_main' => $this->load->view('backend/dashboard/dashboard_estructura', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	public function micuenta(){
		$user = $this->ion_auth->user()->row();

		if ($this->input->post('enviar_form')) {
			if (!empty($_FILES['foto']['tmp_name'])) {
				$img = $this->backend_lib->imagen_upload('foto', 'users');
			} else {
				$foto = $this->codegen_model->row('users', 'id_user, avatar', 'id_user = '.$user->id);
				$img = $foto->avatar;
			}

			$data = array(
				'name' => ucwords(strtolower($this->input->post('nombre'))),
				'surname' => ucwords(strtolower($this->input->post('apellido'))),
				'telefono' => $this->input->post('telefono'),
				'phone' => $this->input->post('celular'),
				'avatar' => $img,
				'template' => $this->input->post('template')
			);

			$this->ion_auth->update($user->id, $data);
			redirect(base_url("backend/dashboard"), 'refresh');
		}

		$vista_interna = array(
			'permisos_efectivos' => $this->permisos,
			'issa' => $this->issa,
			'grupos' => $this->sudaca_backend_md->groups_getAll(),
			'grupo' => $this->codegen_model->row('users_groups','*','id_user = '.$user->id),
			'result' => $this->codegen_model->row('users','*','id_user = '.$user->id)
		);

		$vista_externa = array(			
			'title' => ucwords("Mi Cuenta"),
			'contenido_main' => $this->load->view('backend/users/users_account', $vista_interna, true)
		);		
		
		$this->load->view('template/backend', $vista_externa);
	}

	public function accesos_directos() {
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();
		
		// Get user permissions and available menus
		$all_menus = $this->sudaca_md->getMenus($user->id_user);
		
		// Organize menus by category
		$menu_categories = [
			'customer_management' => [
				'title' => 'Gestión de Clientes',
				'icon' => 'fas fa-users',
				'items' => []
			],
			'order_management' => [
				'title' => 'Gestión de Pedidos',
				'icon' => 'fas fa-shopping-cart',
				'items' => []
			],
			'tariff_management' => [
				'title' => 'Gestión de Tarifas',
				'icon' => 'fas fa-dollar-sign',
				'items' => []
			],
			'location_management' => [
				'title' => 'Gestión de Ubicaciones',
				'icon' => 'fas fa-map-marker-alt',
				'items' => []
			],
			'user_management' => [
				'title' => 'Gestión de Usuarios',
				'icon' => 'fas fa-user-shield',
				'items' => []
			],
			'system_config' => [
				'title' => 'Configuración del Sistema',
				'icon' => 'fas fa-cogs',
				'items' => []
			],
			'authentication' => [
				'title' => 'Autenticación',
				'icon' => 'fas fa-lock',
				'items' => []
			],
			'utilities' => [
				'title' => 'Otras Utilidades',
				'icon' => 'fas fa-tools',
				'items' => []
			]
		];
		
		// Predefined menu items
		$predefined_menu_items = [
			// Customer Management
			[
				'category' => 'customer_management',
				'title' => 'Listar Clientes',
				'url' => site_url('ecommerce/customers'),
				'icon' => 'fas fa-list',
				'implemented' => true
			],
			[
				'category' => 'customer_management',
				'title' => 'Agregar Cliente',
				'url' => site_url('ecommerce/customers/add'),
				'icon' => 'fas fa-user-plus',
				'implemented' => true
			],
			[
				'category' => 'customer_management',
				'title' => 'Revocar Token',
				'url' => site_url('ecommerce/customers'),
				'icon' => 'fas fa-times-circle',
				'implemented' => true,
				'note' => 'Accesible desde la vista de tokens'
			],
			
			// Order Management
			[
				'category' => 'order_management',
				'title' => 'Listar Pedidos',
				'url' => site_url('ecommerce/orders'),
				'icon' => 'fas fa-list',
				'implemented' => true
			],
			[
				'category' => 'order_management',
				'title' => 'Actualizar Estado',
				'url' => site_url('ecommerce/orders'),
				'icon' => 'fas fa-sync',
				'implemented' => true,
				'note' => 'Editable desde la lista de pedidos'
			],
			
			// Tariff Management
			[
				'category' => 'tariff_management',
				'title' => 'Listar Tarifas',
				'url' => site_url('ecommerce/tariff'),
				'icon' => 'fas fa-list',
				'implemented' => true
			],
			[
				'category' => 'tariff_management',
				'title' => 'Agregar Tarifa',
				'url' => site_url('ecommerce/tariff/add'),
				'icon' => 'fas fa-plus',
				'implemented' => true
			],
			
			// Location Management
			[
				'category' => 'location_management',
				'title' => 'Países',
				'url' => site_url('ecommerce/countries'),
				'icon' => 'fas fa-globe',
				'implemented' => true,
				'note' => 'Gestionado vía modelo'
			],
			[
				'category' => 'location_management',
				'title' => 'Provincias',
				'url' => site_url('ecommerce/provinces'),
				'icon' => 'fas fa-map',
				'implemented' => true
			],
			[
				'category' => 'location_management',
				'title' => 'Destinos',
				'url' => site_url('ecommerce/destinations'),
				'icon' => 'fas fa-location-arrow',
				'implemented' => true
			],
			
			// User Management
			[
				'category' => 'user_management',
				'title' => 'Listar Usuarios',
				'url' => site_url('backend/users'),
				'icon' => 'fas fa-list',
				'implemented' => true
			],
			[
				'category' => 'user_management',
				'title' => 'Agregar Usuario',
				'url' => site_url('backend/users/add'),
				'icon' => 'fas fa-user-plus',
				'implemented' => true
			],
			
			// System Configuration
			[
				'category' => 'system_config',
				'title' => 'Ver Configuraciones',
				'url' => site_url('backend/configuraciones'),
				'icon' => 'fas fa-cogs',
				'implemented' => true
			],
			
			// Authentication
			[
				'category' => 'authentication',
				'title' => 'Iniciar Sesión',
				'url' => site_url('web_ctrl'),
				'icon' => 'fas fa-sign-in-alt',
				'implemented' => true
			],
			[
				'category' => 'authentication',
				'title' => 'Cerrar Sesión',
				'url' => site_url('backend/auth/logout'),
				'icon' => 'fas fa-sign-out-alt',
				'implemented' => true
			],
			[
				'category' => 'authentication',
				'title' => 'Recuperar Contraseña',
				'url' => site_url('backend/auth/forgot_password'),
				'icon' => 'fas fa-unlock-alt',
				'implemented' => true
			],
			
			// Other Utilities
			[
				'category' => 'utilities',
				'title' => 'Registros de Actividad',
				'url' => site_url('backend/auditoria'),
				'icon' => 'fas fa-clipboard-list',
				'implemented' => true
			],
			[
				'category' => 'utilities',
				'title' => 'Registros del Sistema',
				'url' => site_url('backend/logs'),
				'icon' => 'fas fa-file-alt',
				'implemented' => true
			]
		];

		// Map predefined menu items to categories
		foreach ($predefined_menu_items as $item) {
			$menu_categories[$item['category']]['items'][] = $item;
		}
		
		// Filter categories that have no items
		$filtered_categories = array_filter($menu_categories, function($category) {
			return !empty($category['items']);
		});
		
		$data['padres'] = $this->sudaca_md->getMenus($user->id_user);
		$data['hijos'] = $this->sudaca_md->getAccesosDirectosHijos($user->id_user);
		$data['menu_categories'] = $filtered_categories;
		
		$this->load->view('backend/dashboard/dashboard_accesos_directos', $data);
	}

	public function ultimos_accesos() {
		if (!$this->ion_auth->logged_in()) {
			redirect('backend/auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();
		
		$data['accesos'] = $this->sudaca_md->getUltimosAccesos($user->id_user);
		
		$this->load->view('backend/dashboard/dashboard_ultimos_accesos', $data);
	}
}