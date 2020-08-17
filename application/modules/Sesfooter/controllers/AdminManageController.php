<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_AdminManageController extends Core_Controller_Action_Admin {

  public function footerSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfooter_admin_main', array(), 'sesfooter_admin_main_footer');

    $this->view->form = $form = new Sesfooter_Form_Admin_FooterSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();

      foreach ($values as $key => $value) {
        if ($key == 'ses_footer_design') {
          Engine_Api::_()->sesfooter()->readWriteXML($key, $value);
        }
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function footerSocialIconsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfooter_admin_main', array(), 'sesfooter_admin_main_footersociallinks');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sesfooter')->getSocialInfo();
  }

  public function footerLinksAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfooter_admin_main', array(), 'sesfooter_admin_main_footerlinks');

    $this->view->paginator = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => 0));
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('socialicon_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesfooter_socialicons', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesfooter/manage/footer-social-icons');
  }

  public function enabledLinkAction() {

    $id = $this->_getParam('footerlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesfooter_footerlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if (!$sublink)
      $this->_redirect('admin/sesfooter/manage/footer-links');
    else
      $this->_redirect('admin/sesfooter/manage/footer-links');
  }
  
  public function editAction() {

    $socialiconItem = Engine_Api::_()->getItem('sesfooter_socialicons', $this->_getParam('socialicon_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesfooter_Form_Admin_Edit();
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
      $this->_redirect('admin/sesfooter/manage/footer-social-icons');
    }
  }

  public function editlinkAction() {

    $item = Engine_Api::_()->getItem('sesfooter_footerlinks', $this->_getParam('footerlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesfooter_Form_Admin_EditLink();
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
        $item->footer_headingicon = $values["footer_headingicon"];
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
      $this->_redirect('admin/sesfooter/manage/edit-link');
    }
  }

  public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesfooter_Form_Admin_Addsublink();
    $form->setTitle('Add New Footer Link');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('footerlinks', 'sesfooter');
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
        Engine_Api::_()->getDbtable('footerlinks', 'sesfooter')->delete(array('footerlink_id =?' => $this->_getParam('footerlink_id')));
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

    $table = Engine_Api::_()->getDbtable('socialicons', 'sesfooter');
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
	
    $headingFontFamily = Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontfamily');
    if(empty($headingFontFamily)) {
      Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_heading_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_heading_fontsize', '17px');
    }
    $textFontFamily = Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontfamily');
    if(empty($textFontFamily)) {
      Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_text_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_text_fontsize', '15px');
    }
		$referralurl = $this->_getParam('referralurl', false);
		if($referralurl == 'install') {
			$this->_redirect('install/manage');
		} elseif($referralurl == 'query') {
			$this->_redirect('install/manage/complete');
		}
	}
}