<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminLevelController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_AdminLevelController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_level');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_level', array(), 'courses_admin_main_courselvl');
    // Get level id
    if( null !== ($id = $this->_getParam('id')) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if(!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;
    // Make form
    $this->view->form = $form = new Courses_Form_Admin_Course_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    // Populate values
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed('courses', $id, array_keys($form->getValues())));
    // Check post
    if( !$this->getRequest()->isPost())
      return;
    // Check validitiy
    if( !$form->isValid($this->getRequest()->getPost()))
      return;

    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
      $permissionsTable->setAllowed('courses', $id, $values);
      $claimValue = array('create' => $values['allow_claim']);
      $permissionsTable->setAllowed('courses_claim', $id, $claimValue);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
 public function classLevelAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_level');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_level', array(), 'courses_admin_main_clslvl');

    // Get level id
    if( null !== ($id = $this->_getParam('id')) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }

    if(!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;

    // Make form
    $this->view->form = $form = new Courses_Form_Admin_Classroom_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    // Populate values
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed('eclassroom', $id, array_keys($form->getValues())));
    // Check post
    if( !$this->getRequest()->isPost())
      return;

    // Check validitiy
    if( !$form->isValid($this->getRequest()->getPost()))
      return;

    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
      $permissionsTable->setAllowed('eclassroom', $id, $values);
      $permissionsTable->setAllowed('classroom', $id, $values);
      $claimValue = array('create' => $values['allow_claim']);
      $permissionsTable->setAllowed('classroom_claim', $id, $claimValue);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
}
