<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Security Configuration
|--------------------------------------------------------------------------
*/

// PHP Settings
ini_set('display_errors', '0');  // Disable error display in production
ini_set('expose_php', '0');      // Hide PHP version
ini_set('session.cookie_httponly', '1');  // Prevent JavaScript access to session cookie
ini_set('session.cookie_secure', '1');    // Only send cookie over HTTPS
ini_set('session.use_strict_mode', '1');  // Use strict session mode
ini_set('session.cookie_samesite', 'Lax'); // SameSite cookie attribute

// CodeIgniter Security Settings
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array('frontend/api/.*');  // Exclude API endpoints

$config['global_xss_filtering'] = TRUE;  // Enable global XSS filtering
$config['encryption_key'] = getenv('APP_ENCRYPTION_KEY') ?: '';

// Security Headers
$config['security_headers'] = array(
    'X-Frame-Options' => 'SAMEORIGIN',
    'X-XSS-Protection' => '1; mode=block',
    'X-Content-Type-Options' => 'nosniff',
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
    'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/ https://cdn.jsdelivr.net https://code.jquery.com https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com; style-src * 'unsafe-inline'; style-src-elem * 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; img-src 'self' data: https:; connect-src 'self' https:; frame-src 'self' https://www.google.com/recaptcha/ https://recaptcha.google.com/recaptcha/; object-src 'none'"
);