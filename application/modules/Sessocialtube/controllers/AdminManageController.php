<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_menus');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getApi('menus', 'sessocialtube')->getMenus(array('menu' => 'core_main'));
  }
  
  public function managePhotosAction() {
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $slide = Engine_Api::_()->getItem('sessocialtube_headerphoto', $value);
          if ($slide->thumb_icon) {
            $item = Engine_Api::_()->getItem('storage_file', $slide->thumb_icon);
            if ($item->storage_path) {
              @unlink($item->storage_path);
              $item->remove();
            }
          }
          if ($slide->file_id) {
            $item = Engine_Api::_()->getItem('storage_file', $slide->file_id);
            if ($item->storage_path) {
              @unlink($item->storage_path);
              $item->remove();
            }
          }
          $slide->delete();
        }
      }
    }
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_menus');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('headerphotos', 'sessocialtube')->getPhotos('all');
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(1000);
    $paginator->setCurrentPageNumber($page);
  }
  
  public function createImageAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_menus');

    $this->view->slide_id = $slide_id = $this->_getParam('headerphoto_id', false);

    $this->view->form = $form = new Sessocialtube_Form_Admin_Createimage();
    if ($slide_id) {
      //$form->setTitle("Edit HTML5 Video Background");
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Image");
      $form->setDescription("Below, edit the details for the image.");
      $slide = Engine_Api::_()->getItem('sessocialtube_headerphoto', $slide_id);
      $form->populate($slide->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('headerphotos', 'sessocialtube')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('headerphotos', 'sessocialtube');
        $values = $form->getValues();
        if (!isset($slide))
          $slide = $table->createRow();
        $slide->setFromArray($values);
				$slide->save();
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($form->file, array(
              'parent_id' => $slide->headerphoto_id,
              'parent_type' => 'sessocialtube_headerphoto',
              'user_id' => 1,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $slide->file_id = $filename->file_id;
        }
        $slide->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'manage-photos'), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
  
  public function deleteImageAction() {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $slide = Engine_Api::_()->getItem('sessocialtube_headerphoto', $id);
      if ($slide->file_id) {
        $item = Engine_Api::_()->getItem('storage_file', $slide->file_id);
        if ($item->storage_path) {
          @unlink($item->storage_path);
          $item->remove();
        }
      }
      $slide->delete();

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Image Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage/delete-image.tpl');
  }
  
  public function enabledImageAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sessocialtube_headerphoto', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sessocialtube/manage/manage-photos');
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $slidesTable = Engine_Api::_()->getDbtable('headerphotos', 'sessocialtube');
    $slides = $slidesTable->fetchAll($slidesTable->select());
    foreach ($slides as $slide) {
      $order = $this->getRequest()->getParam('slide_' . $slide->headerphoto_id);
      if (!$order)
        $order = 999;
      $slide->order = $order;
      $slide->save();
    }
    return;
  }
  
  public function headerTemplateAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_menus');

    $this->view->form = $form = new Sessocialtube_Form_Admin_HeaderTemplate();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_five']);
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        if ($key == 'socialtube_header_design' || $key == 'socialtube_menu_logo_top_space' || $key == 'socialtube_popup_design') {
          Engine_Api::_()->sessocialtube()->readWriteXML($key, $value);
        } else {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_footer');

    $this->view->form = $form = new Sessocialtube_Form_Admin_FooterSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        if ($key == 'socialtube_footer_design' || $key == 'socialtube_footer_background_image') {
          Engine_Api::_()->sessocialtube()->readWriteXML($key, $value);
        }
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerSocialIconsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_footer');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sessocialtube')->getSocialInfo();
  }

  public function footerLinksAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialtube_admin_main', array(), 'sessocialtube_admin_main_footer');

    $this->view->paginator = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getInfo(array('sublink' => 0));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('socialicon_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sessocialtube_socialicons', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sessocialtube/manage/footer-social-icons');
  }

  public function enabledLinkAction() {

    $id = $this->_getParam('footerlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sessocialtube_footerlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if (!$sublink)
      $this->_redirect('admin/sessocialtube/manage/footer-links');
    else
      $this->_redirect('admin/sessocialtube/manage/footer-links');
  }

  public function uploadIconAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_core_menuitems')
            ->where('id = ?', $id)
            ->query()
            ->fetchObject();
    $this->view->form = new Sessocialtube_Form_Admin_Icon();

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sessocialtube()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_core_menuitems', array('file_id' => $photoFile->file_id), array('id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      if ($type == 'main') {
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialtube', 'controller' => 'admin-manage', 'action' => 'index'), 'default', true);
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

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $mainMenuIcon = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
        $mainMenuIcon->delete();
        $db->update('engine4_core_menuitems', array('file_id' => 0), array('id = ?' => $id,
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
    $this->renderScript('admin-manage/delete-menu-icon.tpl');
  }

  public function editAction() {

    $socialiconItem = Engine_Api::_()->getItem('sessocialtube_socialicons', $this->_getParam('socialicon_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sessocialtube_Form_Admin_Edit();
    $form->setTitle('Edit Social Site Link');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('socialicon_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($socialiconItem->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $socialiconItem->url = $values["url"];
        $socialiconItem->title = $values["title"];
        $socialiconItem->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit entry.')
      ));
      $this->_redirect('admin/sessocialtube/manage/footer-social-icons');
    }
  }

  public function editlinkAction() {

    $item = Engine_Api::_()->getItem('sessocialtube_footerlinks', $this->_getParam('footerlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sessocialtube_Form_Admin_EditLink();
    $form->setTitle('Edit Footer Link');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('footerlink_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($item->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->name = $values["name"];
        $item->url = $values["url"];
        $item->nonloginenabled = $values["nonloginenabled"];
        $item->nonlogintarget = $values["nonlogintarget"];
        $item->loginurl = $values["loginurl"];
        $item->loginenabled = $values["loginenabled"];
        $item->logintarget = $values["logintarget"];
        $item->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit entry.')
      ));
      $this->_redirect('admin/sessocialtube/manage/edit-link');
    }
  }

  public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sessocialtube_Form_Admin_Addsublink();
    $form->setTitle('Add New Footer Link');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('footerlinks', 'sessocialtube');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $row = $designations_table->createRow();
        $row->name = $values["name"];
        $row->url = $values["url"];
        $row->nonloginenabled = $values["nonloginenabled"];
        $row->nonlogintarget = $values["nonlogintarget"];
        $row->loginurl = $values["loginurl"];
        $row->loginenabled = $values["loginenabled"];
        $row->logintarget = $values["logintarget"];
        $row->sublink = $this->_getParam('footerlink_id', null);
        $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully add sub link.'))
      ));
    }
  }

  public function deletesublinkAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('footerlinks', 'sessocialtube')->delete(array('footerlink_id =?' => $this->_getParam('footerlink_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed team member entry.'))
      ));
    }
    $this->renderScript('admin-manage/deletesublink.tpl');
  }

  public function orderSocialIconsAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('socialicons', 'sessocialtube');
    $menuitems = $table->fetchAll($table->select());
    foreach ($menuitems as $menuitem) {
      $order = $this->getRequest()->getParam('footersocialicons_' . $menuitem->socialicon_id);
      if (!$order)
        $order = 999;
      $menuitem->order = $order;
      $menuitem->save();
    }
    return;
  }

}
