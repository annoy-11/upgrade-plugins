<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesadvsitenotification',
    //'sku' => 'sesadvsitenotification',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesadvsitenotification',
    'title' => 'SES - Advanced Site Notifications in Popups Plugin',
    'description' => 'SES - Advanced Site Notifications in Popups Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
      'path' => 'application/modules/Sesadvsitenotification/settings/install.php',
      'class' => 'Sesadvsitenotification_Installer',
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
      0 => 'application/modules/Sesadvsitenotification',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesadvsitenotification.csv',
    ),
  ),
);
