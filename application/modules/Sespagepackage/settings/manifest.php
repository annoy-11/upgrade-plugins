<?php

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespagepackage',
        'version' => '4.10.5p1',
        'path' => 'application/modules/Sespagepackage',
        'title' => 'SES - Page Directories - Packages for Allowing Page Creation Extension',
        'description' => 'SES - Page Directories - Packages for Allowing Page Creation Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespagepackage/settings/install.php',
            'class' => 'Sespagepackage_Installer',
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
            0 => 'application/modules/Sespagepackage',
        ),
        'files' => array(
            'application/languages/en/sespagepackage.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespagepackage_package',
        'sespagepackage_orderspackage',
        'sespagepackage_gateway',
        'sespagepackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sespagepackage_general' => array(
            'route' => 'pagepackage/:action/*',
            'defaults' => array(
                'module' => 'sespagepackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(page|confirm-upgrade|cancel)',
            )
        ),
        'sespagepackage_payment' => array(
            'route' => 'pagepayment/:action/*',
            'defaults' => array(
                'module' => 'sespagepackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish|fill-details)',
            )
        )
    ),
);
