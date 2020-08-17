<?php return array(
  'package' =>
  array(
    'type' => 'module',
    'name' => 'eocsso',
    'version' => '4.10.3p7',
    'sku' => 'eocsso',
    'path' => 'application/modules/Eocsso',
    'title' => 'SES - SSO OC(Opencart) Server Plugin',
    'description' => '',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'author' => 'SES',
    'callback' =>
    array(
      'path' => 'application/modules/Eocsso/settings/install.php',
      'class' => 'Eocsso_Installer',
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
      0 => 'application/modules/Eocsso',
    ),
    'files' =>
    array(
      0 => 'application/languages/en/eocsso.csv',
    ),
  ),
  'items' =>
  array(
    'eocsso_client'
  ),
  'hooks' => array(
    array(
      'event' => 'onUserLoginAfter',
      'resource' => 'Eocsso_Plugin_Core'
    ),
    array(
      'event' => 'onUserSignupAfter',
      'resource' => 'Eocsso_Plugin_Core'
    ),
    array(
      'event' => 'onUserLogoutAfter',
      'resource' => 'Eocsso_Plugin_Core'
    ),
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Eocsso_Plugin_Core'
    ),
  ),
);