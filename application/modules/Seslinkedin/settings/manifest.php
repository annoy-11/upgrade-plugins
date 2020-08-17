<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'seslinkedin',
        //'sku' => 'seslinkedin',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Seslinkedin',
        'title' => 'SES - LinkedIn Clone Theme',
        'description' => 'SES - LinkedIn Clone Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Seslinkedin/settings/install.php',
            'class' => 'Seslinkedin_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Seslinkedin',
            1 => 'application/themes/seslinkedin',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/seslinkedin.csv',
        ),
    ),
    'items' => array(
        'seslinkedin_dashboardlinks',
        'seslinkedin_customthemes',
        'seslinkedin_managesearchoptions',
        'seslinkedin_footerlinks',
        'seslinkedin_socialicons'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
        'event' => 'onUserLoginAfter',
        'resource' => 'Seslinkedin_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Seslinkedin_Plugin_Core'
        )
    ),
);
