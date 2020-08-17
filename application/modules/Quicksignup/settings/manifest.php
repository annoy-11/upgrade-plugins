<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'quicksignup',
    //'sku' => 'quicksignup',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
		'path' => 'application/modules/Quicksignup',
		'title' => 'SES - Quick & One Step Signup Plugin',
		'description' => 'SES - Quick & One Step Signup Plugin',
		'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
		'callback' =>
			array (
			  'path' => 'application/modules/Quicksignup/settings/install.php',
			  'class' => 'Quicksignup_Installer',
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
		  0 => 'application/modules/Quicksignup',
		),
		'files' =>
		array (
		  0 => 'application/languages/en/quicksignup.csv',
		),
	  ),
	   'hooks' => array(
		   array(
				'event' => 'onRenderLayoutDefault',
				'resource' => 'Quicksignup_Plugin_Core'
			),
			array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Quicksignup_Plugin_Core'
			),
			array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Quicksignup_Plugin_Core'
			),
			array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Quicksignup_Plugin_Core'
			),
		),
); ?>
