<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// Security hooks
$hook['post_system'][] = array(
    'class'    => 'Security_hook',
    'function' => 'check_file_permissions',
    'filename' => 'Security_hook.php',
    'filepath' => 'hooks'
);

$hook['post_controller'][] = array(
    'class'    => 'Security_hook',
    'function' => 'apply_security_headers',
    'filename' => 'Security_hook.php',
    'filepath' => 'hooks'
);
