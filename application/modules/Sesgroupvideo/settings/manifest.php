<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "groupvideos";
$videoRoute = "groupvideo";
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
  $videosRoute = $setting->getSetting('sesgroupvideo.videos.manifest', 'groupvideos');
  $videoRoute = $setting->getSetting('sesgroupvideo.video.manifest', 'groupvideo');
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesgroupvideo',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesgroupvideo',
        'title' => 'SES - Group Videos Extension',
        'description' => 'SES - Group Videos Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesgroupvideo/settings/install.php',
            'class' => 'Sesgroupvideo_Installer',
        ),
        'directories' => array(
            'application/modules/Sesgroupvideo',
        ),
        'files' => array(
            'application/languages/en/sesgroupvideo.csv',
        ),
    ),
		// Compose
    'composer' => array(
        'sesgroupvideo' => array(
            'script' => array('_composeSesgroupVideo.tpl', 'sesgroupvideo'),
            'plugin' => 'Sesgroupvideo_Plugin_Composer',
            'auth' => array('groupvideo','upload'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'groupvideo', 'watchlater',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesgroupvideo_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesgroupvideo_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesgroupvideo_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesgroupvideo_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesgroupvideo_general' => array(
            'route' => $videosRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesgroupvideo',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|list|view|share|tags|edit|delete|location|locations|get-video|browse)',
            )
        ),
        //lightbox all videos
        'sesgroupvideo_allvideos' => array(
            'route' => $videoRoute.'/all-videos/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesgroupvideo',
                'controller' => 'index',
                'action' => 'all-videos',
                'slug' => '',
            )
        ),
        //lightbox video
        'sesgroupvideo_lightbox' => array(
            'route' => $videoRoute.'/imageviewerdetail/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesgroupvideo',
                'controller' => 'index',
                'action' => 'imageviewerdetail',
                'slug' => '',
            )
        ),
        'sesgroupvideo_view' => array(
            'route' => $videoRoute.'/:user_id/:video_id/:slug/*',
            'defaults' => array(
                'module' => 'sesgroupvideo',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+'
            )
        ),
        'sesgroupvideo_watchlater' => array(
            'route' => $videosRoute . '/watchlater/:action/*',
            'defaults' => array(
                'module' => 'sesgroupvideo',
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
