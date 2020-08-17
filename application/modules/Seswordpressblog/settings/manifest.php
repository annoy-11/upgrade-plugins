<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'seswordpressblog',
    'version' => '4.10.3',
    'path' => 'application/modules/Seswordpressblog',
    'title' => 'SES - Wordpress Blog Import Plugin',
    'description' => 'seswordpressblogplugin ',
    'author' => 'SocialEngineSolutions',
    'callback' => array(
      'path' => 'application/modules/Seswordpressblog/settings/install.php',
      'class' => 'Seswordpressblog_Installer',
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
      0 => 'application/modules/Seswordpressblog',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/seswordpressblog.csv',
    ),
  ),
  'hooks' => array(
  array(
    'event' => 'onSesblogBlogCreateAfter',
    'resource' => 'Seswordpressblog_Plugin_Core',
    ),
  ),
    'items' => array(
    'sesblog',
    'sesblog_blog',
    ),
); ?>