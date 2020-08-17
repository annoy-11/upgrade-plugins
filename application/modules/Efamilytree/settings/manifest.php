<?php return [
  'package' =>
  [
    'type' => 'module',
    'name' => 'efamilytree',
    'version' => '4.10.5',
    'path' => 'application/modules/Efamilytree',
    'title' => 'Family Tree',
    'description' => 'Family Tree',
     'author' => '<a href="http://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
     'actions' => [
          'install',
          'upgrade',
          'refresh',
          'enable',
          'disable',
     ],
     'callback' => [
          'path' => 'application/modules/Efamilytree/settings/install.php',
          'class' => 'Efamilytree_Installer',
     ],
    'directories' =>
    [
      0 => 'application/modules/Efamilytree',
    ],
    'files' =>
    [
      0 => 'application/languages/en/efamilytree.csv',
    ],
  ],
    // Items ---------------------------------------------------------------------
    'items' => [
        'efamilytree_relation',
        'efamilytree_relative',
        'efamilytree_userdetail',
        'efamilytree_user'
    ],
    'routes' => [
        // Public
        'efamilytree_specific' => [
            'route' => 'familytree/:action/*',
            'defaults' => [
                'module' => 'efamilytree',
                'controller' => 'index',
                'action' => 'index',
            ],
        ],
    ]
]; ?>