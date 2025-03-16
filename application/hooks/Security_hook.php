<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_hook {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function apply_security_headers() {
        // Load security config
        $this->CI->config->load('security', TRUE);
        $security_headers = $this->CI->config->item('security_headers', 'security');

        // Apply security headers
        if (is_array($security_headers)) {
            foreach ($security_headers as $header => $value) {
                header($header . ': ' . $value);
            }
        }

        // Force HTTPS in production
        if (ENVIRONMENT === 'production' && !is_https()) {
            redirect(str_replace('http://', 'https://', current_url()), 'location', 301);
        }
    }

    public function check_file_permissions() {
        // Critical config files to check
        $critical_files = array(
            APPPATH . 'config/config.php',
            APPPATH . 'config/database.php',
            APPPATH . 'config/email.php'
        );

        foreach ($critical_files as $file) {
            if (file_exists($file)) {
                $perms = fileperms($file);
                if (($perms & 0x0004) || ($perms & 0x0002)) {
                    // Log warning if file is world readable or writable
                    log_message('error', 'Insecure file permissions for ' . $file);
                }
            }
        }
    }
} 