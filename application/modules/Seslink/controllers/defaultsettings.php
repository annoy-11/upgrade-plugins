<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// Browse page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslink_index_index')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslink_index_index',
    'displayname' => 'SES - External Link and Topic Sharing - Link Browse Page',
    'title' => 'Link Browse',
    'description' => 'This page lists link entries.',
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

  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslink.browse-menu',
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

  // Insert search
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslink.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $mainRightId,
    'order' => 1,
  ));
}

// profile page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslink_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslink_index_manage',
    'displayname' => 'SES - External Link and Topic Sharing - Link Manage Page',
    'title' => 'My Link',
    'description' => 'This page lists a user\'s link entries.',
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

  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslink.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslink.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $mainRightId,
    'order' => 1,
  ));
}
//Link View Page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslink_index_view')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslink_index_view',
    'displayname' => 'SES - External Link and Topic Sharing - Link View Page',
    'title' => 'Link View',
    'description' => 'This page displays a link entry.',
    'provides' => 'subject=seslink_link',
    'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $pageId,
  ));
  $mainId = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 1,
  ));
  $leftId = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 2,
  ));
  $middleId = $db->lastInsertId();


  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => 1,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => 2,
  ));
}

//Link create page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslink_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$pageId ) {

  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslink_index_create',
    'displayname' => 'SES - External Link and Topic Sharing - Create Page',
    'title' => 'Post New Link',
    'description' => 'This page is the link create page.',
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
    'name' => 'seslink.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
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