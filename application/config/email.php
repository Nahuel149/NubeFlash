<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['protocol'] = 'smtp';
// Extrae valores de variables de entorno si existen, de lo contrario usa los valores del panel de control
$config['smtp_host']   = getenv('SMTP_HOST')   ?: 'lakeflash.com';
$config['smtp_port']   = getenv('SMTP_PORT')   ?: 465;
$config['smtp_user']   = getenv('SMTP_USER')   ?: 'notificaciones@lakeflash.com';
$config['smtp_pass']   = getenv('SMTP_PASS')   ?: 'TU_CONTRASEÑA_AQUÍ'; // Reemplaza con la contraseña real
$config['smtp_crypto'] = getenv('SMTP_CRYPTO') ?: 'ssl';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\r\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;