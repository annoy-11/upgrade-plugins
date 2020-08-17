<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminBotmanageactionController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminBotmanageactionController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managebotactions');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('botactions', 'sesautoaction')->getBotaction();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $action = Engine_Api::_()->getItem('sesautoaction_botaction', $value)->delete();
          $db->query("DELETE FROM engine4_sesautoaction_botactions WHERE botaction_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }


  //Add new team member using auto suggest
  public function getusersAction() {

    $sesdata = array();

//     $autouserstable = Engine_Api::_()->getDbTable('users', 'sesautoaction');
//     $autouserstableName = $autouserstable->info('name');
//
//     $exselect = $autouserstable->select()->from($autouserstableName);
//     $resultsex = $autouserstable->fetchAll($exselect);
//     $exIds = array();
//     foreach($resultsex as $result) {
//         $exIds[] = $result->resource_id;
//     }

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $table->select()
                    ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                    ->order('displayname ASC')->limit('40');
//     if(count($exIds) > 0)
//         $select = $select->where('user_id NOT IN (?)', $exIds);
    $users = $table->fetchAll($select);

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


  public function createAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managebotactions');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Createbotaction();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('botactions', 'sesautoaction')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('botactions', 'sesautoaction');
        $values = $form->getValues();
        if(isset($values['member_levels']))
            $values['member_levels'] = implode(',',$values['member_levels']);
        if(isset($values['users']))
            $values['users'] = implode(',',$values['users']);
        $action = $table->createRow();
        $action->setFromArray($values);
        $action->save();

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_redirect('admin/sesautoaction/botmanageaction');
    }
  }

  public function editAction() {

	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_managebotactions');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Editbotaction();

	$id = $this->_getParam('id');
    $this->view->item = $item = Engine_Api::_()->getItem('sesautoaction_botaction', $id);

    if($item->member_levels && !$this->item->actionperform) {
      $item->member_levels = explode(",",$item->member_levels);
    }
    if($item->users) {
      $item->users = explode(",",$item->users);
    }
    if($item->resource_id && $item->actionperform) {
        $user = Engine_Api::_()->getItem('user', $item->resource_id);
      $form->name->setValue($user->getTitle());
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
    unset($values['name']);
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
    return $this->_helper->redirector->gotoRoute(array('module' => 'sesautoaction', 'action' => 'index', 'controller' => 'botmanageaction'), 'admin_default', true);
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_botaction', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/botmanageaction');
  }

  public function newsignupAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_botaction', $id);
      $item->newsignup = !$item->newsignup;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/manage');
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesautoaction_Form_Admin_DeleteBotAction();
    $form->setTitle('Remove This Entry?');
    $form->setDescription('Are you sure that you want to remove this Entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Remove');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesautoaction_botaction', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Entry Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-botmanageaction/delete.tpl');
  }
}
