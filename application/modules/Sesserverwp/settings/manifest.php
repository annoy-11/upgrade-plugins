<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'sesserverwp',
    //'sku'=>'sesserverwp',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesserverwp',
    'title' => 'SES - SSO WP Server Plugin',
    'description' => 'SES SSO for wp',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => 
    array (
      'path'=>'application/modules/Sesserverwp/settings/install.php',
      'class' => 'Sesserverwp_Installer',
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
      0 => 'application/modules/Sesserverwp',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/sesserverwp.csv',
    ),
  ),
  'items'=>
  array(
      'sesserverwp_clients'
  ),
  'hooks' => array(
    array(
        'event' => 'onUserLoginAfter',
        'resource' => 'Sesserverwp_Plugin_Core'
    ),
    array(
        'event' => 'onUserSignupAfter',
        'resource' => 'Sesserverwp_Plugin_Core'
    ),
    array(
        'event' => 'onRenderLayoutDefault',
        'resource' => 'Sesserverwp_Plugin_Core'
    ),
  ),
); 
?>
