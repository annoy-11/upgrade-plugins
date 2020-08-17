<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManagetabsController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminManagetabsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_managetabs');

    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_tab')->getTabs();
  }

  public function createAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_managetabs');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managetab_Create();

    $showElements = array();
    foreach ($_POST as $key => $value) {
      if ($key == 'name' || $key == 'submit' || empty($value))
        continue;
      $showElements[$key] = $value;
    }
    $this->view->showElements = $showElements;

    //If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $table = Engine_Api::_()->getItemTable('sespagebuilder_tab');
    $values = $form->getValues();

    $db = Engine_Db_Table::getDefaultAdapter();

    foreach ($_POST as $key => $value) {
      $columnName = $key;
      if ($columnName == 'name' || $columnName == 'submit')
        continue;

      $explodedColumnName = explode('_', $columnName);

      if (!isset($explodedColumnName[2]))
        continue;

      $explodedString = explode('_', $key);
      $explodeKey = @end($explodedString);
      $column = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_tabs LIKE '$columnName'")->fetch();
      if (empty($column)) {
        if ($explodeKey == 'name')
          $db->query("ALTER TABLE `engine4_sespagebuilder_tabs` ADD $columnName VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");
        else
          $db->query("ALTER TABLE `engine4_sespagebuilder_tabs` ADD $columnName LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
      }
    }

    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $tabs = $table->createRow();
      $tabs->setFromArray($values);
      $tabs->save();
      $tabId = $tabs->tab_id;
      $db->commit();
      if (isset($_POST['save']))
        return $this->_helper->redirector->gotoRoute(array('action' => 'edit', 'id' => $tabId));
      else
        return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_managetabs');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managetab_Edit();

    $tabId = $this->_getParam('id');
    $this->view->showElements = $tab = Engine_Api::_()->getItem('sespagebuilder_tab', $tabId);

    //Populate form
    $form->populate($tab->toArray());

    //Check post/form
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $tab->setFromArray($values);
      $tab->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('action' => 'edit', 'id' => $tabId));
    else
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function deleteAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Tab?');
    $form->setDescription('Are you sure that you want to delete this tab entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getItem('sespagebuilder_tab', $this->_getParam('id'))->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete this tab entry.')
      ));
    }
  }

  public function showContainerTypeAction() {

    $this->view->tab_id = $this->_getParam('tab_id');
    $this->view->form = new Sespagebuilder_Form_Admin_Managetab_Container();
  }

  public function showPopupAction() {

    $this->view->short_code = $this->_getParam('short_code', null);
  }

}
