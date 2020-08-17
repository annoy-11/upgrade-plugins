<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 $pollsRoute = "businesspolls";
$pollRoute = "businesspoll";
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
  $pollsRoute = $setting->getSetting('sesbusinesspoll.polls.manifest', 'businesspolls');
  $pollRoute = $setting->getSetting('sesbusinesspoll.poll.manifest', 'businesspoll');
}
return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesbusinesspoll',
    'version' => '4.10.5',
    'path' => 'application/modules/Sesbusinesspoll',
    'title' => 'SES - Business Polls Extension',
    'description' => 'SES - Business Polls Extension',

      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesbusinesspoll/settings/install.php',
          'class' => 'Sesbusinesspoll_Installer',
      ),
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'directories' => array(
      'application/modules/Sesbusinesspoll',
    ),
    'files' => array(
      'application/languages/en/Sesbusinesspoll.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesbusinesspoll_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesbusinesspoll_Plugin_Core'
        ),
	array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sesbusinesspoll_Plugin_Core'
        ),

    ),
  //      composer
  'composer' => array(
    'sesbusinesspoll' => array(
      'script' => array('_composeSesbusinesspoll.tpl', 'sesbusinesspoll'),
      'plugin' => 'Sesbusinesspoll_Plugin_Composer',
      'auth' => array('sesbusinesspoll_poll', 'create'),
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesbusinesspoll_poll',
    'sesbusinesspoll_option',
    'sesbusinesspoll_vote',
    'sesbusinesspoll_favourite'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesbusinesspoll_extended' => array(
            'route' => $pollsRoute.'/:controller/:action/*',
      'defaults' => array(
        'module' => 'sesbusinesspoll',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'controller' => '\D+',
        'action' => '\D+',
      ),
    ),
    'sesbusinesspoll_general' => array(
            'route' => $pollsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesbusinesspoll',
        'controller' => 'index',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse|manage|create|home)',
      ),
    ),
    'sesbusinesspoll_specific' => array(
            'route' => $pollsRoute.'/:action/:poll_id/*',
      'defaults' => array(
        'module' => 'sesbusinesspoll',
        'controller' => 'poll',
        'action' => 'index',
      ),
      'reqs' => array(
        'poll_id' => '\d+',
        'action' => '(delete|edit|close|vote)',
      ),
    ),
    'sesbusinesspoll_view' => array(
            'route' => $pollRoute.'/view/:poll_id/:slug',
      'defaults' => array(
        'module' => 'sesbusinesspoll',
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
