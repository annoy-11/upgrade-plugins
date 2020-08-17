<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Member Profile Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'user_profile_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
if($page_id) {
  $main_id = $db->select()
            ->from('engine4_core_content', 'content_id')
            ->where('page_id = ?', $page_id)
            ->where('name = ?', 'main')
            ->limit(1)
            ->query()
            ->fetchColumn();

  $left_id = $db->select()
          ->from('engine4_core_content', 'content_id')
          ->where('page_id = ?', $page_id)
          ->where('name = ?', 'left')
          ->limit(1)
          ->query()
          ->fetchColumn();

  $right_id = $db->select()
          ->from('engine4_core_content', 'content_id')
          ->where('page_id = ?', $page_id)
          ->where('name = ?', 'right')
          ->limit(1)
          ->query()
          ->fetchColumn();

  if($left_id) {
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmemveroth.verify-button-badge',
      'page_id' => $page_id,
      'parent_content_id' => $left_id,
      'order' => 999,
      'params' => '{"showdetails":["button","badge","details"],"title":"","nomobile":"0","name":"sesmemveroth.verify-button-badge"}',
    ));
  }
  if($right_id) {
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmemveroth.verify-button-badge',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => 999,
      'params' => '{"showdetails":["button","badge","details"],"title":"","nomobile":"0","name":"sesmemveroth.verify-button-badge"}',
    ));
  }
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesmemveroth_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesmemveroth', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('sesmemveroth', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sesmemveroth.displaycomment", "1"),
("sesmemveroth.enablecomment", "1"),
("sesmemveroth.enableverification", "2"),
("sesmemveroth.verifybadge", "0");');
