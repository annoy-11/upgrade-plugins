<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $groupsRoute = $setting->getSetting('sesgroup.groups.manifest', 'groups');
  $groupRoute = $setting->getSetting('sesgroup.group.manifest', 'group');
}

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'egroupjoinfees',
    //'sku' => 'egroupjoinfees',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Egroupjoinfees',
    'title' => 'SES - Advanced Groups - Groups Joining Fees & Payments System Plugin',
    'description' => 'Advanced Groups - Groups Joining Fees & Payments System Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'path' => 'application/modules/Egroupjoinfees/settings/install.php',
	    'class' => 'Egroupjoinfees_Installer',
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
      0 => 'application/modules/Egroupjoinfees',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/egroupjoinfees.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
//     'hooks' => array(
//         array(
//             'event' => 'onSesgroupParticipantCreateAfter',
//             'resource' => 'Egroupjoinfees_Plugin_Core',
//         ),
//    ),
  // Items ---------------------------------------------------------------------
    'items' => array(
      'egroupjoinfees_order',
      'egroupjoinfees_gateway',
      'egroupjoinfees_plan',
      'egroupjoinfees_usergateway',
      'egroupjoinfees_userpayrequest',
      'egroupjoinfees_remainingpayment',
    ),
     // Routes --------------------------------------------------------------------
    'routes' => array(
      'egroupjoinfees_user_order' => array(
          'route' => $groupsRoute.'/orders/:action/*',
          'defaults' => array(
              'module' => 'egroupjoinfees',
              'controller' => 'index',
              'action' => 'order',
          ),
      ),
      'egroupjoinfees_order' => array(
          'route' => $groupsRoute.'/order/:action/:group_id/*',
          'defaults' => array(
              'module' => 'egroupjoinfees',
              'controller' => 'order',
              'action' => 'index',
          ),

        ),
    ),
); ?>
