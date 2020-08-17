<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdemouser_admin_main', array(), 'sesdemouser_admin_main_manageuser');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('demousers', 'sesdemouser')->getDemoUsers();

    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function addDemoMemberAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdemouser_admin_main', array(), 'sesdemouser_admin_main_manageuser');
    $this->_helper->layout->setLayout('admin-simple');

    //Render Form
    $this->view->form = $form = new Sesdemouser_Form_Admin_Add();
    $form->setDescription("Here, you can choose any existing site user to be added as a test user of your website.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $demousersTable = Engine_Api::_()->getDbtable('demousers', 'sesdemouser');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        if (!$values["user_id"]) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not chosen a member from the auto-suggest box. Please choose the site member from auto-suggest box below.");
          $form->addError($itemError);
          return;
        }

        $result = $demousersTable->getUserId(array('user_id' => $values["user_id"]));
        if (!empty($result)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("This member has already been added as test user, please choose any other member.");
          $form->addError($itemError);
          return;
        } else {

          if (empty($result)) {
            $row = $demousersTable->createRow();
            $row->user_id = $values["user_id"];
          }
          $row->setFromArray($values);
          $row->save();
          $db->commit();
        }
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
      //$this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('demousers', 'sesdemouser')->delete(array('demouser_id =?' => $this->_getParam('demouser_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed demo member entry.'))
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  public function multiDeleteAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $demousers = Engine_Api::_()->getItem('sesdemouser_demousers', (int) $value);
          if (!empty($demousers))
            $demousers->delete();
        }
      }
    }
    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function enabledAction() {

    $id = $this->_getParam('demouser_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesdemouser_demousers', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesdemouser/manage');
  }

  public function getusersAction() {

    $sesdata = array();
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $users_table->select()
								    ->where('level_id != ?', 1)
                    ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                    ->order('displayname ASC')->limit('40');
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

  public function orderteamAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('demousers', 'sesdemouser');
    $demousers = $table->fetchAll($table->select());
    foreach ($demousers as $demouser) {
      $order = $this->getRequest()->getParam('teams_' . $demouser->demouser_id);
      if (!$order)
        $order = 999;
      if ($order) {
        $demouser->order = $order;
        $demouser->save();
      }
    }
    return;
  }

}
