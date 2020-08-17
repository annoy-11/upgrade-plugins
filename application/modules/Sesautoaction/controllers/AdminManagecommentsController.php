<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManagecommentsController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminManagecommentsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managecomments');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('comments', 'sesautoaction')->getComment();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $action = Engine_Api::_()->getItem('sesautoaction_comment', $value)->delete();
          $db->query("DELETE FROM engine4_sesautoaction_comments WHERE comment_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }


  public function createAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managecomments');

    $this->view->form = $form = new Sesautoaction_Form_Admin_CreateComment();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('comments', 'sesautoaction')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('comments', 'sesautoaction');
        $values = $form->getValues();
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_redirect('admin/sesautoaction/managecomments');
    }
  }

  public function editAction() {

	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managecomments');

    $this->view->form = $form = new Sesautoaction_Form_Admin_EditComments();

	$id = $this->_getParam('id');
    $this->view->item = $item = Engine_Api::_()->getItem('sesautoaction_comment', $id);
    $form->populate($item->toArray());

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $values = $form->getValues();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
        $item->setFromArray($values);
        $item->save();
        $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('module' => 'sesautoaction', 'action' => 'index', 'controller' => 'managecomments'), 'admin_default', true);
  }


  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_comment', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/managecomments');
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesautoaction_Form_Admin_DeleteComment();
    $form->setTitle('Delete This Entry?');
    $form->setDescription('Are you sure that you want to delete this entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesautoaction_comment', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-managecomments/delete.tpl');
  }
}
