<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$forumsRoute = "groupforums";
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
  $forumsRoute = $setting->getSetting('sesgroupforum.forums.manifest', 'groupforums');
  $forumRoute = $setting->getSetting('sesgroupforum.forum.manifest', 'groupforum');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesgroupforum',
    //'sku' => 'sesgroupforum',
    'version' => '4.10.5',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.10.5',
      ),
    ),
    'path' => 'application/modules/Sesgroupforum',
    'title' => 'SNS - Group Forums Extension',
    'description' => 'SNS - Group Forums Extension',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'enable',
      'disable',
    ),
    'callback' => array(
      'path' => 'application/modules/Sesgroupforum/settings/install.php',
      'class' => 'Sesgroupforum_Installer',
    ),
    'directories' => array(
      'application/modules/Sesgroupforum',
    ),
    'files' => array(
      'application/languages/en/sesgroupforum.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesgroupforum_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteAfter',
      'resource' => 'Sesgroupforum_Plugin_Core'
    ),
    array(
      'event' => 'addActivity',
      'resource' => 'Sesgroupforum_Plugin_Core'
    ),
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesgroupforum_Plugin_Core',
    ),
    array(
      'event' => 'getActivity',
      'resource' => 'Sesgroupforum_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesgroupforum', // Hack, sesgroupforum_forum should be removed
    //'sesgroupforum_forum',
    'sesgroupforum_category',
    'sesgroupforum_container',
    'sesgroupforum_post',
    'sesgroupforum_signature',
    'sesgroupforum_topic',
    'sesgroupforum_list',
    'sesgroupforum_list_item',
    'sesgroupforum_subscribe',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesgroupforum_general' => array(
      'route' => $forumsRoute.'/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'index',
        'action' => 'index'
      ),
    ),
    'sesgroupforum_tags' => array(
      'route' => $forumsRoute.'-tags/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'index',
        'action' => 'tags'
      ),
    ),
    'sesgroupforum_search' => array(
      'route' => 'topics/search/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'index',
        'action' => 'search'
      ),
    ),
    'sesgroupforum_extend' => array(
      'route' => $forumRoute.'-dashboard/:type/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'index',
        'action' => 'dashboard'
      ),
    ),
    'sesgroupforum_forum' => array(
      'route' => $forumsRoute.'/:forum_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'forum',
        'action' => 'view',
        'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(create|edit|delete|view|topic-create)',
        'slug' => '[\w-]+',
      ),
    ),
    'sesgroupforum_topic' => array(
      'route' => $forumsRoute.'/topic/:topic_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'topic',
        'action' => 'view',
        'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(edit|delete|close|rename|move|sticky|view|watch|post-create)',
        'slug' => '[\w-]+',
      ),
    ),
    'sesgroupforum_post' => array(
      'route' => $forumsRoute.'/post/:post_id/:action/*',
      //'route' => 'sesgroupforums/post/:post_id/:slug/:action/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'post',
        'action' => 'view',
        //'slug' => '-',
      ),
      'reqs' => array(
        'action' => '(edit|delete)',
        //'slug' => '[\w-]+',
      ),
    ),
    'sesgroupforum_category' => array(
      'route' => $forumsRoute.'/category/:category_id/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'category',
        'action' => 'view',
      ),
    ),
    'sesgroupforum_photo' => array(
      'route' => $forumRoute.'/*',
      'defaults' => array(
        'module' => 'sesgroupforum',
        'controller' => 'index',
        'action' => 'upload-photo'
      )
    ),
  )
);
