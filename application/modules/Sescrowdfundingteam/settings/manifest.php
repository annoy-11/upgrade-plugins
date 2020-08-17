<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$crowdfundingteamRoute = 'crowdfundingteam';
$module1 = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $crowdfundingteamRoute = $setting->getSetting('sescrowdfundingteam.urlmanifest', 'crowdfundingteam');
}
return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sescrowdfundingteam',
      'version' => '4.10.3',
      'path' => 'application/modules/Sescrowdfundingteam',
      'title' => 'SES - Crowdfunding Team Showcase Extension',
      'description' => 'SES - Crowdfunding Team Showcase Extension',
      'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sescrowdfundingteam/settings/install.php',
          'class' => 'Sescrowdfundingteam_Installer',
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
          0 => 'application/modules/Sescrowdfundingteam',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sescrowdfundingteam.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sescrowdfundingteam_designations', 'sescrowdfundingteam_team',
  ),
  'routes' => array(
    'sescrowdfundingteam_dashboard' => array(
      'route' => $crowdfundingteamRoute . '/dashboard/:action/:crowdfunding_id/*',
      'defaults' => array(
        'module' => 'sescrowdfundingteam',
        'controller' => 'index',
        'action' => 'add',
      ),
    ),
    'sescrowdfundingteam_entry_view' => array(
      'route' => $crowdfundingteamRoute.'/:controller/:action/:crowdfunding_id/:team_id/*',
      'defaults' => array(
        'module' => 'sescrowdfundingteam',
        'controller' => 'index',
        'action' => 'view',
      ),
      'reqs' => array(
        'crowdfunding_id' => '\d+',
        'team_id' => '\d+',
      )
    ),
  ),
);
