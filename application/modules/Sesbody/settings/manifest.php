<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesbody',
        //'sku' => 'sesbody',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesbody',
        'title' => 'SES - Responsive Body Theme',
        'description' => 'SES - Responsive Body Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesbody/settings/install.php',
            'class' => 'Sesbody_Installer',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sesbody',
            1 => 'application/themes/sesbody',
            2 => 'public/admin'
        ),
        'files' => array(
            'application/languages/en/sesbody.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesbody_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesbody_Plugin_Core'
        ),
    ),
);
