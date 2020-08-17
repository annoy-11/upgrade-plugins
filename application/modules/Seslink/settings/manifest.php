<?php 

return array (
  'package' => array(
    'type' => 'module',
    'name' => 'seslink',
    'version' => '4.10.5',
    'path' => 'application/modules/Seslink',
    'title' => 'SES - External Link and Topic Sharing Plugin',
    'description' => 'SES - External Link and Topic Sharing Plugin',
    'author' => '<a href="http://www.socialenginesolutions.com" style="link-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Seslink/settings/install.php',
        'class' => 'Seslink_Installer',
    ),
    'directories' => array(
        'application/modules/Seslink',
    ),
    'files' => array(
        'application/languages/en/seslink.csv',
    ),
  ),
  'items' => array(
    'seslink_link'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'seslink_entry_view' => array(
      'route' => 'links/:user_id/:link_id/:slug',
      'defaults' => array(
        'module' => 'seslink',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'link_id' => '\d+'
      ),
    ),
    'seslink_specific' => array(
      'route' => 'links/:action/:link_id/*',
      'defaults' => array(
        'module' => 'seslink',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'link_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'seslink_general' => array(
      'route' => 'links/:action/*',
      'defaults' => array(
        'module' => 'seslink',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage)',
      ),
    ),
  ),
);
