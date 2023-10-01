<?php
namespace Config;

use CodeIgniter\Router\RouteCollection;


/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('School');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'School::index');
$routes->get('school/login', 'School::index');
// $routes->get('/', 'Home::index');
$routes->get('administrator', 'Home::index');
$routes->get('admin', 'Home::index');
$routes->post('adminlogin', 'Home::login');
$routes->get('admin/logout', 'Home::logout');


$routes->post('school/login', 'Home::sdLogin');

$routes->get('district/dashboard', 'District::dashboard');
$routes->get('district/manage_schools', 'District::manage_schools');
$routes->get('district/addschool', 'District::addschool');
$routes->post('district/addschool', 'District::addschool');
$routes->get('district/addschool/(:num)', 'District::addschool/$1');
$routes->post('district/addschool/(:num)', 'District::addschool/$1');
$routes->get('district/manage_reviewed_surveys', 'District::manage_reviewed_surveys');
$routes->get('district/delete_survey', 'District::delete_survey');
$routes->get('district/manage_submitted_surveys', 'District::manage_submitted_surveys');
$routes->get('district/manage_school_reports', 'District::manage_school_reports');
$routes->get('district/delete_school/(:num)', 'District::delete_school/$1');

// $routes->get('school/addtemplate_step2/(:num)', 'School::addtemplate_step2/$1');



$routes->get('admin/dashboard', 'Admin::index');
$routes->get('admin/admin_setting', 'Admin::admin_setting');
$routes->post('admin/admin_setting', 'Admin::admin_setting');
$routes->get('admin/terms_of_use', 'Admin::terms_of_use');
$routes->get('admin/privacy_policy', 'Admin::privacy_policy');
$routes->get('admin/pages', 'Admin::pages');
$routes->get('admin/addpage/(:num)', 'Admin::addpage/$1');

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
$routes->get('admin/delete_school/(:num)', 'Admin::delete_school/$1');
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
$routes->get('admin/addtemplate', 'Admin::addtemplate');
$routes->get('admin/addtemplate/(:num)', 'Admin::addtemplate/$1');
$routes->get('admin/addtemplate_step2/(:num)', 'Admin::addtemplate_step2/$1');
$routes->get('admin/addtemplate_step3/(:num)', 'Admin::addtemplate_step3/$1');
$routes->post('admin/save_template_content', 'Admin::save_template_content');
$routes->post('admin/save_template_content_step2', 'Admin::save_template_content_step2');
$routes->post('admin/save_template_content_step3', 'Admin::save_template_content_step3');
$routes->post('admin/ajax_create_master_template', 'Admin::ajax_create_master_template');
$routes->get('admin/deactivate_templates/(:num)', 'Admin::deactivate_templates/$1');
$routes->get('admin/activate_templates/(:num)', 'Admin::activate_templates/$1');
$routes->post('admin/take_a_copy_master_template', 'Admin::take_a_copy_master_template');
$routes->get('admin/delete_templates/(:num)', 'Admin::delete_templates/$1');

$routes->get('admin/manage_full_surveys', 'Admin::manage_full_surveys');
$routes->get('admin/manage_full_submitted_surveys', 'Admin::manage_full_submitted_surveys');
$routes->get('admin/manage_full_reviewed_surveys', 'Admin::manage_full_reviewed_surveys');
$routes->post('admin/school_lists', 'Admin::school_lists');
$routes->post('admin/get_school_full_surveys', 'Admin::get_school_full_surveys');
$routes->get('admin/add_submitted_template/(:num)', 'Admin::add_submitted_template/$1');
$routes->get('admin/add_submitted_template_step2/(:num)', 'Admin::add_submitted_template_step2/$1');
$routes->get('admin/add_submitted_template_step3/(:num)', 'Admin::add_submitted_template_step3/$1');
$routes->post('admin/save_template_content_submitted', 'Admin::save_template_content_submitted');
$routes->post('admin/save_template_content_step2_submitted', 'Admin::save_template_content_step2_submitted');

$routes->post('admin/print_pdf_sections', 'Admin::print_pdf_sections');
$routes->post('admin/print_pdf', 'Admin::print_pdf');
$routes->post('admin/download_pdf', 'Admin::download_pdf');
$routes->post('admin/download_pdf_sections', 'Admin::download_pdf_sections');

$routes->get('admin/manage_reviewed_surveys', 'Admin::manage_reviewed_surveys');
$routes->get('admin/delete_survey', 'Admin::delete_survey');
$routes->get('admin/manage_submitted_surveys', 'Admin::manage_submitted_surveys');
$routes->get('admin/manage_school_reports', 'Admin::manage_school_reports');

$routes->post('admin/take_a_copy', 'Admin::take_a_copy');
$routes->post('admin/add_comment_specifics', 'Admin::add_comment_specifics');
$routes->post('admin/show_existing_comments', 'Admin::show_existing_comments');

$routes->get('admin/delete_report_template/(:num)', 'Admin::delete_report_template/$1');
$routes->get('admin/delete_report_attachment/(:num)', 'Admin::delete_report_attachment/$1');
$routes->get('admin/manage_district_reports', 'Admin::manage_district_reports');

$routes->get('admin/manage_reports', 'Admin::manage_reports');

$routes->get('admin/view_result_reports', 'Admin::view_result_reports');
$routes->post('admin/reports_result', 'Admin::reports_result');
$routes->post('admin/school_lists_checkbox', 'Admin::school_lists_checkbox');
$routes->post('admin/set_due_dates', 'Admin::set_due_dates');
$routes->post('admin/filter_by_district_search', 'Admin::filter_by_district_search');
$routes->post('admin/filter_by_school_search', 'Admin::filter_by_school_search');
$routes->get('admin/principal_apportionment', 'Admin::principal_apportionment');
$routes->post('admin/get_reports_from_school', 'Admin::get_reports_from_school');
$routes->post('admin/change_date_report', 'Admin::change_date_report');
$routes->post('admin/update_principal_apportionment', 'Admin::update_principal_apportionment');











