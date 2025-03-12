<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {

    private $debug_results = array();

    public function __construct() {
        parent::__construct();
        // Only allow access in development environment
        if (ENVIRONMENT !== 'development') {
            show_error('Debug controller is only available in development environment');
        }
    }

    public function index() {
        // Core system checks
        $this->debug_results['database'] = $this->check_database();
        $this->debug_results['session'] = $this->check_session();
        $this->debug_results['file_permissions'] = $this->check_file_permissions();
        $this->debug_results['routes'] = $this->check_routes();
        $this->debug_results['auth'] = $this->check_auth_system();
        $this->debug_results['models'] = $this->check_models();
        $this->debug_results['php_extensions'] = $this->check_php_extensions();
        $this->debug_results['email'] = $this->check_email();
        
        // Framework core components check
        $this->debug_results['framework_core'] = $this->check_framework_core();
        
        // Frontend/Backend systems check
        $this->debug_results['frontend_system'] = $this->check_frontend_system();
        $this->debug_results['backend_system'] = $this->check_backend_system();
        
        // E-commerce features check
        $this->debug_results['ecommerce'] = $this->check_ecommerce_system();

        // API and Performance checks
        $this->debug_results['api_endpoints'] = $this->check_api_endpoints();
        $this->debug_results['performance'] = $this->check_performance();
        $this->debug_results['security'] = $this->check_security();

        // Additional system checks
        $this->debug_results['assets'] = $this->check_asset_management();
        $this->debug_results['third_party'] = $this->check_third_party_integrations();
        $this->debug_results['cache'] = $this->check_cache_system();
        
        // Template and Generation checks
        $this->debug_results['template'] = $this->check_template_system();
        $this->debug_results['generation'] = $this->check_qr_pdf_generation();
        $this->debug_results['directory'] = $this->check_directory_structure();
        
        // Log the debug run
        log_message('debug', 'Debug run started: ' . json_encode($this->debug_results));
        
        $this->load->view('debug/results', array('results' => $this->debug_results));
    }

    public function fix_all() {
        $fixes = array();
        
        // Fix file permissions
        $paths_to_fix = array(
            APPPATH . 'cache',
            APPPATH . 'logs',
            FCPATH . 'assets/uploads'
        );

        foreach ($paths_to_fix as $path) {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
                $fixes[] = "Created directory: {$path}";
            }
            if (file_exists($path) && !is_writable($path)) {
                chmod($path, 0755);
                $fixes[] = "Fixed permissions for: {$path}";
            }
        }

        // Fix session issues
        $sess_path = config_item('sess_save_path');
        if (!$sess_path) {
            $this->config->set_item('sess_save_path', APPPATH . 'sessions');
            $fixes[] = "Set session save path to: " . APPPATH . 'sessions';
        }

        // Check and fix database issues
        try {
            $this->load->database();
            $this->db->simple_query('SELECT 1');
        } catch (Exception $e) {
            $fixes[] = "Database connection issue detected. Please check database configuration in application/config/database.php";
        }

        // Load critical models and attempt fixes
        $critical_models = array(
            'customer_model',
            'order_model',
            'tariff_model',
            'country_model',
            'province_model',
            'destination_model'
        );

        foreach ($critical_models as $model) {
            try {
                $this->load->model($model);
            } catch (Exception $e) {
                $fixes[] = "Failed to load {$model}. Please check model file exists and is properly formatted.";
            }
        }

        // Check Ion Auth tables
        $ion_auth_tables = array(
            'users' => array(
                'id_user' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
                'username' => array('type' => 'VARCHAR', 'constraint' => 100),
                'password' => array('type' => 'VARCHAR', 'constraint' => 255),
                'email' => array('type' => 'VARCHAR', 'constraint' => 100),
                'active' => array('type' => 'INT', 'constraint' => 1, 'default' => 1)
            ),
            'users_groups' => array(
                'id_user' => array('type' => 'INT', 'constraint' => 11),
                'id_group' => array('type' => 'INT', 'constraint' => 11)
            ),
            'login_attempts' => array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
                'ip_address' => array('type' => 'VARCHAR', 'constraint' => 45),
                'login' => array('type' => 'VARCHAR', 'constraint' => 100),
                'time' => array('type' => 'INT', 'constraint' => 11)
            )
        );

        foreach ($ion_auth_tables as $table => $fields) {
            if (!$this->db->table_exists($table)) {
                $this->load->dbforge();
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('id_user', TRUE);
                $this->dbforge->create_table($table, TRUE);
                $fixes[] = "Created missing table: {$table}";
            }
        }

        // Return results
        $this->load->view('debug/fixes', array('fixes' => $fixes));
    }

    private function check_database() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check main database connection
            $this->load->database();
            $this->db->simple_query('SELECT 1');
            $results['details'][] = "Main database connection: OK";

            // Check critical tables with suggestions
            $critical_tables = array(
                'users' => 'Run auth migrations or check database setup',
                'customers' => 'Run customer table migration',
                'orders' => 'Run orders table migration',
                'tariff' => 'Run tariff table migration',
                'countries' => 'Run location tables migration',
                'provinces' => 'Run location tables migration',
                'destinations' => 'Run shipping tables migration'
            );

            foreach ($critical_tables as $table => $suggestion) {
                if ($this->db->table_exists($table)) {
                    // Check if table has records
                    $count = $this->db->count_all($table);
                    $results['details'][] = "Table {$table}: EXISTS ({$count} records)";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Table {$table}: MISSING - {$suggestion}";
                }
            }

            // Check database version
            $version = $this->db->version();
            $results['details'][] = "Database version: {$version}";

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Database error: " . $e->getMessage();
            log_message('error', 'Debug database check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_session() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check if session library is loaded
            $this->load->library('session');
            $results['details'][] = "Session library: LOADED";

            // Check session save path
            $save_path = config_item('sess_save_path');
            if (!$save_path) {
                $save_path = APPPATH . 'sessions';
                $results['status'] = 'warning';
                $results['details'][] = "Session save path not set - Using default: {$save_path}";
            }

            // Check if save path exists and is writable
            if (!file_exists($save_path)) {
                $results['status'] = 'error';
                $results['details'][] = "Session directory does not exist: {$save_path}";
            } else if (!is_writable($save_path)) {
                $results['status'] = 'error';
                $results['details'][] = "Session directory not writable: {$save_path}";
            } else {
                $results['details'][] = "Session save path ({$save_path}): WRITABLE";
            }

            // Test session functionality
            $test_key = 'debug_test_' . time();
            $test_value = 'test_value_' . time();
            $this->session->set_userdata($test_key, $test_value);
            
            if ($this->session->userdata($test_key) === $test_value) {
                $results['details'][] = "Session data test: OK";
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Session data test: FAILED - Check session handler configuration";
            }
            
            $this->session->unset_userdata($test_key);

            // Check session configuration
            $sess_driver = config_item('sess_driver');
            $results['details'][] = "Session driver: {$sess_driver}";
            
            if ($sess_driver === 'files') {
                $gc_probability = config_item('sess_gc_probability');
                if ($gc_probability === FALSE || $gc_probability < 1) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Session garbage collection disabled - May cause session buildup";
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Session error: " . $e->getMessage();
            log_message('error', 'Debug session check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_file_permissions() {
        $results = array('status' => 'ok', 'details' => array());
        
        $paths_to_check = array(
            APPPATH . 'cache',
            APPPATH . 'logs',
            FCPATH . 'assets/uploads'
        );

        foreach ($paths_to_check as $path) {
            if (file_exists($path)) {
                if (is_writable($path)) {
                    $results['details'][] = "{$path}: WRITABLE";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$path}: NOT WRITABLE";
                }
            } else {
                $results['status'] = 'error';
                $results['details'][] = "{$path}: DOES NOT EXIST";
            }
        }

        return $results;
    }

    private function check_routes() {
        $results = array('status' => 'ok', 'details' => array());
        
        // Check critical routes by verifying controller files exist
        $critical_routes = array(
            'backend/auth/login' => APPPATH . 'controllers/backend/Auth.php',
            'backend/dashboard' => APPPATH . 'controllers/backend/Dashboard.php',
            'frontend/web' => APPPATH . 'controllers/frontend/Web.php',
            'ecommerce/customers' => APPPATH . 'controllers/ecommerce/Customers.php',
            'ecommerce/orders' => APPPATH . 'controllers/ecommerce/Orders.php'
        );

        foreach ($critical_routes as $route => $controller_path) {
            if (file_exists($controller_path)) {
                $results['details'][] = "Route {$route}: EXISTS (Controller found)";
            } else {
                $results['status'] = 'warning';
                $results['details'][] = "Route {$route}: NOT FOUND (Controller missing)";
            }
        }

        return $results;
    }

    private function check_auth_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check Ion Auth
            $this->load->library('ion_auth');
            $results['details'][] = "Ion Auth library: LOADED";

            // Check auth tables
            $auth_tables = array('users', 'users_groups', 'login_attempts');
            foreach ($auth_tables as $table) {
                if ($this->db->table_exists($table)) {
                    $results['details'][] = "Auth table {$table}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Auth table {$table}: MISSING";
                }
            }
        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Auth system error: " . $e->getMessage();
        }

        return $results;
    }

    private function check_models() {
        $results = array('status' => 'ok', 'details' => array());
        
        $critical_models = array(
            'customer_model' => 'customer',
            'order_model' => 'order',
            'tariff_model' => 'tariff',
            'country_model' => 'country',
            'province_model' => 'province',
            'destination_model' => 'destination'
        );

        foreach ($critical_models as $model => $name) {
            try {
                $this->load->model($model, $name);
                $results['details'][] = "Model {$model}: LOADED";
            } catch (Exception $e) {
                $results['status'] = 'error';
                $results['details'][] = "Model {$model}: FAILED TO LOAD";
            }
        }

        return $results;
    }

    private function check_php_extensions() {
        $results = array('status' => 'ok', 'details' => array());
        
        $required_extensions = array(
            'mbstring' => 'Required for UTF-8 string handling',
            'gd' => 'Required for image processing',
            'curl' => 'Required for HTTP requests',
            'json' => 'Required for API responses',
            'mysqli' => 'Required for database operations',
            'session' => 'Required for session handling',
            'openssl' => 'Required for secure communications'
        );

        foreach ($required_extensions as $ext => $reason) {
            if (extension_loaded($ext)) {
                $version = phpversion($ext);
                $version_info = $version ? " (version: {$version})" : "";
                $results['details'][] = "Extension {$ext}: LOADED{$version_info}";
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Extension {$ext}: MISSING - {$reason}";
            }
        }

        // Check PHP version
        $php_version = phpversion();
        if (version_compare($php_version, '7.0.0', '>=')) {
            $results['details'][] = "PHP Version: {$php_version} (OK)";
        } else {
            $results['status'] = 'warning';
            $results['details'][] = "PHP Version: {$php_version} (Upgrade recommended - minimum 7.0.0)";
        }

        return $results;
    }

    private function check_email() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            $this->load->library('email');
            
            // Check email configuration
            $protocol = $this->config->item('protocol', 'email');
            $results['details'][] = "Email protocol: " . ($protocol ?: 'not set');

            if ($protocol === 'smtp') {
                $smtp_host = $this->config->item('smtp_host', 'email');
                $smtp_port = $this->config->item('smtp_port', 'email');
                $smtp_user = $this->config->item('smtp_user', 'email');
                
                if (empty($smtp_host) || empty($smtp_port) || empty($smtp_user)) {
                    $results['status'] = 'warning';
                    $results['details'][] = "SMTP configuration incomplete - Check email config";
                } else {
                    $results['details'][] = "SMTP configuration: PRESENT";
                }
            }

            // Only attempt to send test email if configuration looks valid
            if ($results['status'] === 'ok') {
                $test_email = 'test@lanube.com';
                
                $this->email->from($test_email, 'Debug Test');
                $this->email->to($test_email);
                $this->email->subject('Debug Test Email');
                $this->email->message('This is a test email from the debug system.');

                if ($this->email->send()) {
                    $results['details'][] = "Test email: SENT";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Test email failed: " . $this->email->print_debugger(array('headers'));
                }
            }
        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Email system error: " . $e->getMessage();
            log_message('error', 'Debug email check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_framework_core() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check core system files
            $core_files = array(
                BASEPATH . 'core/CodeIgniter.php' => 'CodeIgniter Core',
                BASEPATH . 'core/Controller.php' => 'Base Controller',
                BASEPATH . 'core/Model.php' => 'Base Model',
                BASEPATH . 'core/Loader.php' => 'Loader',
                BASEPATH . 'core/Router.php' => 'Router',
                BASEPATH . 'core/Output.php' => 'Output',
                BASEPATH . 'core/Input.php' => 'Input',
                BASEPATH . 'core/Lang.php' => 'Language',
                BASEPATH . 'core/URI.php' => 'URI',
                BASEPATH . 'core/Security.php' => 'Security' // Added Security in core
            );

            foreach ($core_files as $file => $description) {
                if (file_exists($file)) {
                    $results['details'][] = "Core file {$description}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Core file {$description}: MISSING";
                }
            }

            // Check core libraries (only those that should be in libraries directory)
            $core_libraries = array(
                'database' => BASEPATH . 'database/DB.php', // Database is in database directory
                'session' => BASEPATH . 'libraries/Session/Session.php',
                'form_validation' => BASEPATH . 'libraries/Form_validation.php',
                'upload' => BASEPATH . 'libraries/Upload.php',
                'email' => BASEPATH . 'libraries/Email.php',
                'pagination' => BASEPATH . 'libraries/Pagination.php',
                'zip' => BASEPATH . 'libraries/Zip.php'
            );

            foreach ($core_libraries as $library => $path) {
                if (file_exists($path)) {
                    $results['details'][] = "Core library {$library}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Core library {$library}: MISSING";
                }
            }

            // Check core helpers
            $core_helpers = array(
                'url', 'form', 'file', 'html', 'string', 'text',
                'date', 'array', 'cookie', 'security'
            );

            foreach ($core_helpers as $helper) {
                if (file_exists(BASEPATH . 'helpers/' . $helper . '_helper.php')) {
                    $results['details'][] = "Core helper {$helper}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Core helper {$helper}: MISSING";
                }
            }

            // Check core configuration
            $core_configs = array(
                'config', 'database', 'routes', 'autoload',
                'hooks', 'mimes', 'smileys', 'user_agents'
            );

            foreach ($core_configs as $config) {
                if (file_exists(APPPATH . 'config/' . $config . '.php')) {
                    $results['details'][] = "Core config {$config}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Core config {$config}: MISSING";
                }
            }

            // Check core functionality
            $this->benchmark->mark('core_test_start');
            $this->load->helper('url');
            $this->benchmark->mark('core_test_end');
            $elapsed = $this->benchmark->elapsed_time('core_test_start', 'core_test_end');
            $results['details'][] = "Core loading performance: {$elapsed} seconds";

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Framework core error: " . $e->getMessage();
            log_message('error', 'Debug framework core check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_frontend_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check frontend controllers
            $frontend_controllers = array(
                'frontend/Ajax.php' => 'Frontend AJAX controller',
                'frontend/Api.php' => 'REST API controller',
                'frontend/Ecommerce.php' => 'E-commerce base controller',
                'frontend/Web.php' => 'Main website controller'
            );

            foreach ($frontend_controllers as $controller => $description) {
                if (file_exists(APPPATH . 'controllers/' . $controller)) {
                    $results['details'][] = "{$description}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$description}: MISSING";
                }
            }

            // Check frontend views
            $frontend_views = array(
                'frontend/public',
                'frontend/private',
                'frontend/email'
            );

            foreach ($frontend_views as $view_dir) {
                if (is_dir(APPPATH . 'views/' . $view_dir)) {
                    $results['details'][] = "Frontend view directory {$view_dir}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Frontend view directory {$view_dir}: MISSING";
                }
            }

            // Check frontend assets
            $frontend_assets = array(
                'css/enhanced-style.css',
                'css/animate.css',
                'css/bootstrap.css',
                'js/bootstrap.bundle.js',
                'js/functions.js'
            );

            foreach ($frontend_assets as $asset) {
                if (file_exists(FCPATH . 'assets/frontend/' . $asset)) {
                    $results['details'][] = "Frontend asset {$asset}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "Frontend asset {$asset}: MISSING";
                }
            }

            // Check frontend libraries
            $frontend_libraries = array(
                'Frontend_lib.php' => 'Frontend utilities',
                'MY_Cart.php' => 'Shopping cart',
                'Ecommerce_lib.php' => 'E-commerce utilities'
            );

            foreach ($frontend_libraries as $library => $description) {
                if (file_exists(APPPATH . 'libraries/' . $library)) {
                    $results['details'][] = "{$description}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "{$description}: MISSING";
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Frontend system error: " . $e->getMessage();
            log_message('error', 'Debug frontend system check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_backend_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check backend controllers
            $backend_controllers = array(
                'Dashboard.php' => 'Admin dashboard',
                'Auth.php' => 'Authentication',
                'Users.php' => 'User management',
                'Groups.php' => 'Group management',
                'Menus.php' => 'Menu management',
                'Configuraciones.php' => 'System config'
            );

            foreach ($backend_controllers as $controller => $description) {
                if (file_exists(APPPATH . 'controllers/backend/' . $controller)) {
                    $results['details'][] = "Backend {$description} controller: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Backend {$description} controller: MISSING";
                }
            }

            // Check backend views
            $backend_views = array(
                'dashboard',
                'users',
                'groups',
                'auth',
                'menus',
                'configuraciones'
            );

            foreach ($backend_views as $view) {
                if (is_dir(APPPATH . 'views/backend/' . $view)) {
                    $results['details'][] = "Backend view directory {$view}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Backend view directory {$view}: MISSING";
                }
            }

            // Check backend assets
            $backend_assets = array(
                'css/admin.css',
                'js/dashboard.js',
                'js/main.js',
                'images/logo_nube.png'
            );

            foreach ($backend_assets as $asset) {
                if (file_exists(FCPATH . 'assets/backend/' . $asset)) {
                    $results['details'][] = "Backend asset {$asset}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "Backend asset {$asset}: MISSING";
                }
            }

            // Check backend libraries
            $backend_libraries = array(
                'Backend_lib.php' => 'Admin utilities',
                'Permisos_lib.php' => 'Permissions management'
            );

            foreach ($backend_libraries as $library => $description) {
                if (file_exists(APPPATH . 'libraries/' . $library)) {
                    $results['details'][] = "Backend {$description}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "Backend {$description}: MISSING";
                }
            }

            // Check backend functionality
            if (class_exists('Ion_auth')) {
                $results['details'][] = "Backend authentication system: LOADED";
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Backend authentication system: NOT LOADED";
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Backend system error: " . $e->getMessage();
            log_message('error', 'Debug backend system check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_ecommerce_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check e-commerce controllers
            $ecommerce_controllers = array(
                'Countries.php' => 'Country management',
                'Customers.php' => 'Customer management',
                'Destinations.php' => 'Shipping destinations',
                'Faqs.php' => 'FAQ management',
                'Provinces.php' => 'Province management',
                'Tariff.php' => 'Shipping rates'
            );

            foreach ($ecommerce_controllers as $controller => $description) {
                if (file_exists(APPPATH . 'controllers/ecommerce/' . $controller)) {
                    $results['details'][] = "E-commerce {$description} controller: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "E-commerce {$description} controller: MISSING";
                }
            }

            // Check e-commerce models
            $ecommerce_models = array(
                'Order_model.php' => 'Orders',
                'Tariff_model.php' => 'Pricing',
                'Customer_model.php' => 'Customers',
                'Country_model.php' => 'Countries',
                'Province_model.php' => 'Provinces',
                'Destination_model.php' => 'Destinations'
            );

            foreach ($ecommerce_models as $model => $description) {
                if (file_exists(APPPATH . 'models/' . $model)) {
                    $results['details'][] = "E-commerce {$description} model: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "E-commerce {$description} model: MISSING";
                }
            }

            // Check e-commerce components
            $ecommerce_components = array(
                'countries',
                'customers',
                'destinations',
                'faqs',
                'provinces',
                'shipping',
                'tariff'
            );

            foreach ($ecommerce_components as $component) {
                if (is_dir(APPPATH . 'views/components/ecommerce/' . $component)) {
                    $results['details'][] = "E-commerce component {$component}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "E-commerce component {$component}: MISSING";
                }
            }

            // Check e-commerce functionality
            // Test database tables
            $ecommerce_tables = array(
                'orders' => 'Orders table',
                'customers' => 'Customers table',
                'countries' => 'Countries table',
                'provinces' => 'Provinces table',
                'destinations' => 'Destinations table',
                'tariff' => 'Tariff table'
            );

            foreach ($ecommerce_tables as $table => $description) {
                if ($this->db->table_exists($table)) {
                    $count = $this->db->count_all($table);
                    $results['details'][] = "{$description}: EXISTS ({$count} records)";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$description}: MISSING";
                }
            }

            // Check shipping calculation functionality
            try {
                $this->load->model('Business/Tariff_model');
                $test_data = array(
                    'weight' => 1,
                    'volume' => 0.5,
                    'postal_code' => '1000'
                );
                $this->Tariff_model->getShippingCost($test_data);
                $results['details'][] = "Shipping calculation test: OK";
            } catch (Exception $e) {
                $results['status'] = 'warning';
                $results['details'][] = "Shipping calculation test: FAILED - " . $e->getMessage();
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "E-commerce system error: " . $e->getMessage();
            log_message('error', 'Debug e-commerce system check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_api_endpoints() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check API controller existence
            if (file_exists(APPPATH . 'controllers/frontend/Api.php')) {
                $results['details'][] = "API Controller: EXISTS";
                
                // Load API controller file content to check implementation
                $api_content = file_get_contents(APPPATH . 'controllers/frontend/Api.php');
                
                // Define critical API endpoints to check
                $api_endpoints = array(
                    'getShippingCost' => array(
                        'method' => 'POST',
                        'required_params' => array(
                            'token' => 'Authentication token',
                            'data_client' => array(
                                'postal_code' => 'Destination postal code'
                            ),
                            'weight' => 'Package weight',
                            'volume' => 'Package volume'
                        )
                    ),
                    'getCustomer' => array(
                        'method' => 'POST',
                        'required_params' => array(
                            'token' => 'Authentication token',
                            'user' => 'Customer email'
                        )
                    ),
                    'sendOrder' => array(
                        'method' => 'POST',
                        'required_params' => array(
                            'token' => 'Authentication token',
                            'data_client' => array(
                                'postal_code' => 'Destination postal code',
                                'client' => 'Client name',
                                'reference' => 'Order reference',
                                'shipping_data' => array(
                                    'store' => array(
                                        'name' => 'Store name'
                                    ),
                                    'email' => 'Client email',
                                    'province' => 'Province name',
                                    'city' => 'City name',
                                    'address' => 'Full address',
                                    'telephone' => 'Phone number'
                                )
                            ),
                            'weight' => 'Package weight',
                            'volume' => 'Package volume'
                        )
                    )
                );

                // Check each endpoint
                foreach ($api_endpoints as $endpoint => $config) {
                    // Check if method exists in API controller
                    if (strpos($api_content, "function {$endpoint}") !== false) {
                        $results['details'][] = "API Endpoint {$endpoint}: EXISTS";
                        
                        // Check for parameter validation in the code
                        $missing_params = array();
                        foreach ($config['required_params'] as $param => $description) {
                            // For nested parameters in data_client
                            if (is_array($description)) {
                                if (strpos($api_content, "\$data->{$param}") === false && 
                                    strpos($api_content, "\$data['{$param}']") === false) {
                                    $missing_params[] = $param;
                                }
                            } else {
                                if (strpos($api_content, "\$data->{$param}") === false && 
                                    strpos($api_content, "\$data['{$param}']") === false) {
                                    $missing_params[] = $param;
                                }
                            }
                        }
                        
                        if (!empty($missing_params)) {
                            $results['status'] = 'warning';
                            $results['details'][] = "API Endpoint {$endpoint} should validate parameters: " . implode(', ', $missing_params);
                        }
                    } else {
                        $results['status'] = 'error';
                        $results['details'][] = "API Endpoint {$endpoint}: MISSING";
                    }
                }
            } else {
                $results['status'] = 'error';
                $results['details'][] = "API Controller: MISSING";
            }

            // Check API documentation
            $api_docs = array(
                APPPATH . 'docs/api.md' => 'API Documentation',
                APPPATH . 'docs/READMENOW3.md' => 'API README'
            );
            
            foreach ($api_docs as $doc => $description) {
                if (file_exists($doc)) {
                    $results['details'][] = "{$description}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "{$description}: MISSING - Documentation should be created for better API understanding";
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "API endpoints error: " . $e->getMessage();
            log_message('error', 'Debug API endpoints check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_performance() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check PHP configuration
            $memory_limit = ini_get('memory_limit');
            $max_execution_time = ini_get('max_execution_time');
            $results['details'][] = "Memory Limit: {$memory_limit}";
            $results['details'][] = "Max Execution Time: {$max_execution_time}s";

            // Check database performance
            $this->benchmark->mark('db_test_start');
            $this->db->query('SELECT 1');
            $this->benchmark->mark('db_test_end');
            $db_time = $this->benchmark->elapsed_time('db_test_start', 'db_test_end');
            $results['details'][] = "Database Response Time: {$db_time}s";

            if ($db_time > 0.1) {
                $results['status'] = 'warning';
                $results['details'][] = "Database response time is high (> 0.1s)";
            }

            // Check session performance
            $this->benchmark->mark('session_test_start');
            $this->session->set_userdata('perf_test', 'test');
            $this->session->userdata('perf_test');
            $this->session->unset_userdata('perf_test');
            $this->benchmark->mark('session_test_end');
            $session_time = $this->benchmark->elapsed_time('session_test_start', 'session_test_end');
            $results['details'][] = "Session Operation Time: {$session_time}s";

            if ($session_time > 0.05) {
                $results['status'] = 'warning';
                $results['details'][] = "Session operations are slow (> 0.05s)";
            }

            // Check file system performance
            $this->benchmark->mark('fs_test_start');
            $test_file = APPPATH . 'cache/perf_test.txt';
            file_put_contents($test_file, 'test');
            file_get_contents($test_file);
            unlink($test_file);
            $this->benchmark->mark('fs_test_end');
            $fs_time = $this->benchmark->elapsed_time('fs_test_start', 'fs_test_end');
            $results['details'][] = "File System Operation Time: {$fs_time}s";

            if ($fs_time > 0.05) {
                $results['status'] = 'warning';
                $results['details'][] = "File system operations are slow (> 0.05s)";
            }

            // Check cache performance if available
            if (class_exists('CI_Cache')) {
                $this->load->driver('cache');
                $this->benchmark->mark('cache_test_start');
                $this->cache->file->save('perf_test', 'test', 60);
                $this->cache->file->get('perf_test');
                $this->cache->file->delete('perf_test');
                $this->benchmark->mark('cache_test_end');
                $cache_time = $this->benchmark->elapsed_time('cache_test_start', 'cache_test_end');
                $results['details'][] = "Cache Operation Time: {$cache_time}s";

                if ($cache_time > 0.05) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Cache operations are slow (> 0.05s)";
                }
            }

            // Memory usage statistics
            $memory_usage = memory_get_usage(true);
            $peak_memory = memory_get_peak_usage(true);
            $results['details'][] = "Current Memory Usage: " . round($memory_usage / 1024 / 1024, 2) . "MB";
            $results['details'][] = "Peak Memory Usage: " . round($peak_memory / 1024 / 1024, 2) . "MB";

            if ($peak_memory > 64 * 1024 * 1024) { // 64MB threshold
                $results['status'] = 'warning';
                $results['details'][] = "High memory usage detected (> 64MB)";
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Performance check error: " . $e->getMessage();
            log_message('error', 'Debug performance check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_security() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check security-related PHP settings
            $security_settings = array(
                'display_errors' => ini_get('display_errors'),
                'expose_php' => ini_get('expose_php'),
                'session.cookie_httponly' => ini_get('session.cookie_httponly'),
                'session.cookie_secure' => ini_get('session.cookie_secure'),
                'session.use_strict_mode' => ini_get('session.use_strict_mode')
            );

            foreach ($security_settings as $setting => $value) {
                $results['details'][] = "PHP {$setting}: {$value}";
                if (($setting === 'display_errors' && $value === '1' && ENVIRONMENT === 'production') ||
                    ($setting === 'expose_php' && $value === '1') ||
                    ($setting === 'session.cookie_httponly' && $value === '0') ||
                    ($setting === 'session.use_strict_mode' && $value === '0')) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Insecure PHP setting: {$setting}";
                }
            }

            // Check CodeIgniter security configuration
            $ci_security = array(
                'csrf_protection' => config_item('csrf_protection'),
                'csrf_token_name' => config_item('csrf_token_name'),
                'csrf_cookie_name' => config_item('csrf_cookie_name'),
                'csrf_expire' => config_item('csrf_expire'),
                'encryption_key' => config_item('encryption_key'),
                'global_xss_filtering' => config_item('global_xss_filtering')
            );

            foreach ($ci_security as $setting => $value) {
                $results['details'][] = "CI {$setting}: " . (is_bool($value) ? ($value ? 'TRUE' : 'FALSE') : $value);
                if (($setting === 'csrf_protection' && !$value) ||
                    ($setting === 'encryption_key' && empty($value)) ||
                    ($setting === 'global_xss_filtering' && !$value)) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Recommended security setting not enabled: {$setting}";
                }
            }

            // Check file permissions
            $critical_paths = array(
                APPPATH . 'config/config.php',
                APPPATH . 'config/database.php',
                APPPATH . 'config/email.php'
            );

            foreach ($critical_paths as $path) {
                if (file_exists($path)) {
                    $perms = fileperms($path);
                    $octal_perms = substr(sprintf('%o', $perms), -4);
                    $results['details'][] = "File permissions for {$path}: {$octal_perms}";
                    
                    // Check if file is world-readable or world-writable
                    if ($perms & 0x0004 || $perms & 0x0002) {
                        $results['status'] = 'error';
                        $results['details'][] = "Insecure file permissions for {$path}";
                    }
                }
            }

            // Check for secure headers
            $headers = array(
                'X-Frame-Options',
                'X-XSS-Protection',
                'X-Content-Type-Options',
                'Strict-Transport-Security',
                'Content-Security-Policy'
            );

            // Mock a request to check headers
            $this->output->set_header('X-Frame-Options: SAMEORIGIN');
            $actual_headers = headers_list();
            
            foreach ($headers as $header) {
                $found = false;
                foreach ($actual_headers as $actual) {
                    if (stripos($actual, $header) !== false) {
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Security header missing: {$header}";
                }
            }

            // Check for secure database configuration
            $db_config = $this->config->item('database');
            if (isset($db_config) && is_array($db_config)) {
                foreach ($db_config as $group => $config) {
                    if (isset($config['password']) && empty($config['password'])) {
                        $results['status'] = 'warning';
                        $results['details'][] = "Empty database password for group: {$group}";
                    }
                }
            }

            // Check for development files
            $dev_files = array(
                'README.md',
                'composer.json',
                'package.json',
                '.env',
                '.git',
                '.gitignore'
            );

            if (ENVIRONMENT === 'production') {
                foreach ($dev_files as $file) {
                    if (file_exists(FCPATH . $file)) {
                        $results['status'] = 'warning';
                        $results['details'][] = "Development file found in production: {$file}";
                    }
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Security check error: " . $e->getMessage();
            log_message('error', 'Debug security check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_asset_management() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check asset directories structure
            $asset_directories = array(
                'backend' => array(
                    'css', 'js', 'images',
                    // Remove plugins since we use bower_components
                ),
                'frontend' => array(
                    'css', 'js', 'images', 'plugins'
                ),
                'common' => array(
                    'fonts', 'icons', 'uploads'
                )
            );

            foreach ($asset_directories as $main_dir => $subdirs) {
                $main_path = FCPATH . 'assets/' . $main_dir;
                if (is_dir($main_path)) {
                    $results['details'][] = "Asset directory {$main_dir}: EXISTS";
                    foreach ($subdirs as $subdir) {
                        $subdir_path = $main_path . '/' . $subdir;
                        if (is_dir($subdir_path)) {
                            $results['details'][] = "Asset subdirectory {$main_dir}/{$subdir}: EXISTS";
                        } else {
                            // Only warn about missing directories that we actually need
                            if ($subdir !== 'plugins' || $main_dir !== 'backend') {
                                $results['status'] = 'warning';
                                $results['details'][] = "Asset subdirectory {$main_dir}/{$subdir}: MISSING";
                            }
                        }
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Asset directory {$main_dir}: MISSING";
                }
            }

            // Check critical assets
            $critical_assets = array(
                'backend' => array(
                    'css/admin.css' => 'Admin styles',
                    'js/main.js' => 'Admin main script',
                    'js/dashboard.js' => 'Dashboard script',
                    'images/logo_nube.png' => 'Logo image'
                ),
                'frontend' => array(
                    'css/enhanced-style.css' => 'Enhanced styles',
                    'css/bootstrap.css' => 'Bootstrap styles',
                    'js/bootstrap.bundle.js' => 'Bootstrap script',
                    'js/functions.js' => 'Main functions'
                ),
                'common' => array(
                    'fonts/Poppins/Poppins-Regular.ttf' => 'Poppins font',
                    'fonts/Montserrat/Montserrat-Regular.ttf' => 'Montserrat font'
                )
            );

            foreach ($critical_assets as $dir => $assets) {
                foreach ($assets as $path => $description) {
                    $full_path = FCPATH . 'assets/' . $dir . '/' . $path;
                    if (file_exists($full_path)) {
                        $size = filesize($full_path);
                        $results['details'][] = "{$description} ({$dir}/{$path}): EXISTS ({$size} bytes)";
                    } else {
                        $results['status'] = 'warning';
                        $results['details'][] = "{$description} ({$dir}/{$path}): MISSING";
                    }
                }
            }

            // Check upload directories
            $upload_dirs = array(
                FCPATH . 'assets/common/uploads',
                FCPATH . 'store/uploads',
                FCPATH . 'store/qrcodes',
                FCPATH . 'store/pdfs'
            );

            foreach ($upload_dirs as $dir) {
                if (is_dir($dir)) {
                    if (is_writable($dir)) {
                        $results['details'][] = "Upload directory {$dir}: WRITABLE";
                    } else {
                        $results['status'] = 'error';
                        $results['details'][] = "Upload directory {$dir}: NOT WRITABLE";
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Upload directory {$dir}: MISSING";
                }
            }

            // Check for minification - but be smarter about it
            $custom_files = array(
                'css' => array(
                    // Backend custom CSS
                    'backend/css/admin.css',
                    'backend/css/backend.css',
                    'backend/css/main.css',
                    // Frontend custom CSS
                    'frontend/css/enhanced-style.css',
                    'frontend/css/menu_categorias.css',
                    'frontend/css/preloader.css',
                    'frontend/css/responsive.css',
                    'frontend/css/style.css'
                ),
                'js' => array(
                    // Backend custom JS
                    'backend/js/dashboard.js',
                    'backend/js/main.js',
                    'backend/js/main_front.js',
                    // Frontend custom JS
                    'frontend/js/constants.js',
                    'frontend/js/functions.js',
                    'frontend/js/script.js'
                )
            );

            // Third-party files to exclude
            $exclude_patterns = array(
                'bootstrap',
                'jquery.',
                'owl.',
                'dropzone',
                'nicescroll',
                'wow',
                '.min.',
                'vendor/',
                'plugins/',
                'bower_components/'
            );

            foreach ($custom_files['css'] as $css_file) {
                $full_path = FCPATH . 'assets/' . $css_file;
                if (file_exists($full_path)) {
                    $min_file = str_replace('.css', '.min.css', $full_path);
                    if (!file_exists($min_file)) {
                        $results['status'] = 'warning';
                        $results['details'][] = "Minified version missing for custom CSS: " . basename($css_file);
                    }
                }
            }

            foreach ($custom_files['js'] as $js_file) {
                $full_path = FCPATH . 'assets/' . $js_file;
                if (file_exists($full_path)) {
                    $min_file = str_replace('.js', '.min.js', $full_path);
                    if (!file_exists($min_file)) {
                        $results['status'] = 'warning';
                        $results['details'][] = "Minified version missing for custom JS: " . basename($js_file);
                    }
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Asset management error: " . $e->getMessage();
            log_message('error', 'Debug asset management check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_third_party_integrations() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check Composer autoloader
            if (file_exists(APPPATH . 'vendor/autoload.php')) {
                $results['details'][] = "Composer autoloader: EXISTS";
                
                // Check critical packages
                $required_packages = array(
                    'endroid/qr-code' => array(
                        'version' => '^3.9',
                        'class' => 'Endroid\\QrCode\\QrCode'
                    ),
                    'dompdf/dompdf' => array(
                        'version' => '0.8.*',
                        'class' => 'Dompdf\\Dompdf'
                    ),
                    'tecnickcom/tcpdf' => array(
                        'version' => '6.2.*',
                        'class' => 'TCPDF'
                    )
                );

                foreach ($required_packages as $package => $info) {
                    if (class_exists($info['class'])) {
                        $results['details'][] = "Package {$package}: LOADED";
                    } else {
                        $results['status'] = 'error';
                        $results['details'][] = "Package {$package}: NOT LOADED";
                    }
                }
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Composer autoloader: MISSING";
            }

            // Check Ion Auth library
            $ion_auth_components = array(
                'files' => array(
                    APPPATH . 'libraries/Ion_auth.php',
                    APPPATH . 'models/Ion_auth_model.php'
                ),
                'tables' => array('users', 'users_groups', 'login_attempts')
            );

            // Check Ion Auth files
            $missing_files = array();
            foreach ($ion_auth_components['files'] as $file) {
                if (!file_exists($file)) {
                    $missing_files[] = basename($file);
                }
            }
            
            if (empty($missing_files)) {
                $results['details'][] = "Ion Auth library files: ALL PRESENT";
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Ion Auth missing files: " . implode(', ', $missing_files);
            }

            // Check Ion Auth tables
            foreach ($ion_auth_components['tables'] as $table) {
                if ($this->db->table_exists($table)) {
                    $results['details'][] = "Ion Auth table {$table}: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Ion Auth table {$table}: MISSING";
                }
            }

            // Check JavaScript dependencies in bower_components
            $js_dependencies = array(
                'jquery' => 'jquery/dist/jquery.min.js',
                'bootstrap' => 'bootstrap/dist/js/bootstrap.bundle.min.js',
                'moment' => 'moment/min/moment.min.js',
                'chart.js' => 'chart.js/dist/Chart.min.js'
            );

            $bower_path = FCPATH . 'assets/backend/bower_components/';
            $js_found = 0;
            $js_missing = array();

            if (is_dir($bower_path)) {
                foreach ($js_dependencies as $lib => $path) {
                    if (file_exists($bower_path . $path)) {
                        $js_found++;
                        $results['details'][] = "JavaScript library {$lib}: EXISTS";
                    } else {
                        $js_missing[] = $lib;
                    }
                }

                // Only add summary if we found some libraries
                if ($js_found > 0) {
                    if (!empty($js_missing)) {
                        $results['details'][] = "Optional JavaScript libraries missing: " . implode(', ', $js_missing);
                    }
                    $results['details'][] = "JavaScript libraries found: {$js_found}";
                }
            } else {
                $results['details'][] = "Bower components directory not found - This is optional if using CDN";
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Third-party integration error: " . $e->getMessage();
            log_message('error', 'Debug third-party integration check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_cache_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check cache configuration
            $cache_config = array(
                'cache_path' => config_item('cache_path') ?: APPPATH . 'cache/',
                'cache_query_string' => config_item('cache_query_string') ?: FALSE,
                'cache_default_expires' => config_item('cache_default_expires') ?: 7200
            );

            // Report cache configuration
            foreach ($cache_config as $key => $value) {
                $results['details'][] = "Cache config {$key}: " . ($value ? $value : 'Using default');
            }

            // Check cache directory
            $cache_path = $cache_config['cache_path'];
            if (is_dir($cache_path)) {
                if (is_writable($cache_path)) {
                    $results['details'][] = "Cache directory: WRITABLE";
                    
                    // Check cache directory size
                    $cache_size = $this->get_directory_size($cache_path);
                    $results['details'][] = "Cache size: " . round($cache_size / 1024 / 1024, 2) . "MB";
                    
                    if ($cache_size > 100 * 1024 * 1024) { // 100MB threshold
                        $results['status'] = 'warning';
                        $results['details'][] = "Cache directory size is large (> 100MB) - Consider cleanup";
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Cache directory: NOT WRITABLE";
                }
            } else {
                try {
                    mkdir($cache_path, 0755, true);
                    $results['details'][] = "Cache directory: CREATED";
                } catch (Exception $e) {
                    $results['status'] = 'error';
                    $results['details'][] = "Cache directory: CREATION FAILED - " . $e->getMessage();
                }
            }

            // Check available cache drivers
            $available_drivers = array();
            $optional_drivers = array(
                'apc' => 'APC',
                'memcached' => 'Memcached',
                'redis' => 'Redis'
            );
            
            // File driver is required
            if ($this->is_cache_driver_available('file')) {
                $results['details'][] = "Cache driver file: AVAILABLE (Primary)";
                $available_drivers[] = 'file';
            } else {
                $results['status'] = 'error';
                $results['details'][] = "Cache driver file: NOT AVAILABLE - Required for basic caching";
            }

            // Check optional drivers
            foreach ($optional_drivers as $driver => $name) {
                if ($this->is_cache_driver_available($driver)) {
                    $results['details'][] = "Cache driver {$driver}: AVAILABLE";
                    $available_drivers[] = $driver;
                } else {
                    $results['details'][] = "Cache driver {$driver}: NOT AVAILABLE (Optional)";
                }
            }

            // Test cache functionality if at least one driver is available
            if (!empty($available_drivers)) {
                $this->load->driver('cache', array('adapter' => $available_drivers[0]));
                
                // Write test
                $test_key = 'debug_test_' . time();
                $test_value = 'test_value_' . time();
                
                $this->benchmark->mark('cache_write_start');
                $this->cache->save($test_key, $test_value, 300);
                $this->benchmark->mark('cache_write_end');
                $write_time = $this->benchmark->elapsed_time('cache_write_start', 'cache_write_end');
                
                // Read test
                $this->benchmark->mark('cache_read_start');
                $retrieved_value = $this->cache->get($test_key);
                $this->benchmark->mark('cache_read_end');
                $read_time = $this->benchmark->elapsed_time('cache_read_start', 'cache_read_end');
                
                if ($retrieved_value === $test_value) {
                    $results['details'][] = "Cache read/write test: OK";
                    $results['details'][] = "Cache write time: {$write_time}s";
                    $results['details'][] = "Cache read time: {$read_time}s";
                    
                    // Only warn if both operations are slow
                    if ($write_time > 0.1 && $read_time > 0.1) {
                        $results['status'] = 'warning';
                        $results['details'][] = "Cache operations are slow (both > 0.1s) - Consider using a faster cache driver";
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Cache read/write test: FAILED";
                }
                
                // Cleanup
                $this->cache->delete($test_key);
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Cache system error: " . $e->getMessage();
            log_message('error', 'Debug cache system check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function is_cache_driver_available($driver) {
        switch ($driver) {
            case 'apc':
                return function_exists('apc_store');
            case 'memcached':
                return class_exists('Memcached');
            case 'redis':
                return class_exists('Redis');
            case 'file':
                return is_writable(APPPATH . 'cache');
            default:
                return false;
        }
    }

    private function get_directory_size($path) {
        $size = 0;
        $files = scandir($path);
        
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $full_path = $path . DIRECTORY_SEPARATOR . $file;
                if (is_dir($full_path)) {
                    $size += $this->get_directory_size($full_path);
                } else {
                    $size += filesize($full_path);
                }
            }
        }
        
        return $size;
    }

    private function check_template_system() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check view template structure
            $template_dirs = array(
                'frontend' => array('public', 'private', 'email', 'components'),
                'backend' => array('dashboard', 'users', 'groups', 'auth', 'menus'),
                'templates' => array('layouts', 'partials', 'emails')
            );

            foreach ($template_dirs as $main_dir => $subdirs) {
                $main_path = APPPATH . 'views/' . $main_dir;
                if (is_dir($main_path)) {
                    $results['details'][] = "Template directory {$main_dir}: EXISTS";
                    foreach ($subdirs as $subdir) {
                        if (is_dir($main_path . '/' . $subdir)) {
                            $results['details'][] = "Template subdirectory {$main_dir}/{$subdir}: EXISTS";
                        } else {
                            $results['status'] = 'warning';
                            $results['details'][] = "Template subdirectory {$main_dir}/{$subdir}: MISSING";
                        }
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Template directory {$main_dir}: MISSING";
                }
            }

            // Check critical layout files
            $layout_files = array(
                'templates/layouts/main.php' => 'Main layout',
                'templates/layouts/auth.php' => 'Auth layout',
                'templates/layouts/email.php' => 'Email layout',
                'templates/partials/header.php' => 'Header partial',
                'templates/partials/footer.php' => 'Footer partial',
                'templates/partials/sidebar.php' => 'Sidebar partial'
            );

            foreach ($layout_files as $file => $description) {
                if (file_exists(APPPATH . 'views/' . $file)) {
                    $results['details'][] = "{$description}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "{$description}: MISSING";
                }
            }

            // Check template helpers
            $template_helpers = array(
                'template_helper.php' => 'Template helper functions',
                'html_helper.php' => 'HTML helper functions',
                'form_helper.php' => 'Form helper functions'
            );

            foreach ($template_helpers as $helper => $description) {
                if (file_exists(APPPATH . 'helpers/' . $helper)) {
                    $results['details'][] = "{$description}: EXISTS";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "{$description}: MISSING";
                }
            }

            // Test template engine functionality
            $this->load->library('parser');
            $test_data = array('title' => 'Test Title');
            $test_template = '<h1>{title}</h1>';
            
            try {
                $parsed = $this->parser->parse_string($test_template, $test_data, TRUE);
                if (strpos($parsed, 'Test Title') !== false) {
                    $results['details'][] = "Template parser: FUNCTIONAL";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "Template parser: NOT WORKING CORRECTLY";
                }
            } catch (Exception $e) {
                $results['status'] = 'error';
                $results['details'][] = "Template parser error: " . $e->getMessage();
            }

            // Check template caching
            $cache_path = APPPATH . 'cache/templates';
            if (is_dir($cache_path)) {
                if (is_writable($cache_path)) {
                    $results['details'][] = "Template cache directory: WRITABLE";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "Template cache directory: NOT WRITABLE";
                }
            } else {
                $results['status'] = 'warning';
                $results['details'][] = "Template cache directory: MISSING";
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Template system error: " . $e->getMessage();
            log_message('error', 'Debug template system check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_qr_pdf_generation() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check QR Code library
            if (class_exists('Endroid\\QrCode\\QrCode')) {
                $results['details'][] = "QR Code library: LOADED";
                
                // Test QR generation
                try {
                    $qr = new \Endroid\QrCode\QrCode('Test QR Code');
                    $qr_path = FCPATH . 'store/qrcodes/test.png';
                    $qr->writeFile($qr_path);
                    
                    if (file_exists($qr_path)) {
                        $results['details'][] = "QR Code generation: FUNCTIONAL";
                        unlink($qr_path); // Clean up test file
                    } else {
                        $results['status'] = 'error';
                        $results['details'][] = "QR Code generation: FAILED";
                    }
                } catch (Exception $e) {
                    $results['status'] = 'error';
                    $results['details'][] = "QR Code generation error: " . $e->getMessage();
                }
            } else {
                $results['status'] = 'error';
                $results['details'][] = "QR Code library: NOT LOADED";
            }

            // Check PDF libraries
            $pdf_libraries = array(
                'TCPDF' => 'TCPDF',
                'Dompdf\\Dompdf' => 'DOMPDF'
            );

            foreach ($pdf_libraries as $class => $name) {
                if (class_exists($class)) {
                    $results['details'][] = "{$name} library: LOADED";
                } else {
                    $results['status'] = 'warning';
                    $results['details'][] = "{$name} library: NOT LOADED";
                }
            }

            // Check PDF generation directories
            $pdf_directories = array(
                'store/pdfs' => 'PDF storage',
                'store/pdfs/temp' => 'Temporary PDF storage'
            );

            foreach ($pdf_directories as $dir => $description) {
                $full_path = FCPATH . $dir;
                if (is_dir($full_path)) {
                    if (is_writable($full_path)) {
                        $results['details'][] = "{$description} directory: WRITABLE";
                    } else {
                        $results['status'] = 'error';
                        $results['details'][] = "{$description} directory: NOT WRITABLE";
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$description} directory: MISSING";
                }
            }

            // Check font availability
            $required_fonts = array(
                'helvetica' => 'Helvetica',
                'times' => 'Times New Roman',
                'courier' => 'Courier'
            );

            if (class_exists('TCPDF')) {
                $pdf = new TCPDF();
                foreach ($required_fonts as $font => $name) {
                    if (file_exists(K_PATH_FONTS . 'times.php')) {
                        $results['details'][] = "Font {$name}: AVAILABLE";
                    } else {
                        $results['status'] = 'warning';
                        $results['details'][] = "Font {$name}: MISSING";
                    }
                }
            }

            // Test PDF generation
            try {
                $pdf = new TCPDF();
                $pdf->AddPage();
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(0, 10, 'Test PDF Generation', 0, 1, 'C');
                $test_pdf = FCPATH . 'store/pdfs/temp/test.pdf';
                $pdf->Output($test_pdf, 'F');
                
                if (file_exists($test_pdf)) {
                    $results['details'][] = "PDF generation: FUNCTIONAL";
                    unlink($test_pdf); // Clean up test file
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "PDF generation: FAILED";
                }
            } catch (Exception $e) {
                $results['status'] = 'error';
                $results['details'][] = "PDF generation error: " . $e->getMessage();
            }

            // Remove QR Code directory check from here since it's now in check_third_party_integrations

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "QR/PDF generation error: " . $e->getMessage();
            log_message('error', 'Debug QR/PDF generation check failed: ' . $e->getMessage());
        }

        return $results;
    }

    private function check_directory_structure() {
        $results = array('status' => 'ok', 'details' => array());
        
        try {
            // Check core directory structure
            $core_directories = array(
                APPPATH => 'Application',
                BASEPATH => 'System',
                FCPATH => 'Public'
            );

            foreach ($core_directories as $path => $name) {
                if (is_dir($path)) {
                    $results['details'][] = "{$name} directory: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$name} directory: MISSING";
                }
            }

            // Check MVC directories
            $mvc_directories = array(
                'controllers' => array('backend', 'frontend', 'ecommerce'),
                'models' => array('Business', 'System'),
                'views' => array('frontend', 'backend', 'templates', 'components')
            );

            foreach ($mvc_directories as $dir => $subdirs) {
                $main_path = APPPATH . $dir;
                if (is_dir($main_path)) {
                    $results['details'][] = "MVC {$dir} directory: EXISTS";
                    foreach ($subdirs as $subdir) {
                        if (is_dir($main_path . '/' . $subdir)) {
                            $results['details'][] = "MVC {$dir}/{$subdir} directory: EXISTS";
                        } else {
                            $results['status'] = 'warning';
                            $results['details'][] = "MVC {$dir}/{$subdir} directory: MISSING";
                        }
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "MVC {$dir} directory: MISSING";
                }
            }

            // Check required system directories
            $system_directories = array(
                'cache' => 'Cache storage',
                'logs' => 'Log files',
                'config' => 'Configuration files',
                'language' => 'Language files',
                'libraries' => 'Libraries',
                'helpers' => 'Helper functions',
                'third_party' => 'Third-party packages'
            );

            foreach ($system_directories as $dir => $description) {
                $path = APPPATH . $dir;
                if (is_dir($path)) {
                    if (is_writable($path)) {
                        $results['details'][] = "{$description} directory: WRITABLE";
                    } else {
                        if ($dir === 'cache' || $dir === 'logs') {
                            $results['status'] = 'error';
                            $results['details'][] = "{$description} directory: NOT WRITABLE";
                        } else {
                            $results['details'][] = "{$description} directory: EXISTS";
                        }
                    }
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$description} directory: MISSING";
                }
            }

            // Check file naming conventions
            $naming_patterns = array(
                'controllers' => '/^[A-Z][a-zA-Z0-9_]*\.php$/',
                'models' => '/^[A-Z][a-zA-Z0-9_]*_model\.php$/',
                'views' => '/^[a-z0-9_]+\.php$/'
            );

            foreach ($naming_patterns as $type => $pattern) {
                $files = glob(APPPATH . $type . '/*/*.php');
                $invalid_files = array();
                
                foreach ($files as $file) {
                    if (!preg_match($pattern, basename($file))) {
                        $invalid_files[] = basename($file);
                    }
                }
                
                if (!empty($invalid_files)) {
                    $results['status'] = 'warning';
                    $results['details'][] = "Invalid {$type} file names: " . implode(', ', $invalid_files);
                }
            }

            // Check critical file presence
            $critical_files = array(
                'config/config.php' => 'Main configuration',
                'config/database.php' => 'Database configuration',
                'config/routes.php' => 'Routes configuration',
                'config/autoload.php' => 'Autoload configuration',
                'controllers/backend/Auth.php' => 'Authentication controller',
                'controllers/frontend/Web.php' => 'Main website controller',
                'models/Business/Customer_model.php' => 'Customer model',
                'views/templates/layouts/main.php' => 'Main layout template'
            );

            foreach ($critical_files as $file => $description) {
                if (file_exists(APPPATH . $file)) {
                    $results['details'][] = "{$description} file: EXISTS";
                } else {
                    $results['status'] = 'error';
                    $results['details'][] = "{$description} file: MISSING";
                }
            }

        } catch (Exception $e) {
            $results['status'] = 'error';
            $results['details'][] = "Directory structure error: " . $e->getMessage();
            log_message('error', 'Debug directory structure check failed: ' . $e->getMessage());
        }

        return $results;
    }
} 