<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$prayersRoute = "prayers";
$prayerRoute = 'prayer';
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $prayersRoute = $setting->getSetting('sesprayer.prayers.manifest', 'prayers');
  $prayerRoute = $setting->getSetting('sesprayer.prayer.manifest', 'prayer');
}
return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sesprayer',
    //'sku' => 'sesprayer',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesprayer',
    'title' => 'SES - Prayers Plugin',
    'description' => 'SES - Prayers Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Sesprayer/settings/install.php',
        'class' => 'Sesprayer_Installer',
    ),
    'directories' => array(
        'application/modules/Sesprayer',
    ),
    'files' => array(
        'application/languages/en/sesprayer.csv',
    ),
  ),
  'items' => array(
    'sesprayer_prayer', 'sesprayer_category','sesprayer_receiver'
  ),
  // Compose -------------------------------------------------------------------
  'composer' => array(
    'prayer' => array(
      'script' => array('_composeprayer.tpl', 'sesprayer'),
      'plugin' => 'Sesprayer_Plugin_PrayerComposer',
    ),
  ),
  //Hooks
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesprayer_Plugin_Core'
    ),
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesprayer_category' => array(
      'route' => $prayersRoute.'/categories/:action/*',
      'defaults' => array(
        'module' => 'sesprayer',
        'controller' => 'category',
        'action' => 'browse',
      ),
    ),
    'sesprayer_specific' => array(
      'route' => $prayersRoute.'/:action/:prayer_id/*',
      'defaults' => array(
        'module' => 'sesprayer',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'prayer_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesprayer_entry_view' => array(
      'route' => $prayersRoute.'/:user_id/:prayer_id/:slug',
      'defaults' => array(
        'module' => 'sesprayer',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'prayer_id' => '\d+'
      ),
    ),
    'sesprayer_general' => array(
      'route' => $prayersRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesprayer',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage)',
      ),
    ),
  ),
);
