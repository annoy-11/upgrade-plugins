<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$wishesRoute = "wishes";
$wisheRoute = 'wishe';
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
  $wishesRoute = $setting->getSetting('seswishe.wishes.manifest', 'wishes');
  $wisheRoute = $setting->getSetting('seswishe.wishe.manifest', 'wishe');
}
return array (
  'package' => array(
    'type' => 'module',
    'name' => 'seswishe',
    //'sku' => 'seswishe',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Seswishe',
    'title' => 'SES - Wishes Plugin',
    'description' => 'SES - Wishes Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Seswishe/settings/install.php',
        'class' => 'Seswishe_Installer',
    ),
    'directories' => array(
        'application/modules/Seswishe',
    ),
    'files' => array(
        'application/languages/en/seswishe.csv',
    ),
  ),
  'items' => array(
    'seswishe_wishe', 'seswishe_category',
  ),
  // Compose -------------------------------------------------------------------
  'composer' => array(
    'wishe' => array(
      'script' => array('_composewishe.tpl', 'seswishe'),
      'plugin' => 'Seswishe_Plugin_WisheComposer',
    ),
  ),
  //Hooks
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Seswishe_Plugin_Core'
    ),
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'seswishe_category' => array(
      'route' => $wishesRoute.'/categories/:action/*',
      'defaults' => array(
        'module' => 'seswishe',
        'controller' => 'category',
        'action' => 'browse',
      ),
    ),
    'seswishe_specific' => array(
      'route' => $wishesRoute.'/:action/:wishe_id/*',
      'defaults' => array(
        'module' => 'seswishe',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'wishe_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'seswishe_entry_view' => array(
      'route' => $wishesRoute.'/:user_id/:wishe_id/:slug',
      'defaults' => array(
        'module' => 'seswishe',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'wishe_id' => '\d+'
      ),
    ),
    'seswishe_general' => array(
      'route' => $wishesRoute.'/:action/*',
      'defaults' => array(
        'module' => 'seswishe',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage)',
      ),
    ),
  ),
);
