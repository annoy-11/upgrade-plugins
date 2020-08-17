<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
	'package' => array(
        'type' => 'module',
        'name' => 'sesdating',
        //'sku' => 'sesdating',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesdating',
        'title' => 'SES - Responsive Dating Theme',
        'description' => 'SES - Responsive Dating Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Sesdating/settings/install.php',
                'class' => 'Sesdating_Installer',
        ),
        'directories' =>
        array(
            'application/modules/Sesdating',
            'application/themes/sesdating',
        ),
        'files' => array(
                'application/languages/en/sesdating.csv',
                'public/admin/blank.png',
								'public/admin/theme-banner.jpg',
								'public/admin/banner-img.png',
        ),
	),
	// Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesdating_Plugin_Core'
		)
	),
	// Items ---------------------------------------------------------------------
	'items' => array(
		'sesdating_slideimage', 'sesdating_slide', 'sesdating_banner', 'sesdating_customthemes'
	),
);
