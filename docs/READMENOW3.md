# La Nube - Part 3: Setup Instructions and API Documentation

## Setup Instructions

### Prerequisites

- **PHP 7.3.33**: Required for compatibility with CodeIgniter 3.1.13
- **MySQL Server**: For database storage and management
- **Apache/Nginx Web Server**: To serve the application
- **Composer 2.8.5**: For dependency management
- **Git**: Optional, for version control and cloning the repository

### Installation Steps

#### Clone the Repository

```bash
git clone https://github.com/yourusername/lanube.git
cd lanube
```

#### Install Dependencies

```bash
composer install
```

Installs required packages like endroid/qr-code:^3.9, dompdf/dompdf:0.8.*, and tecnickcom/tcpdf:6.2.*

#### Database Setup

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE lanube_api CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# Import schema
mysql -u root -p lanube_api < create_database.sql

# Import test data (optional)
mysql -u root -p lanube_api < insert_test_data.sql
```

- Schema file: create_database.sql (18KB, 446 lines)
- Test data file: insert_test_data.sql (10KB, 186 lines)

#### Configuration

Copy .env.example to .env (if exists, though not explicitly provided in original README)

Update database settings in application/config/database.php:

```php
$db['developed'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'lanube_api',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'port'     => '3306'
);
```

Set base URL in application/config/config.php (if needed):

```php
$config['base_url'] = 'http://localhost:8000';
```

Configure email settings in application/config/email.php:

```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'your-email@gmail.com';
$config['smtp_pass'] = 'your-password';
$config['mailtype'] = 'html';
```

#### Directory Permissions

```bash
# Set write permissions for required directories
chmod -R 755 application/logs
chmod -R 755 application/cache
chmod -R 755 application/sessions
chmod -R 755 store
```

#### Web Server Configuration

- **Apache**: Ensure mod_rewrite is enabled; use the provided .htaccess file (128B, 4 lines) for URL rewriting
- **Nginx**: Configure URL rewriting as per CodeIgniter documentation (e.g., rewrite rules for clean URLs)

#### Initial Login

- Access the admin panel at `/backend`
- Default credentials:
  - Username: admin@admin.com
  - Password: password
- Change the default password immediately via `/backend/users`

### Development Environment

#### Local Development Server

```bash
# Using PHP's built-in server
php -S localhost:8000
```

#### Database Configuration

- Use the developed database group for local development
- Ensure `$active_group = 'developed';` in application/config/database.php

#### Error Reporting

Development environment shows detailed errors

Set ENVIRONMENT to development in index.php:

```php
define('ENVIRONMENT', 'development');
```

#### Testing Tools

- QR Code Test: `/test_qr`
- PDF Generation Test: `/test_pdf`
- API Test: `/frontend/api/test` (if implemented, inferred as a potential endpoint)

## Development Guidelines

### Coding Standards

- Follow CodeIgniter 3.x coding style (e.g., camelCase for methods, indentation with tabs)
- Use PSR-1/PSR-2 for new code where applicable
- Document all functions and classes with PHPDoc comments
- Use meaningful variable and function names (e.g., getCustomerData instead of getData)
- Keep functions small and focused (single responsibility principle)

### File Organization

#### Controllers: Place in appropriate directories:
- Backend: application/controllers/backend/ (e.g., Dashboard.php)
- Frontend: application/controllers/frontend/ (e.g., Web.php)

#### Models: Place in application/models/ (e.g., Customer_model.php)

#### Views: Place in appropriate directories:
- Backend: application/views/backend/ (e.g., dashboard/dashboard.php)
- Frontend: application/views/frontend/ (e.g., public/)

#### Libraries: Place in application/libraries/ (e.g., Ion_auth.php)

#### Helpers: Place in application/helpers/ (e.g., sudaca_helper.php)

### Database Guidelines

- Use migrations for schema changes (configured in application/config/migration.php)
- Document all database changes in create_database.sql or separate migration files
- Use meaningful table and column names
- Follow naming conventions:
  - Tables: Lowercase, plural (e.g., users)
  - Columns: Lowercase, underscore-separated (e.g., first_name)
  - Primary Keys: id_[table] (e.g., id_user)
  - Foreign Keys: id_[referenced_table] (e.g., id_group)

### Version Control

- Use descriptive commit messages (e.g., "feat: Add customer registration form")
- Create feature branches for new features (e.g., feature/customer-portal)
- Create bugfix branches for bug fixes (e.g., bugfix/login-error)
- Use pull requests for code review
- Keep commits small and focused

### Security Guidelines

- Validate all user input using CodeIgniter's form_validation library
- Escape all output with html_escape() or prepared statements
- Use prepared statements for database queries via $this->db->query()
- Implement proper authentication and authorization with Ion Auth
- Follow OWASP security best practices (e.g., CSRF protection, XSS prevention)
- Enforce strong password requirements with client and server-side validation:
  - Require at least 8 characters in passwords
  - Require at least one uppercase letter
  - Require at least one special character (e.g., !@#$%^&*)
  - Provide real-time visual feedback on password strength
  - Display tooltip with password requirements when validation fails
- Implement first-letter capitalization for password fields to encourage stronger passwords
- Provide clear visual indicators for form validation state (red for invalid, green for valid)

### Form Field Implementation

When implementing new form fields or modifying existing ones:

1. **Naming Conventions**
   ```html
   <!-- Follow this pattern -->
   <label for="fieldname_input">Field Label</label>
   <input id="fieldname_input" name="fieldname" type="text" />
   ```

2. **Accessibility Requirements**
   - Always pair labels with inputs using matching `for` and `id` attributes
   - Use appropriate `autocomplete` attributes
   - Include ARIA labels where needed
   - Provide clear error messages
   - Ensure keyboard navigation works

3. **Phone Number Fields**
   - Allow international format with '+' prefix
   - Implement real-time validation
   - Use appropriate input type and pattern
   - Include clear format instructions

### Security Implementation

1. **CORB Prevention**
   - Load all scripts from the same origin
   - Use local copies of third-party libraries
   - Update template references to use local resources
   - Verify script loading order

2. **Form Security**
   - Include CSRF tokens
   - Validate input on both client and server
   - Sanitize all user input
   - Implement proper error handling

### UI/UX Guidelines

#### User Feedback
- Use styled modals instead of browser alerts for user feedback
- Implement consistent success and error messages across the application
- Provide clear visual feedback for user actions
- Auto-reload pages after successful operations when appropriate

#### Modal Design Standards
1. **Success Modals**
   - Title: "¡Éxito!"
   - Primary button text: "Aceptar"
   - Auto-dismiss with page reload when appropriate
   - Clear success message display

2. **Error Modals**
   - Title: "Error"
   - Primary button text: "Aceptar"
   - Clear error message display
   - Option to retry operation when applicable

3. **Confirmation Modals**
   - Clear action description
   - Cancel and confirm buttons
   - Consistent button styling
   - Proper focus management

#### Form Validation
- Real-time validation feedback where appropriate
- Clear error messages
- Consistent validation styling
- Proper field focus management

### Delete Operations Standard

When implementing delete operations in controllers, follow these guidelines:

1. **Controller Method Structure**
```php
function delete($id) {
    $response = array(
        'success' => false,
        'message' => '',
        'csrf_hash' => $this->security->get_csrf_hash()
    );

    try {
        $data = array(
            'active' => 0
        );
        
        $this->model->edit($data, $id);
        
        $response['success'] = true;
        $response['message'] = '[Resource] eliminado exitosamente';
    } catch (Exception $e) {
        $response['message'] = 'Ocurrió un error al eliminar [resource]';
    }

    echo json_encode($response);
}
```

2. **View Implementation**
```php
<?php if($permisos_efectivos->delete==1) { ?>
    <a onClick="eleminarRegistro('<?php echo base_url().'path/to/delete/'.$id ?>')" 
       href="#" 
       class="btn btn-danger">
        <i class="fa fa-trash"></i>
    </a>
<?php } ?>
```

3. **Best Practices**:
   - Always use soft deletes (setting active = 0)
   - Include CSRF token in response
   - Implement proper error handling
   - Check user permissions
   - Use consistent icon styling (fa-trash)
   - Provide clear success/error messages

4. **Security Considerations**:
   - Validate user permissions before delete
   - Refresh CSRF token after operation
   - Log delete operations for audit
   - Implement proper error handling
   - Use try-catch blocks for database operations

## Troubleshooting

### Common Issues and Solutions

#### Delete Functionality Issues

When implementing or troubleshooting the delete functionality in the system, consider the following:

1. **Soft Delete Implementation**
   - The system uses soft delete through the `active` column
   - Records are marked as inactive (`active = 0`) rather than being physically deleted
   - Example implementation in Customer model:
   ```php
   public function edit($data, $id)
   {
       try {
           $this->db->where($this->id, $id);
           $this->db->update($this->table, $data);
           return $this->db->affected_rows() > 0;
       } catch (Exception $e) {
           log_message('error', 'Database error in Customer_model::edit: ' . $e->getMessage());
           throw $e;
       }
   }
   ```

2. **Controller Implementation**
   - Delete operations should check permissions
   - Handle both AJAX and non-AJAX requests
   - Provide proper JSON responses
   - Example from Customers controller:
   ```php
   function delete($id)
   {
       // Check permissions
       if ($permisos_efectivos->delete == 1) {
           try {
               $data = array('active' => 0);
               $result = $this->customer->edit($data, $id);
               
               if ($result) {
                   $response['success'] = true;
                   $response['message'] = 'Registro eliminado correctamente';
               }
           } catch (Exception $e) {
               $response['message'] = 'Error al eliminar el registro: ' . $e->getMessage();
           }
       }
   }
   ```

3. **Frontend Implementation**
   - Uses SweetAlert2 for confirmations
   - Handles both success and error cases
   - Example JavaScript:
   ```javascript
   function eleminarRegistro(link) {
       if (typeof Swal !== 'undefined') {
           Swal.fire({
               title: "Confirmación",
               text: "¿Desea eliminar este registro?",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#f44141",
               cancelButtonColor: "#c9dae1",
               confirmButtonText: "Aceptar",
               cancelButtonText: "Cancelar"
           }).then((result) => {
               if (result.isConfirmed) {
                   performDelete(link);
               }
           });
       }
   }
   ```

4. **Error Handling**
   - Server-side errors are logged using CodeIgniter's logging system
   - Client-side errors are displayed using SweetAlert
   - Database errors are caught and properly formatted
   - Both HTML and JSON responses are handled appropriately

5. **Best Practices**
   - Always use soft deletes instead of hard deletes
   - Implement proper permission checks
   - Use AJAX for delete operations
   - Show confirmation dialogs
   - Provide clear feedback to users
   - Handle both success and error cases
   - Log errors for debugging

6. **Common Issues**
   - Database column missing errors: Ensure all required columns exist
   - Permission errors: Check user permissions are properly set
   - AJAX response parsing: Handle both JSON and HTML error responses
   - Session timeout: Handle cases where user session expires

7. **Testing Delete Functionality**
   - Test with and without proper permissions
   - Verify soft delete is working (check active column)
   - Confirm proper error messages are shown
   - Test session timeout scenarios
   - Verify record is still in database but marked as inactive

#### Order Form Submission Issues

When troubleshooting form submission issues in the Orders module, consider the following:

1. **Hidden Input for Form Identification**
   - The controller methods check for a specific POST parameter to identify form submissions
   - For the Orders edit form, the controller checks for `$this->input->post('enviar_form')`
   - Missing this parameter will result in the form not being processed
   - Solution: Add a hidden input field to the form:
   ```php
   <input type="hidden" name="enviar_form" value="1">
   ```

2. **CSRF Token Implementation**
   - All forms should include the CodeIgniter CSRF token to prevent cross-site request forgery
   - This is especially important for admin forms that modify data
   - Implementation example:
   ```php
   <?php 
   // Include CSRF token
   $csrf = array(
       'name' => $this->security->get_csrf_token_name(),
       'hash' => $this->security->get_csrf_hash()
   );
   ?>
   <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
   ```

3. **Form Button Configuration**
   - For forms using regular submission (not AJAX), the submit button should be configured properly
   - Example of a correctly configured submit button:
   ```php
   <button class="btn btn-primary" type="submit" id="btnSubmit">Guardar</button>
   ```
   - Avoid naming conflicts between hidden inputs and button names

4. **AJAX Form Submission**
   - For forms that need AJAX submission, ensure proper handling of form data
   - Example implementation:
   ```javascript
   $('#formEdit').submit(function(e) {
       e.preventDefault(); // Prevent default submission
       
       // Validate form fields
       
       // Submit via AJAX
       $.ajax({
           url: $(this).attr('action'),
           type: 'POST',
           data: new FormData(this),
           processData: false,
           contentType: false,
           success: function(response) {
               // Handle success
               window.location.href = '/success/url';
           },
           error: function(xhr, status, error) {
               // Handle errors
               console.error('Error:', error);
               alert('Error al guardar los cambios. Por favor, intente nuevamente.');
           }
       });
   });
   ```

#### Status Change Issues

When implementing status changes for orders, consider the following:

1. **Handling Both AJAX and Regular Requests**
   - Use `$this->input->is_ajax_request()` to detect AJAX requests and respond accordingly
   - Implementation example:
   ```php
   function changeStatus() 
   {
       $error = false;
       $message = "";
       $data = array();
       $status_id = $this->input->post('status_id');
       $order_id = $this->input->post('order_id');

       if (!empty($status_id) && !empty($order_id)) {
           try {
               $this->order->edit([
                   'status_id' => $status_id,
               ], $order_id);
               $message = 'Se ha modificado el estado del pedido';
           } catch (Exception $e) {
               $error = true;
               $message = 'Error al modificar el estado: ' . $e->getMessage();
           }
       } else {
           $error = true;
           $message = 'No se ha podido cambiar el estado. Faltan parámetros.';
       }

       // Check if it's an AJAX request
       if ($this->input->is_ajax_request()) {
           // Return JSON for AJAX calls
           echo json_encode([
               'error' => $error,
               'message' => $message,
               'data' => $data
           ]);
       } else {
           // Set flash message for regular form submission
           if (!$error) {
               $this->session->set_flashdata('success', $message);
           } else {
               $this->session->set_flashdata('error', $message);
           }
           
           // Redirect back to the orders list
           redirect(base_url() . 'ecommerce/orders');
       }
   }
   ```

2. **CSRF Token in AJAX Requests**
   - For AJAX requests, you may need to handle CSRF tokens differently
   - Either include it in the form data or add it as a header
   - Example of adding a CSRF token to an AJAX request:
   ```javascript
   // Add CSRF token to all AJAX requests
   $.ajaxSetup({
       beforeSend: function(xhr, settings) {
           if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type)) {
               xhr.setRequestHeader('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
           }
       }
   });
   ```

#### Property Undefined Errors

When working with objects from the database, consider the following:

1. **Property Checking Before Access**
   - Always check if properties exist before accessing them to prevent undefined property errors
   - Use the `isset()` function or null coalescing operator (`??`)
   - Example implementation:
   ```php
   $customer_name = isset($customer->social_reason) ? $customer->social_reason : '-';
   // Or with PHP 7+ 
   $customer_name = $customer->social_reason ?? '-';
   ```

2. **JSON Data Handling**
   - When working with JSON data stored in the database, always decode with safe fallbacks
   - Example implementation:
   ```php
   $shipping_data = json_decode($order->shipping_data, true) ?: [];
   
   // Set default values if keys don't exist
   if (!isset($shipping_data['store'])) {
       $shipping_data['store'] = [
           'name' => isset($customer->social_reason) ? $customer->social_reason : '-',
           'email' => isset($customer->email) ? $customer->email : '-',
           'country' => '-',
           'telephone' => isset($customer->telephone) ? $customer->telephone : '-',
           'domain' => '#',
       ];
   }
   ```

### Debugging Techniques

1. **JavaScript Console Logging**
   - Use `console.log()` to debug JavaScript issues
   - Log form data, AJAX requests, and responses
   - Example implementation:
   ```javascript
   // Log form data
   var formData = new FormData(this);
   for (var pair of formData.entries()) {
       console.log(pair[0] + ': ' + pair[1]);
   }
   ```

2. **PHP Logging**
   - Use CodeIgniter's logging functionality for PHP debugging
   - Logs are stored in `application/logs/`
   - Example implementation:
   ```php
   log_message('debug', 'Edit method called for order ID: ' . $id);
   log_message('debug', 'POST data: ' . print_r($_POST, true));
   ```

3. **Browser Developer Tools**
   - Use browser developer tools (F12) to:
     - Inspect network requests
     - Check for JavaScript errors
     - Monitor form submissions
     - Analyze responses

### Interface Features

#### Navigation Tabs

The application uses a tab-based navigation system in many sections to provide contextual actions:

1. **Orders List Navigation**
   - The orders list view (`shipping_list.php`) includes navigation tabs for different actions
   - Implementation example:
   ```php
   <div class="row">
       <div class="col-sm-12">
           <h6 class="element-header">Lista de Pedidos</h6>
           <ul class="nav nav-tabs">
               <li class="nav-item">
                   <a class="nav-link active" href="#">Pedidos</a>
               </li>
               <?php if (isset($permisos_efectivos) && isset($permisos_efectivos->update) && $permisos_efectivos->update && isset($results) && count($results) > 0) : ?>
               <li class="nav-item">
                   <a class="nav-link bg-success text-white" href="<?php echo base_url() ?>ecommerce/orders/edit/<?php echo $results[0]->order_id ?>">
                       <i class="os-icon os-icon-pencil-2"></i> Editar
                   </a>
               </li>
               <?php endif; ?>
           </ul>
       </div>
   </div>
   ```

2. **Tab Display Rules**
   - Tabs should be displayed based on user permissions
   - For example, the "Editar" tab is only shown if:
     - The user has update permissions (`$permisos_efectivos->update`)
     - There are orders available to edit (`isset($results) && count($results) > 0`)
   - Follow this pattern for all conditional UI elements

3. **Tab Styling Guidelines**
   - Use consistent styling for tabs across the application
   - Active tabs: Default style with `active` class
   - Action tabs (e.g., Edit): Use appropriate color coding
     - Edit actions: `bg-success text-white`
     - Delete actions: `bg-danger text-white`
     - View actions: `bg-primary text-white`
   - Include appropriate icons from the icon library

## API Documentation

### Authentication

All API endpoints require authentication using a token:

```json
{
    "token": "YOUR_API_TOKEN"
}
```

Token Generation:
- Customer registration via `/registro`
- Admin panel at `/backend/customers` (Generate Token option)
- Direct insertion into customer_shipping_credentials table

### API Endpoints

#### 1. Get Shipping Cost

Calculate shipping cost based on package details and destination.

**Endpoint**: POST `/frontend/api/getShippingCost`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "data_client": {
        "postal_code": "1000"
    },
    "weight": "10",
    "long": "1",
    "width": "1",
    "high": "0.5",
    "volume": "0.5"
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": {
        "price_item": 200.00
    }
}
```

**Response (Error)**:
```json
{
    "status": "Error",
    "data": {
        "message": "Invalid weight or volume"
    }
}
```

#### 2. Get Customer

Retrieve customer information.

**Endpoint**: POST `/frontend/api/getCustomer`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "user": "customer@email.com"
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": {
        "customer_id": 1,
        "name": "Customer Name",
        "email": "customer@email.com",
        "country_id": 1,
        "country_name": "Argentina",
        "active": 1
    }
}
```

#### 3. Send Order

Create a new shipping order.

**Endpoint**: POST `/frontend/api/sendOrder`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "data_client": {
        "postal_code": "1000",
        "client": "Client Name",
        "reference": "Order Reference",
        "shipping_data": {
            "store": {
                "name": "Store Name"
            },
            "email": "client@email.com",
            "province": "Province Name",
            "city": "City Name",
            "address": "Full Address",
            "telephone": "Phone Number"
        }
    },
    "weight": "10",
    "long": "1",
    "width": "1",
    "high": "0.5",
    "volume": "0.5"
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": {
        "code_tracking": "generated_tracking_code"
    }
}
```

#### 4. Get Order Status

Check the status of an existing order.

**Endpoint**: POST `/frontend/api/getOrderStatus`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "tracking_code": "order_tracking_code"
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": {
        "order_id": 123,
        "order_number": "ORD-123456",
        "status_id": 2,
        "status_name": "Confirmado",
        "tracking_number": "order_tracking_code",
        "created_at": "2023-05-01 14:30:00"
    }
}
```

#### 5. Get Destinations

Retrieve available destinations for a province.

**Endpoint**: POST `/frontend/api/getDestinations`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "province_id": 1
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": [
        {
            "destination_id": 1,
            "name": "Destination 1",
            "postal_code": "1000"
        },
        {
            "destination_id": 2,
            "name": "Destination 2",
            "postal_code": "1001"
        }
    ]
}
```

#### 6. Get Provinces

Retrieve provinces for a country.

**Endpoint**: POST `/frontend/api/getProvinces`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN",
    "country_id": 1
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": [
        {
            "province_id": 1,
            "name": "Province 1"
        },
        {
            "province_id": 2,
            "name": "Province 2"
        }
    ]
}
```

#### 7. Get Countries

Retrieve available countries.

**Endpoint**: POST `/frontend/api/getCountries`

**Request**:
```json
{
    "token": "YOUR_API_TOKEN"
}
```

**Response (Success)**:
```json
{
    "status": "Success",
    "data": [
        {
            "country_id": 1,
            "name": "Argentina"
        },
        {
            "country_id": 2,
            "name": "Uruguay"
        }
    ]
}
```

### Error Codes

| Error Message | Description |
|---------------|-------------|
| "Token is invalid" | The provided token is invalid or expired |
| "Client no exists" | The customer does not exist |
| "Volume Invalid" | The provided volume is invalid or inconsistent |
| "Invalid weight or volume" | The weight or volume values are invalid |
| "Tariff no exists" | No tariff exists for the provided parameters |
| "Country doesn't match" | Customer's country doesn't match tariff's |

### API Usage Examples

#### cURL Example

```bash
curl -X POST "http://localhost:8000/frontend/api/getShippingCost" \
-H "Content-Type: application/json" \
-d '{
    "token": "YOUR_API_TOKEN",
    "data_client": {
        "postal_code": "1000"
    },
    "weight": "10",
    "long": "1",
    "width": "1",
    "high": "0.5",
    "volume": "0.5"
}'
```

#### PHP Example

```php
<?php
$url = 'http://localhost:8000/frontend/api/getShippingCost';
$data = [
    'token' => 'YOUR_API_TOKEN',
    'data_client' => [
        'postal_code' => '1000'
    ],
    'weight' => '10',
    'long' => '1',
    'width' => '1',
    'high' => '0.5',
    'volume' => '0.5'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo $result;
?>
```

#### JavaScript Example

```javascript
fetch('http://localhost:8000/frontend/api/getShippingCost', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        token: 'YOUR_API_TOKEN',
        data_client: {
            postal_code: '1000'
        },
        weight: '10',
        long: '1',
        width: '1',
        high: '0.5',
        volume: '0.5'
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

#### Python Example

```python
url = 'http://localhost:8000/frontend/api/getShippingCost'
data = {
    'token': 'YOUR_API_TOKEN',
    'data_client': {
        'postal_code': '1000'
    },
    'weight': '10',
    'long': '1',
    'width': '1',
    'high': '0.5',
    'volume': '0.5'
}

import json
import urllib.request

req = urllib.request.Request(url)
req.add_header('Content-Type', 'application/json')
data_bytes = json.dumps(data).encode('utf-8')
response = urllib.request.urlopen(req, data=data_bytes)
content = response.read().decode('utf-8')
print(content)
```

## Recent Updates and Improvements

### Tariff Management System Updates (March 2024)
- Enhanced error handling in tariff management:
  - Added validation for missing tariff IDs in edit operations
  - Improved error messages for non-existent tariffs
  - Implemented proper soft delete functionality with `deleted_at` and `delete_by` tracking
- Updated tariff edit workflow:
  - Added input validation and error handling
  - Improved user feedback with success/error messages
  - Enhanced form submission security with CSRF protection

### Database Structure Improvements
- Added proper soft delete support for tariffs table:
  - `deleted_at`: Tracks when a record was soft deleted
  - `delete_by`: Records which user performed the deletion
  - `create_by`: Tracks record creation
  - `update_by`: Tracks record updates
- Maintained referential integrity with foreign key constraints
- Enhanced indexing for better query performance

### Security Enhancements
- Implemented CSRF token validation in AJAX requests
- Added proper error handling and user feedback
- Enhanced input validation and sanitization
- Improved session management and user authentication

### UI/UX Improvements
- Added clear feedback messages for user actions
- Enhanced form validation with proper error displays
- Improved navigation flow in tariff management
- Added proper redirection after operations

### Code Quality and Maintenance
- Improved code organization and documentation
- Enhanced error logging and debugging capabilities
- Added proper type checking and validation
- Implemented consistent coding standards

### Countries Management System Updates (March 2024)
- Enhanced error handling in country management:
  - Removed references to non-existent columns
  - Added proper validation for required fields
  - Improved error messages and feedback
- Updated country operations:
  - Automatic code generation from country names
  - Proper soft delete implementation
  - Consistent UI text and grammar
- Database structure alignment:
  - Operations now match table structure
  - Proper handling of required fields
  - Improved data integrity

## Deployment

### Production Environment

#### Server Requirements
- PHP 7.3.33
- MySQL Server
- Apache/Nginx web server
- Composer 2.8.5

#### Deployment Steps
1. Upload files to production server
2. Set ENVIRONMENT to production in index.php:
   ```
   define('ENVIRONMENT', 'production');
   ```
3. Set `$active_group = 'production';` in application/config/database.php
4. Configure production database settings
5. Set file permissions: `chmod -R 755 application/logs application/cache application/sessions store`
6. Configure web server for URL rewriting (Apache .htaccess or Nginx rules)

#### Security Considerations
- Remove development files (e.g., insert_test_data.sql)
- Secure sensitive directories with .htaccess (Deny from all)
- Use HTTPS for all connections
- Implement firewall rules (e.g., allow ports 80, 443, 587)
- Set up regular backups

### Maintenance

#### Database Backup
```
# Backup database
mysqldump -u username -p lanube_api > backup_$(date +%Y%m%d).sql
```

#### Log Rotation
- Implement log rotation for application/logs/ using logrotate or similar
- Archive old logs monthly

#### Performance Monitoring
- Monitor server resources (CPU, memory) with tools like htop
- Check database performance with EXPLAIN on queries
- Monitor API response times with logging or external tools
- Set up alerts for critical issues (e.g., via cron jobs)

#### Updates
- Keep PHP and MySQL updated (e.g., security patches)
- Update dependencies with composer update
- Apply security patches promptly

## Support and Resources

### Documentation
- CodeIgniter 3.x Documentation: https://codeigniter.com/userguide3/
- PHP 7.3 Documentation: https://www.php.net/manual/en/
- MySQL Documentation: https://dev.mysql.com/doc/

### Community Resources
- CodeIgniter Forums: https://forum.codeigniter.com/
- Stack Overflow: https://stackoverflow.com/questions/tagged/codeigniter

### Contact Information
- Support Email: support@example.com
- Developer Contact: developer@example.com
- Issue Tracker: https://github.com/yourusername/lanube/issues

## Email Configuration and Image Handling

### Email Configuration

The system uses CodeIgniter's email library with SMTP configuration. The configuration is stored in `application/config/email.php`:

```
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'your-email@gmail.com';
$config['smtp_pass'] = 'your-password';
$config['mailtype'] = 'html';
```

### Image Handling in Emails

When sending emails with images, it's important to use absolute URLs that are accessible to the email recipients. The system has been enhanced to handle this in two ways:

#### 1. Using External Image Hosting

Email templates have been updated to use externally hosted images:

```
<img src="https://i.ibb.co/YSs3qT9/superflash.png" width="100"/>
```

This approach ensures that images are visible to all recipients regardless of their location or email client.

#### 2. Dynamic URL Replacement

The `Frontend_lib::enviarEmail()` method has been enhanced to replace localhost URLs with production URLs:

```
public function enviarEmail($data, $vista, $titulo, $email_destino, $email_origen, $remitente){
    // Inicializar libreria
    $this->load->library('email');

    $datos['dato'] = $data;
    
    // Get the site URL from configuration or use a default production URL
    $site_url = $this->CI->config->item('site_url');
    if (empty($site_url)) {
        // Default to a production URL if not configured
        $site_url = 'https://lanubeflash.com'; // Replace with your actual production URL
    }
    
    // Add the site URL to the data for use in templates
    $datos['site_url'] = $site_url;
    
    // Cargar mensaje
    $mensaje = $this->load->view($vista, $datos, true);
    
    // Replace any localhost URLs with absolute URLs
    $mensaje = str_replace('src="'.base_url(), 'src="'.$site_url, $mensaje);

    // Datos de envio email
    $this->email->to($email_destino);
    $this->email->from($email_origen, $remitente);
    $this->email->subject($titulo);
    $this->email->message($mensaje);
    
    // Enviar email y verificar si hubo error
    if (!$this->email->send()) {
        $message = "ERROR EMAIL => Email: $vista, \n  Título: $titulo \n Destino: $email_destino \n Origen: $email_origen \n Remitente: $remitente \n Datos: " . json_encode($data);
        log_message('error', $message);
    }
}
```

A new configuration setting has been added to `application/config/config.php`:

```
// Production site URL for emails (replace with your actual production URL)
$config['site_url'] = 'https://lanubeflash.com';
```

### Password Security Enhancements

The system has been enhanced with improved password security features:

#### 1. Password Change Functionality

- Added a "Cambiar contraseña" modal accessible from the user dropdown menu
- Implemented current password verification before allowing password changes
- Added real-time validation for password complexity requirements

#### 2. Password Complexity Requirements

- Minimum length: 8 characters
- At least one uppercase letter (A-Z)
- At least one special character (e.g., !@#$%^&*)

#### 3. Frontend Validation

- Real-time feedback on password strength
- Visual indicators for valid/invalid input
- Disabled new password fields until current password is verified

#### 4. Backend Validation

- Server-side validation of current password
- Server-side validation of password complexity
- CSRF protection for security

#### 5. Implementation Details

The password change functionality is implemented across several files:

- **Modal**: Defined in `application/views/template/private/footer.php`
- **JavaScript Validation**: Implemented in `assets/frontend/js/change_password_validation.js`
- **Server-side Validation**: Implemented in `application/controllers/frontend/Ajax.php`
- **CSS Styling**: Added to `assets/frontend/css/style.css`

### jQuery Reference Error Fixes

To resolve jQuery reference errors in the application:

1. **Ensured jQuery is Loaded First**:
   - Added jQuery to the head section of `application/views/template/private.php`
   - Removed duplicate jQuery loading from `application/views/template/private/js.php`

2. **Used Full jQuery Name**:
   - Updated all scripts to use `jQuery` instead of `$` shorthand
   - This ensures scripts work regardless of whether `$` is defined

3. **Added Fallback Mechanisms**:
   - Used vanilla JavaScript for critical operations
   - Added conditional checks for jQuery availability

These changes ensure that all JavaScript functionality works correctly without reference errors, while maintaining all existing functionality.

### PDF Document Handling

The system provides robust handling of PDF documents (such as Terms and Conditions and Privacy Policy) through multiple approaches to ensure compatibility across different environments:

#### PDF Storage Locations

PDF documents are stored in two locations for redundancy:

1. **Primary Location**: `assets/public/` directory
   - `La Nube - Políticas de Privacidad.pdf`
   - `4. LaNube - Términos y condiciones v. 06.03.2023-1.pdf`

2. **Secondary Location**: `assets/frontend/web/pdf/` directory
   - `politicas/La Nube - Políticas de Privacidad.pdf`
   - `terminos/4. LaNube - Términos y condiciones.pdf`

#### PDF Serving Methods

The system implements three different methods for serving PDF files:

1. **Direct Controller Method**: `Web::pdf($filename)`
   - Maps simple identifiers ('politicas', 'terminos') to actual filenames
   - Accessed via URL: `frontend/web/pdf/politicas` or `frontend/web/pdf/terminos`
   - Checks both storage locations if file is not found in primary location

2. **Dedicated PDF Methods**: `Web::politicas_pdf()` and `Web::terminos_pdf()`
   - Specifically designed for serving each type of document
   - Accessed via URL: `politicas-pdf` or `terminos-pdf`
   - Checks both storage locations if file is not found in primary location

3. **Generic PDF Serving**: `Web::serve_pdf($filename)`
   - Serves any PDF file from the assets directory
   - Accessed via URL: `pdf/[filename]`
   - Includes security checks to prevent directory traversal
   - Intelligently determines document type based on filename

#### Implementation Details

The PDF serving implementation includes:

1. **Fallback Mechanism**: If a file is not found in the primary location, the system automatically checks the secondary location
2. **Error Logging**: Comprehensive logging for debugging PDF access issues
3. **Security Measures**: File extension validation and access restrictions
4. **Proper Headers**: Sets appropriate Content-Type and caching headers for optimal PDF display

#### Routes Configuration

```
// PDF routes
$route['frontend/web/pdf/(:any)'] = "frontend/web/pdf/$1";
$route['politicas-pdf'] = "frontend/web/politicas_pdf";
$route['terminos-pdf'] = "frontend/web/terminos_pdf";
$route['pdf/(:any)'] = "frontend/web/serve_pdf/$1";
```

This implementation ensures that PDF documents are served correctly across different environments (development, production) and provides multiple access methods for flexibility.

## Known Issues and Solutions

### `/mis-pedidos` Page Error

#### Issue Description
When accessing the `/mis-pedidos` page, users may encounter the following PHP error:

```
A PHP Error was encountered
Severity: Notice
Message: Undefined variable: image_header
Filename: private/nav.php
Line Number: 22
```

This error occurs because the variable `$image_header` is being referenced in the navigation template but is not defined when rendering the orders page.

#### Root Cause
In the `application/views/template/private/nav.php` file, there's a conditional check for `$image_header` on line 22:

```
<span class="text-title text-white"><?php if ($image_header) {?>
    <img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/'.$image_header)); ?>" class="tam-icon icon-categoria"/></span>
<?php } ?>
```

However, when the `Dashboard::orders()` method renders the page, it doesn't pass this variable to the view.

#### Solution
To fix this issue, modify the `orders()` method in `application/controllers/frontend/private/Dashboard.php` to include the `image_header` variable in the view data:

```
public function orders()
{
    if (!$this->session->userdata('customer_id')) {
        redirect(base_url('login'), 'refresh');
    }
    $params = array(
        'where' => array('customer_id' => $this->session->userdata('customer_id')),
    );
    $orders = $this->order->get($params);

    $vista_interna = array(
        'orders' => $orders
    );

    $vista_config  = array(
        'metadata' => '',
        'title' => '',
        'description' => '',
    );

    $vista_externa = array(
        'contenido_main' => $this->load->view('frontend/private/orders', $vista_interna, true),
        'configuracion' => $this->frontend_lib->configuraciones($vista_config),
        'configurations' => $this->codegen_model->get('configurations', '*', 'id_configuration > 0'),
        'image_header' => 'orders.png' // Add this line to define the image_header variable
    );

    $this->load->view('template/private', $vista_externa);
}
```

Alternatively, you can modify the `private/nav.php` file to check if the variable exists before using it:

```
<span class="text-title text-white"><?php if (isset($image_header) && $image_header) {?>
    <img src="<?php echo(base_url('assets/public/dashboard/icons/blanco/'.$image_header)); ?>" class="tam-icon icon-categoria"/></span>
<?php } ?>
```

This change ensures that the code only attempts to use the `$image_header` variable if it has been defined, preventing the PHP notice from appearing.

### Other Common Issues

For additional troubleshooting information, refer to the [Troubleshooting](#troubleshooting) section above.

## Recent System Improvements

The following improvements have been made to the codebase to enhance functionality, security, and accessibility:

### 1. Order Management Enhancements

#### Frontend Order Visibility and Actions
- Enabled the "Mis Pedidos" menu item in the sidebar navigation for better accessibility
- Added tracking number display to the orders table
- Enabled action buttons (view, edit, delete) for order management
- Implemented modal dialogs for viewing order details, editing, and confirming deletion

#### Order Action Implementation
- Added AJAX-based order detail retrieval
- Implemented order editing functionality for basic fields (client, reference, tracking number)
- Added soft-delete capability with confirmation dialog
- Created responsive modals for all order actions

#### JavaScript and UI Improvements
- Added client-side validation for order editing
- Implemented detailed order information display
- Enhanced error handling and user feedback
- Created dedicated JavaScript file for order management (orders.js)

### 2. AJAX Security and Reliability Enhancements

#### CSRF Token Management
- Implemented automatic CSRF token refresh after each AJAX request
- Added token verification in all form submissions
- Updated controllers to include fresh CSRF tokens in all JSON responses
- Enhanced error handling for CSRF validation failures

#### API Error Handling
- Added proper error handling for API email configuration
- Implemented fallback values for missing email configurations
- Fixed 'undefined variable' errors in API responses
- Added detailed error logging while maintaining functionality

### 3. Accessibility Improvements

#### Modal Dialog Accessibility
- Added proper ARIA attributes to modal dialogs
- Implemented focus management for modals (saving and restoring focus)
- Added keyboard navigation improvements
- Fixed aria-hidden warnings in browser console

#### Form Accessibility
- Added proper labels and descriptions for form fields
- Improved validation feedback for screen readers
- Added autocomplete attributes to password fields
- Enhanced focus visualization for keyboard navigation

#### CSS Improvements
- Added specific styles for accessibility support
- Implemented focus indicators for keyboard navigation
- Created consistent feedback styles for form validation
- Added responsive design improvements for all dialog boxes

### 4. Password Management Enhancements

#### Password Change Modal
- Improved the password change modal interface
- Added real-time validation with visual feedback
- Implemented secure password verification flow
- Fixed accessibility issues in the password change process

#### Security Features
- Maintained password complexity requirements (8+ chars, uppercase, special character)
- Added secure autocomplete attributes for password fields
- Enhanced error handling for password validation
- Implemented proper form reset on modal close

These improvements maintain all existing functionality while enhancing security, accessibility, and user experience. The changes are backward compatible and do not introduce any breaking changes to the API or database structure.

## Backend Administration

### Backend Login

To access the backend administration panel:

1. Navigate to `/backend/auth/login` (e.g., http://localhost:8000/backend/auth/login)
2. Use the default admin credentials:
   - Username: `admin@admin.com`
   - Password: `password`
3. Click the "Acceder" button to log in

**Important**: For security reasons, change the default password immediately after your first login by navigating to the Users section.

### Available Backend Pages

The backend administration panel provides access to the following sections:

#### Main Dashboard
- `/backend` or `/backend/dashboard` - Main admin dashboard

#### Customer Management
- `/backend/customers` - List all customers
- `/backend/customers/add` - Add a new customer
- `/backend/customers/edit/{id}` - Edit a specific customer
- `/backend/customers/tokens/{id}` - View customer tokens
- `/backend/customers/generateToken` - Generate a new token for a customer
- `/backend/customers/revokeToken` - Revoke a customer's token

#### Order Management
- `/backend/orders` - List all orders
- `/backend/orders/view/{id}` - View a specific order
- `/backend/orders/edit/{id}` - Edit a specific order
- `/backend/orders/status/{id}/{status_id}` - Update order status

#### Tariff Management
- `/backend/tariffs` - List all tariffs
- `/backend/tariffs/add` - Add a new tariff
- `/backend/tariffs/edit/{id}` - Edit a specific tariff

#### Location Management
- `/backend/countries` - Manage countries
- `/backend/provinces` - Manage provinces
- `/backend/destinations` - Manage destinations

#### User Management
- `/backend/users` - List all admin users
- `/backend/users/add` - Add a new admin user
- `/backend/users/edit/{id}` - Edit a specific admin user
- `/backend/users/change_password/{id}` - Change user password

#### System Configuration
- `/backend/configurations` - System configurations
- `/backend/configurations/edit/{id}` - Edit a specific configuration

#### Reports
- `/backend/reports/orders` - Order reports
- `/backend/reports/customers` - Customer reports
- `/backend/reports/activity` - Activity logs

#### Authentication
- `/backend/auth/login` - Login page
- `/backend/auth/logout` - Logout
- `/backend/auth/forgot_password` - Password recovery

#### Other Utilities
- `/backend/activity_log` - View system activity logs
- `/backend/backup` - Database backup utilities

### Backend Security

The backend administration panel implements several security measures:

1. **Session-based Authentication**: Uses Ion Auth library for secure authentication
2. **Role-based Access Control**: Different user roles have different access permissions
3. **Activity Logging**: All admin actions are logged in the activity_log table
4. **CSRF Protection**: All forms include CSRF tokens to prevent cross-site request forgery
5. **Password Policies**: Enforces strong password requirements
6. **Session Timeout**: Automatically logs out inactive users after a period of inactivity

### Backend User Management

To add a new admin user:

1. Navigate to `/backend/users/add`
2. Fill in the required information:
   - First Name
   - Last Name
   - Email (used for login)
   - Password (must meet complexity requirements)
   - User Group (determines access permissions)
3. Click "Save" to create the new user

To change a user's password:

1. Navigate to `/backend/users`
2. Find the user in the list
3. Click the "Change Password" icon
4. Enter and confirm the new password
5. Click "Save" to update the password

### Dashboard Menu Structure

The backend dashboard (accessible at `/backend/dashboard`) provides a comprehensive menu for system administration. The menu is organized into the following categories:

#### Customer Management
- **List Customers**: View all customer accounts (/ecommerce/customers)
- **Add Customer**: Create new customer accounts (/ecommerce/customers/add)
- **Edit Customer**: Modify existing customer details (/ecommerce/customers/edit/{id})
- **View Customer Tokens**: Review API tokens (Future Feature)
- **Generate Token**: Create authorization tokens (Part of Add Customer process)
- **Revoke Token**: Invalidate API tokens (Future Feature)

#### Order Management
- **List Orders**: View all orders in the system (/ecommerce/orders)
- **Update Status**: Change order status (Editable from the orders list)

#### Tariff Management
- **List Tariffs**: View all shipping tariffs (/ecommerce/tariff)
- **Add Tariff**: Create new shipping rates (/ecommerce/tariff/add)
- **Edit Tariff**: Modify existing tariffs (/ecommerce/tariff/edit/{id})

#### Location Management
- **Countries**: Manage country data (via model)
- **Provinces**: Manage province/state data (/ecommerce/provinces)
- **Destinations**: Manage shipping destinations (/ecommerce/destinations)

#### User Management
- **List Users**: View all system users (/backend/users)
- **Add User**: Create new user accounts (/backend/users/add)
- **Edit User**: Modify existing user accounts (/backend/users/edit/{id})
- **Change Password**: Update user passwords (/backend/users/change_password/{id})
- **Groups**: Manage user groups (/backend/groups)
- **Permissions**: Configure access rights (/backend/permisos)

#### System Configuration
- **View Configurations**: Review system settings (/backend/configuraciones)
- **Edit Configuration**: Modify system parameters (/backend/configuraciones/edit/{id})

#### Authentication
- **Login**: System access (/web_ctrl or /backend/auth/login)
- **Logout**: End session (/backend/auth/logout)
- **Password Recovery**: Reset forgotten passwords (/backend/auth/forgot_password)

#### Other Utilities
- **Activity Logs**: View user actions (/backend/auditoria)
- **System Logs**: Review system events (/backend/logs)

#### Reports
- **Order Reports**: Sales and fulfillment analytics (Pending Implementation)
- **Customer Reports**: Customer activity analytics (Pending Implementation)
- **Activity Logs**: User activity reports (Partially Available)

### Dashboard Navigation

The dashboard interface uses a tabbed layout with main category tabs, and each tab contains card-style links to specific features. Features that are not yet implemented are clearly marked and visually distinguished from active features.

#### Permission-Based Menu Display

Menu items are dynamically filtered based on the logged-in user's permissions. The system uses:

1. **User Group Membership**: Determines base permission level
2. **Menu Permissions**: Associates menu items with permission requirements
3. **Dynamic Filtering**: Shows only items the user has rights to access

Backend administrators can configure which menu items appear for each user group via the Permissions management interface (/backend/permisos).

### Customer Token Management

The system now includes a comprehensive token management interface for customer API access. This feature allows administrators to:

1. **View Customer Tokens**
   - Access via the key icon in the customers list
   - View both production and development tokens
   - See token status (active/revoked)
   - Copy tokens to clipboard with one click
   - View creation and last update dates

2. **Token Operations**
   - Generate new tokens for customers
   - Revoke existing tokens
   - View token history
   - Manage both production and development tokens

3. **Security Features**
   - Tokens are automatically generated using secure methods
   - Development tokens are prefixed with 'Dev-'
   - Revoked tokens are clearly marked
   - All token operations are logged in the activity log

4. **Access Control**
   - Token management requires appropriate permissions
   - Token generation requires insert permission
   - Token revocation requires delete permission
   - View access is controlled by standard permissions

To access token management:

1. Navigate to `/ecommerce/customers`
2. Find the customer in the list
3. Click the key icon in the actions column
4. View and manage tokens in the resulting page

Token operations are logged in the `activity_log` table with the following actions:
- `GENERATE_TOKEN`: When a new token is generated
- `REVOKE_TOKEN`: When a token is revoked

This implementation ensures that token management is secure and efficient, while maintaining all necessary access controls and logging for audit purposes.

## API Authentication

### Token Types
The API supports two types of authentication tokens:

1. Production Token
   - Used for live environment API calls
   - Format: `live_xxxxxxxxxxxxx`
   - Accessed through the `/mi-token` page
   - Required for all production API endpoints

2. Development Token
   - Used for testing and development
   - Format: `dev_xxxxxxxxxxxxx`
   - Accessed through the `/mi-token` page
   - Allows testing without affecting production data

### Using Tokens
- Include the appropriate token in the `Authorization` header:
```
Authorization: Bearer your_token_here
```
- Use development tokens for testing new integrations
- Switch to production tokens for live environment
- Keep tokens secure and never share them
- Rotate tokens if compromised by generating new ones

### Token Management
- Access tokens through the `/mi-token` dashboard page
- Copy tokens using the provided copy buttons
- Ensure you're using the correct token type for your environment
- Contact support if you need to revoke or regenerate tokens