<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-07-13 00:00:00 SocialEngineSolutions $
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
  $businessesRoute = $setting->getSetting('sesbusiness.businesses.manifest', 'business-directories');
  $businessRoute = $setting->getSetting('sesbusiness.business.manifest', 'business-directory');
}
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesbusiness',
        //'sku' => 'sesbusiness',
        'version' => '4.10.5p1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesbusiness',
        'title' => 'SES - Business Directories Plugin',
        'description' => 'SES - Business Directories Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesbusiness/settings/install.php',
            'class' => 'Sesbusiness_Installer',
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
            'application/modules/Sesbusiness',
        ),
        'files' => array(
            'application/languages/en/sesbusiness.csv',
            'public/admin/businesses-category-banner.jpg',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesbusiness_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onCommentCreateAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeCreateAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onCoreCommentDeleteAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onActivityCommentDeleteAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeDeleteAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Sesbusiness_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesbusiness_Plugin_Core'
        ),
    ),
    //composer
    'composer' => array(
        'sesbusiness_photo' => array(
            'script' => array('_composeSesbusinessAlbum.tpl', 'sesbusiness'),
            'plugin' => 'Sesbusiness_Plugin_Albumcomposer',
        ),
        'sesbusiness' => array(
            'script' => array('_composeSesbusiness.tpl', 'sesbusiness'),
            'plugin' => 'Sesbusiness_Plugin_Composer',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesbusiness_category',
        'businesses',
        'sesbusiness_dashboards',
        'sesbusiness_follower',
        'sesbusiness_favourite',
        'sesbusiness_location',
        'sesbusiness_locationphoto',
        'sesbusiness_announcement',
        'sesbusiness_memberrole',
        'sesbusiness_crosspost',
        'sesbusiness_businessrole',
        'sesbusiness_album',
        'sesbusiness_photo',
        'sesbusiness_managebusinessapp',
        'sesbusiness_service',
        'sesbusiness_claim',
    ),
    'routes' => array(
        'sesbusiness_profile' => array(
            'route' => $businessRoute . '/:id/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),
        'sesbusinessalbum_general' => array(
          'route' => $businessRoute.'-albums/:action/*',
          'defaults' => array(
            'module' => 'sesbusiness',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
        ),
        'sesbusiness_specific_album' => array(
					'route' =>  $businessRoute.'-album/:action/:album_id/*',
					'defaults' => array(
            'module' => 'sesbusiness',
            'controller' => 'album',
            'action' => 'view',
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
        ),
        'sesbusiness_photo_view' => array(
          'route' => $businessRoute.'/photo/:action/*',
          'defaults' => array(
            'module' => 'sesbusiness',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
        ),
        'sesbusiness_extended' => array(
            'route' => $businessesRoute . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
        'sesbusiness_dashboard' => array(
            'route' => $businessesRoute . '/dashboard/:action/:business_id/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
        ),
        'sesbusiness_general' => array(
            'route' => $businessesRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'index',
                'action' => 'welcome',
            ),
            'reqs' => array(
                'action' => '(sesbackuplandingppage|welcome|browse|create|delete|manage|home|edit|delete|tags|browse-locations|contact|close|show-login-page|pinboard|featured|sponsored|hot|verified|localpick|claim|claim-requests|package|transactions)',
            )
        ),
        'sesbusiness_category_view' => array(
            'route' => $businessesRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'sesbusiness_category' => array(
            'route' => $businessesRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesbusiness',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
    )
);
