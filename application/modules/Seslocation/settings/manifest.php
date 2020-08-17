<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'seslocation',
    'version' => '4.11',
    'sku' => 'seslocation',
    'path' => 'application/modules/Seslocation',
    'title' => 'SES - Location Based Member & Content Display',
    'description' => 'SES - Location Based Member & Content Display',
     'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => 
      array (
        0 => 'install',
        1 => 'upgrade',
        2 => 'refresh',
        3 => 'enable',
        4 => 'disable',
      ),
    'callback' => 
    array (
      'path' => 'application/modules/Seslocation/settings/install.php',
      'class' => 'Seslocation_Installer',
    ),
    
    'directories' => 
    array (
      0 => 'application/modules/Seslocation',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/seslocation.csv',
    ),
  ),
  // Items ---------------------------------------------------------------------
    'items' => array(
        
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
      array(
          'event' => 'onUserDeleteBefore',
          'resource' => 'Seslocation_Plugin_Core',
      ),
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Seslocation_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Seslocation_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutMobileDefault',
          'resource' => 'Seslocation_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutMobileDefaultSimple',
          'resource' => 'Seslocation_Plugin_Core'
      )
    ),
); ?>