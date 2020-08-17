<?php
return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'sesmetatag',
    //'sku' => 'sesmetatag',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesmetatag',
    'title' => 'SES - Social Meta Tags Plugin',
    'description' => 'SES - Social Meta Tags Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesmetatag/settings/install.php',
        'class' => 'Sesmetatag_Installer',
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
        0 => 'application/modules/Sesmetatag',
    ),
    'files' =>
    array(
      0 => 'application/languages/en/sesmetatag.csv',
      1 => 'public/admin/social_share.jpg',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesmetatag_managemetatag',
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesmetatag_Plugin_Core'
    ),
  ),
);
