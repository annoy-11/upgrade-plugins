<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "crowdfundingvideos";
$videoRoute = "crowdfundingvideo";
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
  $videosRoute = $setting->getSetting('sescrowdfundingvideo.videos.manifest', 'crowdfundingvideos');
  $videoRoute = $setting->getSetting('sescrowdfundingvideo.video.manifest', 'crowdfundingvideo');
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sescrowdfundingvideo',
        'version' => '4.10.3p1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p3',
            ),
        ),
        'path' => 'application/modules/Sescrowdfundingvideo',
        'title' => 'SES - Crowdfunding Videos Extension',
        'description' => 'SES - Crowdfunding Videos Extension',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sescrowdfundingvideo/settings/install.php',
            'class' => 'Sescrowdfundingvideo_Installer',
        ),
        'directories' => array(
            'application/modules/Sescrowdfundingvideo',
        ),
        'files' => array(
            'application/languages/en/sescrowdfundingvideo.csv',
        ),
    ),
		// Compose
    'composer' => array(
        'sescrowdfundingvideo' => array(
            'script' => array('_composeSescrowdfundingVideo.tpl', 'sescrowdfundingvideo'),
            'plugin' => 'Sescrowdfundingvideo_Plugin_Composer',
            'auth' => array('crowdfundingvideo','upload'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'crowdfundingvideo', 'watchlater',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sescrowdfundingvideo_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sescrowdfundingvideo_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sescrowdfundingvideo_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sescrowdfundingvideo_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sescrowdfundingvideo_general' => array(
            'route' => $videosRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sescrowdfundingvideo',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|list|view|share|tags|edit|delete|location|locations|get-video|browse)',
            )
        ),
        //lightbox all videos
        'sescrowdfundingvideo_allvideos' => array(
            'route' => $videoRoute.'/all-videos/:user_id/:crowdfundingvideo_id/:slug/*',
            'defaults' => array(
                'module' => 'sescrowdfundingvideo',
                'controller' => 'index',
                'action' => 'all-videos',
                'slug' => '',
            )
        ),
        //lightbox video
        'sescrowdfundingvideo_lightbox' => array(
            'route' => $videoRoute.'/imageviewerdetail/:user_id/:crowdfundingvideo_id/:slug/*',
            'defaults' => array(
                'module' => 'sescrowdfundingvideo',
                'controller' => 'index',
                'action' => 'imageviewerdetail',
                'slug' => '',
            )
        ),
        'sescrowdfundingvideo_view' => array(
            'route' => $videoRoute.'/:user_id/:crowdfundingvideo_id/:slug/*',
            'defaults' => array(
                'module' => 'sescrowdfundingvideo',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+'
            )
        ),
        'sescrowdfundingvideo_watchlater' => array(
            'route' => $videosRoute . '/watchlater/:action/*',
            'defaults' => array(
                'module' => 'sescrowdfundingvideo',
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
