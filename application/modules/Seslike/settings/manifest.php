<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'seslike',
        //'sku' => 'seslike',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Seslike',
        'title' => 'SES - Professional Likes Plugin',
        'description' => 'SES - Professional Likes Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Seslike/settings/install.php',
            'class' => 'Seslike_Installer',
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
            0 => 'application/modules/Seslike',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/seslike.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserCreateAfter',
            'resource' => 'Seslike_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'seslike_integrateothersmodule',
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'seslike_general' => array(
            'route' => 'likes/:action/*',
            'defaults' => array(
                'module' => 'seslike',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|mylikes|wholikeme|mycontentlike|myfriendslike|mylikesettings)',
            ),
        ),
    ),
);
