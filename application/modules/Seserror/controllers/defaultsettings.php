<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-01-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// This code for maintance Mode, if site owner want to modified maintance page.
// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
// ("seserror_admin_main_maintenancemode", "seserror", "Maintenance Mode", "", \'{"route":"admin_default","module":"seserror","controller":"maintenancemode", "action":"index"}\', "seserror_admin_main", "", 6),
// ("seserror_admin_main_exception", "seserror", "Exception Page", "", \'{"route":"admin_default","module":"seserror","controller":"exception", "action":"index"}\', "seserror_admin_main", "", 80);');

$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seserror_error_comingsoon')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seserror_error_comingsoon',
      'displayname' => 'SES - Error - Coming Soon Page',
      'title' => 'Coming Soon Page',
      'description' => 'This page is coming soon page.',
      'custom' => 0,
      'layout' => 'default-simple',
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seserror.comingsoon',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seserror_error_view')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seserror_error_view',
      'displayname' => 'SES - Error - Page Not Found Page',
      'title' => 'Page Not Found',
      'description' => 'This page is page not found page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seserror.pagenotfound',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seserror_error_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seserror_error_index',
      'displayname' => 'SES - Error - Private Page',
      'title' => 'Private Error Page',
      'description' => 'This page is private error page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seserror.private',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

//Sign in requried page
$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '9')
        ->where('name = ?', 'middle')
        ->limit(1)
        ->query()
        ->fetchColumn();
if($parent_content_id) {
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seserror.auth-bg-image',
      'page_id' => 9,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}
