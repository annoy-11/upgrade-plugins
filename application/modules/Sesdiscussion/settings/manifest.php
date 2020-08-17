<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$discussionsRoute = "discussions";
$discussionRoute = 'discussion';
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
  $discussionsRoute = $setting->getSetting('sesdiscussion.discussions.manifest', 'discussions');
  $discussionRoute = $setting->getSetting('sesdiscussion.discussion.manifest', 'discussion');
}
return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sesdiscussion',
    //'sku' => 'sesdiscussion',
	'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesdiscussion',
    'title' => 'SES - Discussions & External Links Posting Plugin',
    'description' => 'SES - Discussions & External Links Posting Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'enable',
      'disable',
    ),
    'callback' => array(
      'path' => 'application/modules/Sesdiscussion/settings/install.php',
      'class' => 'Sesdiscussion_Installer',
    ),
    'directories' => array(
      'application/modules/Sesdiscussion',
    ),
    'files' => array(
      'application/languages/en/sesdiscussion.csv',
    ),
  ),
  'items' => array(
    'discussion', 'sesdiscussion_category', 'sesdiscussion_follower',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesdiscussion_category' => array(
      'route' => $discussionsRoute.'/categories/:action/*',
      'defaults' => array(
        'module' => 'sesdiscussion',
        'controller' => 'category',
        'action' => 'browse',
      ),
    ),
    'sesdiscussion_specific' => array(
      'route' => $discussionsRoute.'/:action/:discussion_id/*',
      'defaults' => array(
        'module' => 'sesdiscussion',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'discussion_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesdiscussion_entry_view' => array(
      'route' => $discussionsRoute.'/:user_id/:discussion_id/:slug',
      'defaults' => array(
        'module' => 'sesdiscussion',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'discussion_id' => '\d+'
      ),
    ),
    'sesdiscussion_general' => array(
      'route' => $discussionsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesdiscussion',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage|top-voted)',
      ),
    ),
  ),
);
