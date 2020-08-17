<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$pollsRoute = "polls";
$pollRoute = "poll";
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
    $pollsRoute = $setting->getSetting('sesadvpoll.polls.manifest', 'polls');
    $pollRoute = $setting->getSetting('sesadvpoll.poll.manifest', 'poll');
}

return array(
    // Package -------------------------------------------------------------------
    'package' => array(
        'type' => 'module',
        'name' => 'sesadvpoll',
        //'sku' => 'sesadvpoll',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesadvpoll',
        'title' => 'SES - Advanced Polls Plugin',
        'description' => 'SES - Advanced Polls Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesadvpoll/settings/install.php',
            'class' => 'Sesadvpoll_Installer',
        ),
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
            ),
        'directories' => array(
            'application/modules/Sesadvpoll',
        ),
        'files' => array(
            'application/languages/en/Sesadvpoll.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesadvpoll_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesadvpoll_Plugin_Core'
        ),
    ),
    //Composer
//     'composer' => array(
//         'sesadvpoll' => array(
//             'script' => array('_composeSesadvpoll.tpl', 'sesadvpoll'),
//             'plugin' => 'Sesadvpoll_Plugin_Composer',
//             'auth' => array('sesadvpoll_poll', 'create'),
//         ),
//     ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesadvpoll_poll',
        'sesadvpoll_option',
        'sesadvpoll_vote',
        'sesadvpoll_favourite'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesadvpoll_extended' => array(
            'route' => $pollsRoute.'/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesadvpoll',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            ),
        ),
        'sesadvpoll_general' => array(
            'route' => $pollsRoute.'/:action/*',
            'defaults' => array(
                'module' => 'sesadvpoll',
                'controller' => 'index',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse|manage|create|home)',
            ),
        ),
        'sesadvpoll_specific' => array(
            'route' => $pollsRoute.'/:action/:poll_id/*',
            'defaults' => array(
                'module' => 'sesadvpoll',
                'controller' => 'poll',
                'action' => 'index',
            ),
            'reqs' => array(
                'poll_id' => '\d+',
                'action' => '(delete|edit|close|vote)',
            ),
        ),
        'sesadvpoll_view' => array(
            'route' => $pollRoute.'/view/:poll_id/:slug',
            'defaults' => array(
                'module' => 'sesadvpoll',
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
