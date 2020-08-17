<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$forumsRoute = "forums";
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
  $forumsRoute = $setting->getSetting('sesforum.forums.manifest', 'forums');
  $forumRoute = $setting->getSetting('sesforum.forum.manifest', 'forum');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesforum',
    //'sku' => 'sesforum',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesforum',
    'title' => 'SES - Advanced Forums Plugin',
    'description' => 'SES - Advanced Forums Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'enable',
      'disable',
    ),
    'callback' => array(
      'path' => 'application/modules/Sesforum/settings/install.php',
      'class' => 'Sesforum_Installer',
    ),
    'directories' => array(
      'application/modules/Sesforum',
    ),
    'files' => array(
      'application/languages/en/sesforum.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesforum_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteAfter',
      'resource' => 'Sesforum_Plugin_Core'
    ),
    array(
      'event' => 'addActivity',
      'resource' => 'Sesforum_Plugin_Core'
    ),
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesforum_Plugin_Core',
    ),
    array(
      'event' => 'getActivity',
      'resource' => 'Sesforum_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
  //  'sesforum', // Hack, sesforum_forum should be removed
    'sesforum_forum',
    'sesforum_category',
    'sesforum_container',
    'sesforum_post',
    'sesforum_signature',
    'sesforum_topic',
    'sesforum_list',
    'sesforum_list_item',
    'sesforum_subscribe',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesforum_general' => array(
      'route' => $forumsRoute.'/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'index',
        'action' => 'index'
      ),
    ),
    'sesforum_tags' => array(
      'route' => $forumsRoute.'-tags/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'index',
        'action' => 'tags'
      ),
    ),
    'sesforum_search' => array(
      'route' => 'topics/search/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'index',
        'action' => 'search'
      ),
    ),
    'sesforum_extend' => array(
      'route' => $forumRoute.'-dashboard/:type/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'index',
        'action' => 'dashboard'
      ),
    ),
    'sesforum_forum' => array(
      'route' => $forumsRoute.'/:forum_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'forum',
        'action' => 'view',
        'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(create|edit|delete|view|topic-create)',
        'slug' => '[\w-]+',
      ),
    ),
    'sesforum_topic' => array(
      'route' => $forumsRoute.'/topic/:topic_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'topic',
        'action' => 'view',
        'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(edit|delete|close|rename|move|sticky|view|watch|post-create)',
        'slug' => '[\w-]+',
      ),
    ),
    'sesforum_post' => array(
      'route' => $forumsRoute.'/post/:post_id/:action/*',
      //'route' => 'sesforums/post/:post_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'post',
        'action' => 'view',
        //'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(edit|delete)',
        //'slug' => '[\w-]+',
      ),
    ),
    'sesforum_category' => array(
      'route' => $forumsRoute.'/category/:category_id/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'category',
        'action' => 'view',
      ),
    ),
    'sesforum_photo' => array(
      'route' => $forumRoute.'/*',
      'defaults' => array(
        'module' => 'sesforum',
        'controller' => 'index',
        'action' => 'upload-photo'
      )
    ),
  )
);
