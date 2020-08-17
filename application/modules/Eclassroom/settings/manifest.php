<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
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
  $classroomsRoute = $setting->getSetting('eclassroom.plural.manifest', 'classrooms');
  $classroomRoute = $setting->getSetting('eclassroom.singular.manifest', 'classroom');
}
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'eclassroom',
    'version' => '4.10.5',
    'sku' => 'courses',
    'path' => 'application/modules/Eclassroom',
    'title' => '<span style="color:#DDDDDD">Courses - Learning Management System</span>',
    'description' => '',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Eclassroom',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/eclassroom.csv',
    ),
  ),
   'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Eclassroom_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onCommentCreateAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeCreateAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onCoreCommentDeleteAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onActivityCommentDeleteAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeDeleteAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Eclassroom_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Eclassroom_Plugin_Core'
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'eclassroom_category',
        'classroom',
        'eclassroom_album',
        'eclassroom_announcement',
        'eclassroom_service',
        'eclassroom_album',
        'eclassroom_photo',
        'eclassroom_memberrole',
        'eclassroom_classroomroles',
        'eclassroom_claim',
        'eclassroom_manageclassroomapps',
        'eclassroom_service',
        'eclassroom_location',
        'eclassroom_review',
        'eclassroom_locationphoto',
        'eclassroom_parameter'
    ),
    'routes' => array(
        'eclassroom_general' => array(
            'route' => $classroomsRoute. '/:action/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|browse|create|delete|contact|claim|claim-requests|tags|browse-locations|verified|sponsored|featured|hot|manage|browse-review)',
            )
        ),
        'eclassroom_dashboard' => array(
            'route' => $classroomRoute .'-dashboard/:action/:classroom_id/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
        ),
        'eclassroom_profile' => array(
            'route' => $classroomRoute . '-profile/:id/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),
        'eclassroom_category_view' => array(
            'route' => $classroomsRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'eclassroom_photo_view' => array(
          'route' => $classroomRoute.'/photo/:action/*',
          'defaults' => array(
            'module' => 'eclassroom',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
        ),
        'eclassroom_specific_album' => array(
            'route' =>  $classroomRoute.'-album/:action/:album_id/*',
            'defaults' => array(
            'module' => 'eclassroom',
            'controller' => 'album',
            'action' => 'view',
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
        ),
        'eclassroom_category' => array(
            'route' => $classroomsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'eclassroomalbum_general' => array(
          'route' => $classroomRoute.'-albums/:action/*',
          'defaults' => array(
            'module' => 'eclassroom',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
        ),
        'eclassroom_extended' => array(
            'route' => $classroomRoute . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
        'eclassroomreview_view' => array(
            'route' => $classroomsRoute.'/reviews/:action/:review_id/:slug',
            'defaults' => array(
                'module' => 'eclassroom',
                'controller' => 'review',
                'action' => 'view',
                'slug' => ''
            ),
            'reqs' => array(
                'action' => '(edit|view|delete|edit-review)',
                'review_id' => '\d+'
            )
        ),
    )
); ?>
