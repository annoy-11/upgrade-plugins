<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageusersController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminManageusersController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_manageusers');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('users', 'sesautoaction')->getUser();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $action = Engine_Api::_()->getItem('sesautoaction_user', $value)->delete();
          $db->query("DELETE FROM engine4_sesautoaction_users WHERE user_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }


  public function createAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesautoaction_Form_Admin_Add();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('users', 'sesautoaction')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('users', 'sesautoaction');
        $values = $form->getValues();
        $values['displayname'] = $values['name'];
        $user = $table->createRow();
        $user->setFromArray($values);
        $user->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('User Added successfully.')
      ));
    }
  }

  //Add new team member using auto suggest
  public function getusersAction() {

    $sesdata = array();

    $autouserstable = Engine_Api::_()->getDbTable('users', 'sesautoaction');
    $autouserstableName = $autouserstable->info('name');

    $exselect = $autouserstable->select()->from($autouserstableName);
    $resultsex = $autouserstable->fetchAll($exselect);
    $exIds = array();
    foreach($resultsex as $result) {
        $exIds[] = $result->resource_id;
    }

    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $users_table->select()
                    ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                    ->order('displayname ASC')->limit('40');
    if(count($exIds) > 0)
        $select = $select->where('user_id NOT IN (?)', $exIds);
    $users = $users_table->fetchAll($select);

    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_user', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/manageusers');
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Delete();
    $form->setTitle('Remove This Entry?');
    $form->setDescription('Are you sure that you want to remove this user? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Remove');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesautoaction_user', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry Deleted Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manageusers/delete.tpl');
  }
}
