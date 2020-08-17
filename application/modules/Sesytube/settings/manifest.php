<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
	'package' => array(
        'type' => 'module',
        'name' => 'sesytube',
        //'sku' => 'sesytube',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesytube',
        'title' => 'SES - UTube Clone Theme',
        'description' => 'SES - UTube Clone Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Sesytube/settings/install.php',
                'class' => 'Sesytube_Installer',
        ),
        'directories' =>
        array(
            'application/modules/Sesytube',
            'application/themes/sesytube',
        ),
        'files' => array(
            'application/languages/en/sesytube.csv',
            'public/admin/blank.png',
            'public/admin/ytube-theme-banner.jpg',

        ),
	),
	// Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesytube_Plugin_Core'
		)
	),
	// Items ---------------------------------------------------------------------
	'items' => array(
		'sesytube_slideimage', 'sesytube_slide', 'sesytube_banner', 'sesytube_customthemes',
	),
);
