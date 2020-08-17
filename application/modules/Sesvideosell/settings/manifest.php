<?php 
return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'sesvideosell',
    'version' => '4.9.4',
    'path' => 'application/modules/Sesvideosell',
    'title' => 'SES - Advanced Videos - Sell Extension',
    'description' => 'SES - Advanced Videos - Sell Extension',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesvideosell/settings/install.php',
        'class' => 'Sesvideosell_Installer',
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
        0 => 'application/modules/Sesvideosell',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sesvideosell.csv',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesvideosell_order', 'sesvideosell_gateway', 'sesvideosell_transaction', 'sesvideosell_remainingpayment'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesvideosell_specific' => array(
      'route' => 'videosell/:video_id/:action/*',
      'defaults' => array(
          'module' => 'sesvideosell',
          'controller' => 'index',
          'action' => 'download',
      ),
    ),
    'sesvideosell_extended' => array(
      'route' => 'videoorders/*',
      'defaults' => array(
        'module' => 'sesvideosell',
        'controller' => 'index',
        'action' => 'orders'
      ),
    ),
    'sesvideosell_sold' => array(
      'route' => 'soldorders/*',
      'defaults' => array(
        'module' => 'sesvideosell',
        'controller' => 'index',
        'action' => 'sold'
      ),
    ),
  ),
);