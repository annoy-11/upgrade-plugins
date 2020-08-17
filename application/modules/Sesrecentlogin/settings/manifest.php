<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesrecentlogin',
        //'sku' => 'sesrecentlogin',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesrecentlogin',
        'title' => 'SES - Recent Login & Account Switcher Plugin',
        'description' => 'SES - Recent Login & Account Switcher Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesrecentlogin/settings/install.php',
            'class' => 'Sesrecentlogin_Installer',
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
            0 => 'application/modules/Sesrecentlogin',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesrecentlogin.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserLoginAfter',
            'resource' => 'Sesrecentlogin_Plugin_Core',
        ),
    ),
);
