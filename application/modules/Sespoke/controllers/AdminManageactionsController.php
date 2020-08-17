<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageactionsController.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_AdminManageactionsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespoke_admin_main', array(), 'sespoke_admin_main_manageactions');

    $select = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->select()->order('manageaction_id DESC');

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function addAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespoke_admin_main', array(), 'sespoke_admin_main_manageactions');

    $this->view->form = $form = new Sespoke_Form_Admin_Manage_Add();

    $this->view->manageModules = Engine_Api::_()->getItem('sespoke_manageaction', $this->_getParam('manageaction_id'));

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      if (empty($values['icon'])) {
        $error = Zend_Registry::get('Zend_Translate')->_("Icon is requried field. Please choose a icon for this.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }

      if (empty($values['image'])) {
        $error = Zend_Registry::get('Zend_Translate')->_("Image is requried field. Please choose a image for this.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }
      
      $manageactionsTable = Engine_Api::_()->getDbtable('manageactions', 'sespoke');

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $row = $manageactionsTable->createRow();

        if (@$values['member_levels'])
          $values['member_levels'] = json_encode(@$values['member_levels']);
        else
          $values['member_levels'] = json_encode($levelValues);

        //Upload add icon
        if (isset($_FILES['icon'])) {
          $photoFileIcon = $row->setPhoto($form->icon);
          if (!empty($photoFileIcon->file_id))
            $values['icon'] = $photoFileIcon->file_id;
        }

        $row->setFromArray($values);
        $row->save();
        $manageaction_id = $row->manageaction_id;

        //Image upload for attachement only
        if (isset($_FILES['image'])) {
          if(!empty($_FILES['image']['name'])){
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $storageObject = $storage->createFile($form->image, array(
              'parent_id' => $manageaction_id,
              'parent_type' => 'sespoke',
              'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            ));
            // Remove temporary file
            @unlink($file['tmp_name']);
            $row->image = $storageObject->file_id;
            $row->save();
          }
        }

        //Insert query in activity table.
        $name = strtolower(str_replace(' ', '_', $values['name']));
        $count = $db->query("SHOW COLUMNS FROM engine4_sespoke_userinfos LIKE '" . $name . "_count'")->fetch();
        if (empty($count)) {
          $db->query("ALTER TABLE `engine4_sespoke_userinfos` ADD `" . $name . "_count` INT(11) NOT NULL;");
        }

        if ($values['action'] == 'action') {

          //Activity work
          $db->query("DELETE FROM `engine4_activity_actiontypes` WHERE `engine4_activity_actiontypes`.`type` = 'sespoke_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES ("sespoke_' . $name . '", "sespoke", "{item:$subject} ' . $values['verb'] . ' {item:$object}.", 1, 6, 1, 1, 1, 1);');

          //Notification work
          $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sespoke_' . $name . '", "sespoke", "{item:$subject} ' . $values['verb'] . ' you. {var:$pokedPageLink}", 0, "");');

          $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_back_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sespoke_back_' . $name . '", "sespoke", "{item:$subject} ' . $values['verb'] . ' you back.", 0, "");');


          if (isset($values)) {
            $customCSV = APPLICATION_PATH . '/application/languages/en/custom.csv';
            if (file_exists($customCSV)) {
              $name = strtoupper($name);
              $translaterWriter = new Engine_Translate_Writer_Csv($customCSV);
              $translaterWriter->setTranslations(array(
                  $values['name'] => $values['name'],
                  $values['verb'] => $values['verb'],
                  '{item:$subject} ' . $values['name'] . ' {item:$object}.' => '{item:$subject} ' . $values['name'] . ' {item:$object}.',
                  '{item:$subject} ' . $values['name'] . ' you. {var:$pokedPageLink}' => '{item:$subject} ' . $values['name'] . ' you. {var:$pokedPageLink}',
                  '{item:$subject} ' . $values['name'] . ' you back.' => '{item:$subject} ' . $values['name'] . ' you back.',
                  "ADMIN_ACTIVITY_TYPE_SESPOKE_$name" => 'When a user (subject) ' . $values['name'] . ' on another user (object).',
                  "_ACTIVITY_ACTIONTYPE_SESPOKE_$name" => ucfirst($values['name']) . ' you',
                  "ACTIVITY_TYPE_SESPOKE_$name" => "When someone " . $values['name'] . " me.",
                  "ACTIVITY_TYPE_SESPOKE_BACK_$name" => "When someone " . $values['name'] . " me back."
              ));

              $translaterWriter->write();
              Zend_Registry::get('Zend_Cache')->clean();
            }
          }
        } elseif ($values['action'] == 'gift') {

          //Activity Work
          $db->query("DELETE FROM `engine4_activity_actiontypes` WHERE `engine4_activity_actiontypes`.`type` = 'sespoke_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES ("sespoke_' . $name . '", "sespoke", "{item:$subject} sent {item:$object} a ' . strtolower($values['name']) . '.", 1, 6, 1, 1, 1, 1);');

          //Notification Work
          $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sespoke_' . $name . '", "sespoke", "{item:$subject} sent you a ' . strtolower($values['name']) . '. {var:$pokedPageLink}", 0, "");');

          //Notification Work
          $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_back_$name' LIMIT 1");
          $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sespoke_back_' . $name . '", "sespoke", "{item:$subject} back ' . $values['name'] . ' to you.", 0, "");');

          if (isset($values)) {
            $customCSV = APPLICATION_PATH . '/application/languages/en/custom.csv';
            if (file_exists($customCSV)) {
              $name = strtoupper($name);
              $translaterWriter = new Engine_Translate_Writer_Csv($customCSV);
              $translaterWriter->setTranslations(array(
                  $values['name'] => $values['name'],
                  $values['verb'] => $values['verb'],
                  '{item:$subject} sent {item:$object} a ' . strtolower($values['name']) . '.' => '{item:$subject} sent {item:$object} a ' . strtolower($values['name']) . '.',
                  '{item:$subject} sent you a ' . strtolower($values['name']) . '. {var:$pokedPageLink}' => '{item:$subject} sent you a ' . strtolower($values['name']) . '. {var:$pokedPageLink}',
                  '{item:$subject} back ' . $values['name'] . ' to you.' => '{item:$subject} back ' . $values['name'] . ' to you.',
                  "ADMIN_ACTIVITY_TYPE_SESPOKE_$name" => 'When a user (subject) send ' . $values['name'] . ' to another user (object).',
                  "_ACTIVITY_ACTIONTYPE_SESPOKE_$name" => 'Send ' . ucfirst($values['name']),
                  "ACTIVITY_TYPE_SESPOKE_$name" => "When someone send " . $values['name'] . " to me.",
                  "ACTIVITY_TYPE_SESPOKE_BACK_$name" => "When someone send back " . $values['name'] . " to me."
              ));

              $translaterWriter->write();
              Zend_Registry::get('Zend_Cache')->clean();
            }
          }
        }

        //Gutter menu for member profile page only
        $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name` , `module` , `label` , `plugin` ,`params`, `menu`, `enabled`, `custom`, `order`) VALUES ("sespoke_gutter_create_' . $manageaction_id . '", "sespoke", "", \'Sespoke_Plugin_Menus::sespokeGutterCreate\', \'{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "' . $manageaction_id . '"}\', "user_profile", 1, 0, 1 )');

        //Email Work
        $db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES ("sespoke_poke", "sespoke", "[host],[email],[subject],[body],[recipient_title],[recipient_link],[recipient_photo],[object_link]");');

        $row->enabled_gutter = $values['enabled_gutter'];
        $row->save();

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  //Edit entry
  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespoke_admin_main', array(), 'sespoke_admin_main_manageactions');

    $this->view->form = $form = new Sespoke_Form_Admin_Manage_Edit();

    $manageaction_id = $this->_getParam('manageaction_id');
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $manageaction_id);
    $previousName = strtolower($manageActions->name);
    $manageActions['member_levels'] = json_decode($manageActions->member_levels);

    //Populate the from
    $form->populate($manageActions->toArray());
    $form->setTitle('Edit Entry');
    $form->setDescription('Here, you can edit action / gift, edit their settings and enabled, disable.');
    $form->execute->setLabel('Save Changes');

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $values = $form->getValues();
    if (empty($values['icon']))
      unset($values['icon']);
    if (empty($values['image']))
      unset($values['image']);
    unset($values['action']);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

      if (@$values['member_levels'])
        $values['member_levels'] = json_encode(@$values['member_levels']);
      else
        $values['member_levels'] = json_encode($levelValues);

      if (isset($_FILES['icon'])) {
        $addIcon = $manageActions->setPhoto($form->icon);
        if (!empty($addIcon->file_id))
          $values['icon'] = $addIcon->file_id;
      }
      $manageActions->setFromArray($values);
      $manageActions->save();

      //Image upload for attachement only
      if (isset($_FILES['image'])) {
        if(!empty($_FILES['image']['name'])){
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $storageObject = $storage->createFile($form->image, array(
            'parent_id' => $manageaction_id,
            'parent_type' => 'sespoke',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $manageActions->image = $storageObject->file_id;
          $manageActions->save();
        }
      }
        
      if ($values['enabled_gutter']) {
        $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sespoke_gutter_create_$manageaction_id';");
      } else {
        $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sespoke_gutter_create_$manageaction_id';");
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  //Delete entry
  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $manageaction_id = $this->_getParam('manageaction_id');
    $manageAction = Engine_Api::_()->getItem('sespoke_manageaction', $manageaction_id);
    $name = strtolower(str_replace(' ', '_', $manageAction->name));
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $db->query("DELETE FROM `engine4_sespoke_pokes` WHERE `engine4_sespoke_pokes`.`manageaction_id` = $manageaction_id;");
        $db->query("DELETE FROM `engine4_activity_actiontypes` WHERE `engine4_activity_actiontypes`.`type` = 'sespoke_$name' LIMIT 1");
        $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_$name' LIMIT 1");
        $db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sespoke_back_$name' LIMIT 1");
        $db->query("DELETE FROM `engine4_activity_actions` WHERE `engine4_activity_actions`.`type` = 'sespoke_$name'");
        $db->query("DELETE FROM `engine4_activity_notifications` WHERE `engine4_activity_notifications`.`type` = 'sespoke_$name'");
        $db->query("DELETE FROM `engine4_activity_notifications` WHERE `engine4_activity_notifications`.`type` = 'sespoke_back_$name'");
        $db->query("DELETE FROM `engine4_core_menuitems` WHERE `engine4_core_menuitems`.`name` = 'sespoke_gutter_create_$manageaction_id'");
        $count = $db->query("SHOW COLUMNS FROM engine4_sespoke_userinfos LIKE '" . $name . "_count'")->fetch();
        if (!empty($count)) {
          $db->query("ALTER TABLE `engine4_sespoke_userinfos` DROP `" . $name . "_count`;");
        }
        $manageAction->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete entry.')
      ));
    }
    $this->renderScript('admin-manageactions/delete.tpl');
  }

  //Enable / Disable Action
  public function enabledAction() {

    $param = $this->_getParam('param', null);
    $manageaction_id = $this->_getParam('manageaction_id', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $content = Engine_Api::_()->getItemTable('sespoke_manageaction')->fetchRow(array('manageaction_id = ?' => $manageaction_id));
    try {
      if ($param == 'activity') {
        $content->enable_activity = !$content->enable_activity;
        $content->save();
      } elseif ($param == 'action') {
        $content->enabled = !$content->enabled;
        $content->save();
      } elseif ($param == 'gutter') {
        $content->enabled_gutter = !$content->enabled_gutter;
        $content->save();
        $enabled_gutter = $this->_getParam('enabled_gutter', null);
        if ($enabled_gutter) {
          $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sespoke_gutter_create_$manageaction_id';");
        } else {
          $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sespoke_gutter_create_$manageaction_id';");
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

}
