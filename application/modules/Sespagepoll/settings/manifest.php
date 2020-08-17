<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 $pollsRoute = "pagepolls";
$pollRoute = "pagepoll";
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
  $pollsRoute = $setting->getSetting('sespagepoll.polls.manifest', 'pagepolls');
  $pollRoute = $setting->getSetting('sespagepoll.poll.manifest', 'pagepoll');
}
 
return array(
    // Package -------------------------------------------------------------------
    'package' => array(
        'type' => 'module',
        'name' => 'sespagepoll',
        'version' => '4.10.5',
        'path' => 'application/modules/Sespagepoll',
        'title' => 'SES - Page Polls Extension',
        'description' => 'SES - Page Polls Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespagepoll/settings/install.php',
            'class' => 'Sespagepoll_Installer',
        ),
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
            ),
        'directories' => array(
            'application/modules/Sespagepoll',
        ),
        'files' => array(
            'application/languages/en/Sespagepoll.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sespagepoll_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sespagepoll_Plugin_Core'
        ),
		array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Sespagepoll_Plugin_Core'
        ),

    ),
    //composer
    'composer' => array(
        'sespagepoll' => array(
        'script' => array('_composeSespagepoll.tpl', 'sespagepoll'),
        'plugin' => 'Sespagepoll_Plugin_Composer',
        'auth' => array('sespagepoll_poll', 'create'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespagepoll_poll',
        'sespagepoll_option',
        'sespagepoll_vote',
        'sespagepoll_favourite'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sespagepoll_extended' => array(
            'route' => $pollsRoute.'/:controller/:action/*',
            'defaults' => array(
                'module' => 'sespagepoll',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            ),
        ),
        'sespagepoll_general' => array(
            'route' => $pollsRoute.'/:action/*',
            'defaults' => array(
                'module' => 'sespagepoll',
                'controller' => 'index',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse|manage|create|home)',
            ),
        ),
        'sespagepoll_specific' => array(
            'route' => $pollsRoute.'/:action/:poll_id/*',
            'defaults' => array(
                'module' => 'sespagepoll',
                'controller' => 'poll',
                'action' => 'index',
            ),
            'reqs' => array(
                'poll_id' => '\d+',
                'action' => '(delete|edit|close|vote)',
            ),
        ),
        'sespagepoll_view' => array(
            'route' => $pollRoute.'/view/:poll_id/:slug',
            'defaults' => array(
                'module' => 'sespagepoll',
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
