<?php
/**
 * Script de prueba de conexión a la base de datos.
 *
 * Carga la configuración de CodeIgniter (application/config/database.php)
 * y utiliza el grupo activo ($active_group) para intentar abrir la conexión.
 *
 * Cómo usarlo:
 * 1. Subir este archivo al mismo directorio que el proyecto (generalmente public_html/ o el root del proyecto).
 * 2. Acceder vía navegador, por ejemplo: https://tu-dominio.com/test_db.php
 * 3. Eliminar el archivo después de la prueba para evitar exposición de información sensible.
 */

// Ruta absoluta a la configuración de la base de datos
require __DIR__ . '/application/config/database.php';

// Determinar el grupo de conexión activo (por defecto 'production')
$group = isset($active_group) ? $active_group : 'production';

if (!isset($db[$group])) {
    http_response_code(500);
    echo "No se encontró la configuración para el grupo: {$group}";
    exit;
}

$config = $db[$group];

$mysqli = @new mysqli(
    $config['hostname'],
    $config['username'],
    $config['password'],
    $config['database'],
    isset($config['port']) ? (int)$config['port'] : 3306
);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo 'Error de conexión (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error;
    exit;
}

echo 'Conexión exitosa a la base de datos "' . $config['database'] . '" usando el usuario "' . $config['username'] . '".';

$mysqli->close();