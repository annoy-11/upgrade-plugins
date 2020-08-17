<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesadvancedheader',
    //'sku' => 'sesadvancedheader',
    'version' => '4.10.5',
    'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesadvancedheader',
    'title' => 'Advanced Header Plugin',
    'description' => 'Advanced Header Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Sesadvancedheader',
    ),
  ),
    // Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesadvancedheader_Plugin_Core'
		)
	),
  // Items ---------------------------------------------------------------------
	'items' => array(
		'sesadvancedheader_managesearchoptions', 'sesadvancedheader_header', 'sesadvancedheader_headers'
	),
);
