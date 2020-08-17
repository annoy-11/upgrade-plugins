<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Select Service
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesmediaimporter_index_index')
    ->limit(1)
    ->query()
    ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesmediaimporter_index_index',
      'displayname' => 'SES - Media Importer - Home Page',
      'title' => 'SES - Media Importer - Home Page',
      'description' => 'This page is the media importer home page.',
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
  
  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmediaimporter.importer-select',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => 1,
    'params' => '',
  ));
}

//Import Media
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmediaimporter_index_service')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesmediaimporter_index_service',
      'displayname' => 'SES - Media Importer - Media Import View Page',
      'title' => 'SES - Media Importer - Media Import View Page',
      'description' => 'This page is the media importer view page.',
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
  
  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmediaimporter.importer-service',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => 1,
    'params' => '',
  ));
}

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmediaimporter_admin_main_level", "sesmediaimporter", "Member Level Settings", "", \'{"route":"admin_default","module":"sesmediaimporter","controller":"level"}\', "sesmediaimporter_admin_main", "", 1);');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
  level_id as `level_id`,
  "sesmediaimporter" as `type`,
  "allow_service" as `name`,
  5 as `value`,
  \'["facebook", "instagram","flickr", "google", "px500","zip"]\' as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sesmediaimporter_import_error", "sesmediaimporter", "All the photos you were trying to upload are not uploaded as during the upload, the storage limit of your account got filled {var:$sesmediaLink}.", 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_sesmediaimporter_import_error", "sesmediaimporter", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]");');