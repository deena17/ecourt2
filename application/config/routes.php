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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = 'auth/error404';
$route['translate_uri_dashes'] = FALSE;

$route[''] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['auth/403'] = 'auth/error403';
$route['dashboard'] = 'dashboard/index';
$route['case/details-by-filing-number/(:any)'] = 'cases/get_case_details/$1';

$route['scrutiny'] = 'scrutiny/index';
$route['scrutiny/objection'] = 'scrutiny/objection';
$route['scrutiny/(:any)/objection/documents'] = 'scrutiny/document_objection/$1';
$route['scrutiny/(:any)/objection/update'] = 'scrutiny/update_objection/$1';

$route['indexregister/search'] = 'indexRegister/search_index/';
$route['indexregister/cause-list'] = 'indexRegister/cause_list/';
$route['indexregister/(:any)/documents'] = 'indexRegister/list_index/$1';
$route['indexregister/get-eindex-document/(:any)/(:num)'] = 'indexRegister/get_eindex_document/$1/$2';
$route['indexregister/get-index-document/(:any)/(:num)'] = 'indexRegister/get_index_document/$1/$2';
$route['indexregister/delete'] = 'indexRegister/delete';
// $route['indexregister/delete'] = 'indexRegister/delete_selected';
