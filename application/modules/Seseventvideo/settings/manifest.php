<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "videos";
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
  $videosRoute = $setting->getSetting('seseventvideo.videos.manifest', 'eventvideos');
  $videoRoute = $setting->getSetting('seseventvideo.video.manifest', 'eventvideo');
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'seseventvideo',
        'version' => '4.10.5',
        'path' => 'application/modules/Seseventvideo',
        'title' => 'SES - Advanced Events - Videos Extension',
        'description' => 'SES - Advanced Events - Videos Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Seseventvideo/settings/install.php',
            'class' => 'Seseventvideo_Installer',
        ),
        'directories' => array(
            'application/modules/Seseventvideo',
        ),
        'files' => array(
            'application/languages/en/seseventvideo.csv',
        ),
    ),
		// Compose
    'composer' => array(
        'seseventvideo' => array(
            'script' => array('_composeSeseventVideo.tpl', 'seseventvideo'),
            'plugin' => 'Seseventvideo_Plugin_Composer',
            'auth' => array('seseventvideo_video','upload'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'seseventvideo_video', 'watchlater','seseventvideo_watchlater'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Seseventvideo_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Seseventvideo_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Seseventvideo_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Seseventvideo_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'seseventvideo_general' => array(
            'route' => $videosRoute . '/:action/*',
            'defaults' => array(
                'module' => 'seseventvideo',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|list|view|share|tags|edit|delete|location|locations|get-video)',
            )
        ),
        //lightbox all videos
        'seseventvideo_allvideos' => array(
            'route' => $videoRoute.'/all-videos/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'seseventvideo',
                'controller' => 'index',
                'action' => 'all-videos',
                'slug' => '',
            )
        ),
        //lightbox video
        'seseventvideo_lightbox' => array(
            'route' => $videoRoute.'/imageviewerdetail/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'seseventvideo',
                'controller' => 'index',
                'action' => 'imageviewerdetail',
                'slug' => '',
            )
        ),
        'seseventvideo_view' => array(
            'route' => $videoRoute.'/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'seseventvideo',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+'
            )
        ),
        'seseventvideo_watchlater' => array(
            'route' => $videosRoute . '/watchlater/:action/*',
            'defaults' => array(
                'module' => 'seseventvideo',
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
