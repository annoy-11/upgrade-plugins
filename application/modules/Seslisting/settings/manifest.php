<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$listingsRoute = "listings";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $listingsRoute = $setting->getSetting('seslisting.listings.manifest', 'listings');
  $listingRoute = $setting->getSetting('seslisting.listing.manifest', 'listing');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'seslisting',
    //'sku' => 'seslisting',
    'version' => '4.10.5p1',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Seslisting',
    'title' => 'SES - Advanced Listing Plugin',
    'description' => 'SES - Advanced Listing Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Seslisting/settings/install.php',
      'class' => 'Seslisting_Installer',
    ),
    'directories' => array(
      'application/modules/Seslisting',
    ),
    'files' => array(
           'application/languages/en/seslisting.csv',
            'public/admin/listing-category-banner.jpg',
        ),
  ),
  // Compose
  'composer' => array(
    'seslisting' => array(
      'script' => array('_composeListing.tpl', 'seslisting'),
      'auth' => array('seslisting', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Seslisting_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Seslisting_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Seslisting_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Seslisting_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Seslisting_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Seslisting_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'seslisting',
    'seslisting_parameter',
    'seslisting_claim',
    'seslisting_category',
    'seslisting_dashboards',
    'seslisting_album',
    'seslisting_photo',
    'seslistingreview',
    'seslisting_categorymapping',
    'seslisting_integrateothermodule',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'seslisting_specific' => array(
      'route' => $listingsRoute.'/:action/:listing_id/*',
      'defaults' => array(
        'module' => 'seslisting',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'listing_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'seslisting_general' => array(
      'route' => $listingsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'seslisting',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|index|browse|create|manage|style|tag|upload-photo|link-listing|listing-request|tags|home|claim|claim-requests|locations|rss-feed|contributors)',
      ),
    ),

            'seslisting_extended' => array(
            'route' => 'Seslistings/:controller/:action/*',
            'defaults' => array(
                'module' => 'seslisting',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    'seslisting_view' => array(
      'route' => $listingRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'seslisting',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
		'seslisting_category_view' => array(
		    'route' => $listingsRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'seslisting',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
    'seslisting_entry_view' => array(
      'route' => $listingRoute.'/:listing_id/*',
      'defaults' => array(
        'module' => 'seslisting',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),
    'seslistingreview_extended' => array(
        'route' => $listingsRoute.'/reviews/:action/:listing_id/*',
        'defaults' => array(
            'module' => 'seslisting',
            'controller' => 'review',
            'action' => 'index',
        ),
        'reqs' => array(
            'listing_id' => '\d+',
            'action' => '(create)',
        )
    ),
            'seslisting_specific_album' => array(
					'route' =>  'listing-album/:action/:album_id',
					'defaults' => array(
							'module' => 'seslisting',
							'controller' => 'album',
							'action' => 'view',
						),
							'reqs' => array(
							'album_id' => '\d+'
						)
        ),
    'seslistingreview_view' => array(
        'route' => $listingsRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'seslisting',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete)',
            'review_id' => '\d+'
        )
    ),
            'seslisting_dashboard' => array(
            'route' => $listingsRoute.'/dashboard/:action/:listing_id/*',
            'defaults' => array(
                'module' => 'seslisting',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|listing-role|save-listing-admin|fields|upgrade|edit-location)',
            )
        ),
                'seslisting_review' => array(
            'route' => $listingsRoute.'/browse-review/:action/*',
            'defaults' => array(
                'module' => 'seslisting',
                'controller' => 'review',
                'action' => 'browse'
            ),
        ),
                'seslisting_category' => array(
            'route' => $listingsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'seslisting',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'seslisting_import' => array(
      'route' => $listingsRoute.'/import/:action/*',
      'defaults' => array(
        'module' => 'seslisting',
        'controller' => 'import',
        'action' => 'index',
      ),
      'reqs' => array(
                'action' => '(index)',
            )

    ),
  ),
);
