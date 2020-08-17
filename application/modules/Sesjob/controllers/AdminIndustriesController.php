<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminIndustriesController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminIndustriesController extends Core_Controller_Action_Admin {

  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_industries');

    $this->view->industries = Engine_Api::_()->getItemTable('sesjob_industry')->fetchAll();
  }


  public function addIndustryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Sesjob_Form_Admin_Industry_Add();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-industries/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-industries/form.tpl');
      return;
    }


    // Process
    $values = $form->getValues();

    $industryTable = Engine_Api::_()->getItemTable('sesjob_industry');
    $db = $industryTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();

    try {
      $industryTable->insert(array(
        'user_id' => $viewer->getIdentity(),
        'industry_name' => $values['label'],
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

  public function deleteIndustryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $industry_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->industry_id = $industry_id;
    $industriesTable = Engine_Api::_()->getDbtable('industries', 'sesjob');
    $industry = $industriesTable->find($industry_id)->current();

    if( !$industry ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $industry_id = $industry->getIdentity();
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-industries/delete.tpl');
      return;
    }

    // Process
    $db = $industriesTable->getAdapter();
    $db->beginTransaction();

    try {

      $industry->delete();

//       $sesjobTable = Engine_Api::_()->getDbtable('sesjobs', 'sesjob');
//       $sesjobTable->update(array(
//         'industry_id' => 0,
//       ), array(
//         'industry_id = ?' => $industry_id,
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

  public function editIndustryAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $industry_id = $this->_getParam('id');
    $this->view->sesjob_id = $this->view->industry_id = $id;
    $industriesTable = Engine_Api::_()->getDbtable('industries', 'sesjob');
    $industry = $industriesTable->find($industry_id)->current();

    if( !$industry ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $industry_id = $industry->getIdentity();
    }

    $form = $this->view->form = new Sesjob_Form_Admin_Industry_Add();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setField($industry);

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-industries/form.tpl');
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-industries/form.tpl');
      return;
    }

    // Process
    $values = $form->getValues();

    $db = $industriesTable->getAdapter();
    $db->beginTransaction();

    try {
      $industry->industry_name = $values['label'];
      $industry->save();

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
