# La Nube - Part 4: Shipping Cost Management Guide

## Table of Contents
1. [Overview](#overview)
2. [How Shipping Costs Work](#how-shipping-costs-work)
3. [Managing Shipping Rates](#managing-shipping-rates)
4. [Shipping Cost Calculator](#shipping-cost-calculator)
5. [Examples](#examples)
6. [API Integration](#api-integration)
7. [System Monitoring and Logs](#system-monitoring-and-logs)

## Overview

La Nube's shipping cost system is designed to be flexible and easy to manage. This guide explains how shipping costs are calculated and how to manage them through the admin panel.

## How Shipping Costs Work

### Basic Concepts

1. **Weight Types**:
   - **Actual Weight**: The physical weight of the package in kilograms
   - **Volumetric Weight**: Calculated from package dimensions
   - **Effective Weight**: The greater of actual and volumetric weight

2. **Pricing Factors**:
   - Origin location
   - Destination location
   - Package weight
   - Package dimensions
   - Special handling requirements
   - Service type (regular/express)

### Weight Calculations

1. **Volumetric Weight Formula**:
   ```
   Volumetric Weight = (Length × Width × Height) ÷ 5000
   ```
   - Measurements in centimeters
   - 5000 is the standard divisor for domestic shipments
   - Example: A box 30cm × 20cm × 15cm = 1.8kg volumetric weight

2. **Effective Weight**:
   ```
   Effective Weight = MAX(Actual Weight, Volumetric Weight)
   ```
   Example:
   - Actual Weight: 1.5 kg
   - Volumetric Weight: 1.8 kg
   - Effective Weight used: 1.8 kg

## Managing Shipping Rates

### Accessing the Rate Manager

1. Log in to the admin panel
2. Navigate to "E-commerce" → "Shipping Rates"
3. You'll see the rate management dashboard

### Setting Up New Rates

1. Click "Add New Rate"
2. Fill in the following:
   - Origin (Province/City)
   - Destination (Province/City)
   - Weight Range (Min-Max)
   - Base Price
   - Price per Additional KG

Example Rate Setup:
```
Origin: Buenos Aires
Destination: Córdoba
Weight Range: 0-5 kg
Base Price: $1000
Additional KG Price: $200
```

### Editing Existing Rates

1. Find the rate in the table
2. Click the "Edit" button
3. Modify any values
4. Click "Save" to update

### Bulk Rate Management

For managing multiple rates:

1. **Export Current Rates**:
   - Click "Export to Excel"
   - You'll get a spreadsheet with all rates

2. **Update Rates**:
   - Modify the spreadsheet
   - Save your changes

3. **Import Updated Rates**:
   - Click "Import from Excel"
   - Upload your modified spreadsheet
   - Review and confirm changes

## Shipping Cost Calculator

### Basic Formula

```
Final Shipping Cost = Base Rate + Additional Weight Cost + Extra Fees
```

Where:
- Base Rate: Price for minimum weight
- Additional Weight Cost: (Effective Weight - Min Weight) × Price per KG
- Extra Fees: Insurance + Fuel Surcharge + Handling

### Example Calculation

For a package:
- Weight: 7 kg
- From: Buenos Aires
- To: Córdoba
- Base rate (0-5 kg): $1000
- Additional KG price: $200

Calculation:
1. Additional weight: 7 kg - 5 kg = 2 kg
2. Additional cost: 2 kg × $200 = $400
3. Base cost: $1000
4. Total before fees: $1400
5. Add fees (example 10%): $1540

## Examples

### Example 1: Small Package
```
Dimensions: 20cm × 15cm × 10cm
Weight: 0.5 kg
Volumetric Weight: (20 × 15 × 10) ÷ 5000 = 0.6 kg
Effective Weight: 0.6 kg
Base Rate (0-1 kg): $500
Final Cost: $500 + fees
```

### Example 2: Large Package
```
Dimensions: 50cm × 40cm × 30cm
Weight: 4 kg
Volumetric Weight: (50 × 40 × 30) ÷ 5000 = 12 kg
Effective Weight: 12 kg
Base Rate (0-5 kg): $1000
Additional: (12 - 5) × $200 = $1400
Final Cost: $2400 + fees
```

## API Integration

### Getting Shipping Costs via API

Endpoint: `/api/get-shippingCost`

Request Example:
```json
{
  "origin": "Buenos Aires",
  "destination": "Córdoba",
  "weight": 7.0,
  "dimensions": {
    "length": 30,
    "width": 20,
    "height": 15
  }
}
```

Response Example:
```json
{
  "success": true,
  "cost": {
    "base_rate": 1000,
    "additional_weight_cost": 400,
    "fees": 140,
    "total": 1540
  },
  "details": {
    "effective_weight": 7.0,
    "delivery_estimate": "2-3 days"
  }
}
```

### Tips for Rate Management

1. **Regular Review**:
   - Review and update rates monthly
   - Check competitor pricing
   - Adjust for fuel cost changes

2. **Special Rates**:
   - Create special rates for high-volume customers
   - Set up promotional rates for specific periods
   - Configure rush delivery rates

3. **Testing Changes**:
   - Always test new rates before activating
   - Use the API test endpoint
   - Verify calculations manually

4. **Monitoring**:
   - Track shipping cost accuracy
   - Monitor customer feedback
   - Analyze profitability by route

## Need Help?

If you need assistance with shipping rate management:
- Contact technical support
- Check the API documentation
- Review the troubleshooting guide

Remember: Accurate shipping costs are crucial for your business. Take time to set up and maintain your rates properly.

# Changelog

## [1.4.2] - 2024-03-13
### Fixed
- Fixed PHP Notice errors in users view when displaying telephone and mobile numbers
- Updated field references in users_view.php to match database schema:
  - Changed 'telephone' to 'telefono'
  - Changed 'mobile' to 'phone'
- Added proper null checks for phone number fields
- Improved error handling for undefined properties in user profile display
- Added fallback text "No especificado" for empty phone fields

### Changed
- Removed Root navigation menu from top bar for cleaner interface
- Simplified menu generation logic in Backend_lib.php
- Improved menu visibility handling with proper case-insensitive checks

### Technical Details
- Updated database field usage:
  - Users table uses 'telefono' for landline numbers
  - Users table uses 'phone' for mobile numbers
- Modified template structure:
  - Removed menu-top-image-i section from navigation
  - Maintained mobile menu functionality
  - Preserved user avatar and dashboard access

## [1.4.1] - 2024-03-12
### Added
- Enhanced countries management interface in the backend
- Added proper code generation for country codes
- Improved error handling in country operations

### Changed
- Updated button text from "Nueva País" to "Nuevo País" for better grammar
- Removed non-existent column references in database operations
- Streamlined country management workflow

### Fixed
- Database errors related to missing columns (created_by, updated_by)
- Proper handling of country codes in add/edit operations
- Consistent UI text in country management section

## [1.4.0] - 2024-03-12
### Added
- Enhanced error handling in tariff management system
- Proper soft delete functionality for tariffs
- Improved CSRF token validation in AJAX requests
- Better user feedback messages throughout the application

### Changed
- Updated tariff edit workflow with better validation
- Improved database structure with proper tracking columns
- Enhanced security measures in form submissions
- Optimized code organization and documentation

### Fixed
- Tariff edit page errors when no ID provided
- CSRF token handling in AJAX requests
- Error display in form submissions
- Navigation flow in tariff management

## [1.4.2] - 2024-03-12
### Added
- Consistent trash icon implementation across all management sections
- Enhanced delete functionality with proper CSRF token handling
- Improved error handling in delete operations for Countries, Provinces, and Destinations

### Changed
- Updated trash icon from `fa-trash-o` to `fa-trash` in all list views
- Standardized delete operation response format across all controllers
- Improved soft delete implementation to only use 'active' column

### Fixed
- Removed references to non-existent columns (deleted_at, deleted_by) in delete operations
- Standardized JSON responses for delete operations
- Consistent error handling and user feedback in delete operations

### Technical Details
1. **Delete Operation Response Format**:
   ```json
   {
     "success": boolean,
     "message": string,
     "csrf_hash": string
   }
   ```

2. **Soft Delete Implementation**:
   ```php
   $data = array(
       'active' => 0
   );
   ```

3. **Error Handling**:
   - Try-catch blocks in all delete operations
   - Proper error messages for failed operations
   - CSRF token refresh on each operation

4. **UI Components**:
   - Consistent button styling across all sections
   - Uniform trash icon implementation
   - Standardized delete confirmation dialogs

### Security
- CSRF token validation in all delete operations
- Proper permission checking before delete operations
- Secure soft delete implementation

## [Previous versions remain unchanged...]

## System Monitoring and Logs

La Nube provides comprehensive system monitoring through two main logging interfaces:

### Activity Logs (/backend/auditoria)

Activity Logs track user actions and system changes, providing an audit trail of who did what and when.

#### Accessing Activity Logs
1. Navigate to "Other Utilities" → "Activity Logs"
2. Use the filters to search specific activities:
   - Date range
   - User
   - Action type (LOGIN, LOGOUT, CREATE, UPDATE, DELETE)

#### Features
- View user actions with timestamps
- Filter by date range and action type
- Export logs to Excel
- Track IP addresses for security
- Color-coded action types for easy identification

#### Example Log Entries
```
Action: LOGIN
User: admin
IP: 192.168.1.100
Date: 2024-03-13 10:30:45

Action: UPDATE
User: operator
Description: Updated order status
IP: 192.168.1.101
Date: 2024-03-13 11:15:22
```

### System Logs (/backend/logs)

System Logs focus on technical aspects and error tracking, essential for system maintenance and debugging.

#### Accessing System Logs
1. Navigate to "Other Utilities" → "System Logs"
2. Choose between:
   - Login Attempts
   - Login Errors

#### Features
- Track successful and failed login attempts
- Monitor system errors and warnings
- Export logs to Excel
- Filter by date range
- View detailed error information

#### Log Types
1. **Login Attempts**
   - Track all login attempts
   - Record IP addresses
   - Show success/failure status
   - Timestamp each attempt

2. **Login Errors**
   - Record failed login details
   - Track error messages
   - Monitor suspicious activity
   - Help identify security issues

### Best Practices

1. **Regular Monitoring**
   - Check Activity Logs daily for unusual patterns
   - Review System Logs for recurring errors
   - Monitor failed login attempts

2. **Log Management**
   - Export and archive logs monthly
   - Clean up old log entries
   - Maintain audit trail for compliance

3. **Security Monitoring**
   - Track failed login attempts
   - Monitor IP addresses for suspicious activity
   - Review user action patterns

4. **Troubleshooting**
   - Use logs to diagnose issues
   - Track error patterns
   - Monitor system performance

### Permissions

Access to logs is controlled by user permissions:

1. **Activity Logs**
   - View: Requires read permission
   - Export: Requires export permission

2. **System Logs**
   - View: Requires read permission
   - Export: Requires export permission

Permissions are managed through the admin interface under user groups.

## [1.4.3] - 2024-03-13
### Added
- Implemented comprehensive Activity Logs system
  - User action tracking
  - Filterable by date, user, and action type
  - Excel export functionality
- Added System Logs interface
  - Login attempt monitoring
  - Error tracking
  - Advanced filtering options

### Changed
- Improved logging system architecture
- Enhanced permission management for log access
- Updated menu structure to include logging tools

### Technical Details
- New database tables utilized:
  - activity_log: For user actions
  - login_attempts: For login tracking
  - login_attempts_errors: For failed logins
  - login_errors: For system errors
- Added menu entries under "Other Utilities"
- Implemented proper permission checks
- Added Excel export functionality using PHPSpreadsheet 