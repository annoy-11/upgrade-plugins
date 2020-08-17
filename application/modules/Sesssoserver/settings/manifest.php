<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


return array (
    // Package -------------------------------------------------------------------
    'package' => array(
        'type' => 'module',
        'name' => 'sesssoserver',
        //'sku' => 'sesssoserver',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesssoserver',
        'title' => 'SES - SSO Server Plugin',
        'description' => 'SES - SSO Server Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesssoserver/settings/install.php',
            'class' => 'Sesssoserver_Installer',
        ),
        'directories' => array(
            'application/modules/Sesssoserver',
        ),
        'files' => array(
            'application/languages/en/sesssoserver.csv',
        ),
    ),
    'items' => array(
        'sesssoserver_clients'
    ),
    //Hooks
    'hooks' => array(
        array(
            'event' => 'onUserLoginAfter',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
        array(
            'event' => 'onUserSignupAfter',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sesssoserver_Plugin_Core'
        ),
    ),
);
