<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$petitionRoute = "petition";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $petitionsRoute = $setting->getSetting('epetition.manifest', 'petitions');
  $petitionRoute = $setting->getSetting('epetition.petition.manifest', 'petition');
}

return array(
  'package' =>
    array(
      'type' => 'module',
      'name' => 'epetition',
      'sku' => 'epetition',
      'version' => '4.10.5',
      'dependencies' => array(
        array(
          'type' => 'module',
          'name' => 'core',
          'minVersion' => '4.10.5',
        ),
      ),
      'path' => 'application/modules/Epetition',
      'title' => 'SNS - Petition Plugin',
      'description' => 'SNS - Petition Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
        'path' => 'application/modules/Epetition/settings/install.php',
        'class' => 'Epetition_Installer',
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
          0 => 'application/modules/Epetition',
        ),
      'files' =>
        array(
          0 => 'application/languages/en/epetition.csv',
        ),
    ),
  'items' => array(
    'epetition',
    //'petitions',
    'epetition_dashboards',
    'epetition_category',
    'epetition_categorymapping',
    'epetition_album',
    'epetition_photo',
    'epetition_signature',
    'epetition_announcement',
    'epetition_admindecisionmaker',  //remove this
    'epetition_decisionmaker',
      'user',
  ),

  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Epetition_Plugin_Core',
    ),
    array(
      'event' => 'onRenderLayoutDefaultSimple',
      'resource' => 'Epetition_Plugin_Core'
    ),
    array(
      'event' => 'onRenderLayoutMobileDefault',
      'resource' => 'Epetition_Plugin_Core'
    ),
    array(
      'event' => 'onRenderLayoutMobileDefaultSimple',
      'resource' => 'Epetition_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Epetition_Plugin_Core',
    ),
  ),


  'routes' => array(
    'epetition_view' => array(
      'route' => $petitionRoute . '/:user_id/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
    'epetition_entry_view' => array(
      'route' => $petitionRoute . '/:epetition_id/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'index',
        'action' => 'view',
        //  'slug' => '',
      ),
      'reqs' => array(),
    ),
    'epetition_dashboard' => array(
      'route' => $petitionsRoute . '/dashboard/:action/:epetition_id/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'dashboard',
        'action' => 'edit',
      ),
      'reqs' => array(
        'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|petition-role|save-petition-admin|fields|upgrade|edit-location|petition-letter|petition-announcement|create-announcement|view-announcement|delete-announcement|edit-announcement|petition-signature|delete-dashboard-signature|view-dashboard-signature|edit-dashboard-signature|petition-decisionmaker|change-enable-deision-maker|add-decision-maker|getusers|decisionmaker|victory|deletesign|petition-victory|petition-close|reports|deleteforgutter|enabled)',
      )
    ),
    'epetition_category_view' => array(
      'route' => $petitionsRoute . '/category/:category_id/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'category',
        'action' => 'index',
      )
    ),
    'epetition_category' => array(
      'route' => $petitionsRoute . '/categories/:action/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'category',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse)',
      )
    ),

    'epetition_categorycreate' => array(
      'route' => $petitionsRoute . '/categories/:action/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'category',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse)',
      )
    ),
    'epetition_categoryviewpage' => array(
      'route' => $petitionsRoute . '/categories/:action/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'category',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse)',
      )
    ),
    'epetition_general' => array(
      'route' => $petitionsRoute . '/:action/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|index|browse|create|manage|style|tag|upload-photo|link-petition|petition-request|tags|home|locations|mysign|deleteforgutter)',
      ),
    ),

    'epetition_specific' => array(
      'route' => $petitionsRoute . '/:action/:epetition_id/*',
      'defaults' => array(
        'module' => 'epetition',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'epetition_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),

  ),


);
