<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'coursesalbum',
    'version' => '4.10.5',
    'path' => 'application/modules/Coursesalbum',
    'title' => 'Courses Album Extension ',
    'description' => '',
    'author' => 'socialenginesolutions',
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
      0 => 'application/modules/Coursesalbum',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/coursesalbum.csv',
    ),
  ),
    // Hooks ---------------------------------------------------------------------
  'hooks' => array(
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Coursesalbum_Plugin_Core'
      ),
			array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Coursesalbum_Plugin_Core'
      )
			
  ),
  
  // Items --------------------------------------------------------------------
  'items' => array(
		'coursesalbum_photo',
		'coursesalbum_album',
	),
	  // Routes --------------------------------------------------------------------
  'routes' => array(
        'coursesalbum_general' => array(
          'route' => 'courses-albums/:action/*',
          'defaults' => array(
            'module' => 'coursesalbum',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
      ),
      'coursesalbum_extended' => array(
          'route' => 'coursesalbums/:controller/:action/*',
          'defaults' => array(
              'module' => 'coursesalbum',
              'controller' => 'index',
              'action' => 'index'
          ),
      ),
      'coursesalbum_photo_view' => array(
          'route' => 'coursesalbum/photo/:action/*',
          'defaults' => array(
            'module' => 'coursesalbum',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
      ),
      'coursesalbum_specific_album' => array(
          'route' =>  'coursesalbums/:action/:album_id/*',
          'defaults' => array(
              'module' => 'coursesalbum',
              'controller' => 'album',
              'action' => 'view',
              'slug' =>''
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
      ),
    ),
    
); ?>
