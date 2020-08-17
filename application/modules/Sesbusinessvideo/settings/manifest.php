<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "businessvideos";
$videoRoute = "businessvideo";
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
  $videosRoute = $setting->getSetting('sesbusinessvideo.videos.manifest', 'businessvideos');
  $videoRoute = $setting->getSetting('sesbusinessvideo.video.manifest', 'businessvideo');
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesbusinessvideo',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesbusinessvideo',
        'title' => 'SES - Business Videos Extension',
        'description' => 'SES - Business Videos Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesbusinessvideo/settings/install.php',
            'class' => 'Sesbusinessvideo_Installer',
        ),
        'directories' => array(
            'application/modules/Sesbusinessvideo',
        ),
        'files' => array(
            'application/languages/en/sesbusinessvideo.csv',
        ),
    ),
		// Compose
    'composer' => array(
        'sesbusinessvideo' => array(
            'script' => array('_composeSesbusinessVideo.tpl', 'sesbusinessvideo'),
            'plugin' => 'Sesbusinessvideo_Plugin_Composer',
            'auth' => array('businessvideo','upload'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'businessvideo', 'watchlater',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesbusinessvideo_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesbusinessvideo_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesbusinessvideo_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesbusinessvideo_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesbusinessvideo_general' => array(
            'route' => $videosRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesbusinessvideo',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|list|view|share|tags|edit|delete|location|locations|get-video|browse)',
            )
        ),
        //lightbox all videos
        'sesbusinessvideo_allvideos' => array(
            'route' => $videoRoute.'/all-videos/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesbusinessvideo',
                'controller' => 'index',
                'action' => 'all-videos',
                'slug' => '',
            )
        ),
        //lightbox video
        'sesbusinessvideo_lightbox' => array(
            'route' => $videoRoute.'/imageviewerdetail/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesbusinessvideo',
                'controller' => 'index',
                'action' => 'imageviewerdetail',
                'slug' => '',
            )
        ),
        'sesbusinessvideo_view' => array(
            'route' => $videoRoute.'/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesbusinessvideo',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+'
            )
        ),
        'sesbusinessvideo_watchlater' => array(
            'route' => $videosRoute . '/watchlater/:action/*',
            'defaults' => array(
                'module' => 'sesbusinessvideo',
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
