<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$pageteamRoute = 'pageteam';
$module1 = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $pageteamRoute = $setting->getSetting('sespageteam.urlmanifest', 'pageteam');
}
return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sespageteam',
      'version' => '4.10.5',
      'path' => 'application/modules/Sespageteam',
      'title' => 'SES - Page Team Showcase Extension',
      'description' => 'SES - Page Team Showcase Extension',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sespageteam/settings/install.php',
          'class' => 'Sespageteam_Installer',
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
          0 => 'application/modules/Sespageteam',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sespageteam.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sespageteam_designations', 'sespageteam_team',
  ),
  'routes' => array(
    'sespageteam_dashboard' => array(
      'route' => $pageteamRoute . '/dashboard/:action/:page_id/*',
      'defaults' => array(
        'module' => 'sespageteam',
        'controller' => 'index',
        'action' => 'add',
      ),
    ),
    'sespageteam_entry_view' => array(
      'route' => $pageteamRoute.'/:controller/:action/:page_id/:team_id/*',
      'defaults' => array(
        'module' => 'sespageteam',
        'controller' => 'index',
        'action' => 'view',
      ),
      'reqs' => array(
        'page_id' => '\d+',
        'team_id' => '\d+',
      )
    ),
  ),
);
