<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesloginpopup',
    //'sku' => 'sesloginpopup',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesloginpopup',
    'title' => 'SES - Login/Signup Popup & Page Plugin',
    'description' => 'SES - Login/Signup Popup & Page Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sesloginpopup/settings/install.php',
			'class' => 'Sesloginpopup_Installer',
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
      'application/modules/Sesloginpopup',
    ),
    'files' =>
    array (
      'application/languages/en/sesloginpopup.csv',
    ),
  ),
  'items' => array(
  ),
);
