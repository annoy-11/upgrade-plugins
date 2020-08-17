<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
// Check if it's already been placed
$select = new Zend_Db_Select($db);
$hasWidget = $select
        ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
        ->where('name = ?', 'sesevent_sponsorship_view-sponsorship')
        ->limit(1)
        ->query()
        ->fetchColumn();
// Add it
if (empty($hasWidget)) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesevent_sponsorship_view-sponsorship',
      'displayname' => 'SES - Advanced Events - Event Sponsorship View Page',
      'title' => 'SES - Event Sponsorship View Page',
      'description' => 'This page is Event Sponsorship View Page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  // Insert top-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
  // Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesevent.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesevent.sponsorship-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

  