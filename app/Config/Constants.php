<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

define('BASE_URL','http://localhost/ci4-csos/');




define('ADMIN_CSS', "assets/admin/css/");

define('ADMIN_JS', "assets/admin/js/");

define('ADMIN_IMG', "assets/admin/img/");

define('ADMIN_IMAGES', "assets/admin/images/");

define('ADMIN_VENDORS', "assets/admin/vendors/");

define("ADMIN_BASIC_IMAGE", BASE_URL."assets/admin/img/");

/********** Views folder **********/

define('UPLOAD_FLAGS','uploads/flags/');

define('UPLOAD_PROFILEPICS','uploads/profileimages/');

define('UPLOAD_SYMBOLS','uploads/symbols/');

define('ADMIN_VIEW','/admin/');

define('ADMIN_USERVIEW','admin/user/');

/********* CONTROLLERS **********/

define('ADMIN_DASHBOARD','admin/dashboard');

define('ADMIN_LOGOUT', 'admin/logout');

define('ADMIN_MANAGESTATES', 'admin/manage_states');

define('ADMIN_ADDSTATES', 'admin/addstates');



define('ADMIN_ADDDISTRICTS', 'admin/adddistricts');

define('ADMIN_MANAGEDISTRICT', 'admin/manage_district');

define('ADMIN_MANAGEDISTRICTADMIN', 'admin/manage_districtadmin');

define('ADMIN_ADDDISTRICTADMIN', 'admin/add_districtadmin');

define('ADMIN_MANAGESCHOOLS', 'admin/manage_schools');

define('ADMIN_ADDSCHOOLS', 'admin/addschools');

/***********DATABASE AND TABLES*************/

define('ADMIN_DETAILS','go_admin');
define('DISTRICTADMIN_DETAILS','go_district_admin');

define('STATES_DETAILS','go_state');

define('DISTRICT_DETAILS','go_districts');

define('SCHOOL_DETAILS','go_schools');

define('GRADE_DETAILS','go_schoolgrade');

define('CREATE_GRADE','go_grade');

define('CLASS_DETAILS','go_class');

define('TEACHER_DETAILS','go_teacher');

define('VIRTUALTEACHER_DETAILS','go_teacher');

define('TEACHER_ROLE_DETAILS','go_teacher_role');

define('STUDENT_DETAILS','go_student');

define('DEPARTMENTNAME_DETAILS','go_departmentname');

define('DEPARTMENT_DETAILS','go_department');

define('EVENT_DETAILS','go_events');

define('GROUP_DETAILS','go_groups');

define('JOINED_EVENTS','joined_events');

define('REJECTED_EVENTS','rejected_events');

define('SAVED_PAPERS','saved_papers');

define('MY_PAPER','mypaper');

define('SUBMITTED_PAPERS','submitted_paper');

define('PAPER_COMMENTS','paper_comments');

define('VOCABULARY_DETAILS','vocabulary_details');

define('TRANSITIONS_DETAILS','transitions_details');

define('ACADEMICWORDS_DETAILS','academicwords_details');



define('VOCABULARY_CATEGORY','vocabulary_category');

define('TRANSITIONS_CATEGORY','transitions_category');

define('ACADEMICWORDS_CATEGORY','academicwords_category');

define('COMMENT_DETAILS','comment_details');

define('RUBRICK_DETAILS','go_rubicks');

define('AUX_RUBRICK_DETAILS','go_aux_rubicks');



define('SCORING_DETAILS','go_scoring');

define('TWOPOINT_RUBRICK_DETAILS','go_twopoint_rubicks');

define('REPORT_DETAILS','report_builder');

define('THIRD_PARTY','third_party');

define('THIRD_PARTY_USERS','third_party_users');

define('THIRD_PARTY_COUNTHISTORY','count_history');

define('THIRD_PARTY_TEACHERHISTORY','teacher_history');

define('SET_TEACHER','set_teacher');

define('TIME_TABLE','set_timetable');

define('TEACHER_TIME_TABLE','set_teacher_timetable');

define('WORD_DICTIONERY','word1');

define('DEFINITION_DICTIONERY','word');

define('SYMBOL_COMMENTS','symbol_comments');

define('MISSPELLED_WORDS','misspelled_words');

define('TEMPLATE_DETAILS','go_template');

define('DEPARTMENTCODE_DETAILS','go_dept_code');

define('STUDENT_ACTIVITIES','student_activities');

define('STICKY_NOTES','sticky_notes');

define('SUBMITTED_STICKY_NOTES','submitted_notes');

define('VIRTUALTEACHER_COURSE','virtual_teacher_course');



define('FAQS','faqs');

define('UPDATES','updates');