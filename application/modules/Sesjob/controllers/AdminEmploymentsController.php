<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminEmploymentsController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminEmploymentsController extends Core_Controller_Action_Admin {

  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_employments');

    $this->view->employments = Engine_Api::_()->getItemTable('sesjob_employment')->fetchAll();
  }


  public function addEmploymentAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Sesjob_Form_Admin_Employment_Add();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-employments/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-employments/form.tpl');
      return;
    }


    // Process
    $values = $form->getValues();

    $employmentTable = Engine_Api::_()->getItemTable('sesjob_employment');
    $db = $employmentTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();

    try {
      $employmentTable->insert(array(
        'employment_name' => $values['label'],
      ));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }

  public function deleteEmploymentAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $employment_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->employment_id = $employment_id;
    $employmentsTable = Engine_Api::_()->getDbtable('employments', 'sesjob');
    $employment = $employmentsTable->find($employment_id)->current();

    if( !$employment ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $employment_id = $employment->getIdentity();
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-employments/delete.tpl');
      return;
    }

    // Process
    $db = $employmentsTable->getAdapter();
    $db->beginTransaction();

    try {

      $employment->delete();

//       $sesjobTable = Engine_Api::_()->getDbtable('sesjobs', 'sesjob');
//       $sesjobTable->update(array(
//         'employment_id' => 0,
//       ), array(
//         'employment_id = ?' => $employment_id,
//       ));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }

  public function editEmploymentAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $employment_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->employment_id = $id;
    $employmentsTable = Engine_Api::_()->getDbtable('employments', 'sesjob');
    $employment = $employmentsTable->find($employment_id)->current();

    if( !$employment ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $employment_id = $employment->getIdentity();
    }

    $form = $this->view->form = new Sesjob_Form_Admin_Employment_Add();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setField($employment);

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-employments/form.tpl');
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-employments/form.tpl');
      return;
    }

    // Process
    $values = $form->getValues();

    $db = $employmentsTable->getAdapter();
    $db->beginTransaction();

    try {
      $employment->employment_name = $values['label'];
      $employment->save();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }
}
