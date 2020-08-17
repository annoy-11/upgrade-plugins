<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seselegant_admin_main', array(), 'seselegant_admin_main_menus');

    $this->view->storage = Engine_Api::_()->storage();
    $select = Engine_Api::_()->getDbTable('menuitems', 'core')->select()
            ->where('menu = ?', 'core_main')
            ->where('enabled = ?', 1)
            ->order('order ASC');
    $this->view->paginator = Engine_Api::_()->getDbTable('menuitems', 'core')->fetchAll($select);
  }


  public function uploadPhotoAction() {

    //Set default layout
    $this->_helper->layout->setLayout('default-simple');

    $admin_file = APPLICATION_PATH . '/public/adminseselegant';

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
    $this->view->photo_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . Zend_Controller_Front::getInstance()->getBaseUrl() . '/public/adminseselegant/' . $info['name'];
  }

  public function uploadIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', null);
    $menuType = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_core_menuitems')->where('id = ?', $id)->query()->fetchObject();

    $this->view->form = new Seselegant_Form_Admin_Icon();

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->seselegant()->setPhoto($_FILES['photo'], $id);
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
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seselegant', 'controller' => 'admin-manage', 'action' => 'index'), 'default', true);
      else
        $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seselegant', 'controller' => 'admin-manage', 'action' => 'footer-menu'), 'default', true);

      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => 'Icon has been upoaded successfully.',
      ));
    }
  }

  public function slideImageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seselegant_admin_main', array(), 'seselegant_admin_main_photo');

    $table = Engine_Api::_()->getDbTable('slideimages', 'seselegant');
    $this->view->storage = Engine_Api::_()->storage();
    $select = $table->select()->order('order ASC');
    $this->view->paginator = $table->fetchAll($select);
  }

  public function uploadSlideshowPhotoAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);
    $file_id = $this->_getParam('file_id', 0);

    if (!empty($file_id)) {
      $this->view->form = $form = new Seselegant_Form_Admin_EditSlidephoto();
      $slideObject = Engine_Api::_()->getItem('seselegant_slideimage', $id);
      $form->caption->setValue($slideObject->caption);
      $form->image_url->setValue($slideObject->image_url);
    } else {
      $this->view->form = $form = new Seselegant_Form_Admin_Slidephoto();
    }

    if ($this->getRequest()->isPost()) {

      $imageURL = $_POST['image_url'];
      if (false === stripos($imageURL, 'http://') && false === stripos(@$publishPicUrl, 'https://') && !empty($imageURL)) {
         $imageURL = 'http://' . $imageURL;
      }
      if (empty($id)) {
        if (empty($_FILES['photo']['name'])) {
          $error = Zend_Registry::get('Zend_Translate')->_('Photo * Please complete this field - it is required.');
          $form->getDecorator('errors')->setOption('escape', false);
          $form->addError($error);
          return;
        }

        $table = Engine_Api::_()->getDbTable('slideimages', 'seselegant');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try {

          $slideImage = $table->createRow();
          $slideImage->caption = $_POST['caption'];
          $slideImage->image_url = $imageURL;
          $slideImage->save();
          $id = $slideImage->slideimage_id;

          // Commit
          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      } else {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->update('engine4_seselegant_slideimages', array(
            'caption' => $_POST['caption'],
            'image_url' => $imageURL,
                ), array(
            'slideimage_id = ?' => $id,
        ));
      }
      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
        $file = Engine_Api::_()->getItem('storage_file', $file_id);
        if (!empty($file)) {
          $file->delete();
        }
        $photoFile = Engine_Api::_()->seselegant()->setPhoto($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->update('engine4_seselegant_slideimages', array(
              'file_id' => $photoFile->file_id,
              'order' => $id,
              'caption' => $_POST['caption'],
                  ), array(
              'slideimage_id = ?' => $id,
          ));
        }
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seselegant', 'controller' => 'admin-manage', 'action' => 'slide-image'), 'default', true),
                  'messages' => 'Image has been uploaded successfully.',
      ));
    }
  }

  public function deletePhotoAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);
    $this->view->file_id = $file_id = $this->_getParam('file_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $mainPhoto = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
        $mainPhoto->delete();
        $slideImage = Engine_Api::_()->getItem('seselegant_slideimage', $id);
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

  public function multiDeleteSlideAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();

      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $explodedKey = explode('_', $key);
          $mainPhoto = Engine_Api::_()->getItemTable('storage_file')->getFile($explodedKey[2]);
          $mainPhoto->delete();
          $slideImage = Engine_Api::_()->getItem('seselegant_slideimage', $explodedKey[1]);
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

    $table = Engine_Api::_()->getDbtable('slideimages', 'seselegant');
    $menuitems = $table->fetchAll($table->select());
    foreach ($menuitems as $menuitem) {
      $order = $this->getRequest()->getParam('slideimage_' . $menuitem->slideimage_id);
      if (!$order) {
        $order = 999;
      }
      $menuitem->order = $order;
      $menuitem->save();
    }
    return;
  }

}
