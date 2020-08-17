<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$businessteamRoute = 'businessteam';
$module1 = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $businessteamRoute = $setting->getSetting('sesbusinessteam.urlmanifest', 'businessteam');
}
return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesbusinessteam',
      'version' => '4.10.5',
      'path' => 'application/modules/Sesbusinessteam',
      'title' => 'SES - Business Team Showcase Extension',
      'description' => 'SES - Business Team Showcase Extension',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesbusinessteam/settings/install.php',
          'class' => 'Sesbusinessteam_Installer',
      ),
      'actions' =>
      array(
          0 => 'install',
          1 => 'upgrade',
          2 => 'refresh',
          3 => 'enable',
          4 => 'disable',
      ),
      'directories' =>
      array(
          0 => 'application/modules/Sesbusinessteam',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesbusinessteam.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesbusinessteam_designations', 'sesbusinessteam_team',
  ),
  'routes' => array(
    'sesbusinessteam_dashboard' => array(
      'route' => $businessteamRoute . '/dashboard/:action/:business_id/*',
      'defaults' => array(
        'module' => 'sesbusinessteam',
        'controller' => 'index',
        'action' => 'add',
      ),
    ),
    'sesbusinessteam_entry_view' => array(
      'route' => $businessteamRoute.'/:controller/:action/:business_id/:team_id/*',
      'defaults' => array(
        'module' => 'sesbusinessteam',
        'controller' => 'index',
        'action' => 'view',
      ),
      'reqs' => array(
        'business_id' => '\d+',
        'team_id' => '\d+',
      )
    ),
  ),
);
