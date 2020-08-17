<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSpecialitiesController.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_AdminSpecialtiesController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_managespecialties');

    //Get all adminspecialties
    $this->view->adminspecialties = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getSpecialty(array('column_name' => '*', 'param' => 'athletic'));
    
  }

  public function addAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->adminspecialty_id = $this->_getParam('adminspecialty_id');
    $this->view->subid = $this->_getParam('subid');

    //Generate and assign form
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Specialty_Add();
    if (empty($this->view->adminspecialty_id)) {
      $form->setTitle('Add New Specialty');
      $form->name->setLabel('Name');
    } elseif ($this->view->adminspecialty_id && empty($this->view->subid)) {
      $form->setTitle('Add New 2nd-level Specialty');
      $form->name->setLabel('Name');
    } else {
      $form->setTitle('Add 3rd-level Specialty');
      $form->name->setLabel('Name');
    }

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $row = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->createRow();

        //Subspecialty and third level Specialty work
        if ($this->view->adminspecialty_id && empty($this->view->subid))
          $values['subid'] = $this->view->adminspecialty_id;
        elseif ($this->view->adminspecialty_id && $this->view->subid)
          $values['subsubid'] = $this->view->adminspecialty_id;
        $values['type'] = json_encode($_POST['type']);
        $row->setFromArray($values);
        $row->save();

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully create specialty.')
      ));
    }
  }

  public function editAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesprofilefield_Form_Admin_Specialty_Edit();
    $sptparam = $this->_getParam('sptparam');
    if ($sptparam == 'main') {
      $form->setTitle('Edit this Specialty');
      $form->name->setLabel('Name');
    } elseif ($sptparam == 'sub') {
      $form->setTitle('Edit this 2nd-level Specialty');
      $form->name->setLabel('Name');
    } elseif ($sptparam == 'subsub') {
      $form->setTitle('Edit this 3rd-level Specialty');
      $form->name->setLabel('Name');
    }

    $id = $this->_getParam('id');
    $specialty = Engine_Api::_()->getItem('sesprofilefield_adminspecialty', $id);
    $form->populate($specialty->toArray());
    if($sptparam == 'subsub')
    $form->type->setValue(json_decode($specialty->type));

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check 
    if (!$form->isValid($this->getRequest()->getPost())) {
      if (empty($_POST['name'])) {
        $form->addError($this->view->translate("Specialty Name * Please complete this field - it is required."));
      }
      return;
    }

    $values = $form->getValues();

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $specialty->type = json_encode($_POST['type']);
      $specialty->name = $values['name'];
      $specialty->save();
      
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array('You have successfully edit specialty.')
    ));
  }

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->id = $id = $this->_getParam('id');
    $this->view->sptparam = $sptparam = $this->_getParam('sptparam');

    $specialtyTable = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield');

    $this->view->subspecialty = $specialtyTable->getModuleSubspecialty(array('column_name' => "*", 'adminspecialty_id' => $id));
    $this->view->subsubspecialty = $specialtyTable->getModuleSubsubspecialty(array('column_name' => "*", 'adminspecialty_id' => $id));

    $specialty = $specialtyTable->find($id)->current();

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        //Delete specialty then we have empty corrosponding value in main table of contents.
//         if ($sptparam == 'main') {
//           $specialtyTable->update(array('adminspecialty_id' => 0), array('adminspecialty_id = ?' => $id));
//         } elseif ($sptparam == 'sub') {
//           $specialtyTable->update(array('subid' => 0), array('subid = ?' => $id));
//         } elseif ($sptparam == 'subsub') {
//           $specialtyTable->update(array('subsubid' => 0), array('subsubid = ?' => $id));
//         }
        $specialty->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully deleted.')
      ));
    }
    //Output
    $this->renderScript('admin-specialties/delete.tpl');
  }
}