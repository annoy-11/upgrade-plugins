<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'snsdemo',
    'version' => '4.10.0',
    'sku' => 'snsdemo',
    'path' => 'application/modules/Snsdemo',
    'title' => 'Demo Plugin',
    'description' => '',
    'author' => '',
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Snsdemo',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/snsdemo.csv',
    ),
  ),
  'items' => array(
    'snsdemo_theme', 'snsdemo_service'
  ),
);
