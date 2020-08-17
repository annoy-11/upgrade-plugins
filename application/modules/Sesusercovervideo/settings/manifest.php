<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesusercovervideo',
    //'sku' => 'sesusercovervideo',
    'version' => '4.10.3p5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.9.4p3',
        ),
    ),
    'path' => 'application/modules/Sesusercovervideo',
    'title' => '<span style="color:#DDDDDD">SES - Member Profiles Cover Video Plugin</span>',
    'description' => 'SES - Member Profiles Cover Video Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sesusercovervideo/settings/install.php',
			'class' => 'Sesusercovervideo_Installer',
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
      0 => 'application/modules/Sesusercovervideo',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesusercovervideo.csv',
    ),
  ),
  // Itema
  'items' => array(
    'sesusercovervideo_video'
  ),
  'routes' => array(
    'sesvideo_general' => array(
        'route' => 'sdfasf/:action/*',
        'defaults' => array(
            'module' => 'sesusercovervideo',
            'controller' => 'index',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '()',
        )
    ),
  ),
);
