<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesgrouppackage',
        'version' => '4.10.5p1',
        'path' => 'application/modules/Sesgrouppackage',
        'title' => 'SES - Group Communities - Packages for Allowing Group Creation Extension',
        'description' => 'SES - Group Communities - Packages for Allowing Group Creation Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesgrouppackage/settings/install.php',
            'class' => 'Sesgrouppackage_Installer',
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
            0 => 'application/modules/Sesgrouppackage',
        ),
        'files' => array(
            'application/languages/en/sesgrouppackage.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesgrouppackage_package',
        'sesgrouppackage_orderspackage',
        'sesgrouppackage_gateway',
        'sesgrouppackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesgrouppackage_general' => array(
            'route' => 'grouppackage/:action/*',
            'defaults' => array(
                'module' => 'sesgrouppackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(group|confirm-upgrade|cancel)',
            )
        ),
        'sesgrouppackage_payment' => array(
            'route' => 'grouppayment/:action/*',
            'defaults' => array(
                'module' => 'sesgrouppackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish)',
            )
        )
    ),
);
