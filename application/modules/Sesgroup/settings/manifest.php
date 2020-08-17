<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
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
  $groupsRoute = $setting->getSetting('sesgroup.groups.manifest', 'group-communities');
  $groupRoute = $setting->getSetting('sesgroup.group.manifest', 'group-community');
}
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesgroup',
        //'sku' => 'sesgroup',
        'version' => '4.10.5p1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesgroup',
        'title' => 'SES - Group Communities Plugin',
        'description' => 'SES - Group Communities Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesgroup/settings/install.php',
            'class' => 'Sesgroup_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' => array(
            'application/modules/Sesgroup',
        ),
        'files' => array(
            'application/languages/en/sesgroup.csv',
            'public/admin/groups-category-banner.jpg',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesgroup_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onCommentCreateAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeCreateAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onCoreCommentDeleteAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onActivityCommentDeleteAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeDeleteAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sesgroup_Plugin_Core'
        ),
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Sesgroup_Plugin_Core',
        ),
    ),
    //composer
    'composer' => array(
        'sesgroup_photo' => array(
            'script' => array('_composeSesgroupAlbum.tpl', 'sesgroup'),
            'plugin' => 'Sesgroup_Plugin_Albumcomposer',
        ),
        'sesgroup' => array(
            'script' => array('_composeSesgroup.tpl', 'sesgroup'),
            'plugin' => 'Sesgroup_Plugin_Composer',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesgroup_category',
        'sesgroup_group',
        'sesgroup_dashboards',
        'sesgroup_follower',
        'sesgroup_favourite',
        'sesgroup_location',
        'sesgroup_locationphoto',
        'sesgroup_announcement',
        'sesgroup_memberrole',
        'sesgroup_crosspost',
        'sesgroup_grouprole',
        'sesgroup_album',
        'sesgroup_photo',
        'sesgroup_managegroupapp',
        'sesgroup_service',
        'sesgroup_claim',
        'sesgroup_rule'
    ),
    'routes' => array(
        'sesgroup_profile' => array(
            'route' => $groupRoute . '/:id/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),
        'sesgroupalbum_general' => array(
          'route' => $groupRoute.'-albums/:action/*',
          'defaults' => array(
            'module' => 'sesgroup',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
        ),
        'sesgroup_specific_album' => array(
					'route' =>  $groupRoute.'-album/:action/:album_id/*',
					'defaults' => array(
            'module' => 'sesgroup',
            'controller' => 'album',
            'action' => 'view',
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
        ),
        'sesgroup_photo_view' => array(
          'route' => $groupRoute.'/photo/:action/*',
          'defaults' => array(
            'module' => 'sesgroup',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
        ),
        'sesgroup_extended' => array(
            'route' => $groupsRoute . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
        'sesgroup_dashboard' => array(
            'route' => $groupsRoute . '/dashboard/:action/:group_id/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
        ),
        'sesgroup_general' => array(
            'route' => $groupsRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'index',
                'action' => 'welcome',
            ),
            'reqs' => array(
                'action' => '(sesbackuplandingppage|welcome|browse|create|delete|manage|home|edit|delete|tags|browse-locations|contact|close|show-login-page|pinboard|featured|sponsored|hot|verified|localpick|claim|claim-requests|package|transactions)',
            )
        ),
        'sesgroup_category_view' => array(
            'route' => $groupsRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'sesgroup_category' => array(
            'route' => $groupsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'sesgroup_join_group' => array(
            'route' => $groupRoute . '/:action/:group_id/*',
            'defaults' => array(
                'module' => 'sesgroup',
                'controller' => 'join',
                'action' => 'create',
            ),
            'reqs' => array(
                'action' => '(create|record|edit|delete)',
            )
        ),
    )
);
