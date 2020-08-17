<?php

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sessubscribeuser',
        'version' => '4.8.13',
        'path' => 'application/modules/Sessubscribeuser',
        'title' => 'User Subscriber Plugin',
        'description' => 'User Subscriber Plugin',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sessubscribeuser/settings/install.php',
            'class' => 'Sessubscribeuser_Installer',
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
            0 => 'application/modules/Sessubscribeuser',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sessubscribeuser.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
      'sessubscribeuser_package', 'sessubscribeuser_gateway', 'sessubscribeuser_order', 'sessubscribeuser_remainingpayment', 'sessubscribeuser_usergateway', 'sessubscribeuser_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
      // User - General
      'sessubscribeuser_extended' => array(
        'route' => 'subscriber/:controller/:action/*',
        'defaults' => array(
          'module' => 'sessubscribeuser',
          'controller' => 'index',
          'action' => 'index'
        ),
      ),
    )
);