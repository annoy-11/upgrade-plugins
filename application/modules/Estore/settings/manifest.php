<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $storesRoute = $setting->getSetting('estore.stores.manifest', 'stores');
  $storeRoute = $setting->getSetting('estore.store.manifest', 'store');
}
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'estore',
        //'sku' => 'estore',
        'version' => '4.10.5p2',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Estore',
        'title' => 'SES - Stores Marketplace Plugin',
        'description' => 'SES - Stores Marketplace Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Estore/settings/install.php',
            'class' => 'Estore_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' => array(
            'application/modules/Estore',
        ),
        'files' => array(
            'application/languages/en/estore.csv',
            'public/admin/stores-category-banner.jpg',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Estore_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onCommentCreateAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeCreateAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onCoreCommentDeleteAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onActivityCommentDeleteAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onActivityLikeDeleteAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'onActivitySubmittedAfter',
            'resource' => 'Estore_Plugin_Core'
        ),
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Estore_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Estore_Plugin_Core'
        ),
    ),
    //composer
    'composer' => array(
        'estore_photo' => array(
            'script' => array('_composeEstoreAlbum.tpl', 'estore'),
            'plugin' => 'Estore_Plugin_Albumcomposer',
        ),
        'estore' => array(
            'script' => array('_composeEstore.tpl', 'estore'),
            'plugin' => 'Estore_Plugin_Composer',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'estore_category',
        'stores',
        'estore_parameter',
        'estore_review',
        'estore_taxes',
        'estore_shippingmethod',
        'estore_taxstate',
        'estore_dashboards',
        'estore_follower',
        'estore_favourite',
        'estore_location',
        'estore_locationphoto',
        'estore_announcement',
        'estore_memberrole',
        'estore_crosspost',
        'estore_storerole',
        'estore_album',
        'estore_photo',
        'estore_managestoreapp',
        'estore_service',
        'estore_claim',
        'estore_country',
        'estore_state',
        'estore_offer',
        'estore_slides'
    ),
    'routes' => array(
        'estore_profile' => array(
            'route' => $storeRoute . '/:id/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),
        'estorealbum_general' => array(
          'route' => $storeRoute.'-albums/:action/*',
          'defaults' => array(
            'module' => 'estore',
            'controller' => 'album',
            'action' => 'home',
          ),
          'reqs' => array(
            'action' => '(home|browse)',
          )
        ),
        'estore_specific_album' => array(
            'route' =>  $storeRoute.'-album/:action/:album_id/*',
            'defaults' => array(
            'module' => 'estore',
            'controller' => 'album',
            'action' => 'view',
          ),
          'reqs' => array(
            'album_id' => '\d+'
          )
        ),
        'estore_photo_view' => array(
          'route' => $storeRoute.'/photo/:action/*',
          'defaults' => array(
            'module' => 'estore',
            'controller' => 'photo',
            'action' => 'view',
          ),
          'reqs' => array(
            'controller' => '\D+',
            'action' => '\D+',
          )
        ),
        'estore_extended' => array(
            'route' => $storesRoute . '/:controller/:action/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
        'estore_dashboard' => array(
            'route' => $storesRoute . '/dashboard/:action/:store_id/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
        ),
        'account_details' => array(
            'route' => $storesRoute . '/:store_id/gateway_type/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'dashboard',
                'action' => 'account-details',
            ),
        ),
        'estore_general' => array(
            'route' => $storesRoute . '/:action/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'index',
                'action' => 'welcome',
            ),
            'reqs' => array(
                'action' => '(sesbackuplandingppage|welcome|browse|create|delete|manage|home|edit|delete|tags|browse-locations|contact|close|show-login-page|pinboard|featured|sponsored|hot|verified|localpick|claim|claim-requests|package|transactions)',
            )
        ),
        'estore_category_view' => array(
            'route' => $storesRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'estore_order' => array(
            'route' => $storesRoute.'/order/:action/:store_id/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'order',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|checkout|process|return|finish|success|view|print-ticket|free-order|print-invoice|checkorder|email-ticket)',
            )
        ),
        'estore_account' =>array(
            'route' => $storesRoute.'/manage-account/:action/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'manage',
                'action' => 'index',
            ),
        ),
        'estore_category' => array(
            'route' => $storesRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'estore',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'estorereview_view' => array(
        'route' => $storesRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'estore',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete|edit-review)',
            'review_id' => '\d+'
        )
    ),
    )
);
