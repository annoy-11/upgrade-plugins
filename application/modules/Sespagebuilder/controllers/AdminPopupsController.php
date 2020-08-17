<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPopupsController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminPopupsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_popups');
    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_popup')->getContent();
  }

  public function createAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_popups');
    $this->view->form = $form = new Sespagebuilder_Form_Admin_Popup_Popupcreate();
    $form->setTitle('Create New Modal Window');

    //If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $table = Engine_Api::_()->getDbtable('popups', 'sespagebuilder');
    $values = $form->getValues();

    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $bars = $table->createRow();
      $bars->setFromArray($values);
      $bars->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'edit', 'id' => $bars->popup_id), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'index'), 'admin_default', true);
  }

  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_popups');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Popup_Popupedit();
    $form->setTitle('Edit Progress Bar');

    $table = Engine_Api::_()->getItem('sespagebuilder_popup', $this->_getParam('id'));

    //Populate form
    $form->populate($table->toArray());

    //Check post/form
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $table->setFromArray($form->getValues());
      $table->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'edit', 'id' => $this->_getParam('id')), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'index'), 'admin_default', true);
  }

  public function deleteAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Modal Window?');
    $form->setDescription('Are you sure that you want to delete this modal window entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('popups', 'sespagebuilder')->delete(array('popup_id =?' => $this->_getParam('id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete this pop up entry.')
      ));
    }
  }

  public function duplicateModelAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $tableId = $this->_getParam('id');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $contentItem = Engine_Api::_()->getItem('sespagebuilder_popup', $tableId);
        $contentTable = Engine_Api::_()->getDbtable('popups', 'sespagebuilder');
        $tabs = $contentTable->createRow();
        $tabs->title = $contentItem->title;
        $tabs->description = $contentItem->description;
        $tabs->enable = $contentItem->enable;
        $tabs->type = $contentItem->type;
        $tabs->order = $contentItem->order;
        $tabs->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'edit', 'id' => $tableId), 'admin_default', true),
          'messages' => array('You have successfully duplicate this entry.')
      ));
    }
    //Output
    $this->renderScript('admin-popups/duplicate-model.tpl');
  }

}
