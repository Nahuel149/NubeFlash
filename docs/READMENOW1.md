# La Nube - E-commerce and Shipping Management System

## Table of Contents
- [Project Overview](#project-overview) (README 1)
- [System Architecture](#system-architecture) (README 1)
- [Directory Structure](#directory-structure) (README 1)
- [Framework Foundation](#framework-foundation) (README 2)
- [System Services](#system-services) (README 2)
- [Database Structure](#database-structure) (README 1)
- [Setup Instructions](#setup-instructions) (README 3)
- [Development Guidelines](#development-guidelines) (README 3)
- [API Documentation](#api-documentation) (README 3)
- [Troubleshooting](#troubleshooting) (README 3)

# La Nube - Part 1: Project Overview and Architecture

## Project Overview

La Nube is a comprehensive e-commerce and shipping management system built with CodeIgniter 3.x. The project aims to provide a robust platform for managing orders, customers, shipping rates, and product inventory with a modern API-first approach. It serves both backend administration needs (e.g., user management, analytics) and frontend e-commerce functionalities (e.g., customer portal, shopping cart).

### Objectives
- Streamline order management and tracking
- Enhance customer relationship management
- Automate shipping rate calculations
- Maintain product inventory control
- Deliver backend administrative tools
- Provide frontend e-commerce capabilities
- Enable API-driven interactions

## Technical Stack

### Core Technologies
- **PHP**: 7.3.33
- **Framework**: CodeIgniter 3.1.13
- **Database**: MySQL (Local Development Environment)
- **Composer**: 2.8.5
- **Character Set**: UTF-8 (utf8mb4)

### Key Dependencies
```json
{
    "require": {
        "php": ">=7.3",
        "endroid/qr-code": "^3.9",       // QR code generation
        "dompdf/dompdf": "0.8.*",        // PDF generation
        "tecnickcom/tcpdf": "6.2.*"      // PDF generation
    },
    "config": {
        "vendor-dir": "application/vendor",
        "platform": {
            "php": "7.3.33"
        }
    }
}

## Project Status & Progress

## Current Environment Setup

| Component | Details |
|-----------|---------|
| PHP Version | 7.3.33 |
| Framework | CodeIgniter 3.1.13 |
| Composer Version | 2.8.5 |
| Database | MySQL (Local Development Environment) |
| Character Set | UTF-8 (utf8mb4) |
| Framework Location | /system directory (core files) |
| Application Code | /application directory (custom code) |

## Frontend User Pages

The application provides several pages for frontend users, divided into public pages (accessible to all) and private pages (requiring authentication).

### Public Pages

| Page | URL | Controller | Description |
|------|-----|------------|-------------|
| Home | `/` or `/index` | frontend/web/index | Main landing page with FAQs and general information |
| Login | `/login` | frontend/web/login | User authentication page |
| Registration | `/registro` | frontend/web/register | New user registration with enhanced password security |
| Contact | `/contacto` | frontend/web/contacto | Contact form with reCAPTCHA integration |
| API Documentation | `/apis-documentacion` | frontend/web/documentation | Documentation for API endpoints |
| Terms and Conditions | `/terminos-pdf` | frontend/web/terminos_pdf | PDF document with terms and conditions |
| Privacy Policy | `/politicas-pdf` | frontend/web/politicas_pdf | PDF document with privacy policy |

### Private Pages (Authenticated Users)

| Page | URL | Controller | Description |
|------|-----|------------|-------------|
| Dashboard | `/dashboard` | frontend/private/dashboard/index | Main user dashboard with account overview |
| Profile Management | `/mi-perfil` | frontend/private/dashboard/profile | User profile management |
| API Token Management | `/mi-token` | frontend/private/dashboard/token | View and manage API tokens for integration |
| Order History | `/mis-pedidos` | frontend/private/dashboard/orders | View and track order history |

### API Endpoints

| Endpoint | URL | Controller | Description |
|----------|-----|------------|-------------|
| Get Customer | `/api/get-client` | frontend/api/getCustomer | Retrieve customer information |
| Get Shipping Cost | `/api/get-shippingCost` | frontend/api/getShippingCost | Calculate shipping costs |
| Send Order | `/api/send-order` | frontend/api/sendOrder | Create a new shipping order |
| Get Order Status | N/A | frontend/api/getOrderStatus | Check the status of an existing order |
| Get Destinations | N/A | frontend/api/getDestinations | Retrieve available destinations for a province |
| Get Provinces | N/A | frontend/api/getProvinces | Retrieve provinces for a country |
| Get Countries | N/A | frontend/api/getCountries | Retrieve available countries |

### User Journey

The frontend design supports the following user journeys:

1. **New User Registration**
   - Visit the registration page (`/registro`)
   - Fill out the registration form with secure password requirements
   - Submit the form and receive confirmation
   - Login with new credentials

2. **Customer Authentication**
   - Access the login page (`/login`)
   - Enter credentials with secure validation
   - Redirect to profile page upon successful login
   - Access to secure customer area

3. **Profile Management**
   - View and edit personal information (`/mi-perfil`)
   - Update contact details and business information
   - Change password with secure validation
   - Manage account settings

4. **API Integration**
   - View and manage API tokens (`/mi-token`)
   - Generate new tokens for external integration
   - View test and production tokens
   - Access documentation for API implementation

5. **Order Management**
   - View order history and status (`/mis-pedidos`)
   - Filter and search orders
   - View detailed order information
   - Update and manage order details
   - Track shipments with tracking numbers

6. **Documentation and Support**
   - Access API documentation (`/apis-documentacion`)
   - View terms and conditions (`/terminos-pdf`)
   - Review privacy policy (`/politicas-pdf`)
   - Contact support via contact form (`/contacto`)

### Frontend Features

The frontend includes several key features:

1. **Responsive Design**
   - Mobile-friendly layout
   - Adaptive interface for different screen sizes
   - Consistent navigation across devices

2. **Security Features**
   - CSRF protection on all forms
   - Secure password handling
   - Token-based API authentication
   - Session management with timeout
   - CORB (Cross-Origin Read Blocking) protection
   - Local resource loading for enhanced security

3. **Accessibility Improvements**
   - ARIA attributes for screen readers
   - Keyboard navigation support
   - Focus management for modals
   - High contrast visual elements
   - Proper label-input associations
   - Enhanced form field validation
   - Improved error messaging
   - Phone number input validation with international format support

4. **User Experience Enhancements**
   - Real-time form validation
   - Detailed error messages
   - Confirmation dialogs for important actions
   - Interactive modal dialogs
   - Enhanced phone number input with '+' symbol support
   - Improved form field labeling and organization

### Recent Fixes

1. **Enhanced Form Accessibility**
   - Fixed label `for` attributes to match input IDs
   - Added proper autocomplete attributes for form fields
   - Improved validation feedback for phone numbers
   - Enhanced error message display

2. **Security Improvements**
   - Resolved CORB issues by using local resources
   - Updated template to load scripts from same origin
   - Enhanced DataTables integration

3. **Phone Number Validation**
   - Added support for international phone numbers
   - Implemented '+' symbol validation
   - Enhanced real-time validation feedback
   - Updated field labels for clarity

4. **Template Consistency**
   - Added appropriate icon images for each section
   - Standardized variable passing across pages
   - Improved error handling for AJAX requests
   - Fixed accessibility issues with modals
   - Updated form field IDs for consistency

### System Structure

The project uses a clean CodeIgniter 3.1.13 installation with:

- Core framework files in `/system` (unmodified CodeIgniter core)
- Custom application code in `/application`
- Static assets in `/assets`
- File storage in `/store`
- Original configuration files preserved with `.original` extension

## Completed Features ✓

### Core System Setup
- CodeIgniter framework integration
- Composer dependency management (e.g., endroid/qr-code:^3.9, dompdf/dompdf:0.8., tecnickcom/tcpdf:6.2.)
- Database schema implementation
- Basic routing structure

### Authentication System
- User registration and login
- Group-based permissions
- Password recovery system
- Session management
- Login attempt tracking

### Backend Administration
- Dashboard implementation
- User management interface
- Group and permission control
- Menu management system
- System configuration
- Audit logging

### Frontend System
- Basic web interface
- API endpoints structure
- AJAX functionality
- E-commerce base setup

### E-commerce Features
- Customer management
- Location management (countries, provinces, destinations)
- Shipping rate calculation
- FAQ system

### Utility Features

#### QR Code Generation
- `/test_qr` (Welcome message)
- `/test_qr/generate` (Display QR)
- `/test_qr/download` (Download QR)

#### PDF Generation
- `/test_pdf` (Welcome message)
- `/test_pdf/generate` (Generate PDF)
- `/test_pdf/download` (Download PDF)

## Pending Implementation

### Frontend Development
- Complete customer portal interface
- Shopping cart implementation
- Product catalog interface
- Order tracking system
- Customer dashboard
- Responsive design implementation

### Backend Enhancements
- Advanced analytics dashboard
- Bulk operations for orders
- Enhanced reporting system
- File management system
- Email template manager

### E-commerce Features
- Product catalog management
- Shopping cart functionality
- Order processing workflow
- Payment gateway integration
- Inventory management
- Product variants support

### Shipping System
- Advanced rate calculation engine
- Real-time tracking integration
- Shipping label generation
- Address validation
- Multiple carrier support

### API Development
- Complete RESTful API implementation
- API versioning
- Rate limiting
- API authentication
- Swagger documentation

### Testing & Quality Assurance
- Unit testing suite
- Integration testing
- Performance testing
- Security audit
- Load testing

### Documentation
- API documentation
- User guides
- Developer documentation
- Deployment guides
- System architecture documentation

## System Architecture

### Core Components

The application is structured into key modules:

#### Backend Administration
- Dashboard and analytics
- User and group management
- Permission control
- System configuration
- Audit logging

#### Frontend E-commerce
- Public website interface
- Customer portal
- Shopping functionality
- API endpoints

#### E-commerce Management
- Customer management
- Location and shipping
- Tariff calculation
- FAQ management

### Directory Structure

#### Root Directory (/)

```
project_root/
├── application/         # Application code (Core application files)
├── assets/              # Static resources (Frontend and backend assets)
├── system/              # CodeIgniter core (v3.1.13)
├── store/               # File storage
└── Root Files           # Configuration and documentation files
```

#### Application Directory (/application/)

```
application/
├── cache/                    # Cache storage
│   ├── .htaccess             # Cache protection (123B, 6 lines)
│   └── index.html            # Directory protection (131B, 12 lines)
│
├── controllers/              # Application controllers
│   ├── Root Controllers
│   │   ├── Test_pdf.php           # PDF generation test (2.9KB, 88 lines)
│   │   ├── Test_qr.php            # QR code test (937B, 35 lines)
│   │   ├── Audits.php             # Audit controller (3.5KB, 119 lines)
│   │   ├── Sudaca_controller.php  # Base controller (272B, 15 lines)
│   │   └── Sudaca_errores.php     # Error handling (413B, 22 lines)
│   │
│   ├── backend/               # Backend controllers
│   │   ├── Dashboard.php        # Admin dashboard (2.7KB, 89 lines)
│   │   ├── Ajax.php            # AJAX handlers (979B, 43 lines)
│   │   ├── Auth.php            # Authentication (15KB, 337 lines)
│   │   ├── Auditoria.php       # Audit logging (746B, 28 lines)
│   │   ├── Codegen.php         # Code generation (15KB, 308 lines)
│   │   ├── Configuraciones.php # System config (1.2KB, 44 lines)
│   │   ├── Groups.php          # Group management (2.6KB, 117 lines)
│   │   ├── Login_attempts.php  # Login tracking (788B, 28 lines)
│   │   ├── Login_errors.php    # Error logging (730B, 28 lines)
│   │   ├── Logs.php            # System logs (2.6KB, 83 lines)
│   │   ├── Menus.php           # Menu management (2.9KB, 102 lines)
│   │   ├── Permisos.php        # Permissions (3.2KB, 114 lines)
│   │   └── Users.php           # User management (5.0KB, 186 lines)
│   │
│   ├── frontend/              # Frontend controllers
│   │   ├── Ajax.php           # Frontend AJAX (2.9KB, 108 lines)
│   │   ├── Api.php            # REST API (13KB, 270 lines)
│   │   ├── Ecommerce.php      # E-commerce base (106B, 10 lines)
│   │   ├── Web.php            # Main website (9.3KB, 287 lines)
│   │   └── private/           # Customer area controllers
│   │       └── Dashboard.php  # Customer dashboard (4.0KB, 131 lines)
│   │
│   ├── ecommerce/             # E-commerce controllers
│   │   ├── Countries.php      # Country management (2.4KB, 96 lines)
│   │   ├── Customers.php      # Customer management (6.5KB, 233 lines)
│   │   ├── Destinations.php   # Shipping destinations (2.9KB, 103 lines)
│   │   ├── Faqs.php           # FAQ management (2.7KB, 122 lines)
│   │   ├── Provinces.php      # Province management (2.6KB, 101 lines)
│   │   └── Tariff.php         # Shipping rates (4.3KB, 146 lines)
│   │
│   ├── cms/                   # CMS controllers
│   │   └── Slider.php         # Slider management (2.9KB, 120 lines)
│   │
│   └── index.html             # Directory protection (131B, 12 lines)
│
├── models/                    # Database models
│   ├── Base Models/
│   │   ├── Sudaca_md.php           # Base model (3.7KB, 98 lines)
│   │   ├── Sudaca_backend_md.php   # Admin model (5.9KB, 148 lines)
│   │   ├── Sudaca_cms_md.php       # CMS model (113B, 7 lines)
│   │   ├── Sudaca_ecommerce_md.php # E-commerce model (562B, 24 lines)
│   │   └── Sudaca_frontend_md.php  # Frontend model (119B, 8 lines)
│   │
│   ├── Authentication/
│   │   ├── Ion_auth_model.php         # Auth model (48KB, 2100 lines)
│   │   └── Ion_auth_mongodb_model.php # MongoDB auth (54KB, 2202 lines)
│   │
│   ├── Business/
│   │   ├── Order_model.php       # Orders (3.9KB, 85 lines)
│   │   ├── Tariff_model.php      # Pricing (3.3KB, 78 lines)
│   │   ├── Customer_model.php    # Customers (927B, 42 lines)
│   │   ├── Country_model.php     # Countries (916B, 42 lines)
│   │   ├── Province_model.php    # Provinces (1.3KB, 46 lines)
│   │   ├── Destination_model.php # Destinations (1.3KB, 46 lines)
│   │   ├── Faq_model.php         # FAQs (979B, 49 lines)
│   │   ├── Slider_model.php      # Content slider (923B, 43 lines)
│   │   └── Status_model.php      # Status management (672B, 27 lines)
│   │
│   └── Development/
│       └── Codegen_model.php     # Code generation (2.7KB, 112 lines)
│
├── libraries/                # Custom libraries
│   ├── Core Libraries
│   │   ├── Ion_auth.php         # Authentication system (13KB, 516 lines)
│   │   ├── Log.php              # System logging (3.4KB, 134 lines)
│   │   └── Permisos_lib.php     # Permissions management (1.9KB, 76 lines)
│   │
│   ├── Frontend Libraries
│   │   ├── Frontend_lib.php     # Frontend utilities (3.4KB, 125 lines)
│   │   ├── MY_Cart.php          # Shopping cart (2.9KB, 98 lines)
│   │   └── Ecommerce_lib.php    # E-commerce utilities (1.1KB, 33 lines)
│   │
│   ├── Backend Libraries
│   │   └── Backend_lib.php      # Admin utilities (7.2KB, 237 lines)
│   │
│   ├── PDF Libraries
│   │   ├── Html2pdf.php         # HTML to PDF conversion (3.1KB, 164 lines)
│   │   └── crearPdf.php         # PDF creation utilities (932B, 40 lines)
│   │
│   ├── External Libraries
│   │   ├── dompdf/              # DOMPDF library
│   │   └── PHPPdf/              # PHP PDF library
│   │
│   └── index.html           # Directory protection (131B, 12 lines)
│
├── views/                    # View templates
│   ├── backend/             # Admin interface views
│   │   ├── dashboard/       # Dashboard views
│   │   │   ├── dashboard.php                 # Main view (225B, 7 lines)
│   │   │   ├── dashboard_estructura.php      # Layout (1.1KB, 33 lines)
│   │   │   ├── dashboard_accesos_directos.php # Shortcuts (1.1KB, 29 lines)
│   │   │   ├── dashboard_iconos.php          # Icons (1.8KB, 52 lines)
│   │   │   ├── dashboard_js.php              # JavaScript (1.2KB, 38 lines)
│   │   │   └── dashboard_ultimos_accesos.php # Recent access (210B, 4 lines)
│   │   │
│   │   ├── users/          # User management views
│   │   │   ├── users_account.php  # Account settings (3.6KB, 59 lines)
│   │   │   ├── users_add.php      # Add user (5.6KB, 97 lines)
│   │   │   ├── users_edit.php     # Edit user (5.7KB, 94 lines)
│   │   │   ├── users_js.php       # JavaScript (2.3KB, 64 lines)
│   │   │   ├── users_list.php     # List users (3.1KB, 73 lines)
│   │   │   ├── users_password.php # Password management (2.0KB, 45 lines)
│   │   │   └── users_view.php     # View user (1.3KB, 31 lines)
│   │   │
│   │   ├── auth/           # Authentication views
│   │   │   ├── login.php           # Login form (1.4KB, 32 lines)
│   │   │   ├── change_password.php # Change password (1.9KB, 44 lines)
│   │   │   ├── forgot_password.php # Password recovery (1.1KB, 23 lines)
│   │   │   ├── reset_password.php  # Reset password (1.9KB, 33 lines)
│   │   │   └── email/             # Email templates
│   │   │       ├── activate.tpl.php        # Account activation (314B, 5 lines)
│   │   │       ├── forgot_password.php     # Password recovery (369B, 5 lines)
│   │   │       ├── forgot_password.tpl.php # Recovery template (344B, 5 lines)
│   │   │       └── new_password.tpl.php    # New password (259B, 5 lines)
│   │   │
│   │   ├── groups/         # Group management views
│   │   │   ├── groups_add.php    # Add group (1.6KB, 33 lines)
│   │   │   ├── groups_edit.php   # Edit group (1.8KB, 34 lines)
│   │   │   ├── groups_list.php   # List groups (3.6KB, 70 lines)
│   │   │   └── groups_view.php   # View group (843B, 19 lines)
│   │   │
│   │   └── System Views
│   │       ├── login_attempts/ # Login tracking views
│   │       ├── login_errors/   # Error logging views
│   │       ├── logs/           # System log views
│   │       ├── menus/          # Menu management
│   │       ├── opciones/       # Options views
│   │       ├── permisos/       # Permissions views
│   │       ├── auditoria/      # Audit views
│   │       ├── configuraciones/ # Settings views
│   │       ├── emails/         # Email templates
│   │       ├── error/          # Error pages
│   │       └── generador/      # Code generation views
│   │
│   ├── frontend/          # Public website views
│   │   ├── public/        # Public pages
│   │   ├── private/       # Customer area
│   │   ├── email/         # Email templates
│   │   └── index.html     # Directory protection (131B, 12 lines)
│   │
│   ├── template/          # Layout templates
│   │   ├── backend.php    # Admin template (1.4KB, 47 lines)
│   │   ├── frontend.php   # Public template (544B, 20 lines)
│   │   ├── private.php    # Customer template (1.2KB, 39 lines)
│   │   ├── error.php      # Error template (404B, 16 lines)
│   │   ├── login.php      # Login template (328B, 14 lines)
│   │   ├── view.php       # Basic view (30B, 1 lines)
│   │   ├── frontend/      # Frontend layouts
│   │   ├── backend/       # Admin layouts
│   │   ├── private/       # Customer layouts
│   │   └── index.html     # Directory protection (131B, 12 lines)
│   │
│   └── components/        # Reusable components
│       ├── ecommerce/     # E-commerce components
│       │   ├── countries/    # Country management components
│       │   ├── customers/    # Customer management components
│       │   ├── destinations/ # Destination management components
│       │   ├── faqs/         # FAQ management components
│       │   ├── provinces/    # Province management components
│       │   ├── shipping/     # Shipping management components
│       │   └── tariff/       # Tariff management components
│       │
│       ├── cms/           # CMS components
│       │   ├── secciones/   # Section management
│       │   └── slider/      # Slider management
│       │
│       └── audits/        # Audit components
│           ├── audits_add.php   # Add audit view (3.3KB, 65 lines)
│           ├── audits_edit.php  # Edit audit view (3.7KB, 64 lines)
│           ├── audits_list.php  # List audits view (2.4KB, 51 lines)
│           └── audits_view.php  # View audit details (2.0KB, 54 lines)
│
├── helpers/                 # Helper functions
│   ├── codegen_helper.php   # Code generation helpers (1.0KB, 52 lines)
│   ├── sudaca_helper.php    # Custom utility helpers (421B, 18 lines)
│   └── index.html           # Directory protection (131B, 12 lines)
│
├── language/                # Language files
│   ├── english/             # English translations
│   │   ├── auth_lang.php    # Auth messages (7.8KB, 146 lines)
│   │   ├── ion_auth_lang.php # Ion Auth messages (3.3KB, 74 lines)
│   │   └── index.html       # Directory protection (131B, 12 lines)
│   │
│   ├── spanish/             # Spanish translations
│   │   ├── auth_lang.php    # Auth messages (8.8KB, 165 lines)
│   │   └── index.html       # Directory protection (131B, 12 lines)
│   │
│   └── index.html           # Directory protection (131B, 12 lines)
```

#### Assets Directory (/assets/)

```
assets/
├── backend/                # Admin panel assets
│   ├── css/                # Stylesheets
│   │   ├── admin.css        # Core admin styles
│   │   └── custom/          # Custom style overrides
│   │
│   ├── js/                 # JavaScript files
│   │   ├── dashboard.js       # Dashboard functionality (1.4KB, 41 lines)
│   │   ├── dataTables.bootstrap4.min.js # DataTables plugin (2.0KB, 8 lines)
│   │   ├── jquery.PrintArea.js # Printing functionality (8.9KB, 193 lines)
│   │   ├── main.js           # Core admin JS (21KB, 717 lines)
│   │   ├── main_front.js     # Frontend integration (1.3KB, 1 line)
│   │   └── popup_chat_trigger_demo.js # Chat functionality (69B, 5 lines)
│   │
│   ├── images/             # Image resources
│   │   ├── logo_nube.png        # Main logo (38KB)
│   │   └── superflash.png       # Logo variant (50KB)
│   │
│   └── plugins/            # Third-party plugins
│       ├── bootstrap/       # Bootstrap framework
│       ├── jquery/         # jQuery library
│       ├── ckeditor/       # Rich text editor
│       ├── fullcalendar/   # Calendar component
│       └── select2/        # Enhanced select boxes
│
├── frontend/               # Public website assets
│   ├── css/                # Stylesheets
│   │   ├── enhanced-style.css    # Enhanced styles (4.3KB, 229 lines)
│   │   ├── animate.css           # Animations (74KB, 3159 lines)
│   │   ├── bootstrap.css         # Bootstrap core (198KB, 10038 lines)
│   │   ├── menu_categorias.css   # Category menu (3.0KB, 127 lines)
│   │   ├── owl.carousel.css      # Carousel styles (1.5KB, 72 lines)
│   │   ├── preloader.css         # Loading styles (712B, 27 lines)
│   │   └── style.css             # Main styles (2.4KB, 113 lines)
│   │
│   ├── js/                 # JavaScript files
│   │   ├── bootstrap.bundle.js    # Bootstrap core (231KB, 7014 lines)
│   │   ├── constants.js           # Global constants (220B, 8 lines)
│   │   ├── dropzone.js           # File upload (125KB, 3505 lines)
│   │   ├── functions.js          # Utility functions (79KB, 1775 lines)
│   │   ├── jquery.min.js         # jQuery library (94KB, 5 lines)
│   │   ├── jquery.nicescroll.js  # Scrollbar (117KB, 3184 lines)
│   │   └── owl.carousel.js       # Carousel (83KB, 3070 lines)
│   │
│   ├── images/             # Image resources
│   │   ├── homecelus02.png      # Hero image (541KB)
│   │   └── homeslider1.png      # Slider image (582KB)
│   │
│   └── plugins/            # Third-party plugins
│       ├── moment/         # Date/time library
│       ├── chart.js/       # Charting library
│       ├── trumbowyg/      # Lightweight editor
│       └── sweetalert/     # Alert dialogs
│
└── common/                 # Shared resources
    ├── fonts/              # Font files
    │   ├── Poppins/         # Poppins font family
    │   ├── Montserrat/      # Montserrat font family
    │   ├── Open_Sans/       # Open Sans font family
    │   ├── Raleway/         # Raleway font family
    │   ├── Roboto/          # Roboto font family
    │   └── Lato/            # Lato font family
    │
    ├── icons/              # Icon sets
    │   └── Various font files:
    │       ├── Poppins-Regular.ttf     (154KB)
    │       ├── Montserrat-Regular.ttf  (240KB)
    │       ├── OpenSans-Regular.ttf    (95KB)
    │       ├── Raleway-Regular.ttf     (160KB)
    │       ├── Roboto-Regular.ttf      (167KB)
    │       └── Lato-Regular.ttf        (73KB)
    │
    └── uploads/            # User uploads
```

#### Store Directory (/store/)

```
store/
├── qrcodes/                # Generated QR codes
├── pdfs/                   # Generated PDF files
│   ├── invoices/           # Generated invoice PDFs
│   ├── reports/            # Generated report PDFs
│   └── shipping/           # Shipping labels and documents
│
├── temp/                   # Temporary files
└── uploads/                # User uploads
    ├── customers/          # Customer files
    ├── products/           # Product images
    └── system/             # System files
```

### Key Files

- **index.php**: Front controller (with backup as index.php.original) (10KB, 316 lines)
- **.htaccess**: URL rewriting (with backup as .htaccess.original) (128B, 4 lines)
- **composer.json**: Dependency management (with backup as composer.json.original) (508B, 27 lines)
- **php.ini**: PHP configuration (with backup as php.ini.original) (303B, 10 lines)
- **create_database.sql**: Database schema (18KB, 446 lines)
- **insert_test_data.sql**: Initial test data (10KB, 186 lines)

### Dependencies (composer.json)

```json
{
    "require": {
        "php": ">=7.3",
        "endroid/qr-code": "^3.9",
        "dompdf/dompdf": "0.8.*",
        "tecnickcom/tcpdf": "6.2.*"
    },
    "config": {
        "vendor-dir": "application/vendor",
        "platform": {
            "php": "7.3.33"
        }
    }
}
```

## Database Structure

### Database Configuration
- **Name**: lanube_api
- **Character Set**: UTF8MB4
- **Collation**: utf8mb4_general_ci
- **Engine**: InnoDB (for foreign key support)

### Standardized Table Structure
- **Primary Keys**: id_[table] (e.g., id_user), INT AUTO_INCREMENT
- **Foreign Keys**: id_[referenced_table] (e.g., id_group), INT
- **Common Fields**:
  - Timestamps: created_at, updated_at, deleted_at
  - Audit Fields: create_by, update_by, delete_by
  - Status: active (TINYINT, DEFAULT 1)

### Key Tables

#### Authentication & Authorization
- **users**: User info and authentication
- **groups**: User group definitions
- **users_groups**: User-group relationships
- **login_attempts**: Security monitoring

#### Location Management
- **countries**: Country data
- **provinces**: Province/state data
- **destinations**: Shipping destinations

#### Customer Management
- **customers**: Customer profiles
- **customer_shipping_credentials**: Shipping details

#### Order System
- **orders**: Order tracking
- **order_items**: Order line items
- **tariff**: Shipping rates
- **statuses**: Order status tracking

#### Content Management
- **menus**: Navigation structure
- **faqs**: FAQs
- **image_gallery**: Media storage
- **email_templates**: Email templates

## Detailed Controller Structure

### Root Controllers

#### Test_pdf.php (2.9KB, 88 lines)
- PDF generation testing
- Sample PDF creation
- PDF download functionality
- PDF template rendering

#### Test_qr.php (937B, 35 lines)
- QR code generation testing
- QR code creation samples
- QR code download functionality

#### Audits.php (3.5KB, 119 lines)
- System audit logging
- Activity tracking
- User action monitoring
- Audit report generation

#### Sudaca_controller.php (272B, 15 lines)
- Base controller class
- Common controller functionality
- Shared methods and properties

#### Sudaca_errores.php (413B, 22 lines)
- Error handling controller
- Custom error pages
- Error logging functionality

## Detailed Models Structure

### Base Models

#### Sudaca_md.php (3.7KB, 98 lines)
- Base model functionality
- Common database operations
- Data validation methods
- Error handling utilities

#### Sudaca_backend_md.php (5.9KB, 148 lines)
- Admin panel model functionality
- Backend data operations
- Admin-specific validations
- Backend utilities

#### Sudaca_cms_md.php (113B, 7 lines)
- CMS base functionality
- Content management operations
- CMS-specific validations

#### Sudaca_ecommerce_md.php (562B, 24 lines)
- E-commerce base functionality
- Product management operations
- Order processing methods

#### Sudaca_frontend_md.php (119B, 8 lines)
- Frontend data operations
- Public website functionality
- Frontend-specific methods

### Business Models

#### Order_model.php (3.9KB, 85 lines)
- Order processing
- Order status management
- Order history tracking
- Payment processing
- Order validation

#### Tariff_model.php (3.3KB, 78 lines)
- Shipping rate calculations
- Price management
- Zone-based pricing
- Weight calculations
- Volume-based rates

#### Customer_model.php (927B, 42 lines)
- Customer data management
- Profile operations
- Customer history
- Address management
- Preferences handling

#### Country_model.php (916B, 42 lines)
- Country data management
- Geographic operations
- Country-specific rules
- Location validation

#### Province_model.php (1.3KB, 46 lines)
- Province/state management
- Regional data operations
- Local shipping rules
- Area-specific functionality

#### Destination_model.php (1.3KB, 46 lines)
- Shipping destination management
- Address validation
- Delivery zone handling
- Location formatting

## Security Implementation

### Security Configuration
The system implements a comprehensive security framework:

1. **PHP Security Settings**
```php
ini_set('display_errors', '0');      // Production error handling
ini_set('expose_php', '0');          // Hide PHP version
ini_set('session.cookie_httponly', '1');  // Secure cookies
ini_set('session.cookie_secure', '1');    // HTTPS-only cookies
ini_set('session.use_strict_mode', '1');  // Strict session mode
ini_set('session.cookie_samesite', 'Lax'); // SameSite cookies
```

2. **Security Headers**
```php
$config['security_headers'] = array(
    'X-Frame-Options' => 'SAMEORIGIN',
    'X-XSS-Protection' => '1; mode=block',
    'X-Content-Type-Options' => 'nosniff',
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
    'Content-Security-Policy' => "default-src 'self'..."
);
```

3. **File Permissions**
- Regular automated checks
- Critical file monitoring
- Permission violation logging

4. **Security Hooks**
```php
// Pre-system hook for file permission checks
$hook['pre_system'][] = array(
    'class'    => 'Security_hook',
    'function' => 'check_file_permissions'
);

// Post-controller hook for security headers
$hook['post_controller_constructor'][] = array(
    'class'    => 'Security_hook',
    'function' => 'apply_security_headers'
);
```

### Template System Structure

#### Directory Organization
```
application/
└── views/
    ├── frontend/
    │   ├── public/      # Public pages
    │   ├── private/     # Customer area
    │   ├── email/       # Email templates
    │   └── components/  # Reusable components
    ├── backend/
    │   ├── dashboard/   # Admin dashboard
    │   ├── users/       # User management
    │   ├── groups/      # Group management
    │   ├── auth/        # Authentication
    │   └── menus/       # Menu management
    └── templates/
        ├── layouts/     # Base layouts
        ├── partials/    # Shared partials
        └── emails/      # Email templates
```

#### Helper Functions

1. **HTML Helpers**
```php
// Status badges
html_status_badge('active', 'Active User');

// Icon buttons
html_icon_button('fas fa-edit', 'Edit', '/edit/1');

// Data tables
html_data_table($headers, $data, ['table_class' => 'table-hover']);
```

2. **Form Helpers**
```php
// Form groups
form_group('Username', form_input('username'));

// Select2 dropdowns
form_select2('country', $countries);

// Image uploads
form_upload_image('avatar', '', true);
```