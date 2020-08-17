<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$crowdfundingsRoute = "crowdfundings";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $crowdfundingsRoute = $setting->getSetting('sescrowdfunding.crowdfundings.manifest', 'crowdfundings');
  $crowdfundingRoute = $setting->getSetting('sescrowdfunding.crowdfunding.manifest', 'crowdfunding');
}


return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sescrowdfunding',
    //'sku' => 'sescrowdfunding',
    'version' => '4.10.5p1',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sescrowdfunding',
    'title' => 'SES - Crowdfunding / Charity / Fundraising / Donations Plugin',
    'description' => 'SES - Crowdfunding / Charity / Fundraising / Donations Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sescrowdfunding/settings/install.php',
        'class' => 'Sescrowdfunding_Installer',
    ),
    'actions' =>
    array(
        0 => 'install',
        1 => 'upgrade',
        2 => 'refresh',
        3 => 'enable',
        4 => 'disable',
    ),
    'directories' =>
    array(
        0 => 'application/modules/Sescrowdfunding',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sescrowdfunding.csv',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sescrowdfunding_category',
    'crowdfunding',
    'sescrowdfunding_album',
    'sescrowdfunding_photo',
    'sescrowdfunding_announcement',
    'sescrowdfunding_order',
    'sescrowdfunding_gateway',
    'sescrowdfunding_transaction',
    'sescrowdfunding_remainingpayment',
    'sescrowdfunding_dashboards',
    'sescrowdfunding_userpayrequest',
    'sescrowdfunding_reward',

  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sescrowdfunding_specific' => array(
      'route' => $crowdfundingsRoute.'/:action/:crowdfunding_id/*',
      'defaults' => array(
        'module' => 'sescrowdfunding',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'crowdfunding_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sescrowdfunding_general' => array(
      'route' => $crowdfundingsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sescrowdfunding',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|browse|create|manage|tag|upload-photo|tags|home|manage-donations|manage-received-donations|messageowner|tellafriend|crowdfunding-owner-faqs|doners-faqs)',
      ),
    ),
    'sescrowdfunding_entry_view' => array(
      'route' => $crowdfundingRoute.'/:crowdfunding_id/*',
      'defaults' => array(
        'module' => 'sescrowdfunding',
        'controller' => 'index',
        'action' => 'view',
      ),
    ),
    'sescrowdfunding_dashboard' => array(
      'route' => $crowdfundingsRoute.'/dashboard/:action/:crowdfunding_id/*',
      'defaults' => array(
        'module' => 'sescrowdfunding',
        'controller' => 'dashboard',
        'action' => 'edit',
      ),
      'reqs' => array(
        'action' => '(edit|edit-photo|remove-photo|contact-information|edit-location|manage-photos|upload|announcements|post-announcement|edit-announcement|delete-announcement|currency-converter|view-doners|account-details|payment-requests|payment-transaction|payment-request|detail-payment|delete-payment|payment-transaction|donations-stats|donations-reports|overview|announcement|seo|advertise-crowdfunding|backgroundphoto|style|remove-backgroundphoto|manage-team|rewards|post-reward|edit-reward|delete-reward|design)',
      )
    ),

//     'sescrowdfunding_account' => array(
//       'route' => $crowdfundingsRoute.'/:gateway_id/*',
//       'defaults' => array(
//         'module' => 'sescrowdfunding',
//         'controller' => 'dashboard',
//         'action' => 'account-details',
//       ),
//     ),

    'sescrowdfunding_category_view' => array(
      'route' => $crowdfundingsRoute.'/category/:category_id/*',
      'defaults' => array(
        'module' => 'sescrowdfunding',
        'controller' => 'category',
        'action' => 'index',
      )
    ),

    'sescrowdfunding_category' => array(
      'route' => $crowdfundingsRoute . '/categories/:action/*',
      'defaults' => array(
          'module' => 'sescrowdfunding',
          'controller' => 'category',
          'action' => 'browse',
      ),
      'reqs' => array(
          'action' => '(index|browse)',
      )
    ),
    'sescrowdfunding_payment' => array(
        'route' => $crowdfundingsRoute.'/payment/:order_id/:action/*',
        'defaults' => array(
            'module' => 'sescrowdfunding',
            'controller' => 'order',
            'action' => 'donate',
        ),
    ),
    'sescrowdfunding_album_specific' => array(
        'route' => $crowdfundingsRoute.'/:action/:album_id/:crowdfunding_id/*',
        'defaults' => array(
            'module' => 'sescrowdfunding',
            'controller' => 'album',
            'action' => 'upload'
        ),
        'reqs' => array(
            'action' => '(upload|upload-photo|addphoto-crowdfundingprofile|edit-photo|save-information)',
        ),
    ),
  ),
);
