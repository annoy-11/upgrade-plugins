<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfundingteam_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingteam');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingteam_admin_main', array(), 'sescrowdfundingteam_admin_main_manage');

    //$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingteam_admin_main', array(), 'sescrowdfundingteam_admin_main_manage');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('teams', 'sescrowdfundingteam')->getTeamMemers();
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  //Delete team member
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('teams', 'sescrowdfundingteam')->delete(array('team_id =?' => $this->_getParam('team_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed team member entry.'))
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Delete multiple team members
  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesteam_teams = Engine_Api::_()->getItem('sescrowdfundingteam_team', (int) $value);
          if (!empty($sesteam_teams))
            $sesteam_teams->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('team_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sescrowdfundingteam_team', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sescrowdfundingteam/manage/');
  }

  //Manage all designation
  public function designationsAction() {


    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingteam');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingteam_admin_main', array(), 'sescrowdfundingteam_admin_main_managedesignation');

    $designations_table = Engine_Api::_()->getDbTable('designations', 'sescrowdfundingteam');
    $select = $designations_table->select()->order('order ASC')->where('is_admincreated =?', 1);
    $this->view->paginator = $designations_table->fetchAll($select);
  }

  //Add new designation
  public function adddesignationAction() {

    //Set Layout
    $this->_helper->layout->setLayout('admin-simple');

    //Render Form
    $this->view->form = $form = new Sescrowdfundingteam_Form_Admin_Adddesignation();
    $form->setTitle('Add New Designation');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('designations', 'sescrowdfundingteam');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $row = $designations_table->createRow();
        $row->designation = $values["designation"];
        $row->save();
        $db->commit();

        if ($row->designation_id)
          $db->update('engine4_sescrowdfundingteam_designations', array('order' => $row->designation_id), array('designation_id = ?' => $row->designation_id));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully add designation.'))
      ));
    }
  }

  //Edit Designation
  public function editdesignationAction() {

    //Get designation id and make designation table object
    $designationItem = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $this->_getParam('designation_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sescrowdfundingteam_Form_Admin_Editdesignation();
    $form->setTitle('Edit Designation');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    //Must have an id
    if (!($id = $this->_getParam('designation_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($designationItem->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        //$db->update('engine4_sescrowdfundingteam_teams', array('designation' => $values["designation"]), array('designation_id = ?' => $this->_getParam('designation_id')));
        $designationItem->designation = $values["designation"];
        $designationItem->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit designation entry.')
      ));
    }

    //Output
    $this->renderScript('admin-manage/editdesignation.tpl');
  }

  //Delete designation
  public function deletedesignationAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $db->update('engine4_sescrowdfundingteam_teams', array('designation_id' => '', 'designation' => ''), array('designation_id = ?' => $this->_getParam('designation_id')));
        Engine_Api::_()->getDbtable('designations', 'sescrowdfundingteam')->delete(array('designation_id =?' => $this->_getParam('designation_id')));

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully delete entry'))
      ));
    }

    $this->renderScript('admin-manage/deletedesignation.tpl');
  }

  public function multiDeleteDesignationsAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();

      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $explodedKey = explode('_', $key);
          $slideImage = Engine_Api::_()->getItem('sescrowdfundingteam_designations', $explodedKey[1]);
          $slideImage->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'designations'));
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('designations', 'sescrowdfundingteam');
    $designations = $table->fetchAll($table->select());
    foreach ($designations as $designation) {
      $order = $this->getRequest()->getParam('designations_' . $designation->designation_id);
      if (!$order)
        $order = 999;
      $designation->order = $order;
      $designation->save();
    }
    return;
  }
}
