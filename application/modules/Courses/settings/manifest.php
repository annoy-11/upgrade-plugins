<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $coursesRoute = $setting->getSetting('courses.plural.manifest', 'courses');
  $courseRoute = $setting->getSetting('courses.singular.manifest', 'course');
}
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'courses',
    'version' => '4.10.5p1',
    //'sku' => 'courses',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.10.5',
      ),
    ),
    'path' => 'application/modules/Courses',
    'title' => 'Courses - Learning Management System',
    'description' => 'Courses - Learning Management System',
    'author' => '<a href="http://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'path' => 'application/modules/Courses/settings/install.php',
      'class' => 'Courses_Installer',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      'application/modules/Courses',
      'application/modules/Eclassroom',
    ),
    'files' =>
    array (
      'application/languages/en/courses.csv',
      'application/languages/en/eclassroom.csv',
    ),
  ),
  'hooks' => array(
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Courses_Plugin_Core',
      ),
      array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onCommentCreateAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onActivityLikeCreateAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onCoreLikeCreateAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onCoreCommentDeleteAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onActivityCommentDeleteAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onActivityLikeDeleteAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onCoreLikeDeleteAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onCoreLikeDeleteBefore',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'onActivitySubmittedAfter',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
          'event' => 'getAdminNotifications',
          'resource' => 'Courses_Plugin_Core',
      ),
      array(
          'event' => 'onUserDeleteBefore',
          'resource' => 'Courses_Plugin_Core'
      ),
      array(
        'event' => 'onUserLoginAfter',
        'resource' => 'Courses_Plugin_Core'
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
      'courses_category',
      'courses',
      'courses_claim',
      'courses_memberrole',
      'courses_test',
      'courses_usertest',
      'courses_testquestion',
      'courses_testanswer',
      'courses_lecture',
      'courses_cartcourse',
      'courses_transaction',
      'courses_review',
      'courses_parameter',
      'courses_package',
      'courses_orderspackage',
      'courses_photo',
      'courses_album',
      'courses_dashboard',
      'courses_offer',
      'courses_slides',
      'courses_announcement',
      'courses_service',
      'courses_location',
      'courses_locationphoto',
      'courses_wishlist',
      'courses_taxstate',
      'courses_taxes',
      'courses_country',
      'courses_state',
      'courses_order',
      'courses_gateway',
      'courses_managecourseapps',
      'courses_usergateway',
      'courses_userpayrequest'
  ),
  'routes' => array(
    'lecture_general' => array(
        'route' => $coursesRoute . '/lecture/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'lecture',
            'action' => 'create',
        ),
        'reqs' => array(
            'action' => '(create|edit|view)',
        )
    ),
    'tests_general' => array(
        'route' => $coursesRoute . '/test/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'test',
            'action' => 'create',
        ),
        'reqs' => array(
            'action' => '(create)',
        )
    ),
    'lecture_profile' => array(
        'route' =>  'lecture-view/:lecture_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'lecture-profile',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '(index)',
        )
    ),
    'courses_general' => array(
        'route' => $coursesRoute . '/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'index',
            'action' => 'welcome',
        ),
        'reqs' => array(
            'action' => '(page|create|delete|welcome|browse|create-lecture|create-test|compare-course|home|tags|manage|compare|browse-review|hot|verified|featured|sponsored|claim|claim-requests|browse-instructor)',
        )
    ),
    'courses_dashboard' => array(
        'route' => $coursesRoute .'-dashboard/:action/:course_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'dashboard',
            'action' => 'edit',
        ),
          'reqs' => array(
            'action' => '(edit|account-details|contact-information|policy|manage-lectures|manage-tests|taxes|create-tax|edit-tax|manage-locations|create-location|states|enable-location-tax|delete-location-tax|payment-requests|payment-request|payment-transaction|detail-payment|delete-payment|style|sales-stats|sales-reports|mainphoto|course-policy|profile-field|manage-orders|enable-tax|seo|overview|advertise-course|announcement|post-announcement|edit-announcement|delete-announcement|send-updates|course-roles|manage-courseapps|managecourseonoffapps|manage-location|add-location|edit-location|add-photos|compose-upload|remove|delete-location)',
        )
    ),
    'courses_profile' => array(
        'route' => $courseRoute . '-view/:course_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'profile',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '(index)',
        )
    ),
    'courses_category_view' => array(
        'route' => $coursesRoute . '/category/:category_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'category',
            'action' => 'index',
        )
    ),
      'courses_account_details' => array(
        'route' => $coursesRoute . '/:course_id/gateway_type/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'dashboard',
            'action' => 'account-details',
        ),
    ),
    'courses_account' =>array(
        'route' => $coursesRoute.'/manage-account/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'manage',
            'action' => 'index',
        ),
    ),
    'courses_extended' => array(
        'route' => $courseRoute . '/:controller/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'index',
            'action' => 'index',
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'courses_category' => array(
        'route' => $courseRoute . '/categories/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'category',
            'action' => 'browse',
        ),
        'reqs' => array(
            'action' => '(index|browse)',
        )
    ),
    'courses_order' => array(
        'route' => $coursesRoute.'/order/:action/:order_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'order',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '(index|view|print-invoice)',
        )
    ),
    'coursesreview_view' => array(
        'route' => $coursesRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete|edit-review)',
            'review_id' => '\d+'
        )
    ),
    'courses_wishlist' => array(
        'route' => $coursesRoute.'/wishlist/:action',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'wishlist',
            'action' => 'browse',
        ),
        'reqs' => array(
            'action' => '(add)',
        )
    ),
    'courses_wishlist_view' => array(
        'route' => $coursesRoute.'/wishlist/:wishlist_id/:slug/:action/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'wishlist',
            'action' => 'view',
            'slug' => '',
        ),
        'reqs' => array(
            'wishlist_id' => '\d+',
            'action' => '(add|edit|delete)',
        )
    ),
    'courses_cart' => array(
      'route' => $courseRoute.'/cart/:action/*',
      'defaults' => array(
          'module' => 'courses',
          'controller' => 'cart',
          'action' => 'checkout',
      ),
    ),
    'courses_view' => array(
        'route' => $courseRoute.'/:user_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'index',
            'action' => 'list',
        ),
        'reqs' => array(
            'user_id' => '\d+',
        ),
    ),
    'courses_specific' => array(
        'route' => $coursesRoute.'/:action/:course_id/*',
        'defaults' => array(
            'module' => 'courses',
            'controller' => 'index',
            'action' => 'index',
        ),
        'reqs' => array(
            'course_id' => '\d+',
            'action' => '(delete|edit)',
        ),
    ),
    'courses_payment' => array(
      'route' => $coursesRoute.'/payment/:order_id/:action/*',
      'defaults' => array(
          'module' => 'courses',
          'controller' => 'payment',
          'action' => 'index',
      ),
    ),
  )
);
