<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminEducationsController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminEducationsController extends Core_Controller_Action_Admin {

  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_educations');

    $this->view->educations = Engine_Api::_()->getItemTable('sesjob_education')->fetchAll();
  }


  public function addEducationAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Sesjob_Form_Admin_Education_Add();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-educations/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-educations/form.tpl');
      return;
    }


    // Process
    $values = $form->getValues();

    $educationTable = Engine_Api::_()->getItemTable('sesjob_education');
    $db = $educationTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();

    try {
      $educationTable->insert(array(
        'education_name' => $values['label'],
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

  public function deleteEducationAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $education_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->education_id = $education_id;
    $educationsTable = Engine_Api::_()->getDbtable('educations', 'sesjob');
    $education = $educationsTable->find($education_id)->current();

    if( !$education ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $education_id = $education->getIdentity();
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-educations/delete.tpl');
      return;
    }

    // Process
    $db = $educationsTable->getAdapter();
    $db->beginTransaction();

    try {

      $education->delete();

//       $sesjobTable = Engine_Api::_()->getDbtable('sesjobs', 'sesjob');
//       $sesjobTable->update(array(
//         'education_id' => 0,
//       ), array(
//         'education_id = ?' => $education_id,
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

  public function editEducationAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $education_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->education_id = $id;
    $educationsTable = Engine_Api::_()->getDbtable('educations', 'sesjob');
    $education = $educationsTable->find($education_id)->current();

    if( !$education ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $education_id = $education->getIdentity();
    }

    $form = $this->view->form = new Sesjob_Form_Admin_Education_Add();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setField($education);

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-educations/form.tpl');
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-educations/form.tpl');
      return;
    }

    // Process
    $values = $form->getValues();

    $db = $educationsTable->getAdapter();
    $db->beginTransaction();

    try {
      $education->education_name = $values['label'];
      $education->save();

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
