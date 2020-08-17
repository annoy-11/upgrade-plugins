<?php 

return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sesmembersubscription',
    'version' => '4.10.2',
    'path' => 'application/modules/Sesmembersubscription',
    'title' => 'SES - Subscribe Member Profiles Plugin',
    'description' => 'SES - Subscribe Member Profiles Plugin',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Sesmembersubscription/settings/install.php',
        'class' => 'Sesmembersubscription_Installer',
    ),
    'directories' => array(
        'application/modules/Sesmembersubscription',
    ),
    'files' => array(
        'application/languages/en/sesmembersubscription.csv',
    ),
  ),
  'items' => array(
    'sesmembersubscription_commission'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // User - General
    'sesmembersubscription_extended' => array(
      'route' => 'subscriber/:controller/:action/*',
      'defaults' => array(
        'module' => 'sesmembersubscription',
        'controller' => 'index',
        'action' => 'index'
      ),
    ),
  )
);