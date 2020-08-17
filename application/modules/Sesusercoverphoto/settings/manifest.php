<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesusercoverphoto',
    //'sku' => 'sesusercoverphoto',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesusercoverphoto',
    'title' => 'SES - Member Profiles Cover Photo & Video Plugin',
    'description' => 'SES - Member Profiles Cover Photo & Video Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sesusercoverphoto/settings/install.php',
			'class' => 'Sesusercoverphoto_Installer',
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
      'application/modules/Sesusercoverphoto',
      'application/modules/Sesusercovervideo',
    ),
    'files' =>
    array (
      'application/languages/en/sesusercoverphoto.csv',
      'application/languages/en/sesusercovervideo.csv',
    ),
  ),
  'routes' => array(
    'sesvideo_general' => array(
        'route' => 'sdfasf/:action/*',
        'defaults' => array(
            'module' => 'sesusercoverphoto',
            'controller' => 'index',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '()',
        )
    ),
  ),
);
