<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
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
$pagesRoute = 'page-directories';
$pageRoute = 'page-directory';
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $pagesRoute = $setting->getSetting('sespage.pages.manifest', 'page-directories');
  $pageRoute = $setting->getSetting('sespage.page.manifest', 'page-directory');
}
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespage',
        //'sku' => 'sespage',
        'version' => '4.10.5p2',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sespage',
        'title' => 'SES - Page Directories Plugin',
        'description' => 'SES - Page Directories Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespage/settings/install.php',
            'class' => 'Sespage_Installer',
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
            'application/modules/Sespage',
        ),
        'files' => array(
            'application/languages/en/sespage.csv',
            'public/admin/pages-category-banner.jpg',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sespage_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onCommentCreateAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeCreateAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onCoreCommentDeleteAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onActivityCommentDeleteAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeDeleteAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sespage_Plugin_Core'
        ),
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Sespage_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sespage_Plugin_Core'
        ),
    ),
    //composer
    'composer' => array(
        'sespage_photo' => array(
            'script' => array('_composeSespageAlbum.tpl', 'sespage'),
            'plugin' => 'Sespage_Plugin_Albumcomposer',
        ),
        'sespage' => array(
            'script' => array('_composeSespage.tpl', 'sespage'),
            'plugin' => 'Sespage_Plugin_Composer',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespage_category',
        'sespage_page',
        'sespage_dashboards',
        'sespage_follower',
        'sespage_favourite',
        'sespage_location',
        'sespage_locationphoto',
        'sespage_announcement',
        'sespage_memberrole',
        'sespage_crosspost',
        'sespage_pagerole',
        'sespage_album',
        'sespage_photo',
        'sespage_managepageapp',
        'sespage_service',
        'sespage_claim',
    ),
    'routes' => array(
        'sespage_profile' => array(
            'route' => $pageRoute . '/:id/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),
        'sespagealbum_general' => array(
          'route' => $pageRoute.'-albums/:action/*',
          'defaults' => array(
            'module' => 'sespage',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
        ),
        'sespage_specific_album' => array(
					'route' =>  $pageRoute.'-album/:action/:album_id/*',
					'defaults' => array(
            'module' => 'sespage',
            'controller' => 'album',
            'action' => 'view',
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
        ),
        'sespage_photo_view' => array(
          'route' => $pageRoute.'/photo/:action/*',
          'defaults' => array(
            'module' => 'sespage',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
        ),
        'sespage_extended' => array(
            'route' => $pagesRoute . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
        'sespage_dashboard' => array(
            'route' => $pagesRoute . '/dashboard/:action/:page_id/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
        ),
        'sespage_general' => array(
            'route' => $pagesRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'index',
                'action' => 'welcome',
            ),
            'reqs' => array(
                'action' => '(sesbackuplandingppage|welcome|browse|create|delete|manage|home|edit|delete|tags|browse-locations|contact|close|show-login-page|pinboard|featured|sponsored|hot|verified|localpick|claim|claim-requests|package|transactions|top-pages)',
            )
        ),
        'sespage_category_view' => array(
            'route' => $pagesRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'sespage_category' => array(
            'route' => $pagesRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sespage',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
    )
);
