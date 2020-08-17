<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
    return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sessegpay',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p3',
            ),
        ),
        'path' => 'application/modules/Sessegpay',
        'title' => 'SES - Segpay Payment Gateway Integration Plugin',
        'description' => 'SES - Segpay Payment Gateway Integration Plugin',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sessegpay/settings/install.php',
            'class' => 'Sessegpay_Installer',
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
            0 => 'application/modules/Sessegpay',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sessegpay.csv',
        ),
    ),
    'items' => array(

    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sessegpay_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sessegpay_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sessegpay_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sessegpay_Plugin_Core'
        )
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
         'sessegpay_general' => array(
            'route' =>  'segpay/:action/*',
            'defaults' => array(
                'module' => 'segpay',
                'controller' => 'index',
                'action' => 'browse',
            ),
        ),
     ),
);
