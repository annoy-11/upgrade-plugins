<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_AdminManageController extends Core_Controller_Action_Admin {

  public function slideImageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilelock_admin_main', array(), 'sesprofilelock_admin_main_manageslides');
    $this->view->storage = Engine_Api::_()->storage();
    $table = Engine_Api::_()->getDbTable('slideimages', 'sesprofilelock');
    $select = $table->select()->order('order ASC');
    $this->view->slides = $table->fetchAll($select);
  }

  public function uploadSlideshowPhotoAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);
    $file_id = $this->_getParam('file_id', 0);

    $this->view->form = $sesform = new Sesprofilelock_Form_Admin_Slidephoto();

    if ($this->getRequest()->isPost()) {

      if (empty($id)) {
        if (empty($_FILES['photo']['name'])) {
          $error = Zend_Registry::get('Zend_Translate')->_('Photo * Please complete this field - it is required.');
          $sesform->getDecorator('errors')->setOption('escape', false);
          $sesform->addError($error);
          return;
        }

        $table = Engine_Api::_()->getDbTable('slideimages', 'sesprofilelock');
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
          $slideImage = $table->createRow();
          $slideImage->save();
          $id = $slideImage->slideimage_id;
          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      }

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
        $file = Engine_Api::_()->getItem('storage_file', $file_id);
        if (!empty($file))
        $file->delete();
        $photoFile = Engine_Api::_()->sesprofilelock()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->update('engine4_sesprofilelock_slideimages', array(
              'file_id' => $photoFile->file_id,
              'order' => $id,
                  ), array(
              'slideimage_id = ?' => $id,
          ));
        }
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesprofilelock', 'controller' => 'admin-manage', 'action' => 'slide-image'), 'default', true),
                  'messages' => 'Image has been uploaded successfully.',
      ));
    }
  }

  public function deletePhotoAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $mainPhoto = Engine_Api::_()->getItemTable('storage_file')->getFile($this->_getParam('file_id', 0));
        $mainPhoto->delete();
        $slideImage = Engine_Api::_()->getItem('sesprofilelock_slideimage', $id);
        $slideImage->delete();
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
    $this->renderScript('admin-manage/delete.tpl');
  }

  public function multiDeleteSlideAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();

      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $explodedKey = explode('_', $key);
          $mainPhoto = Engine_Api::_()->getItemTable('storage_file')->getFile($explodedKey[2]);
          if($mainPhoto)
          $mainPhoto->delete();
          $slideImage = Engine_Api::_()->getItem('sesprofilelock_slideimage', $explodedKey[1]);
          if($slideImage)
          $slideImage->delete();
        }
      }
    }
    //REDIRECTING
    $this->_helper->redirector->gotoRoute(array('action' => 'slide-image'));
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
    return;
    $table = Engine_Api::_()->getDbtable('slideimages', 'sesprofilelock');
    $menuitems = $table->fetchAll($table->select());
    foreach ($menuitems as $menuitem) {
      $order = $this->getRequest()->getParam('slideimage_' . $menuitem->slideimage_id);
      if (!$order)
      $order = 999;
      $menuitem->order = $order;
      $menuitem->save();
    }
    return;
  }

}
