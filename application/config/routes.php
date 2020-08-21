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
$route['default_controller'] = 'home';
/*--------------------
		ADMIN SIDE
---------------------*/

// setting route for admin
$route['admin'] = 'admin/auth/index';
$route['admin/profile'] = 'admin/admin/profile';
$route['admin/change_pwd'] = 'admin/admin/change_pwd';

// subcategory for admin

$route['admin/category/(:num)/subcategories'] = 'admin/category/subcategories/$1';
$route['admin/category/(:num)/subcategories/add'] = 'admin/category/add_subcategory/$1';
$route['admin/subcategory/edit/(:num)'] = 'admin/category/edit_subcategory/$1';
$route['admin/category/(:num)/subcategories/del/(:num)'] = 'admin/category/del_subcategory/$1';

// custom fields
$route['admin/custom_fields/(:num)/categories/add'] = 'admin/custom_fields/add_to_category/$1';
// setting blog category
$route['admin/blog/category/add'] = 'admin/blog/category_add';
$route['admin/blog/category/edit/(:num)'] = 'admin/blog/category_edit/$1';
$route['admin/blog/category/del/(:num)'] = 'admin/blog/category_del/$1';

// Subcategory for admin
$route['admin/category/(:num)/subcategories'] = 'admin/category/subcategories/$1';
$route['admin/category/(:num)/subcategories/add'] = 'admin/category/add_subcategory/$1';
$route['admin/subcategory/edit/(:num)'] = 'admin/category/edit_subcategory/$1';
$route['admin/category/(:num)/subcategories/del/(:num)'] = 'admin/category/del_subcategory/$1';

// Miscellaneous
$route['admin/misc/country/add'] = 'admin/misc/country_add';
$route['admin/misc/country/edit/(:num)'] = 'admin/misc/country_edit/$1';
$route['admin/misc/country/del/(:num)'] = 'admin/misc/country_del/$1';

$route['admin/misc/state/add'] = 'admin/misc/state_add';
$route['admin/misc/state/edit/(:num)'] = 'admin/misc/state_edit/$1';
$route['admin/misc/state/del/(:num)'] = 'admin/misc/state_del/$1';

$route['admin/misc/city/add'] = 'admin/misc/city_add';
$route['admin/misc/city/edit/(:num)'] = 'admin/misc/city_edit/$1';
$route['admin/misc/city/del/(:num)'] = 'admin/misc/city_del/$1';

$route['admin/misc/language/add'] = 'admin/misc/language_add';
$route['admin/misc/language/edit/(:num)'] = 'admin/misc/language_edit/$1';
$route['admin/misc/language/del/(:num)'] = 'admin/misc/language_del/$1';

$route['admin/misc/currency/add'] = 'admin/misc/currency_add';
$route['admin/misc/currency/edit/(:num)'] = 'admin/misc/currency_edit/$1';
$route['admin/misc/currency/del/(:num)'] = 'admin/misc/currency_del/$1';

$route['admin/contact'] = 'admin/misc/contact';
$route['admin/contact/del/(:num)'] = 'admin/misc/contact_del/$1';

/*--------------------
		USER SIDE
---------------------*/
// language
$route['lang/(:num)'] = 'home/set_site_language/$1';

// user inbox
$route['inbox/(:num)/(:any)'] = 'inbox/index/$1/$2';

// user post
$route['ads/add'] = 'ads/add';
$route['ads/search'] = 'ads/search';
$route['ads/save_favorite'] = 'ads/save_favorite';
$route['ad/(:any)'] = 'ads/index/$1';
$route['ads/(:num)'] = 'ads/index/$1';

// post category
$route['category/(:any)'] = 'category/index/$1';
$route['category/(:any)/(:any)'] = 'category/index/$1/$2';

// single static page route

// include 'include/pages.php';
$route['p/([^/]+)/?'] = 'home/page/$1';

$route['services'] = 'home/services';
$route['contact'] = 'home/contact';
$route['about'] = 'home/about_us';
$route['register'] = 'auth/registration';
$route['register/validate_email/(:any)'] = 'auth/validate_email/$1';
$route['login'] = 'auth/login';


$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;
