<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Add Column in user table.
$table_exist = $db->query('SHOW TABLES LIKE \'engine4_users\'')->fetch();
if (!empty($table_exist)) {
  $blocked_levels = $db->query('SHOW COLUMNS FROM engine4_users LIKE \'blocked_levels\'')->fetch();
  if (empty($blocked_levels)) {
    $db->query("ALTER TABLE `engine4_users` ADD `blocked_levels` longtext NOT NULL;");
  }

  $blocked_networks = $db->query('SHOW COLUMNS FROM engine4_users LIKE \'blocked_networks\'')->fetch();
  if (empty($blocked_networks)) {
    $db->query("ALTER TABLE `engine4_users` ADD `blocked_networks` longtext NOT NULL;");
  }
}

//User profile lock page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesprofilelock_index_blocked')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesprofilelock_index_blocked',
      'displayname' => 'User Accounts - Block Members Page',
      'title' => 'Block Members Page',
      'description' => 'This page is the block members page.',
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
      'name' => 'user.settings-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesprofilelock.blocked-members',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 1,
      'params' => '{"title":"Blocked Members"}',
  ));
}
//Default slideimages work
$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesprofilelock' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "backgrounds" . DIRECTORY_SEPARATOR;

$slideImageTable = Engine_Api::_()->getDbtable('slideimages', 'sesprofilelock');
$select = $slideImageTable->select()
        ->from($slideImageTable->info('name'), array('slideimage_id', 'file_id'));
$results = $slideImageTable->fetchAll($select);
$i = 1;
foreach ($results as $result) {
  $slideImageName = 'bg' . $i;
  $slideImageName = $slideImageName . '.jpg';
  $fileId = $this->setPhoto($PathFile . $slideImageName);
  $db->query("UPDATE `engine4_sesprofilelock_slideimages` SET `file_id` = '" . $fileId->file_id . "' WHERE slideimage_id = " . $result->slideimage_id);
  $i++;
} 
