<?php

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sescontestpackage',
        //'sku' => 'sescontestpackage',
        'version' => '4.10.5p1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sescontestpackage',
        'title' => 'SES - Advanced Contests - Packages for Allowing Contest Creation Plugin',
        'description' => 'SES - Advanced Contests - Packages for Allowing Contest Creation Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sescontestpackage/settings/install.php',
            'class' => 'Sescontestpackage_Installer',
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
            0 => 'application/modules/Sescontestpackage',
        ),
        'files' => array(
            'application/languages/en/sescontestpackage.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sescontestpackage_package',
        'sescontestpackage_orderspackage',
        'sescontestpackage_gateway',
        'sescontestpackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sescontestpackage_general' => array(
            'route' => 'contestpackage/:action/*',
            'defaults' => array(
                'module' => 'sescontestpackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(contest|confirm-upgrade|cancel)',
            )
        ),
        'sescontestpackage_payment' => array(
            'route' => 'contestpayment/:action/*',
            'defaults' => array(
                'module' => 'sescontestpackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish)',
            )
        )
    ),
);
?>
