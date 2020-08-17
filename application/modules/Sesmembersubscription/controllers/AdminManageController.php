<?php

class Sesmembersubscription_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmembersubscription_admin_main', array(), 'sesmembersubscription_admin_main_manage');

    $this->view->results = Engine_Api::_()->getItemTable('sesmembersubscription_commission')->fetchAll();
  }
  
  public function addAction() {
  
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Sesmembersubscription_Form_Admin_Add();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-manage/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-manage/form.tpl');
      return;
    }

    // Process
    $values = $form->getValues();

    $commissionTable = Engine_Api::_()->getItemTable('sesmembersubscription_commission');
    $db = $commissionTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();
    
    try {
      $commissionTable->insert(array(
        'from' => $values['from'],
        'to' => $values['to'],
        'commission_type' => $values['commission_type'],
        'commission_value' => $values['commission_value'],
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
  

  public function editAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $commission_id = $this->_getParam('id');
    $this->view->commission_id = $id;
    $commissionTable = Engine_Api::_()->getDbtable('commissions', 'sesmembersubscription');
    $commission = $commissionTable->find($commission_id)->current();
    
    if( !$commission ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $commission_id = $commission->getIdentity();
    }
    
    $form = $this->view->form = new Sesmembersubscription_Form_Admin_Add();
    $form->setTitle('Edit This Commission Value');
    $form->setDescription('Edit this commission value.');
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setField($commission);
    
    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/form.tpl');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-manage/form.tpl');
      return;
    }
    
    // Process
    $values = $form->getValues();
    
    $db = $commissionTable->getAdapter();
    $db->beginTransaction();
    
    try {
      $commission->from = $values['from'];
      $commission->to = $values['to'];
      $commission->commission_type = $values['commission_type'];
      $commission->commission_value = $values['commission_value'];
      $commission->save();
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

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->commission_id = $id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $commission = Engine_Api::_()->getItem('sesmembersubscription_commission', $id);
        $commission->delete();
        $db->commit();
      }

      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }
}