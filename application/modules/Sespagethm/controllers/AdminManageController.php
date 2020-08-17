<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_menus');

    $this->view->storage = Engine_Api::_()->storage();
    $select = Engine_Api::_()->getDbTable('menuitems', 'core')->select()
            ->where('menu = ?', 'core_main')
            ->where('enabled = ?', 1)
            ->order('order ASC');
    $this->view->paginator = Engine_Api::_()->getDbTable('menuitems', 'core')->fetchAll($select);
  }

  public function headerTemplateAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_menus');

    $this->view->form = $form = new Sespagethm_Form_Admin_HeaderTemplate();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_five']);
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        if ($key == 'sespagethm_header_design' || $key == 'sespagethm_menu_logo_top_space' || $key == 'sespagethm_popup_design') {
          Engine_Api::_()->sespagethm()->readWriteXML($key, $value);
        } else {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_footer');

    $this->view->form = $form = new Sespagethm_Form_Admin_FooterSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      foreach ($values as $key => $value) {
        if ($key == 'sespagethm_footer_design' || $key == 'sespagethm_footer_background_image') {
          Engine_Api::_()->sespagethm()->readWriteXML($key, $value);
        }
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerSocialIconsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_footer');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sespagethm')->getSocialInfo();
  }

  public function footerLinksAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagethm_admin_main', array(), 'sespagethm_admin_main_footer');

    $this->view->paginator = Engine_Api::_()->getDbTable('footerlinks', 'sespagethm')->getInfo(array('sublink' => 0));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('socialicon_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sespagethm_socialicons', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sespagethm/manage/footer-social-icons');
  }

  public function uploadPhotoAction() {

    //Set default layout
    $this->_helper->layout->setLayout('default-simple');

    $admin_file = APPLICATION_PATH . '/public/sespagethm';

    $path = realpath($admin_file);

    if (!is_dir($admin_file) && mkdir($admin_file, 0777, true))
      chmod($admin_file, 0777);

    if (empty($_FILES['userfile'])) {
      $this->view->error = 'File failed to upload. Check your server settings (such as php.ini max_upload_filesize).';
      return;
    }

    $info = $_FILES['userfile'];
    $targetFile = $path . '/' . $info['name'];

    if (!move_uploaded_file($info['tmp_name'], $targetFile)) {
      $this->view->error = "Unable to move file to upload directory.";
      return;
    }

    $this->view->status = true;
    $this->view->photo_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . Zend_Controller_Front::getInstance()->getBaseUrl() . '/public/sespagethm/' . $info['name'];
  }

  public function enabledLinkAction() {

    $id = $this->_getParam('footerlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sespagethm_footerlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if (!$sublink)
      $this->_redirect('admin/sespagethm/manage/footer-links');
    else
      $this->_redirect('admin/sespagethm/manage/footer-links');
  }

  public function uploadIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', null);
    $menuType = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_core_menuitems')->where('id = ?', $id)->query()->fetchObject();

    $this->view->form = new Sespagethm_Form_Admin_Icon();

    if ($this->getRequest()->isPost()) {
      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->sespagethm()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previousFile = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menu->id);
          $previous_file_id = !empty($previousFile->icon_id) ? $previousFile->icon_id : 0;
          Engine_Api::_()->getDbTable('menusicons','sesbasic')->addSave($menu->id,$photoFile->file_id);

          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      if ($menuType == 'main')
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagethm', 'controller' => 'admin-manage', 'action' => 'index'), 'default', true);
      else
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagethm', 'controller' => 'admin-manage', 'action' => 'footer-menu'), 'default', true);

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
        if($mainMenuIcon)
          $mainMenuIcon->delete();
        Engine_Api::_()->getDbTable('menusicons','sesbasic')->deleteNotification($id);;
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
    // Output
    $this->renderScript('admin-manage/delete-menu-icon.tpl');
  }

  public function editAction() {

    $socialiconItem = Engine_Api::_()->getItem('sespagethm_socialicons', $this->_getParam('socialicon_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sespagethm_Form_Admin_Edit();
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
      $this->_redirect('admin/sespagethm/manage/footer-social-icons');
    }
  }

  public function editlinkAction() {

    $item = Engine_Api::_()->getItem('sespagethm_footerlinks', $this->_getParam('footerlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sespagethm_Form_Admin_EditLink();
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
      $this->_redirect('admin/sespagethm/manage/edit-link');
    }
  }

  public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sespagethm_Form_Admin_Addsublink();
    $form->setTitle('Add New Footer Link');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('footerlinks', 'sespagethm');
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
        Engine_Api::_()->getDbtable('footerlinks', 'sespagethm')->delete(array('footerlink_id =?' => $this->_getParam('footerlink_id')));
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

    $table = Engine_Api::_()->getDbtable('socialicons', 'sespagethm');
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


  //For write constant in xml file during upgradation
	public function constantxmlAction() {

    $bodyFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontfamily');
    if(empty($bodyFontFamily)) {
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_body_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_body_fontsize', '13px');
    }
    $headingFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontfamily');
    if(empty($headingFontFamily)) {
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_heading_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_heading_fontsize', '17px');
    }
    $mainmenuFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontfamily');
    if(empty($mainmenuFontFamily)) {
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_mainmenu_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_mainmenu_fontsize', '13px');
    }
    $tabFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontfamily');
    if(empty($tabFontFamily)) {
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_tab_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sespagethm()->readWriteXML('sespagethm_tab_fontsize', '15px');
    }
		$referralurl = $this->_getParam('referralurl', false);
		if($referralurl == 'install') {
			$this->_redirect('install/manage');
		} elseif($referralurl == 'query') {
			$this->_redirect('install/manage/complete');
		}
	}
}
