<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'welcome';
// $route['default_controller'] = 'dashboard/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Dashboard routes
$route['dashboard'] = 'dashboard/index';
// $route['dashboard'] = 'admin/dashboard';
$route['dashboard/(:any)'] = 'dashboard/$1';

// Authentication routes
$route['auth/login'] = 'auth/login';
$route['auth/register'] = 'auth/register';
$route['auth/logout'] = 'auth/logout';
$route['auth/verify/(:any)'] = 'auth/verify/$1';

// Admin routes
// $route['admin'] = 'admin/index';
$route['admin/functions'] = 'admin/functions_view';
$route['admin'] = 'admin/functions_view';
$route['admin/(:any)'] = 'admin/$1';
$route['admin/(:any)/(:any)'] = 'admin/$1/$2';


// Enterprise routes
$route['enterprise/functions'] = 'enterprise/functions_view';
$route['enterprise/(:any)'] = 'enterprise/$1';
$route['enterprise/(:any)/(:any)'] = 'enterprise/$1/$2';

// Investor routes
$route['investor/functions'] = 'investor/functions_view';
$route['investor/(:any)'] = 'investor/$1';
$route['investor/(:any)/(:any)'] = 'investor/$1/$2';

// Client routes
$route['client/functions'] = 'client/functions_view';
$route['client/(:any)'] = 'client/$1';
$route['client/(:any)/(:any)'] = 'client/$1/$2';

// API routes
$route['api/(:any)'] = 'api/$1';
$route['api/(:any)/(:any)'] = 'api/$1/$2';

// Language switching
$route['lang/(:any)'] = 'language/switch/$1';