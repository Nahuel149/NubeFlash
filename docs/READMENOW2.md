# La Nube - Part 2: Framework Foundation and System Services

## Framework Foundation

### CodeIgniter 3.1.13 Core

The application is built on CodeIgniter 3.1.13, a lightweight PHP framework that follows the MVC (Model-View-Controller) pattern. The core framework files are located in the `/system` directory and remain unmodified to ensure compatibility with future updates. Key components include:

- **Core Files**: Located in `/system/core/` (e.g., CodeIgniter.php, Controller.php, Model.php)
- **Libraries**: Located in `/system/libraries/` (e.g., Session, Database)
- **Helpers**: Located in `/system/helpers/` (e.g., url_helper.php, form_helper.php)

### MVC Implementation

- **Models**: Handle data access and business logic, stored in `/application/models/`. Examples include Order_model.php for order processing and Customer_model.php for customer data management.
- **Views**: Manage presentation and templating, stored in `/application/views/`. Organized into backend/, frontend/, and template/ directories for admin, public, and layout views respectively.
- **Controllers**: Process requests and coordinate responses, stored in `/application/controllers/`. Organized into subdirectories like backend/, frontend/, and ecommerce/ for specific functionalities.

### Request Flow

1. All requests enter through index.php in the root directory.
2. The router (`/system/core/Router.php`) determines the appropriate controller based on the URL.
3. The controller loads required models and libraries via the Loader.php class.
4. Business logic is processed using models and libraries.
5. Views are rendered and returned to the user via the Output.php class.

## Request Handling

### URL Structure

The application uses clean URLs with the following pattern:

```
http://domain.com/[controller]/[method]/[param1]/[param2]/...
```

Example: `http://localhost:8000/test_qr/generate` calls the generate method in Test_qr.php.

### Routing Configuration

Routes are defined in application/config/routes.php:

```php
// Default route
$route['default_controller'] = 'frontend/web';

// Backend routes
$route['backend'] = 'backend/dashboard';
$route['backend/(:any)'] = 'backend/$1';
$route['backend/(:any)/(:any)'] = 'backend/$1/$2';
$route['backend/(:any)/(:any)/(:any)'] = 'backend/$1/$2/$3';

// Frontend routes
$route['frontend/api/(:any)'] = 'frontend/api/$1';
$route['frontend/ajax/(:any)'] = 'frontend/ajax/$1';

// Authentication routes
$route['login'] = 'frontend/web/login';
$route['logout'] = 'frontend/web/logout';
$route['registro'] = 'frontend/web/register';

// Utility routes
$route['test_qr'] = 'test_qr';
$route['test_pdf'] = 'test_pdf';

// Error handling
$route['404_override'] = 'sudaca_errores/error_404';
$route['translate_uri_dashes'] = FALSE;
```

## Frontend Pages Structure

The frontend of the application is organized into public and private sections, each with its own controllers, views, and templates.

### Controller Structure

#### Public Controllers (Web.php)
- Located in `/application/controllers/frontend/Web.php`
- Handles public-facing pages like home, login, registration
- Manages PDF document serving and contact forms
- Implements user authentication for public users

#### Private Controllers (Dashboard.php)
- Located in `/application/controllers/frontend/private/Dashboard.php`
- Requires user authentication via session
- Manages user dashboard, profile, orders, and API tokens
- Implements security checks before allowing access

#### API Controllers (Api.php)
- Located in `/application/controllers/frontend/Api.php`
- Handles API requests for shipping calculations, order creation
- Implements token-based authentication
- Returns JSON responses for integration with external systems

### View Structure

#### Public Views
- Located in `/application/views/frontend/public/`
- Includes templates for home page, login, registration
- Implements responsive design with Bootstrap

#### Private Views
- Located in `/application/views/frontend/private/`
- Includes dashboard, profile, orders, and token management
- Requires authentication to access

#### Template Structure
- Base templates in `/application/views/template/`
- Frontend template: `frontend.php` (public pages)
- Private template: `private.php` (authenticated user pages)
- Shared components in subdirectories (header, footer, navigation)

### Page Rendering Process

1. **Controller Initialization**:
   ```php
   // Load required models
   $this->load->model('customer_model','customer');
   ```

2. **Data Preparation**:
   ```php
   $vista_interna = array(
       'orders' => $orders
   );
   
   $vista_config = array(
       'metadata' => '',
       'title' => '',
       'description' => '',
   );
   ```

3. **View Rendering**:
   ```php
   $vista_externa = array(
       'contenido_main' => $this->load->view('frontend/private/orders', $vista_interna, true),
       'configuracion' => $this->frontend_lib->configuraciones($vista_config),
       'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
       'image_header' => 'orders.png' // Icon for the page header
   );
   
   $this->load->view('template/private', $vista_externa);
   ```

### Common Variables Passed to Views

| Variable | Description | Used In |
|----------|-------------|---------|
| `$contenido_main` | Main content of the page | All templates |
| `$configuracion` | Configuration settings | All templates |
| `$configurations` | Database configuration | All templates |
| `$image_header` | Icon for the page header | Private template |

### AJAX Request Handling

The frontend implements robust AJAX request handling with CSRF token management:

1. **Token Initialization**:
   ```javascript
   // Variables initialized in template/private/js.php
   var base_url = '<?php echo base_url() ?>';
   var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
   var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
   ```

2. **AJAX Request with Token**:
   ```javascript
   $.ajax({
       url: base_url + 'frontend/private/dashboard/get_order_details',
       type: 'POST',
       dataType: 'json',
       data: {
           order_id: orderId,
           [csrf_token_name]: csrf_hash
       },
       success: function(response) {
           // Update CSRF hash with new token from response
           if (response[csrf_token_name]) {
               csrf_hash = response[csrf_token_name];
           }
           
           // Process response data
           if (response.success) {
               // Handle successful response
           }
       }
   });
   ```

3. **Server-Side Token Refreshing**:
   ```php
   // Include new CSRF token in JSON response
   $response = [
       'success' => true,
       'data' => $data,
       $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
   ];
   
   echo json_encode($response);
   ```

4. **Error Handling**:
   ```javascript
   error: function(xhr, status, error) {
       // Log error for debugging
       console.error("AJAX Error:", status, error);
       
       // Handle specific error codes
       if (xhr.status === 403) {
           // CSRF token mismatch or expired
           errorMessage = 'Error de seguridad. Por favor recargue la página.';
       }
       
       // Display user-friendly error
       displayErrorMessage(errorMessage);
   }
   ```

### Authentication Flow

1. **Login Process**:
   - User submits credentials via `/login`
   - Credentials verified against `customers` table
   - Session created with customer data
   - Redirect to dashboard

2. **Session Verification**:
   - Each private controller checks for `customer_id` in session
   - If not present, redirects to login page
   - For AJAX requests, returns JSON error response

3. **Logout Process**:
   - Session destroyed via `/logout`
   - Redirect to home page

### Controller Hierarchy

The application uses a hierarchical controller structure:

#### Base Controller (Sudaca_controller.php, 272B, 15 lines)
- Loads common libraries and helpers
- Sets up basic configuration
- Handles session management

#### Backend Controller (extends Base Controller)
- Located in `/application/controllers/backend/`
- Manages authentication for admin area (e.g., Auth.php, 15KB, 337 lines)
- Loads admin-specific resources (e.g., Dashboard.php, 2.7KB, 89 lines)
- Handles permission checking via Permisos.php (3.2KB, 114 lines)

#### Frontend Controller (extends Base Controller)
- Located in `/application/controllers/frontend/`
- Manages public website functionality (e.g., Web.php, 9.3KB, 287 lines)
- Handles customer authentication (e.g., Api.php, 13KB, 270 lines)
- Processes API requests

#### Error Controller (Sudaca_errores.php, 413B, 22 lines)
- Handles error display
- Logs exceptions
- Provides custom error pages (e.g., 404, 500)

## System Services

### Authentication System

The application uses Ion Auth for authentication, with customizations for both backend and frontend users:

#### Backend Authentication
- **Admin Users**: Stored in users table
- **Group Permissions**: Defined in groups table and linked via users_groups
- **Login Tracking**: Recorded in login_attempts table
- **Error Logging**: Tracked in login_errors table
- **Implementation**: Ion_auth.php (13KB, 516 lines) and Ion_auth_model.php (48KB, 2100 lines)

#### Frontend Authentication
- **Customers**: Stored in customers table
- **API Authentication**: Token-based, managed via customer_shipping_credentials table
- **Session-Based Web Authentication**: Handled by CodeIgniter's session library
- **Password Recovery**: Email-based, templates in `/application/views/backend/auth/email/`

### Session Management

Sessions are managed using CodeIgniter's session library with database storage:

```php
// Session configuration (application/config/config.php)
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'lanube_session';
$config['sess_expiration'] = 7200; // 2 hours
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300; // 5 minutes
$config['sess_regenerate_destroy'] = FALSE;
```

- **Storage**: Sessions are stored in the ci_sessions table
- **Security**: Uses encryption key defined in `$config['encryption_key'] = 'lanube2023';`

### Database Connectivity

The application supports multiple database environments:

```php
// Database configuration (application/config/database.php)
$active_group = 'developed';
$active_record = TRUE;

$db['developed'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'lanube_api',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'port'     => '3306',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['testing'] = array(
    'hostname' => 'localhost',
    'username' => 'elfiko_tienda',
    'password' => 'admin2016',
    'database' => 'elfiko_giordana',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci'
);

$db['production'] = array(
    'hostname' => 'localhost',
    'username' => 'lanubeflash',
    'password' => 'Y8Ixrqc3Yn38V6B',
    'database' => 'lanubeflash',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci'
);
```

### Email System

The application uses CodeIgniter's email library with SMTP configuration:

```php
// Email configuration (application/config/email.php)
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'your-email@gmail.com';
$config['smtp_pass'] = 'your-password';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";
```

- **Templates**: Stored in email_templates table and managed via `/application/controllers/backend/Configuraciones.php`
- **Usage**: Triggered for password recovery, order confirmations, and notifications

### Logging System

The application implements comprehensive logging:

#### System Logs
- **Location**: application/logs/
- **Configuration**: `$config['log_threshold'] = 1;` (errors only, adjustable to 4 for debug)
- **Format**: Defined by `$config['log_date_format'] = 'Y-m-d H:i:s';`
- **Purpose**: Tracks errors, debug info, and performance metrics

#### Audit Logs
- **Table**: activity_log (not explicitly detailed but inferred from Audits.php)
- **Controller**: Audits.php (3.5KB, 119 lines)
- **Fields**: IP address, timestamp, user ID, action description
- **Views**: Managed via `/application/views/components/audits/`

#### Login Tracking
- **Successful Logins**: login_attempts table
- **Failed Logins**: login_errors table
- **Fields**: IP address, timestamp, username attempted
- **Controllers**: Login_attempts.php (788B, 28 lines), Login_errors.php (730B, 28 lines)

## Configuration Files

### Main Configuration (application/config/config.php)

```php
// Base URL configuration
$protocol = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : 'http';
$config['base_url'] = $protocol . "://" . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8000');

// Index page
$config['index_page'] = '';

// URL suffix
$config['url_suffix'] = '';

// Language
$config['language'] = 'spanish';

// Character set
$config['charset'] = 'UTF-8';

// Enable hooks
$config['enable_hooks'] = FALSE;

// Allowed URL characters
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

// Enable query strings
$config['enable_query_strings'] = FALSE;

// Controller directory
$config['controller_trigger'] = 'c';

// Function directory
$config['function_trigger'] = 'm';

// Directory directory
$config['directory_trigger'] = 'd';

// Allow $_GET array
$config['allow_get_array'] = TRUE;

// Log threshold
$config['log_threshold'] = 1;

// Error logging directory
$config['log_path'] = '';

// Date format for logs
$config['log_date_format'] = 'Y-m-d H:i:s';

// Cache directory
$config['cache_path'] = '';

// Encryption key
$config['encryption_key'] = 'lanube2023';

// Session variables
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'lanube_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// Cookie settings
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;

// XSS filtering
$config['global_xss_filtering'] = FALSE;

// Cross Site Request Forgery
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Compress output
$config['compress_output'] = FALSE;

// Master time reference
$config['time_reference'] = 'local';

// Rewrite short tags
$config['rewrite_short_tags'] = FALSE;

// Reverse proxy IPs
$config['proxy_ips'] = '';
```

### Database Configuration (application/config/database.php)

```php
// Active group
$active_group = 'developed';

// Active record
$active_record = TRUE;

// Database groups
$db['developed'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'lanube_api',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port'     => '3306'
);
```

### Routes Configuration (application/config/routes.php)

```php
// Default controller
$route['default_controller'] = 'frontend/web';

// 404 override
$route['404_override'] = 'sudaca_errores/error_404';

// Translation
$route['translate_uri_dashes'] = FALSE;

// Backend routes
$route['backend'] = 'backend/dashboard';
$route['backend/(:any)'] = 'backend/$1';
$route['backend/(:any)/(:any)'] = 'backend/$1/$2';
$route['backend/(:any)/(:any)/(:any)'] = 'backend/$1/$2/$3';

// Frontend routes
$route['frontend/api/(:any)'] = 'frontend/api/$1';
$route['frontend/ajax/(:any)'] = 'frontend/ajax/$1';

// Authentication routes
$route['login'] = 'frontend/web/login';
$route['logout'] = 'frontend/web/logout';
$route['registro'] = 'frontend/web/register';

// Utility routes
$route['test_qr'] = 'test_qr';
$route['test_pdf'] = 'test_pdf';
```

### Autoload Configuration (application/config/autoload.php)

```php
// Packages
$autoload['packages'] = array();

// Libraries
$autoload['libraries'] = array('database', 'session', 'form_validation', 'ion_auth');

// Drivers
$autoload['drivers'] = array();

// Helper files
$autoload['helper'] = array('url', 'form', 'security', 'sudaca_helper', 'codegen_helper');

// Custom config files
$autoload['config'] = array('ion_auth');

// Language files
$autoload['language'] = array('auth_lang', 'ion_auth_lang');

// Models
$autoload['model'] = array('sudaca_md');
```

## Library Components

### Core Libraries

#### Ion Auth (application/libraries/Ion_auth.php, 13KB, 516 lines)
- User authentication
- Group management
- Permission control
- Password hashing
- Session handling
- Login/logout functionality

#### Template (application/libraries/Frontend_lib.php, 3.4KB, 125 lines)
- View rendering
- Layout management
- Data passing
- Partial views (Note: Adapted as no explicit Template.php exists, inferred functionality)

#### PDF Generation (application/libraries/Html2pdf.php, 3.1KB, 164 lines & crearPdf.php, 932B, 40 lines)
- Document creation
- HTML to PDF conversion
- Custom styling
- File download

#### QR Code (application/libraries/External/endroid/, via Composer)
- QR code generation (via endroid/qr-code:^3.9)
- Custom styling
- Image output
- File download

### Frontend Libraries

#### API Authentication (application/libraries/Ion_auth.php, adapted for frontend)
- Token validation
- Request authentication
- Permission checking
- Rate limiting (pending implementation)

#### Customer Management (application/libraries/Ecommerce_lib.php, 1.1KB, 33 lines)
- Customer data handling
- Profile management
- Address validation
- Order history

#### Shipping Calculator (application/models/Tariff_model.php, 3.3KB, 78 lines)
- Rate calculation
- Weight and volume handling
- Location validation
- Tariff lookup (Note: Modeled here, no explicit library)

#### Shopping Cart (application/libraries/MY_Cart.php, 2.9KB, 98 lines)
- Item management
- Price calculation
- Session storage
- Checkout processing

### Backend Libraries

#### Admin Authentication (application/libraries/Ion_auth.php, 13KB, 516 lines)
- Admin login
- Permission checking
- Session management
- Activity tracking

#### Logger (application/libraries/Log.php, 3.4KB, 134 lines)
- Error logging
- Activity tracking
- Debug information
- Performance metrics

#### Menu Builder (application/controllers/backend/Menus.php, 2.9KB, 102 lines)
- Dynamic menu generation
- Permission-based display
- Active item highlighting
- Nested menu support (Note: Controller-based, no explicit library)

#### Permission Checker (application/libraries/Permisos_lib.php, 1.9KB, 76 lines)
- Access control
- Role-based permissions
- Action authorization
- Resource protection

### External Libraries

#### DOMPDF (application/libraries/External/dompdf/, via Composer)
- HTML to PDF conversion
- CSS styling support
- Font embedding
- Page formatting

#### TCPDF (application/libraries/External/tecnickcom/tcpdf/, via Composer)
- Advanced PDF generation
- Unicode support
- Image embedding
- Table rendering

#### Endroid QR Code (application/libraries/External/endroid/, via Composer)
- QR code generation (endroid/qr-code:^3.9)
- Error correction
- Custom styling
- Multiple formats

#### PhpSpreadsheet (store/vendor/phpoffice/phpspreadsheet/, via Composer)
- Excel file creation
- Data import/export
- Formula support
- Formatting options

## Form Validation and Accessibility

### Input Field Standardization

All form input fields now follow a consistent naming convention and accessibility pattern:

1. **Field IDs and Labels**
   - Input IDs use the format: `{fieldname}_input`
   - Labels use matching `for` attributes
   - Example:
     ```html
     <label for="telefono_input">Teléfono Fijo/Compañía</label>
     <input id="telefono_input" type="text" name="telefono" />
     ```

2. **Autocomplete Attributes**
   - Username: `autocomplete="username"`
   - Email: `autocomplete="email"`
   - Given Name: `autocomplete="given-name"`
   - Family Name: `autocomplete="family-name"`
   - Phone: `autocomplete="tel"`
   - Mobile: `autocomplete="tel-mobile"`

### Phone Number Validation

The system implements enhanced phone number validation with the following features:

1. **Input Validation Rules**
   ```javascript
   function validatePhoneField(input, fieldName) {
       // Allow empty values
       if (!value) return true;
       
       // Allow '+' followed by numbers
       if (/^\+\d+$/.test(value)) return true;
       
       // Allow numbers only
       if (/^\d+$/.test(value)) return true;
       
       return false;
   }
   ```

2. **Real-time Validation**
   - Input event listeners for immediate feedback
   - Blur event validation for final checks
   - Visual feedback through CSS classes
   - Clear error messaging

3. **Special Character Handling**
   - '+' symbol allowed only at the start
   - Automatic position correction for '+' symbol
   - Prevention of multiple '+' symbols

### Security Enhancements

1. **CORB Protection**
   - Local loading of DataTables resources
   - Same-origin script execution
   - Updated template structure for security

2. **Form Security**
   - CSRF token validation
   - Input sanitization
   - XSS protection
   - Secure form submission handling

### JavaScript Validation Framework

The system uses a custom validation framework with the following features:

1. **Core Functions**
   - `validatePhoneField()`: Phone number format validation
   - `validateEmail()`: Email format checking
   - `validateRequiredField()`: Required field validation
   - `handlePhoneInput()`: Phone input formatting
   - `handlePhoneKeydown()`: Keypress validation

2. **Error Handling**
   - Clear error messaging
   - Visual feedback
   - Accessibility announcements
   - Form submission prevention on errors

3. **Event Management**
   - Input event handling
   - Blur event validation
   - Form submission validation
   - Dynamic error clearing

### Token Management

#### Token Display Page (`/mi-token`)
- Located in `/application/views/frontend/private/token.php`
- Displays all active tokens for the authenticated user
- For each token pair shows:
  - Production Token
  - Development Token
  - Creation Date
- Features:
  - Copy functionality for easy token copying
  - Visual feedback when copying tokens
  - Only shows active tokens (where active = 1)
  - Displays warning message if no active tokens exist

#### Token Structure
```php
// Database table: token_customers
// Columns:
- token_id (Primary Key)
- customer_id (Foreign Key)
- token (Production Token)
- token_dev (Development Token)
- active (Boolean)
- created_at (Timestamp)
```

#### Token Security
- Only active tokens are displayed and usable
- Tokens are paired (production and development)
- Each token is unique per customer
- Copy functionality prevents typing errors
- Visual feedback confirms successful copying

#### Token Usage
1. Production Token (`token`):
   - Used for live environment integrations
   - Required for all production API calls
   - Must be included in API request headers

2. Development Token (`token_dev`):
   - Used for testing and development
   - Allows integration testing without affecting production data
   - Follows same security rules as production tokens

### UI Components and Modals

The application uses Bootstrap modals for consistent user interaction across the platform:

#### Success and Error Feedback
- Styled modal dialogs replace browser alerts
- Consistent design across all user interactions
- Automatic page reload after successful operations
- Clear error messaging with styled presentation

#### Modal Implementation
```javascript
// Success Modal Structure
<div class="modal fade" id="successModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¡Éxito!</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
```

#### AJAX Response Handling
```javascript
$.ajax({
    // ... AJAX configuration ...
    success: function(response) {
        var data = JSON.parse(response);
        if (data.success) {
            $('#successMessage').text(data.message);
            $('#successModal').modal('show');
            // Reload page after success
            $('#successModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        } else {
            $('#errorMessage').text(data.message);
            $('#errorModal').modal('show');
        }
    }
});
```