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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*site routes*/
$route['terms-condition'] = 'Home/terms_condition';
$route['privacy'] = 'Home/privacy';
$route['email-verification'] = 'Auth/email_verification';


/*Admin routes*/
$route['admin'] = 'Admin/Login';
$route['do-login'] = 'Admin/Login/do_login';
$route['admin/dashboard'] = 'Admin/Dashboard';
$route['admin/logout'] = 'Admin/Profile/logout';
$route['admin/profile'] = 'Admin/Profile';
$route['admin/area-served-list'] = 'Admin/AreaServed';
$route['admin/pickup-location-list'] = 'Admin/PickupLocation';
$route['admin/edit-area/(:any)'] = 'Admin/AreaServed/edit/$1';
$route['admin/add-area'] = 'Admin/AreaServed/add';
$route['admin/main-page-content'] = 'Admin/Home/edit_content';
$route['admin/home-page-content'] = 'Admin/Home/edit_home_content';
$route['admin/inner-page-content'] = 'Admin/Home/edit_inner_content';
$route['admin/contact-details'] = 'Admin/Home/contact_details';
$route['admin/contact-list'] = 'Admin/Home/contact_list';
$route['admin/category-list'] = 'Admin/Category/category_list';
$route['admin/meal-type-list'] = 'Admin/Meal';
$route['admin/meal-list'] = 'Admin/Meal/meal_list';
$route['admin/add-meals'] = 'Admin/Meal/add_meals';
$route['admin/edit-meal/(:any)'] = 'Admin/Meal/edit_meal/$1';
// $route['admin/add-main-content'] = 'Admin/Home/add_content';
// $route['admin/edit-main-content/(:any)'] = 'Admin/Home/edit_content/$1';

/**********************************/
