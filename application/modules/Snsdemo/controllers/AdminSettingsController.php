<?php

class Snsdemo_AdminSettingsController extends Core_Controller_Action_Admin
{

  public function themesAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('snsdemo_admin_main', array(), 'snsdemo_admin_main_themes');

    $this->view->themes = Engine_Api::_()->getItemTable('snsdemo_theme')->fetchAll();
  }

  
  public function addThemeAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Snsdemo_Form_Admin_Theme();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    
    // Process
    $values = $form->getValues();
    
    

    $themeTable = Engine_Api::_()->getItemTable('snsdemo_theme');
    $db = $themeTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();
    
    try {
      $row = $themeTable->createRow();
      $row->setFromArray($values);
      $row->save();
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

  public function deleteThemeAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $theme_id = $this->_getParam('id');
    $this->view->snsdemo_id = $this->view->theme_id = $theme_id;
    $themesTable = Engine_Api::_()->getDbtable('themes', 'snsdemo');
    $theme = $themesTable->find($theme_id)->current();
    
    if( !$theme ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $theme_id = $theme->getIdentity();
    }
    
    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-settings/delete.tpl');
      return;
    }
    
    // Process
    $db = $themesTable->getAdapter();
    $db->beginTransaction();
    
    try {
      
      $theme->delete();
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

  public function editThemeAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $theme_id = $this->_getParam('id');
    $this->view->snsdemo_id = $this->view->theme_id = $id;
    $themesTable = Engine_Api::_()->getDbtable('themes', 'snsdemo');
    $theme = $themesTable->find($theme_id)->current();
    
    if( !$theme ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $theme_id = $theme->getIdentity();
    }
    
    $form = $this->view->form = new Snsdemo_Form_Admin_Theme();
    $form->populate($theme->toArray());
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    
    
    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    // Process
    $values = $form->getValues();
    
    $db = $themesTable->getAdapter();
    $db->beginTransaction();
    
    try {
      $theme->setFromArray($values);
      $theme->save();
      
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
  

  public function servicesAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('snsdemo_admin_main', array(), 'snsdemo_admin_main_services');

    $this->view->services = Engine_Api::_()->getItemTable('snsdemo_service')->fetchAll();
  }

  
  public function addServiceAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Snsdemo_Form_Admin_Service();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    
    // Process
    $values = $form->getValues();
    
    

    $serviceTable = Engine_Api::_()->getItemTable('snsdemo_service');
    $db = $serviceTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();
    
    try {
      $row = $serviceTable->createRow();
      $row->setFromArray($values);
      $row->save();
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

  public function deleteServiceAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $service_id = $this->_getParam('id');
    $this->view->snsdemo_id = $this->view->service_id = $service_id;
    $servicesTable = Engine_Api::_()->getDbtable('services', 'snsdemo');
    $service = $servicesTable->find($service_id)->current();
    
    if( !$service ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $service_id = $service->getIdentity();
    }
    
    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-settings/delete.tpl');
      return;
    }
    
    // Process
    $db = $servicesTable->getAdapter();
    $db->beginTransaction();
    
    try {
      
      $service->delete();
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

  public function editServiceAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $service_id = $this->_getParam('id');
    $this->view->snsdemo_id = $this->view->service_id = $id;
    $servicesTable = Engine_Api::_()->getDbtable('services', 'snsdemo');
    $service = $servicesTable->find($service_id)->current();
    
    if( !$service ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $service_id = $service->getIdentity();
    }
    
    $form = $this->view->form = new Snsdemo_Form_Admin_Service();
    $form->populate($service->toArray());
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    
    
    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-settings/form.tpl');
      return;
    }
    
    // Process
    $values = $form->getValues();
    
    $db = $servicesTable->getAdapter();
    $db->beginTransaction();
    
    try {
      $service->setFromArray($values);
      $service->save();
      
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
