<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'esenangpay',
    'version' => '4.0.0',
    'sku' => 'esenangpay',
    'path' => 'application/modules/Esenangpay',
    'title' => 'SES - Senangpay Payment Gateway',
    'description' => '',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">Social Networking Solutions</a>',
    'callback' => 
    array (
      'path' => 'application/modules/Esenangpay/settings/install.php',
      'class' => 'Esenangpay_Installer',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Esenangpay',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/esenangpay.csv',
    ),
  ),
); ?>