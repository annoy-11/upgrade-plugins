<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
	'package' => array(
        'type' => 'module',
        'name' => 'sesexpose',
        //'sku' => 'sesexpose',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesexpose',
        'title' => 'SES - Responsive Expose Theme',
        'description' => 'SES - Responsive Expose Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Sesexpose/settings/install.php',
                'class' => 'Sesexpose_Installer',
        ),
        'directories' =>
        array(
                0 => 'application/modules/Sesexpose',
                1 => 'application/themes/sesexpose',
                2 => 'public/admin',
        ),
        'files' => array(
                'application/languages/en/sesexpose.csv',
        ),
	),
	// Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesexpose_Plugin_Core'
		),
		array(
			'event' => 'onRenderLayoutDefaultSimple',
			'resource' => 'Sesexpose_Plugin_Core'
		),
	),
	// Items ---------------------------------------------------------------------
	'items' => array(
		'sesexpose_slide', 'sesexpose_banner','sesexpose_managesearchoptions'
	),
);
