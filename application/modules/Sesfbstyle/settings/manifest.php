<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesfbstyle',
        //'sku' => 'sesfbstyle',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesfbstyle',
        'title' => 'SES - Professional FB Clone Theme',
        'description' => 'SES - Professional FB Clone Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesfbstyle/settings/install.php',
            'class' => 'Sesfbstyle_Installer',
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
            0 => 'application/modules/Sesfbstyle',
            1 => 'application/themes/sesfbstyle',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesfbstyle.csv',
        ),
    ),
    'items' => array(
        'sesfbstyle_dashboardlinks', 'sesfbstyle_customthemes'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
        'event' => 'onUserLoginAfter',
        'resource' => 'Sesfbstyle_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesfbstyle_Plugin_Core'
        )
    ),
);
