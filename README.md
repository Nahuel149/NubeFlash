# NubeFlash

NubeFlash is a web application for managing shipping logistics, customer data, and order processing.

## Features

- User management with role-based permissions
- Customer database and management
- Order processing and tracking
- Shipping rate calculations
- Destination and province management
- Audit logging and system activity monitoring
- Reporting and data export capabilities

## Requirements

- PHP 7.2 or higher
- MySQL
- Required PHP extensions: mysqli, curl, gd, mbstring, zip, xml, pdo, pdo_mysql

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/Nahuel149/NubeFlash.git
   ```

2. Set up your database using the provided SQL file:
   ```
   mysql -u username -p database_name < create_database.sql
   ```

3. Configure your database connection in `application/config/database.php`

4. Configure your base URL in `application/config/config.php`

5. Make sure the following directories are writable:
   - application/logs
   - application/logs/backend
   - application/cache
   - uploads
   - uploads/zip

## Usage

Frontend user: (http://localhost:8000/index)

- Username: contacto@empresaa.com
- Password: password123

Backend user: (http://localhost:8000/web_ctrl)
Access the application at your configured URL. Default admin credentials:

- Username: admin
- Password: admin123

## Pre-Deployment Testing

Run the pre-deployment test script to ensure your environment is properly configured:

```
php pre_deployment_test.php
```

## License
