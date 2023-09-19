<?php
namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('administrator', 'Home::index');
$routes->post('adminlogin', 'Home::login');

$routes->get('admin/dashboard', 'Admin::index');

$routes->get('admin/manage_district', 'Admin::manage_district');
$routes->get('admin/adddistricts', 'Admin::adddistricts');
$routes->post('admin/adddistricts', 'Admin::adddistricts');
$routes->get('admin/adddistricts/(:num)', 'Admin::adddistricts/$1');
$routes->post('admin/adddistricts/(:num)', 'Admin::adddistricts/$1');
$routes->get('admin/check_districtname', 'Admin::check_districtname');
$routes->get('admin/check_districtadmin', 'Admin::check_districtname');
$routes->get('admin/check_districtadmin_email', 'Admin::check_districtname');
$routes->get('admin/deactivate_districts/(:num)', 'Admin::deactivate_districts/$1');
$routes->get('admin/activate_districts/(:num)', 'Admin::activate_districts/$1');
$routes->get('admin/delete_districts/(:num)', 'Admin::delete_districts/$1');
$routes->get('admin/manage_schools', 'Admin::manage_schools');

$routes->get('admin/addschool', 'Admin::addschool');
$routes->post('admin/addschool', 'Admin::addschool');
$routes->get('admin/addschool/(:num)', 'Admin::addschool/$1');
$routes->post('admin/addschool/(:num)', 'Admin::addschool/$1');
$routes->get('admin/check_schoolname/(:num)', 'Admin::check_schoolname/$1');
$routes->get('admin/check_schooladmin/(:num)', 'Admin::check_schooladmin/$1');
$routes->get('admin/manage_surveys', 'Admin::manage_surveys');

$routes->get('admin/documents_timeline', 'Admin::documents_timeline');
$routes->post('admin/school_lists_not_all', 'Admin::school_lists_not_all');
$routes->post('admin/get_documents_timeline', 'Admin::get_documents_timeline');

$routes->get('admin/manage_templates', 'Admin::manage_templates');





