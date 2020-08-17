<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "pagevideos";
$videoRoute = "pagevideo";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $videosRoute = $setting->getSetting('sespagevideo.videos.manifest', 'pagevideos');
  $videoRoute = $setting->getSetting('sespagevideo.video.manifest', 'pagevideo');
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sespagevideo',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sespagevideo',
        'title' => 'SES - Page Videos Extension',
        'description' => 'SES - Page Videos Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sespagevideo/settings/install.php',
            'class' => 'Sespagevideo_Installer',
        ),
        'directories' => array(
            'application/modules/Sespagevideo',
        ),
        'files' => array(
            'application/languages/en/sespagevideo.csv',
        ),
    ),
		// Compose
    'composer' => array(
        'sespagevideo' => array(
            'script' => array('_composeSespageVideo.tpl', 'sespagevideo'),
            'plugin' => 'Sespagevideo_Plugin_Composer',
            'auth' => array('pagevideo','upload'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'pagevideo', 'watchlater',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sespagevideo_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sespagevideo_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sespagevideo_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sespagevideo_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sespagevideo_general' => array(
            'route' => $videosRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sespagevideo',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|list|view|share|tags|edit|delete|location|locations|get-video|browse)',
            )
        ),
        //lightbox all videos
        'sespagevideo_allvideos' => array(
            'route' => $videoRoute.'/all-videos/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sespagevideo',
                'controller' => 'index',
                'action' => 'all-videos',
                'slug' => '',
            )
        ),
        //lightbox video
        'sespagevideo_lightbox' => array(
            'route' => $videoRoute.'/imageviewerdetail/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sespagevideo',
                'controller' => 'index',
                'action' => 'imageviewerdetail',
                'slug' => '',
            )
        ),
        'sespagevideo_view' => array(
            'route' => $videoRoute.'/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sespagevideo',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+'
            )
        ),
        'sespagevideo_watchlater' => array(
            'route' => $videosRoute . '/watchlater/:action/*',
            'defaults' => array(
                'module' => 'sespagevideo',
                'controller' => 'watchlater',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse|add)',
            )
        ),
    ),
);
?>
