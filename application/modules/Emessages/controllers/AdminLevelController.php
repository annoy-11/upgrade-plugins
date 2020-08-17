<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminLevelController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Emessages_AdminLevelController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('emessages_admin_main', array(), 'emessages_admin_main_level');

    // Get level id
    if (null !== ($id = $this->_getParam('id'))) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }


    if (!$level instanceof isMessagesAdmin_Model_Level) {
      //throw new Engine_Exception('missing level');
    }

    //get level id
       $this->view->level_id = $id = $level->level_id;

    // Make form for  setting
    $this->view->form = $form = new Emessages_Form_Admin_Settings_Level(array(
      'public' => (in_array($level->type, array('public'))),
      'moderator' => (in_array($level->type, array('admin', 'moderator'))),
    ));
    $form->level_id->setValue($id);

    // Populate values
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');

    $form->populate($permissionsTable->getAllowed('emessages', $id, array_keys($form->getValues())));
    // Check post
    if (!$this->getRequest()->isPost()) {
      return;
    }

    // Check validitiy
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process

    $values = $form->getValues();

    if(isset($_POST['messages_auth']) && !empty($_POST['messages_auth']))
    {
	    $db_table = Engine_Db_Table::getDefaultAdapter();
	    $messages="messages";
	    $name="auth";
	    $db_table->update('engine4_authorization_permissions', array('params' =>trim($_POST['messages_auth'])), array('level_id = ?' =>$id, 'type = ?' =>$messages,'name = ?'=>$name));

    }

    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
      $permissionsTable->setAllowed('emessages', $id, $values);
      $claimValue = array('create' => $values['allow_claim']);
      $permissionsTable->setAllowed('emessages_claim', $id, $claimValue);

      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
}
