<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_AdminManageController extends Core_Controller_Action_Admin {

  public function headerAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_header');

    $this->view->form = $form = new Seslinkedin_Form_Admin_HeaderSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();

      if (isset($values['seslinkedin_headernonloggedinoptions']))
        $values['seslinkedin_headernonloggedinoptions'] = serialize($values['seslinkedin_headernonloggedinoptions']);
      else
        $values['seslinkedin_headernonloggedinoptions'] = serialize(array());

      if (isset($values['seslinkedin_headerloggedinoptions']))
        $values['seslinkedin_headerloggedinoptions'] = serialize($values['seslinkedin_headerloggedinoptions']);
      else
        $values['seslinkedin_headerloggedinoptions'] = serialize(array());

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_footer');

    $this->view->form = $form = new Seslinkedin_Form_Admin_FooterSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

 public function footerLinksAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_footer');

    $this->view->paginator = Engine_Api::_()->getDbTable('footerlinks', 'seslinkedin')->getInfo(array('sublink' => 0));
  }
  public function setPhoto($photo, $cat_id) {

    if ($photo instanceof Zend_Form_Element_File)
      $catIcon = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $catIcon = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $catIcon = $photo;
    else
      return;

    if (empty($catIcon))
      return;

    $mainName = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary' . '/' . basename($catIcon);

    $photo_params = array(
        'parent_id' => $cat_id,
        'parent_type' => "seslinkedin_icons",
    );

    //Resize category icon
    $image = Engine_Image::factory();
    $image->open($catIcon);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;
    $image->open($catIcon)
            ->resample($x, $y, $size, $size, 24, 24)
            ->write($mainName)
            ->destroy();
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }
    //Delete temp file.
    @unlink($mainName);
    return $photoFile;
  }
  public function editlinkAction() {

    $item = Engine_Api::_()->getItem('seslinkedin_footerlinks', $this->_getParam('footerlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Seslinkedin_Form_Admin_EditLink();
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
      $this->_redirect('admin/seslinkedin/manage/edit-link');
    }
  }
 public function enabledLinkAction() {

    $id = $this->_getParam('footerlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seslinkedin_footerlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if (!$sublink)
      $this->_redirect('admin/seslinkedin/manage/footer-links');
    else
      $this->_redirect('admin/seslinkedin/manage/footer-links');
  }
 public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Seslinkedin_Form_Admin_Addsublink();
    $form->setTitle('Add New Footer Link');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('footerlinks', 'seslinkedin');
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
        Engine_Api::_()->getDbtable('footerlinks', 'seslinkedin')->delete(array('footerlink_id =?' => $this->_getParam('footerlink_id')));
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
  public function footerSocialIconsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_admin_main', array(), 'seslinkedin_admin_main_footer');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'seslinkedin')->getSocialInfo();
  }
    public function orderSocialIconsAction() {

    if (!$this->getRequest()->isPost())
      return;

    $table = Engine_Api::_()->getDbtable('socialicons', 'seslinkedin');
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
    public function editAction() {

    $socialiconItem = Engine_Api::_()->getItem('seslinkedin_socialicons', $this->_getParam('socialicon_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Seslinkedin_Form_Admin_Edit();
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
      $this->_redirect('admin/seslinkedin/manage/footer-social-icons');
    }
  }

    //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('socialicon_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seslinkedin_socialicons', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/seslinkedin/manage/footer-social-icons');
  }

    //For write constant in xml file during upgradation
	public function constantxmlAction() {

    $bodyFontFamily = Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_body_fontfamily');
    if(empty($bodyFontFamily)) {
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_body_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_body_fontsize', '13px');
    }
    $headingFontFamily = Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_heading_fontfamily');
    if(empty($headingFontFamily)) {
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_heading_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_heading_fontsize', '17px');
    }
    $mainmenuFontFamily = Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_mainmenu_fontfamily');
    if(empty($mainmenuFontFamily)) {
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_mainmenu_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_mainmenu_fontsize', '13px');
    }
    $tabFontFamily = Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_tab_fontfamily');
    if(empty($tabFontFamily)) {
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_tab_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->seslinkedin()->readWriteXML('seslinkedin_tab_fontsize', '15px');
    }
		$referralurl = $this->_getParam('referralurl', false);
		if($referralurl == 'install') {
			$this->_redirect('install/manage');
		} elseif($referralurl == 'query') {
			$this->_redirect('install/manage/complete');
		}
	}


}
