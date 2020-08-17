<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$db->query('INSERT IGNORE INTO `engine4_sespage_dashboards` (`type`, `title`, `enabled`, `main`) VALUES
("upgrade", "Upgrade Package", "1", "0");');

// profile page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagepackage_index_page')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagepackage_index_page',
      'displayname' => 'Page Directories - Package Page',
      'title' => 'Page Directories Package Page',
      'description' => 'This page lists page packages.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $topId,
  ));
  $topMiddleId = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => 2,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => 1,
  ));
}

// profile page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_package')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_package',
      'displayname' => 'Page Directories - Manage Package Page',
      'title' => 'Page Directories Manage Package Page',
      'description' => 'This page lists page packages.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $topId,
  ));
  $topMiddleId = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => 2,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => 1,
  ));
}

// profile page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_transactions')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_transactions',
      'displayname' => 'Page Directories - Package Transactions Page',
      'title' => 'Page Directories Package Transactions Page',
      'description' => 'This page lists page packages transactions.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $topId,
  ));
  $topMiddleId = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => 2,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => 1,
  ));
}
$db->update('engine4_sespage_pages', array('package_id' => 1));
$db->query('ALTER TABLE `engine4_sespagepackage_transactions` ADD `file_path` VARCHAR(255) NULL DEFAULT NULL');
$db->query('ALTER TABLE `engine4_sespagepackage_transactions` ADD `message` TEXT NULL DEFAULT NULL'); 

$db->query("ALTER TABLE `engine4_sespagepackage_transactions` ADD `credit_point` INT(11) NOT NULL DEFAULT '0', ADD `credit_value` FLOAT NOT NULL DEFAULT '0';"); 
$db->query("ALTER TABLE `engine4_sespagepackage_transactions` ADD `ordercoupon_id` INT NULL DEFAULT '0';");


