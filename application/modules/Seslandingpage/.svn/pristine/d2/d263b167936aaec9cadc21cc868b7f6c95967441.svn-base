<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seslandingpage_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslandingpage_admin_main', array(), 'seslandingpage_admin_main_manage');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('featureblocks', 'seslandingpage')->getFeatureBlocks();
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber(1);
  }

  public function addAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslandingpage_admin_main', array(), 'seslandingpage_admin_main_manage');

    $this->view->form = $form = new Seslandingpage_Form_Admin_Featureblock_Add();
    $featureblock = Engine_Api::_()->getItem('seslandingpage_featureblock', $this->_getParam('id'));

//     if($featureblock->contents)
//     $contents = Zend_Json::decode($featureblock->contents);
//     else
//     $contents = array();
//     $this->view->contents = $contents;
//     $form->populate(array_merge($featureblock->toArray(), $contents));

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $table = Engine_Api::_()->getDbtable('featureblocks', 'seslandingpage');
      $db = Engine_Api::_()->getDbtable('featureblocks', 'seslandingpage')->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();

        for($i=1;$i<=4;$i++) {
            if($_POST['icon_type'.$i] == 0) {
               if(!empty($_FILES['photo'.$i]['name'])) {
                $photo = 'photo'.$i;

                $file_ext = pathinfo($_FILES[$photo]['name']);

                $file_ext = $file_ext['extension'];
                $storage = Engine_Api::_()->getItemTable('storage_file');
                $storageObject = $storage->createFile($form->$photo, array(
                    'parent_id' => $this->_getParam('id'),
                    'parent_type' => 'seslandingpage_icons',
                    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                ));
                // Remove temporary file
                @unlink($file['tmp_name']);

                //$photoFile = Engine_Api::_()->seslandingpage()->setPhotoIcons($form->$photo, $this->_getParam('id'));
                $values['photo'.$i] = $storageObject->file_id;
               }
            }
        }
        $values['contents'] = Zend_Json::encode($values);

        $featureblock = $table->createRow();
        $featureblock->setFromArray($values);
        $featureblock->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'index'), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function editAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslandingpage_admin_main', array(), 'seslandingpage_admin_main_manage');

    $this->view->form = $form = new Seslandingpage_Form_Admin_Featureblock_Edit();
    $featureblock = Engine_Api::_()->getItem('seslandingpage_featureblock', $this->_getParam('id'));

    if($featureblock->contents)
    $contents = Zend_Json::decode($featureblock->contents);
    else
    $contents = array();
    $this->view->contents = $contents;
    $form->populate(array_merge($featureblock->toArray(), $contents));

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $db = Engine_Api::_()->getDbtable('featureblocks', 'seslandingpage')->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();

        for($i=1;$i<=4;$i++) {
            if($_POST['icon_type'.$i] == 0) {
               if(!empty($_FILES['photo'.$i]['name'])) {
                $photo = 'photo'.$i;

                $file_ext = pathinfo($_FILES[$photo]['name']);

                $file_ext = $file_ext['extension'];
                $storage = Engine_Api::_()->getItemTable('storage_file');
                $storageObject = $storage->createFile($form->$photo, array(
                    'parent_id' => $this->_getParam('id'),
                    'parent_type' => 'seslandingpage_icons',
                    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                ));
                // Remove temporary file
                @unlink($file['tmp_name']);

                //$photoFile = Engine_Api::_()->seslandingpage()->setPhotoIcons($form->$photo, $this->_getParam('id'));
                $values['photo'.$i] = $storageObject->file_id;
               }
            }
        }
        $values['contents'] = Zend_Json::encode($values);
        $featureblock->setFromArray($values);
	    $featureblock->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'index'), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
}
