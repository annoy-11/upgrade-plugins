<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
	'package' => array(
        'type' => 'module',
        'name' => 'sesariana',
        //'sku' => 'sesariana',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesariana',
        'title' => 'SES - Responsive Vertical Theme',
        'description' => 'SES - Responsive Vertical Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Sesariana/settings/install.php',
                'class' => 'Sesariana_Installer',
        ),
        'directories' =>
        array(
                0 => 'application/modules/Sesariana',
                1 => 'application/themes/sesariana',
                2 => 'public/admin'
        ),
        'files' => array(
                'application/languages/en/sesariana.csv',
        ),
	),
	// Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesariana_Plugin_Core'
		)
	),
	// Items ---------------------------------------------------------------------
	'items' => array(
		'sesariana_slideimage', 'sesariana_slide', 'sesariana_banner', 'sesariana_customthemes',
	),
);
