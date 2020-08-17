<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    // Package -------------------------------------------------------------------
    'package' => array(
        'type' => 'module',
        'name' => 'sesssoclient',
        //'sku' => 'sesssoclient',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesssoclient',
        'title' => 'SES - SSO Client Plugin',
        'description' => 'SES - SSO Client Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesssoclient/settings/install.php',
            'class' => 'Sesssoclient_Installer',
        ),
        'directories' => array(
            'application/modules/Sesssoclient',
        ),
        'files' => array(
            'application/languages/en/sesssoclient.csv',
        ),
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesssoclient_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesssoclient_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sesssoclient_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sesssoclient_Plugin_Core',
        ),
    ),
);
