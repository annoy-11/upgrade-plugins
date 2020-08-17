<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$productsRoute = "products";
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
  $productsRoute = $setting->getSetting('estore.stores.manifest', 'stores').'/'.$setting->getSetting('sesproduct.products.manifest', 'sesproducts');
  $productRoute = $setting->getSetting('estore.stores.manifest', 'store').'/'.$setting->getSetting('sesproduct.product.manifest', 'product');
}
return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesproduct',
	//'sku' => 'sesproduct',
    'version' => '5.1.0p2',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '5.0.0',
        ),
    ),
    'path' => 'application/modules/Sesproduct',
    'title' => 'SES - Stores Marketplace - Products Plugin',
    'description' => 'SES - Stores Marketplace - Products Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Sesproduct/settings/install.php',
      'class' => 'Sesproduct_Installer',
    ),
    'directories' => array(
      'application/modules/Sesproduct',
    ),
    'files' => array(
      'application/languages/en/sesproduct.csv',
    ),
  ),
  // Compose
  'composer' => array(
    'sesproduct' => array(
      'script' => array('_composeProduct.tpl', 'sesproduct'),
      'auth' => array('sesproduct', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesproduct_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesproduct_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Sesproduct_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Sesproduct_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Sesproduct_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Sesproduct_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesproduct',
    'sesproduct_addresses',
    'sesproduct_combination',
    'sesproduct_cartproducts',
    'sesproduct_parameter',
    'sesproduct_ordercheques',
    'sesproduct_orderproduct',
    'sesproduct_claim',
    'sesproduct_category',
    'sesproduct_dashboards',
    'sesproduct_album',
    'sesproduct_photo',
    'sesproductreview',
    'sesproduct_categorymapping',
    'sesproduct_slide',
    'sesproduct_wishlist',
    'sesproduct_playlistproduct',
    'sesproduct_order',
    'sesproduct_gateway',
    'sesproduct_usergateway',
    'sesproduct_transaction',
    'sesproduct_orderaddresses',
    'sesproduct_userpayrequest',
    'sesproduct_ordercheques',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'sesproduct_specific' => array(
      'route' => $productsRoute.'/:action/:product_id/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'product_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesproduct_create' => array(
      'route' => $productsRoute.'/:action/store_id/:store_id/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'index',
        'action' => 'create',
      ),
      'reqs' => array(
        'action' => '(create)',
      ),
    ),
    'sesproduct_general' => array(
      'route' => $productsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'index',
        'action' => 'home',
      ),
      'reqs' => array(
        'action' => '(compare|index|browse|manage|style|tag|upload-photo|link-product|product-request|tags|home|claim|claim-requests|locations|rss-feed|contributors|create)',
      ),
    ),
    'sesproduct_order' => array(
            'route' => $productsRoute.'/order/:action/:product_id/*',
            'defaults' => array(
                'module' => 'sesproduct',
                'controller' => 'order',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|checkout|process|return|finish|success|view|print-ticket|free-order|print-invoice|checkorder|email-ticket)',
            )
    ),
    'sesproduct_extended' => array(
        'route' => 'Sesproducts/:controller/:action/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'index',
            'action' => 'index',
        ),
        'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
        )
    ),
    'sesproduct_view' => array(
      'route' => $productRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
    'sesproduct_category_view' => array(
        'route' => $productsRoute.'/category/:category_id/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'category',
            'action' => 'index',
        )
    ),
    'sesproduct_entry_view' => array(
      'route' => $productRoute.'/:product_id/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),
      'sesproduct_cart' => array(
          'route' => $productRoute.'/cart/:action/*',
          'defaults' => array(
              'module' => 'sesproduct',
              'controller' => 'cart',
              'action' => 'index',
          ),
      ),
    'sesproductreview_extended' => array(
        'route' => $productsRoute.'/reviews/:action/:review_id/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'review',
            'action' => 'index',
        ),
        'reqs' => array(
            'review_id' => '\d+',
        )
    ),
    'sesproduct_specific_album' => array(
        'route' =>  'product-album/:action/:album_id',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'album',
            'action' => 'view',
        ),
            'reqs' => array(
            'album_id' => '\d+'
        )
    ),
    'sesproductreview_view' => array(
        'route' => $productsRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete)',
            'review_id' => '\d+'
        )
    ),
    'sesproduct_dashboard' => array(
        'route' => $productsRoute.'/dashboard/:action/:product_id/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'dashboard',
            'action' => 'edit',
        )
    ),
      'sesproduct_cartproducts' => array(
          'route' => $productsRoute.'/dashboard-attributes/:action/:product_id/*',
          'defaults' => array(
              'module' => 'sesproduct',
              'controller' => 'attributes',
              'action' => 'attributes',
          )
      ),
      'sesproduct_category' => array(
        'route' => $productsRoute . '/categories/:action/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'category',
            'action' => 'browse',
        ),
        'reqs' => array(
            'action' => '(index|browse)',
        )
     ),
     'sesproduct_import' => array(
      'route' => $productsRoute.'/import/:action/*',
      'defaults' => array(
        'module' => 'sesproduct',
        'controller' => 'import',
        'action' => 'index',
      ),
      'reqs' => array('action' => '(index)')
    ),
    'sesproduct_wishlist' => array(
        'route' => $productsRoute.'/wishlist/:action',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'wishlist',
            'action' => 'browse',
        ),
        'reqs' => array(
            'action' => '(add)',
        )
    ),
    'sesproduct_payment' => array(
        'route' => $productsRoute.'/payment/:order_id/:action/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'payment',
            'action' => 'index',
        ),
    ),
    'sesproduct_wishlist_view' => array(
        'route' => $productsRoute.'/wishlist/:wishlist_id/:slug/:action/*',
        'defaults' => array(
            'module' => 'sesproduct',
            'controller' => 'wishlist',
            'action' => 'view',
            'slug' => '',
        ),
        'reqs' => array(
            'wishlist_id' => '\d+',
            'action' => '(add|edit|delete)',
        )
    ),
  ),
);
