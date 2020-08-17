<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminProgressbarsController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminProgressbarsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');
    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_progressbar')->getContent();
  }

  public function createAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managecontent_Create();
    $form->setTitle('Create New Progress Bar');
    $form->setDescription('Below, enter progress name and choose its type to create a new progress bar.');
    $form->title->setLabel('Progress Bar Name');
    $form->title->setDescription('Enter the progress bar name. This name is for your indication only and will not be shown at user side.');

    //If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $table = Engine_Api::_()->getDbtable('progressbars', 'sespagebuilder');
    $values = $form->getValues();

    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $bars = $table->createRow();
      $bars->setFromArray($values);
      $bars->save();
      $db->commit();
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'index'), 'admin_default', true);
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');

    $this->view->content_id = $this->_getParam('content_id');
    $this->view->form = $form = new Sespagebuilder_Form_Admin_Managecontent_Edit();
    $form->setTitle('Edit This Progress Bar');
    $form->setDescription('Below, edit this progress bar name');
    $form->title->setLabel('Progress Bar Name');
    $form->title->setDescription('Enter the progress bar name. This name is for your indication only and will not be shown at user side.');

    $table = Engine_Api::_()->getItem('sespagebuilder_progressbar', $this->_getParam('id'));

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
    return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'index'), 'admin_default', true);
  }

  public function deleteAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Progress Bar?');
    $form->setDescription('Are you sure that you want to delete this progress bar entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('progressbars', 'sespagebuilder')->delete(array('progressbar_id =?' => $this->_getParam('id')));
        Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder')->delete(array('progressbar_id =?' => $this->_getParam('id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete this progress bar entry.')
      ));
    }
  }

  public function manageProgressbarAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');

    $this->view->content_id = $id = $this->_getParam('content_id');

    //Get all table columns
    $this->view->columns = Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder')->getProgressbarContent($id);
  }

  //Add table column
  public function addColumnAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');

    //Generate and assign form
    $this->view->form = $form = new Sespagebuilder_Form_Admin_Progressbar_Add();
    $this->view->content_id = $tableId = $this->_getParam('content_id');


    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $pricingTable = Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder');
        $row = $pricingTable->createRow();
        $values['progressbar_id'] = $tableId;
        $row->setFromArray($values);
        $row->save();
        $serializeArray['title_allign'] = $values['title_allign'];
        $serializeArray['value'] = $values['value'];
        $serializeArray['width'] = $values['width'];
        $serializeArray['title_color'] = $values['title_color'];
        $serializeArray['empty_bg_color'] = $values['empty_bg_color'];
        $serializeArray['filled_bg_color'] = $values['filled_bg_color'];
        if (isset($values['circle_width']))
          $serializeArray['circle_width'] = $values['circle_width'];
        else {
          $serializeArray['gradient_setting'] = $values['gradient_setting'];
          $serializeArray['height'] = $values['height'];
          $serializeArray['show_radius'] = $values['show_radius'];
        }
        if (isset($values['show_count']))
          $serializeArray['show_count'] = $values['show_count'];
        $serializeArrayResult = serialize($serializeArray);
        $row->settings = $serializeArrayResult;
        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      if (isset($_POST['save']))
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'edit-column', 'id' => $row->progressbarcontent_id, 'content_id' => $tableId), 'admin_default', true);
      else
        return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'manage-progressbar', 'content_id' => $tableId), 'admin_default', true);
    }
  }

  public function editColumnAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_progressbar');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Progressbar_Edit();

    $this->view->content_id = $tableId = $this->_getParam('content_id');
    $column_id = $this->_getParam('id');
    $this->view->showElements = $column = Engine_Api::_()->getItem('sespagebuilder_progressbarcontent', $column_id);
    $form->populate($column->toArray());
    $form->populate(unserialize($column->settings));
    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check 
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $values['progressbar_id'] = $tableId;
      $column->setFromArray($values);
      $column->save();
      $serializeArray['title_allign'] = $values['title_allign'];
      $serializeArray['value'] = $values['value'];
      $serializeArray['title_color'] = $values['title_color'];
      $serializeArray['width'] = $values['width'];
      $serializeArray['empty_bg_color'] = $values['empty_bg_color'];
      $serializeArray['filled_bg_color'] = $values['filled_bg_color'];
      if (isset($values['circle_width']))
        $serializeArray['circle_width'] = $values['circle_width'];
      else {
        $serializeArray['gradient_setting'] = $values['gradient_setting'];
        $serializeArray['height'] = $values['height'];
        $serializeArray['show_radius'] = $values['show_radius'];
      }
      if (isset($values['show_count']))
        $serializeArray['show_count'] = $values['show_count'];
      $serializeArrayResult = serialize($serializeArray);
      $column->settings = $serializeArrayResult;
      $column->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'edit-column', 'id' => $column_id, 'content_id' => $tableId), 'admin_default', true);
    else
      return $this->_helper->redirector->gotoRoute(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'manage-progressbar', 'content_id' => $tableId), 'admin_default', true);
  }

  //Delete accordion
  public function deleteColumnAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Progress Bar Content?');
    $form->setDescription('Are you sure that you want to delete this progress bar entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $this->view->id = $id = $this->_getParam('id');

    $progressbarContentTable = Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder');
    $column = $progressbarContentTable->find($id)->current();

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $column->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete progress bar column.')
      ));
    }
  }

  public function duplicateProgressbarAction() {

    //In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $tableId = $this->_getParam('id');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $contentItem = Engine_Api::_()->getItem('sespagebuilder_progressbarcontent', $tableId);

        $contentTable = Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder');
        $tabs = $contentTable->createRow();
        $tabs->title = $contentItem->title;
        $tabs->progressbar_id = $contentItem->progressbar_id;
        $tabs->settings = $contentItem->settings;
        $tabs->enable = $contentItem->enable;
        $tabs->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'edit-column', 'id' => $tableId, 'content_id' => $this->_getParam('content_id')), 'admin_default', true),
          'messages' => array('You have successfully duplicate this entry.')
      ));
    }
    //Output
    $this->renderScript('admin-progressbars/duplicate-progressbar.tpl');
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('progressbarcontents', 'sespagebuilder');
    $columns = $table->fetchAll($table->select());
    foreach ($columns as $column) {
      $order = $this->getRequest()->getParam('columns_' . $column->progressbarcontent_id);
      if ($order) {
        $column->order = $order;
        $column->save();
      }
    }
    return;
  }

}