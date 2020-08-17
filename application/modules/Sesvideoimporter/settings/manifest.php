<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$videosRoute = "videos";
$videoRoute = 'video';
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
  $videosRoute = $setting->getSetting('video.videos.manifest', 'videos');
	$videoRoute = $setting->getSetting('video.video.manifest', 'video');
}

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesvideoimporter',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesvideoimporter',
    'title' => 'SES - Advanced Videos & Channels - Video Importer & Search Extension',
    'description' => 'SES - Advanced Videos & Channels - Video Importer & Search Extension',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
      'path' => 'application/modules/Sesvideoimporter/settings/install.php',
      'class' => 'Sesvideoimporter_Installer',
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
      0 => 'application/modules/Sesvideoimporter'
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesvideoimporter.csv',
    ),
  ),
	// Routes --------------------------------------------------------------------
  'routes' => array(
    'sesvideoimporter_general' =>array(
      'route' => $videosRoute . '/play/:action/*',
        'defaults' => array(
            'module' => 'sesvideoimporter',
            'controller' => 'index',
            'action' => 'play',
        ),
        'reqs' => array(
            'action' => '(musicplay|play)',
        )
    ),
    'sesvideoimporter_import_youtube' => array(
        'route' => $videosRoute . '/search/*',
        'defaults' => array(
            'module' => 'sesvideoimporter',
            'controller' => 'index',
            'action' => 'search',
        ),
        'reqs' => array(
            'action' => '(search)',
        )
    ),
  ),
);
