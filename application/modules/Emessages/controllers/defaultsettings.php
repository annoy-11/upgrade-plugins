77<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$db->query('UPDATE `engine4_core_menuitems` SET `label` = "Message Settings Page" WHERE `engine4_core_menuitems`.`name` = "emessages_settings_messagesetting";');

$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'emessages_messages_index')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'emessages_messages_index',
    'displayname' => 'SNS - Professional Messages - Messages Page',
    'title' => 'Messages',
    'description' => 'SNS - Professional Messages - Messages Page',
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
	$db->insert('engine4_core_content', array(
		'type' => 'widget',
		'name' => 'emessages.messages-view',
		'page_id' => $page_id,
		'parent_content_id' => $top_middle_id,
		'order' => 3,
		'params' => '[]',
	));
}


$page_id_setting = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'emessages_messagesetting_index')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id_setting) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'emessages_messagesetting_index',
    'displayname' => 'SNS - Professional Messages - Messages Settings Page',
    'title' => 'Message Settings Page',
    'description' => 'SNS - Professional Messages - Messages Settings Page',
    'custom' => 0,
  ));
  $page_id_setting = $db->lastInsertId();
  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id_setting,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id_setting,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id_setting,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id_setting,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
	$db->insert('engine4_core_content', array(
		'type' => 'widget',
		'name' => 'user.settings-menu',
		'page_id' => $page_id_setting,
		'parent_content_id' => $top_middle_id,
		'order' => 3,
		'params' => '[]',
	));
	$db->insert('engine4_core_content', array(
		'type' => 'widget',
		'name' => 'emessages.messages-settings',
		'page_id' => $page_id_setting,
		'parent_content_id' => $top_middle_id,
		'order' => 4,
		'params' => '[]',
	));
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Emessages_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => (in_array($level->type, array('admin', 'moderator'))),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('emessages', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('emessages', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
