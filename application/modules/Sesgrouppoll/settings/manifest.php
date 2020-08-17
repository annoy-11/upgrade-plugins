<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 $pollsRoute = "grouppolls";
$pollRoute = "grouppoll";
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
  $pollsRoute = $setting->getSetting('sesgrouppoll.polls.manifest', 'grouppolls');
  $pollRoute = $setting->getSetting('sesgrouppoll.poll.manifest', 'grouppoll');
}
 
return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesgrouppoll',
    'version' => '4.10.5',
    'path' => 'application/modules/Sesgrouppoll',
    'title' => 'SES - Group Polls Extension',
    'description' => 'SES - Group Polls Extension',

      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesgrouppoll/settings/install.php',
          'class' => 'Sesgrouppoll_Installer',
      ),
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'directories' => array(
      'application/modules/Sesgrouppoll',
    ),
    'files' => array(
      'application/languages/en/Sesgrouppoll.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesgrouppoll_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesgrouppoll_Plugin_Core'
        ),
		array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sesgrouppoll_Plugin_Core'
        ),

    ),
  //      composer
  'composer' => array(
    'sesgrouppoll' => array(
      'script' => array('_composeSesgrouppoll.tpl', 'sesgrouppoll'),
      'plugin' => 'Sesgrouppoll_Plugin_Composer',
      'auth' => array('sesgrouppoll_poll', 'create'),
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesgrouppoll_poll',
    'sesgrouppoll_option',
    'sesgrouppoll_vote',
    'sesgrouppoll_favourite'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesgrouppoll_extended' => array(
      'route' => $pollsRoute.'/:controller/:action/*',
      'defaults' => array(
        'module' => 'sesgrouppoll',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'controller' => '\D+',
        'action' => '\D+',
      ),
    ),
    'sesgrouppoll_general' => array(
      'route' => $pollsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesgrouppoll',
        'controller' => 'index',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse|manage|create|home)',
      ),
    ),
    'sesgrouppoll_specific' => array(
      'route' => $pollsRoute.'/:action/:poll_id/*',
      'defaults' => array(
        'module' => 'sesgrouppoll',
        'controller' => 'poll',
        'action' => 'index',
      ),
      'reqs' => array(
        'poll_id' => '\d+',
        'action' => '(delete|edit|close|vote)',
      ),
    ),
    'sesgrouppoll_view' => array(
      'route' => $pollRoute.'/view/:poll_id/:slug',
      'defaults' => array(
        'module' => 'sesgrouppoll',
        'controller' => 'poll',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'poll_id' => '\d+'
      )
    ),
  ),
);
