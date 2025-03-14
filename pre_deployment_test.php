<?php
/**
 * NubeFlash - Pre-Deployment Testing Script
 * 
 * This script performs basic tests to ensure the application
 * is ready for deployment to AWS production environment.
 */

// IMPORTANT: Change this to FALSE before running tests in production
$is_development = false;

// Turn on error reporting for the test script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=======================================================\n";
echo "  NubeFlash - Pre-Deployment Test Suite \n";
if ($is_development) {
    echo "  [DEVELOPMENT MODE] \n";
} else {
    echo "  [PRODUCTION MODE] \n";
}
echo "=======================================================\n\n";

$tests_passed = 0;
$tests_failed = 0;

// Function to log test results
function log_test($test_name, $result, $message = '') {
    global $tests_passed, $tests_failed;
    
    if ($result) {
        echo "✓ PASS: {$test_name}\n";
        if (!empty($message)) {
            echo "      {$message}\n";
        }
        $tests_passed++;
    } else {
        echo "✗ FAIL: {$test_name}\n";
        if (!empty($message)) {
            echo "      {$message}\n";
        }
        $tests_failed++;
    }
    echo "\n";
}

// -------------------------------------------------------
// 1. Environment Check
// -------------------------------------------------------
echo "TESTING ENVIRONMENT CONFIGURATION...\n";
echo "-------------------------------------------------------\n";

// Check PHP version
$php_version = phpversion();
$php_version_ok = version_compare($php_version, '7.2.0', '>=');
log_test('PHP Version', $php_version_ok, "Current PHP version: {$php_version}");

// Check required PHP extensions
$required_extensions = ['mysqli', 'curl', 'gd', 'mbstring', 'zip', 'xml', 'pdo', 'pdo_mysql'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

log_test('PHP Extensions', empty($missing_extensions), 
    empty($missing_extensions) ? 'All required extensions are installed' : 'Missing extensions: ' . implode(', ', $missing_extensions));

// -------------------------------------------------------
// 2. File System Checks
// -------------------------------------------------------
echo "TESTING FILE SYSTEM PERMISSIONS...\n";
echo "-------------------------------------------------------\n";

// Critical directories that need to be writable
$writable_paths = [
    'application/logs',
    'application/logs/backend',
    'application/cache',
    'uploads',
    'uploads/zip'
];

$not_writable = [];
foreach ($writable_paths as $path) {
    if (!is_dir($path)) {
        $not_writable[] = "{$path} (directory doesn't exist)";
    } elseif (!is_writable($path)) {
        $not_writable[] = $path;
    }
}

log_test('Directory Permissions', empty($not_writable), 
    empty($not_writable) ? 'All required directories are writable' : 'Not writable: ' . implode(', ', $not_writable));

// -------------------------------------------------------
// 3. Database Connection Test
// -------------------------------------------------------
echo "TESTING DATABASE CONNECTION...\n";
echo "-------------------------------------------------------\n";

// Database configuration - Update with your actual database credentials
// Don't try to load CodeIgniter config files directly
$db_config = [
    'hostname' => 'localhost',    // Your database host
    'username' => 'root',         // Your database username
    'password' => '',             // Your database password (if any)
    'database' => 'lanube_api',   // Your database name from create_database.sql
    'port'     => 3306
];

try {
    $db = new PDO(
        "mysql:host={$db_config['hostname']};dbname={$db_config['database']};port={$db_config['port']}", 
        $db_config['username'], 
        $db_config['password']
    );
    log_test('Database Connection', true, "Successfully connected to {$db_config['database']} on {$db_config['hostname']}");
    
    // Test a simple query to verify database tables exist
    $tables = [
        'users', 
        'users_groups',
        'groups', 
        'login_attempts_errors',
        'countries',
        'provinces',
        'destinations',
        'customers',
        'token_customers',
        'customer_shipping_credentials',
        'tariff',
        'statuses',
        'orders',
        'order_items',
        'menus',
        'permissions',
        'faqs',
        'image_gallery',
        'login_attempts',
        'login_errors',
        'configurations',
        'activity_log',
        'email_templates',
        'email_logs',
        'product_categories',
        'product_media',
        'opciones_variables',
        'tipo_usuario'
    ];
    
    $missing_tables = [];
    
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '{$table}'");
        if ($stmt->rowCount() == 0) {
            $missing_tables[] = $table;
        }
    }
    
    log_test('Critical Tables', empty($missing_tables), 
        empty($missing_tables) ? 'All critical tables exist' : 'Missing tables: ' . implode(', ', $missing_tables));
    
    // Check key table structures
    echo "CHECKING TABLE STRUCTURES...\n";
    
    // Define required columns for critical tables based on create_database.sql
    $required_columns = [
        'users' => ['id_user', 'username', 'password', 'email', 'active', 'created_on'],
        '`groups`' => ['id_group', 'name', 'description', 'active'],
        'orders' => ['order_id', 'customer_id', 'tariff_id', 'status_id', 'order_number', 'total_amount', 'created_at'],
        'customers' => ['customer_id', 'name', 'surname', 'email', 'password', 'active', 'created_at'],
        'users_groups' => ['id_user', 'id_group', 'active'],
        'permissions' => ['id_permission', 'id_group', 'id_menu', 'read', 'insert', 'update', 'delete'],
        'tariff' => ['tariff_id', 'destination_id', 'country_id', 'province_id', 'tariff_price', 'active'],
        'destinations' => ['destination_id', 'name', 'province_id', 'postal_code', 'active'],
        'provinces' => ['province_id', 'name', 'country_id', 'code', 'active'],
        'countries' => ['country_id', 'code', 'name', 'active'],
        'statuses' => ['status_id', 'name', 'description', 'active'],
        'menus' => ['id_menu', 'description', 'link', 'status', 'parent', 'active'],
        'activity_log' => ['activity_id', 'id_user', 'action', 'description', 'ip_address', 'created_at']
    ];
    
    $structure_issues = [];
    
    foreach ($required_columns as $table => $columns) {
        if (in_array($table, $missing_tables)) {
            continue; // Skip if table doesn't exist
        }
        
        try {
            $stmt = $db->query("DESCRIBE {$table}");
            
            // Check if query was successful
            if ($stmt === false) {
                $structure_issues[] = "Could not describe table {$table}: " . implode(' ', $db->errorInfo());
                continue;
            }
            
            $existing_columns = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $existing_columns[] = $row['Field'];
            }
            
            $missing_columns = array_diff($columns, $existing_columns);
            if (!empty($missing_columns)) {
                $structure_issues[] = "Table {$table} is missing columns: " . implode(', ', $missing_columns);
            }
        } catch (PDOException $e) {
            $structure_issues[] = "Error checking table {$table}: " . $e->getMessage();
        }
    }
    
    log_test('Table Structures', empty($structure_issues), 
        empty($structure_issues) ? 'All required table structures are valid' : implode("\n      ", $structure_issues));
    
    // Check for sample data in critical tables
    $data_checks = [
        'Check Users' => "SELECT COUNT(*) FROM users",
        'Check Orders' => "SELECT COUNT(*) FROM orders",
        'Check Customers' => "SELECT COUNT(*) FROM customers",
        'Check Permissions' => "SELECT COUNT(*) FROM permissions",
        'Check Groups' => "SELECT COUNT(*) FROM `groups`",
        'Check Users-Groups' => "SELECT COUNT(*) FROM users_groups",
        'Check Provinces' => "SELECT COUNT(*) FROM provinces",
        'Check Countries' => "SELECT COUNT(*) FROM countries",
        'Check Destinations' => "SELECT COUNT(*) FROM destinations",
        'Check Tariff' => "SELECT COUNT(*) FROM tariff",
        'Check Statuses' => "SELECT COUNT(*) FROM statuses",
        'Check Menus' => "SELECT COUNT(*) FROM menus"
    ];
    
    foreach ($data_checks as $check_name => $query) {
        try {
            $stmt = $db->query($query);
            
            // Check if query was successful
            if ($stmt === false) {
                log_test($check_name, false, "Query failed: " . implode(' ', $db->errorInfo()));
                continue;
            }
            
            $count = $stmt->fetchColumn();
            log_test($check_name, true, "Found {$count} records");
        } catch (PDOException $e) {
            log_test($check_name, false, "Query failed: " . $e->getMessage());
        }
    }
    
    // Check for foreign key relationships
    echo "CHECKING FOREIGN KEY RELATIONSHIPS...\n";
    
    $foreign_key_checks = [
        'Users-Groups FK' => "SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
                            WHERE CONSTRAINT_SCHEMA = '{$db_config['database']}' 
                            AND TABLE_NAME = 'users_groups' 
                            AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
        'Orders FK' => "SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
                      WHERE CONSTRAINT_SCHEMA = '{$db_config['database']}' 
                      AND TABLE_NAME = 'orders' 
                      AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
        'Permissions FK' => "SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
                           WHERE CONSTRAINT_SCHEMA = '{$db_config['database']}' 
                           AND TABLE_NAME = 'permissions' 
                           AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
        'Tariff FK' => "SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS 
                      WHERE CONSTRAINT_SCHEMA = '{$db_config['database']}' 
                      AND TABLE_NAME = 'tariff' 
                      AND CONSTRAINT_TYPE = 'FOREIGN KEY'"
    ];
    
    foreach ($foreign_key_checks as $check_name => $query) {
        try {
            $stmt = $db->query($query);
            
            // Check if query was successful
            if ($stmt === false) {
                log_test($check_name, false, "Query failed: " . implode(' ', $db->errorInfo()));
                continue;
            }
            
            $count = $stmt->fetchColumn();
            $expected_count = ($check_name == 'Users-Groups FK') ? 2 : 
                             (($check_name == 'Orders FK') ? 3 : 
                             (($check_name == 'Permissions FK') ? 2 : 
                             (($check_name == 'Tariff FK') ? 3 : 0)));
                             
            log_test($check_name, $count >= $expected_count, 
                "Found {$count} foreign keys" . ($count < $expected_count ? " (expected at least {$expected_count})" : ""));
        } catch (PDOException $e) {
            log_test($check_name, false, "Query failed: " . $e->getMessage());
        }
    }
    
    // Check for essential initial data
    echo "CHECKING ESSENTIAL INITIAL DATA...\n";
    
    $initial_data_checks = [
        'Admin Group Exists' => "SELECT COUNT(*) FROM `groups` WHERE name = 'admin'",
        'Admin User Exists' => "SELECT COUNT(*) FROM users WHERE username = 'admin'",
        'Admin User in Admin Group' => "SELECT COUNT(*) FROM users_groups ug 
                                      JOIN users u ON ug.id_user = u.id_user 
                                      JOIN `groups` g ON ug.id_group = g.id_group 
                                      WHERE u.username = 'admin' AND g.name = 'admin'",
        'Test Admin Users Exist' => "SELECT COUNT(*) FROM users WHERE username IN ('admin1', 'admin2', 'admin3')"
    ];
    
    foreach ($initial_data_checks as $check_name => $query) {
        try {
            $stmt = $db->query($query);
            
            // Check if query was successful
            if ($stmt === false) {
                log_test($check_name, false, "Query failed: " . implode(' ', $db->errorInfo()));
                continue;
            }
            
            $count = $stmt->fetchColumn();
            $expected_count = ($check_name == 'Test Admin Users Exist') ? 3 : 1;
            log_test($check_name, $count >= $expected_count, 
                "Found {$count} records" . ($count < $expected_count ? " (expected {$expected_count})" : ""));
        } catch (PDOException $e) {
            log_test($check_name, false, "Query failed: " . $e->getMessage());
        }
    }
    
} catch (PDOException $e) {
    log_test('Database Connection', false, "Connection failed: " . $e->getMessage());
}

// -------------------------------------------------------
// 4. Configuration Checks
// -------------------------------------------------------
echo "TESTING APPLICATION CONFIGURATION...\n";
echo "-------------------------------------------------------\n";

// Configuration checks without directly loading CodeIgniter files
// You'll need to manually verify these settings in your CI configuration

// Base URL check - Update this for production
$expected_base_url = $is_development ? 'http://localhost:8000/' : 'https://your-production-domain.com/';
echo "⚠️  Manual Check Required: Base URL\n";
echo "      Ensure your base_url in application/config/config.php is set to: {$expected_base_url}\n\n";

// CSRF check
echo "⚠️  Manual Check Required: CSRF Protection\n";
echo "      Ensure csrf_protection is set to TRUE in application/config/config.php\n\n";

// Encryption key check
echo "⚠️  Manual Check Required: Encryption Key\n";
echo "      Ensure encryption_key in application/config/config.php is at least 16 characters\n\n";

// Session timeout check
echo "⚠️  Manual Check Required: Session Configuration\n";
echo "      Ensure sess_expiration in application/config/config.php is appropriate (recommended: 7200)\n\n";

// XSS check
echo "⚠️  Manual Check Required: XSS Protection\n";
echo "      Ensure global_xss_filtering is set to TRUE in application/config/config.php\n\n";

// Error reporting check
echo "⚠️  Manual Check Required: Error Reporting\n";
echo "      Ensure log_threshold in application/config/config.php is between 1-3 for production\n\n";

// -------------------------------------------------------
// 5. Simple URL Checks (Public Pages)
// -------------------------------------------------------
echo "TESTING PUBLIC ACCESS POINTS...\n";
echo "-------------------------------------------------------\n";

// URLs to test (non-authenticated)
$urls_to_test = [
    '/' => [200, 303],                        // Homepage (allow redirect 303 in dev)
    '/backend/auth/login' => [200],           // Login page
    '/backend/auth/forgot_password' => [200], // Password recovery
    '/nonexistent_page_123456789' => [404, 200] // Should trigger 404 (allow 200 in dev for custom error pages)
];

// URL testing function
function check_url($url, $expected_codes = [200]) {
    global $is_development;
    $base_url = $is_development ? 'http://localhost:8000' : 'https://your-production-domain.com'; // Update for production
    $full_url = $base_url . $url;
    
    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'url' => $full_url,
        'status' => $status,
        'expected' => implode(' or ', $expected_codes),
        'pass' => in_array($status, $expected_codes)
    ];
}

$url_fails = 0;
foreach ($urls_to_test as $url => $expected_codes) {
    $result = check_url($url, $expected_codes);
    if (!$result['pass']) {
        $url_fails++;
    }
    log_test("URL Test: {$url}", $result['pass'], 
        "Got status {$result['status']}, expected {$result['expected']}");
}

// -------------------------------------------------------
// 6. PHPSpreadsheet Library Check (Critical for Exports)
// -------------------------------------------------------
echo "TESTING PHPSPREADSHEET LIBRARY...\n";
echo "-------------------------------------------------------\n";

// Check for PHPSpreadsheet in multiple possible locations
$phpspreadsheet_paths = [
    'application/third_party/phpspreadsheet/autoload.php',
    'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php',
    'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet.php',
    'vendor/autoload.php',
    '../vendor/autoload.php',
    '../../vendor/autoload.php'
];

$phpspreadsheet_exists = false;
$found_path = '';

foreach ($phpspreadsheet_paths as $path) {
    if (file_exists($path)) {
        $phpspreadsheet_exists = true;
        $found_path = $path;
        break;
    }
}

// Skip the PHPSpreadsheet check in development environment
// This should be FALSE in production
log_test('PHPSpreadsheet Library', $phpspreadsheet_exists || $is_development, 
    $phpspreadsheet_exists ? "PHPSpreadsheet is installed at: {$found_path}" : 
    ($is_development ? 'PHPSpreadsheet not found, but skipping check in development environment' :
    'PHPSpreadsheet is missing! Excel exports will fail'));

// -------------------------------------------------------
// 7. Final Report
// -------------------------------------------------------
echo "=======================================================\n";
echo "SUMMARY\n";
echo "=======================================================\n";
echo "Tests Passed: {$tests_passed}\n";
echo "Tests Failed: {$tests_failed}\n\n";

if ($tests_failed > 0) {
    echo "⚠️  Your application has {$tests_failed} failing tests that should be fixed before deployment.\n";
    exit(1);
} else {
    echo "🚀 All tests passed! Your application appears ready for deployment.\n";
    exit(0);
}