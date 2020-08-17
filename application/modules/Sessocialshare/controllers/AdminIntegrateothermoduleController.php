<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminIntegrateothermoduleController.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sessocialshare_AdminIntegrateothermoduleController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialshare_admin_main', array(), 'sessocialshare_admin_main_managemodule');
    $this->view->enabledModules = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();
    $select = Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic')->select()->where('type =?', 'socialshare');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  public function addmoduleAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialshare_admin_main', array(), 'sessocialshare_admin_main_managemodule');
    $this->view->form = $form = new Sessocialshare_Form_Admin_Manageplugins_Add();
    $this->view->type = $type = $this->_getParam('type');
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $integrateothermoduleTable = Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic');
      $is_module_exists= $integrateothermoduleTable->fetchRow(array('content_type = ?' => $values['content_type'], 'module_name = ?' => $values['module_name'], 'type =?' => $type));
      
      if (!empty($is_module_exists)) {
        $error = Zend_Registry::get('Zend_Translate')->_("This Module already exist in our database.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }
			
      $contentTypeItem = Engine_Api::_()->getItemTable($values['content_type']);
			//get current content type item id
      $primaryId = current($contentTypeItem->info("primary"));
			//get primary key for content type
      if (!empty($primaryId))
        $values['content_id'] = $primaryId;

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $row = $integrateothermoduleTable->createRow();
        $values['type'] = $type;
        $row->setFromArray($values);
        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  public function editAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('integrateothermodule_id', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $integrateothermodule = Engine_Api::_()->getItem('sesbasic_integrateothermodule', $id);

    $this->view->form = $form = new Sessocialshare_Form_Admin_Manageplugins_Edit();
    
    $translate = Zend_Registry::get('Zend_Translate');
    if ($integrateothermodule->title)
      $form->title->setValue($translate->translate($integrateothermodule->title));

    if ($this->getRequest()->isPost()) {
    
      $values = $form->getValues();
      
      $db->update('engine4_sesbasic_integrateothermodules', array('title' => $_POST['title']), array('integrateothermodule_id = ?' => $id));

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialshare', 'controller' => 'integrateothermodule', 'action' => 'index'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
        'parentRedirect' => $redirectUrl,
        'messages' => 'You have successfully edit details.',
      ));
    }
  }

  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $content_type = $this->_getParam('content_type');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $integrateothermodule = Engine_Api::_()->getItem('sesbasic_integrateothermodule', $this->_getParam('integrateothermodule_id'));
        $integrateothermodule->delete();
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
    $this->renderScript('admin-integrateothermodule/delete.tpl');
  }

  public function enabledAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $content = Engine_Api::_()->getItemTable('sesbasic_integrateothermodule')->fetchRow(array('integrateothermodule_id = ?' => $this->_getParam('integrateothermodule_id')));
    try {
      $content->enabled = !$content->enabled;
      $content->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }
}