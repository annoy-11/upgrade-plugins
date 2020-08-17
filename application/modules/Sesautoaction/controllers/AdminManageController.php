<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_dashboards');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('actions', 'sesautoaction')->getAction();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $action = Engine_Api::_()->getItem('sesautoaction_action', $value)->delete();
          $db->query("DELETE FROM engine4_sesautoaction_actions WHERE action_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }

  public function editAction() {

	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_dashboards');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Edit();

	$id = $this->_getParam('id');
    $this->view->item = $item = Engine_Api::_()->getItem('sesautoaction_action', $id);

    $data = array();
    foreach(explode(",",$item->resource_id) as $result) {
        $resource = Engine_Api::_()->getItem($item->resource_type, $result);
        $id = $resource->getIdentity();
        $data[$id] = $resource->getTitle();
    }
    $form->resource_id->setMultiOptions($data);
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
    unset($values['resource_type']);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

        if(isset($values['member_levels']))
            $item->member_levels = implode(',',$values['member_levels']);

        unset($values['member_levels']);
        $item->setFromArray($values);
        $item->save();
        $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('module' => 'sesautoaction', 'action' => 'index', 'controller' => 'manage'), 'admin_default', true);
  }

  public function createAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_dashboards');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Create();

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('actions', 'sesautoaction')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('actions', 'sesautoaction');
        $values = $form->getValues();
        if(isset($values['member_levels']))
            $values['member_levels'] = implode(',',$values['member_levels']);
        $resourceIds = $values['resource_id'];
        foreach($resourceIds as $resourceId) {
            $values['resource_id'] = $resourceId;
            $action = $table->createRow();
            $action->setFromArray($values);
            $action->save();
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_redirect('admin/sesautoaction/manage');
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_action', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/manage');
  }

  public function newsignupAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesautoaction_action', $id);
      $item->newsignup = !$item->newsignup;
      $item->save();
    }
    $this->_redirect('admin/sesautoaction/manage');
  }

  public function deleteAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesautoaction_Form_Admin_Delete();
    $form->setTitle('Delete This Action?');
    $form->setDescription('Are you sure that you want to delete this Auto Action? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesautoaction_action', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Action Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }
}
