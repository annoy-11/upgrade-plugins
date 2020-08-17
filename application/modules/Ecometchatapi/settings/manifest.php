<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

 return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'ecometchatapi',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Ecometchatapi',
   'title' => 'SNS - Comet Chat APIs Integration',
    'description' => 'SNS - Comet Chat APIs Integration',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' =>
          array (
              'path' => 'application/modules/Ecometchatapi/settings/install.php',
              'class' => 'Ecometchatapi_Installer',
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
      0 => 'application/modules/Ecometchatapi',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/ecometchatapi.csv',
    ),
  ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserEnable',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onUserCreateAfter',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onUserUpdateAfter',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onUserLoginAfter',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onAuthorizationLevelDeleteBefore',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onAuthorizationLevelCreateAfter',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
        array(
            'event' => 'onAuthorizationLevelUpdateAfter',
            'resource' => 'Ecometchatapi_Plugin_Core',
        ),
    ),
); ?>