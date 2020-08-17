<?php return array (
  'package' => array(
      'type' => 'module',
      'name' => 'sesgroupalbum',
      'version' => '4.8.10',
      'path' => 'application/modules/Sesgroupalbum',
      'title' => 'Group Album Extension',
      'description' => 'Group Album Extension',
      'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
      'actions' => array(
          'install',
          'upgrade',
          'refresh',
          'enable',
          'disable',
      ),
      'callback' => array(
          'path' => 'application/modules/Sesgroupalbum/settings/install.php',
          'class' => 'Sesgroupalbum_Installer',
      ),
      'directories' => array(
          'application/modules/Sesgroupalbum',
      ),
      'files' => array(
          'application/languages/en/sesgroupalbum.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
      array(
          'event' => 'onUserDeleteAfter',
          'resource' => 'Sesgroupalbum_Plugin_Core'
      ),
//       array(
//           'event' => 'onGroupCreateAfter',
//           'resource' => 'Sesgroupalbum_Plugin_Core'
//       ),
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Sesgroupalbum_Plugin_Core'
      ),
			array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Sesgroupalbum_Plugin_Core'
      )
			
  ),
	// Items --------------------------------------------------------------------
	'items' => array(
		'sesgroupalbum_photo',
		'sesgroupalbum_album',
	),
  // Routes --------------------------------------------------------------------
  'routes' => array(
  				'sesgroupalbum_general' => array(
            'route' => 'groupalbum/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesgroupalbum',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|browse|list|manage|upload|upload-photo|like|download|photo-home|browse-photo|share|tags|existing-photos)',
            ),
        ),
      'sesgroupalbum_extended' => array(
          'route' => 'groupalbums/:controller/:action/*',
          'defaults' => array(
              'module' => 'sesgroupalbum',
              'controller' => 'index',
              'action' => 'index'
          ),
      ),
            
      				'sesgroupalbum_specific_album' => array(
            'route' =>  'groupalbums/:slug/:album_id',
            'defaults' => array(
                'module' => 'sesgroupalbum',
                'controller' => 'album',
                'action' => 'view',
								'slug' =>''
            ),
            'reqs' => array(
							'album_id' => '\d+'
						)
        ),
        				 'sesgroupalbum_specific' => array(
            'route' => 'groupalbums/:controller/:action/:album_id/*',
            'defaults' => array(
                'module' => 'sesgroupalbum',
                'controller' => 'album',
                'action' => 'view'
            ),
            'reqs' => array(
                'action' => '(compose-upload|delete|edit|editphotos|upload|order|related-album|create)',
            ),
        ),
    ),
); ?>