<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageautofriendController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminManageautofriendController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_autofriend');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('friends', 'sesautoaction')->getFriend();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $row = Engine_Api::_()->getItem('sesautoaction_friend', $value)->delete();
          $db->query("DELETE FROM engine4_sesautoaction_friends WHERE action_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }

  public function editAction() {

	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_autofriend');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Editautofriend();

	$id = $this->_getParam('id');
    $this->view->item = $item = Engine_Api::_()->getItem('sesautoaction_friend', $id);

    if($item->member_levels) {
      $item->member_levels = explode(",",$item->member_levels);
    }
    if($item->users) {
      $item->users = explode(",",$item->users);
    }
    $form->populate($item->toArray());

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $values = $form->getValues();
    unset($values['resource_id']);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

        if(isset($values['member_levels']))
            $item->member_levels = implode(',',$values['member_levels']);

        if(isset($values['users']))
            $item->users = implode(',',$values['users']);
        unset($values['users']);
        unset($values['member_levels']);
        $item->setFromArray($values);
        $item->save();
        $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('module' => 'sesautoaction', 'action' => 'index', 'controller' => 'manageautofriend'), 'admin_default', true);
  }

  public function createAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_autofriend');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Autofriend();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('friends', 'sesautoaction')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('friends', 'sesautoaction');
        $values = $form->getValues();

        if(isset($values['member_levels']))
            $values['member_levels'] = implode(',',$values['member_levels']);
        if(isset($values['users']))
            $values['users'] = implode(',',$values['users']);
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_redirect('admin/sesautoaction/manageautofriend');
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_friend', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/manageautofriend');
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Deleteautofriend();
    $form->setTitle('Delete This Entry?');
    $form->setDescription('Are you sure that you want to delete this entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesautoaction_friend', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manageautofriend/delete.tpl');
  }
}
