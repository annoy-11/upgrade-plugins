<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'estorepackage',
        'version' => '4.10.5',
        'path' => 'application/modules/Estorepackage',
        'title' => 'SES - Store Directories Plugin - Packages for Allowing Store Creation Extension',
        'description' => 'SES - Store Directories Plugin - Packages for Allowing Store Creation Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Estorepackage/settings/install.php',
            'class' => 'Estorepackage_Installer',
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
            0 => 'application/modules/Estorepackage',
        ),
        'files' => array(
            'application/languages/en/estorepackage.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'estorepackage_package',
        'estorepackage_orderspackage',
        'estorepackage_gateway',
        'estorepackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'estorepackage_general' => array(
            'route' => 'storepackage/:action/*',
            'defaults' => array(
                'module' => 'estorepackage',
                'controller' => 'index',
                'action' => 'index',
            ),
        ),
        'estorepackage_payment' => array(
            'route' => 'storepackage/:action/*',
            'defaults' => array(
                'module' => 'estorepackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish|fill-details)',
            )
        )
    ),
);
