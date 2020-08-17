<?php


$documentsRoute = "documents";
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
  $documentsRoute = $setting->getSetting('sesdocument.documents.manifest', 'documents');
  $documentRoute = $setting->getSetting('sesdocument.document.manifest', 'document');
}


 return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sesdocument',
    'sku' => 'sesdocument',
    'version' => '4.10.3p5',
    'path' => 'application/modules/Sesdocument',
    'title' => 'SES - Documents Sharing Plugin',
    'description' => 'SES - Documents Sharing Plugin',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesdocument/settings/install.php',
        'class' => 'Sesdocument_Installer',
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
        0 => 'application/modules/Sesdocument',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sesdocument.csv',
    ),
  ),
  'items' =>
  array(
    'sesdocument','sesdocument_category','sesdocument_dashboard' ,'sesdocument_photo'
  ),
  //Routes-----------------------------------------
  'routes' => array(
    'sesdocument_profile' => array(
            'route' =>$documentsRoute.'/:id/*',
            'defaults' => array(
                'module' => 'sesdocument',
                'controller' => 'profile',
                'action' => 'index',
            ),
        ),

    'sesdocument_general' => array(
      'route' => $documentsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesdocument',
        'controller' => 'index',
        'action' => 'index|browse|home',
      ),

    ),
    'sesdocument_like' => array(
      'route' => $documentsRoute.'/index/:action/*',
      'defaults' => array(
        'module' => 'sesdocument',
        'controller' => 'index',
        'action' => 'like|favourite|subcategory|subsubcategory',
      ),
    ),
    'sesdocument_profile' => array(
     'route' => $documentRoute.'/:id/*',
        'defaults' => array(
            'module' => 'sesdocument',
            'controller' => 'profile',
            'action' => 'index',
        ),
    ),
    'sesdocument_ajax' => array(
      'route' => $documentRoute.'/ajax/:action/*',
      'defaults' => array(
        'module' => 'sesdocument',
        'controller' => 'ajax',
        'action' => 'subcategory',
      ),
    ),

    'sesdocument_category_view' => array(
      'route' => $documentsRoute.'/category/:category_id/*',
      'defaults' => array(
         'module' => 'sesdocument',
         'controller' => 'category',
         'action' => 'index',
            )
        ),
    'sesdocument_category' => array(
      'route' => $documentsRoute.'/categories/:action/*',
      'defaults' => array(
         'module' => 'sesdocument',
         'controller' => 'category',
         'action' => 'browse',
            ),
            'reqs' => array(
            'action' => '(index|browse)',
            )
        ),
    'sesdocument_dashboard' => array(
            'route' => $documentRoute.'/dashboard/:action/:sesdocument_id/*',
            'defaults' => array(
                'module' => 'sesdocument',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|manage-ticket|contact-information|create-ticket|edit-ticket|delete-ticket|currency-converter|seo|event-termcondition|account-details|sales-stats|manage-orders|sales-reports|payment-requests|payment-request|delete-payment|detail-payment|payment-transaction|show-blog-request|ticket-information|search-ticket|style|overview|mainphoto|remove-mainphoto|edit-photo|remove-photo|backgroundphoto|remove-backgroundphoto)',
            )
        ),

  ),

); ?>
