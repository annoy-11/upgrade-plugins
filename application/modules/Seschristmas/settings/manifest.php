<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$welcome_route = "welcome";
$request = Zend_Controller_Front::getInstance()->getRequest();
$module = null;
$controller = null;
$action = null;

if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $welcome_route = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.urlmanifest', "welcome");
}
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'seschristmas',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Seschristmas',
        'title' => 'SES - Christmas & New Year Design Elements',
        'description' => 'SES - Christmas & New Year Design Elements',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Seschristmas/settings/install.php',
            'class' => 'Seschristmas_Installer',
        ),
        'directories' => array(
            0 => 'application/modules/Seschristmas',
            1 => 'application/themes/seschristmas'
        ),
        'files' => array(
            'application/languages/en/seschristmas.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'seschristmas_christmas'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Seschristmas_Plugin_Core',
        ),
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'seschristmas_welcome' => array(
            'route' => $welcome_route . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'seschristmas',
                'controller' => 'welcome',
                'action' => 'index'
            ),
        ),
        'seschristmas_general' => array(
            'route' => 'wishes/:controller/:action/*',
            'defaults' => array(
                'module' => 'seschristmas',
                'controller' => 'welcome',
                'action' => 'wishes'
            ),
            'reqs' => array(
                'action' => '(wishes|myfriendwishes|create|edit|delete)',
            ),
        ),
        'seschristmas_friend' => array(
            'route' => 'friend-wishes/:controller/:action/*',
            'defaults' => array(
                'module' => 'seschristmas',
                'controller' => 'welcome',
                'action' => 'myfriendwishes'
            ),
        ),
    ),
);