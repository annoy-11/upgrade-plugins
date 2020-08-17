<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_menus');

    $this->view->storage = Engine_Api::_()->storage();
    $select = Engine_Api::_()->getDbTable('menuitems', 'core')->select()
            ->where('menu = ?', 'core_main')
            ->where('enabled = ?', 1)
            ->order('order ASC');
    $this->view->paginator = Engine_Api::_()->getDbTable('menuitems', 'core')->fetchAll($select);
  }

  public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_menus');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesexpose')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_sesexpose_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'sesexpose')->getAllSearchOptions();
  }


  public function orderManageSearchAction() {

    if (!$this->getRequest()->isPost())
      return;

    $managesearchoptionsTable = Engine_Api::_()->getDbtable('managesearchoptions', 'sesexpose');
    $managesearchoptions = $managesearchoptionsTable->fetchAll($managesearchoptionsTable->select());
    foreach ($managesearchoptions as $managesearchoption) {
      $order = $this->getRequest()->getParam('managesearch_' . $managesearchoption->managesearchoption_id);
      if (!$order)
        $order = 999;
      $managesearchoption->order = $order;
      $managesearchoption->save();
    }
    return;
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesexpose_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesexpose/manage/manage-search');
  }

  public function deleteSearchIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);
    $this->view->file_id = $file_id = $this->_getParam('file_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $mainMenuIcon = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
        $mainMenuIcon->delete();
        $db->update('engine4_sesexpose_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
        ));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-manage/delete-search-icon.tpl');
  }

  public function editSearchAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $managesearchoptions = Engine_Api::_()->getItem('sesexpose_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_sesexpose_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Sesexpose_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $db->update('engine4_sesexpose_managesearchoptions', array('title' => $_POST['title']), array('managesearchoption_id = ?' => $id));

        $photoFile = Engine_Api::_()->sesexpose()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_sesexpose_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesexpose', 'controller' => 'manage', 'action' => 'manage-search'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => '',
      ));
    }
  }

  public function uploadIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', null);
    $menuType = $this->_getParam('type', null);

    $this->view->icon_type = $icon_type = $this->_getParam('icon_type', 0);

    $db = Engine_Db_Table::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_core_menuitems')->where('id = ?', $id)->query()->fetchObject();

    $this->view->form = $form = new Sesexpose_Form_Admin_Icon();
    $form->getElement('icon_type')->setValue($icon_type);
    if($icon_type)
        $form->getElement('font_icon')->setValue($menu->font_icon);

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name']) && empty($_POST['icon_type'])) {

//         $photoFile = Engine_Api::_()->sesexpose()->setPhotoIcons($_FILES['photo'], $id);
//         if (!empty($photoFile->file_id)) {
//           $previous_file_id = $menu->file_id;
//           $db->update('engine4_core_menuitems', array('file_id' => $photoFile->file_id), array('id = ?' => $id));
//           $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
//           if (!empty($file))
//             $file->delete();
//         }

        $photoFile = Engine_Api::_()->sesexpose()->setPhotoIcons($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previousFile = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menu->id);
          $previous_file_id = !empty($previousFile->icon_id) ? $previousFile->icon_id : 0;
          Engine_Api::_()->getDbTable('menusicons','sesbasic')->addSave($menu->id,$photoFile->file_id);

          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      } elseif(!empty($_POST['icon_type'])) {

        $previousFile = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menu->id);
        $previous_file_id = !empty($previousFile->font_icon) ? $previousFile->font_icon : '';
        Engine_Api::_()->getDbTable('menusicons','sesbasic')->addSave($menu->id,0,$_POST['font_icon'], $_POST['icon_type']);
      }
      $db->update('engine4_sesbasic_menusicons', array('icon_type' => $_POST['icon_type']), array('menu_id = ?' => $id));

      if ($menuType == 'main') {
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesexpose', 'controller' => 'admin-manage', 'action' => 'index'), 'default', true);
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => 'Icon has been upoaded successfully.',
      ));
    }
  }

  public function deleteMenuIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);
    $this->view->file_id = $file_id = $this->_getParam('file_id', 0);
    $this->view->icon_type = $icon_type = $this->_getParam('icon_type', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {

        if($icon_type == 0) {
          $mainMenuIcon = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
          if($mainMenuIcon)
            $mainMenuIcon->delete();
          $db->update('engine4_sesbasic_menusicons', array('icon_id' => 0), array('menu_id = ?' => $id));
        } else if($icon_type == 1) {
          $db->update('engine4_sesbasic_menusicons', array('font_icon' => '', 'icon_type' => 0), array('menu_id = ?' => $id));
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-manage/delete-menu-icon.tpl');
  }

  public function headerSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesexpose_admin_main', array(), 'sesexpose_admin_main_menus');

    $this->view->form = $form = new Sesexpose_Form_Admin_HeaderSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        if ($key == 'exp_menu_logo_top_space' || $key == 'exp_header_type') {
          Engine_Api::_()->sesexpose()->readWriteXML($key, $value);
        } else {
          if ($key == 'sesexp_header_loggedin_options' || $key == 'sesexp_header_nonloggedin_options') {
            if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
              Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            }
          }
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
}
