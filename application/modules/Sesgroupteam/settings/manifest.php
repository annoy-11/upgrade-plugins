<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$groupteamRoute = 'groupteam';
$module1 = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $groupteamRoute = $setting->getSetting('sesgroupteam.urlmanifest', 'groupteam');
}
return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesgroupteam',
      'version' => '4.10.5',
      'path' => 'application/modules/Sesgroupteam',
      'title' => 'SES - Group Team Showcase Extension',
      'description' => 'SES - Group Team Showcase Extension',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesgroupteam/settings/install.php',
          'class' => 'Sesgroupteam_Installer',
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
          0 => 'application/modules/Sesgroupteam',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesgroupteam.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesgroupteam_designations', 'sesgroupteam_team',
  ),
  'routes' => array(
    'sesgroupteam_dashboard' => array(
      'route' => $groupteamRoute . '/dashboard/:action/:group_id/*',
      'defaults' => array(
        'module' => 'sesgroupteam',
        'controller' => 'index',
        'action' => 'add',
      ),
    ),
    'sesgroupteam_entry_view' => array(
      'route' => $groupteamRoute.'/:controller/:action/:group_id/:team_id/*',
      'defaults' => array(
        'module' => 'sesgroupteam',
        'controller' => 'index',
        'action' => 'view',
      ),
      'reqs' => array(
        'group_id' => '\d+',
        'team_id' => '\d+',
      )
    ),
  ),
);
