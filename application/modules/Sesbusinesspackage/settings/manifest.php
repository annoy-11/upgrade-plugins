<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesbusinesspackage',
        'version' => '4.10.5p1',
        'path' => 'application/modules/Sesbusinesspackage',
        'title' => 'SES - Business Directories - Packages for Allowing Business Creation Extension',
        'description' => 'SES - Business Directories - Packages for Allowing Business Creation Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesbusinesspackage/settings/install.php',
            'class' => 'Sesbusinesspackage_Installer',
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
            0 => 'application/modules/Sesbusinesspackage',
        ),
        'files' => array(
            'application/languages/en/sesbusinesspackage.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesbusinesspackage_package',
        'sesbusinesspackage_orderspackage',
        'sesbusinesspackage_gateway',
        'sesbusinesspackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesbusinesspackage_general' => array(
            'route' => 'businesspackage/:action/*',
            'defaults' => array(
                'module' => 'sesbusinesspackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(business|confirm-upgrade|cancel)',
            )
        ),
        'sesbusinesspackage_payment' => array(
            'route' => 'businesspayment/:action/*',
            'defaults' => array(
                'module' => 'sesbusinesspackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish)',
            )
        )
    ),
);
