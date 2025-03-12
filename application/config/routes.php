<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'sudaca_controller';
$route['404_override'] = 'sudaca_errores/_404';
$route['translate_uri_dashes'] = FALSE;

// backend
$route['web_ctrl'] = "backend/auth/login";
$route['backend'] = "backend/dashboard";
$route['backend/(:any)'] = 'backend/$1';
$route['backend/(:any)/(:any)'] = 'backend/$1/$2';
$route['backend/(:any)/(:any)/(:any)'] = 'backend/$1/$2/$3';

// frontend
$route['index'] = "frontend/web/index";
$route['login'] = "frontend/web/login";
$route['registro'] = "frontend/web/register";
$route['logout'] = "frontend/web/logout";
$route['apis-documentacion'] = "frontend/web/documentation";
$route['contacto'] = "frontend/web/contacto";
// Dashboard
$route['dashboard'] = "frontend/private/dashboard/index";
$route['mi-perfil'] = "frontend/private/dashboard/profile";
$route['mi-token'] = "frontend/private/dashboard/token";
$route['mis-pedidos'] = "frontend/private/dashboard/orders";

//Api 
$route['api/get-client'] = "frontend/api/getCustomer";
$route['api/get-shippingCost'] = "frontend/api/getShippingCost";
$route['api/send-order'] = "frontend/api/sendOrder";

// PDF routes
$route['politicas-pdf'] = "frontend/web/politicas_pdf";
$route['terminos-pdf'] = "frontend/web/terminos_pdf";
$route['frontend/web/pdf/(:any)'] = "frontend/web/pdf/$1";
$route['pdf/(:any)'] = "frontend/web/serve_pdf/$1";

// Ecommerce routes
$route['ecommerce'] = 'ecommerce/dashboard';
$route['ecommerce/customers'] = 'ecommerce/customers';
$route['ecommerce/customers/(:any)'] = 'ecommerce/customers/$1';
$route['ecommerce/orders'] = 'ecommerce/orders';
$route['ecommerce/orders/(:any)'] = 'ecommerce/orders/$1';
$route['ecommerce/tariff'] = 'ecommerce/tariff';
$route['ecommerce/tariff/(:any)'] = 'ecommerce/tariff/$1';
$route['ecommerce/provinces'] = 'ecommerce/provinces';
$route['ecommerce/provinces/(:any)'] = 'ecommerce/provinces/$1';
$route['ecommerce/destinations'] = 'ecommerce/destinations';
$route['ecommerce/destinations/(:any)'] = 'ecommerce/destinations/$1';
