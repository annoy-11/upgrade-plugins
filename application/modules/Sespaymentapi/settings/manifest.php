<?php 

return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sespaymentapi',
    'version' => '4.9.4',
    'path' => 'application/modules/Sespaymentapi',
    'title' => 'SES - Payment API Plugin',
    'description' => 'SES - Payment API Plugin',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Sespaymentapi/settings/install.php',
        'class' => 'Sespaymentapi_Installer',
    ),
    'directories' => array(
        'application/modules/Sespaymentapi',
    ),
    'files' => array(
        'application/languages/en/sespaymentapi.csv',
    ),
  ),
  //Items
  'items' => array(
    'sespaymentapi_usergateway', 'sespaymentapi_order', 'sespaymentapi_gateway', 'sespaymentapi_transaction', 'sespaymentapi_remainingpayment', 'sespaymentapi_package', 'sespaymentapi_userpayrequest', 'sespaymentapi_refundrequest'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
      'sespaymentapi_extended' => array(
      'route' => 'payment-settings/index/:action/*',
      'defaults' => array(
        'module' => 'sespaymentapi',
        'controller' => 'index',
        'action' => 'account-details'
      ),
      'reqs' => array(
        'action' => '(account-details|manage-orders|manage-transactions|payment-requests|payment-transaction|refund-request)',
      )
    ),
  ),
);