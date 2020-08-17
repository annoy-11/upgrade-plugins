<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesweather',
        //'sku' => 'sesweather',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesweather',
        'title' => 'SES - Weather Plugin',
        'description' => 'SES - Weather Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesweather/settings/install.php',
            'class' => 'Sesweather_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' => array(
            'application/modules/Sesweather',
        ),
        'files' => array(
            'application/languages/en/sesweather.csv',
        ),
    ),
    'routes' => array(
        'sesweather_general' => array(
            'route' => 'weather/:action/*',
            'defaults' => array(
                'module' => 'sesweather',
                'controller' => 'index',
                'action' => 'index',
            ),
        ),
    ),
);
