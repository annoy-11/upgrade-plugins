<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManagemetakeywordsController.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesmetatag_AdminManagemetakeywordsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmetatag_admin_main', array(), 'sesmetatag_admin_main_managemetakeywords');
    
    $this->view->formFilter = $formFilter = new Sesmetatag_Form_Admin_Manage_Filter();
   
    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
        'order' => 'metatag_id',
        'order_direction' => 'DESC',
            ), $values);
    $this->view->assign($values);

    $select = Engine_Api::_()->getDbtable('managemetatags', 'sesmetatag')->select();
    
    if (!empty($values['title']))
      $select->where('meta_title LIKE ?', '%' . $values['title'] . '%');

    if (!empty($values['meta_title']))
      $select->where('meta_title LIKE ?', '%' . $values['meta_title'] . '%');

    if (!empty($values['meta_description']))
      $select->where('meta_description LIKE ?', '%' . $values['meta_description'] . '%');

      
    if (isset($_GET['enabled']) && $_GET['enabled'] != '')
      $select->where('enabled = ?', $values['enabled']);
    
    if (isset($_GET['file_id']) && $_GET['file_id'] != '')
      $select->where('file_id = ?', $values['file_id']);

    
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function addAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmetatag_admin_main', array(), 'sesmetatag_admin_main_managemetakeywords');
    
    $this->view->form = $form = new Sesmetatag_Form_Admin_Manage_Add();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues();
      
      $managemetatagsTable = Engine_Api::_()->getDbtable('managemetatags', 'sesmetatag');
      $is_module_exists= $managemetatagsTable->fetchRow(array('page_id = ?' => $values['page_id']));
      if (!empty($is_module_exists)) {
        $error = Zend_Registry::get('Zend_Translate')->_("This Page already exist in our database.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $row = $managemetatagsTable->createRow();
        $row->setFromArray($values);
        $row->save();

        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $Icon = $this->setPhoto($form->photo_id, array('managemetatag_id' => $row->managemetatag_id));
          if (!empty($Icon)) {
            $row->file_id = $Icon;
            $row->save();
          }
        }
        
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('managemetatag_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesmetatag_managemetatag', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesmetatag/managemetakeywords');
  }
  
  public function editAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmetatag_admin_main', array(), 'sesmetatag_admin_main_managemetakeywords');

    $managemetatagTable = Engine_Api::_()->getItem('sesmetatag_managemetatag', $this->_getParam('managemetatag_id'));

    $form = $this->view->form = new Sesmetatag_Form_Admin_Manage_Edit();
    

    $form->execute->setLabel('Save Changes');
    
    $form->populate($managemetatagTable->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues();
      
      if (!$values['page_id'])
        unset($values['page_id']);
        
      if (empty($values['photo_id']))
        unset($values['photo_id']);
        
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $managemetatagTable->setFromArray($values);
        $managemetatagTable->save();

        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $previousCatIcon = $managemetatagTable->file_id;
          $Icon = $this->setPhoto($form->photo_id, array('managemetatag_id' => $managemetatagTable->managemetatag_id));
          if (!empty($Icon)) {
            if ($previousCatIcon) {
              $metaPhoto = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
              $metaPhoto->delete();
            }
            $managemetatagTable->file_id = $Icon;
            $managemetatagTable->save();
          }
        }

        if (isset($values['remove_metaphoto']) && !empty($values['remove_metaphoto'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $managemetatagTable->file_id);
          $managemetatagTable->file_id = 0;
          $managemetatagTable->save();
          if ($storage)
            $storage->delete();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
    $this->renderScript('admin-managemetakeywords/edit.tpl');
  }
  
  public function setPhoto($photo, $param = null) {

    if ($photo instanceof Zend_Form_Element_File)
      $file = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $file = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $file = $photo;
    else
      throw new Sesmusic_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));

    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesmetatag_managemetakeywords',
        'parent_id' => $param['managemetatag_id']
    );

    //Save
    $storage = Engine_Api::_()->storage();
    if ($param == 'mainPhoto') {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($path . '/m_' . $name)
              ->destroy();
    } else {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(1600, 1600)
              ->write($path . '/m_' . $name)
              ->destroy();
    }

    //Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
            ->write($path . '/is_' . $name)
            ->destroy();

    //Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iSquare = $storage->create($path . '/is_' . $name, $params);

    $iMain->bridge($iMain, 'thumb.profile');
    $iMain->bridge($iSquare, 'thumb.icon');

    //Remove temp files
    @unlink($path . '/m_' . $name);
    @unlink($path . '/is_' . $name);

    $photo_id = $iMain->getIdentity();
    return $photo_id;
  }
  
  //Delete entry
  public function deleteAction() {
  
    $this->_helper->layout->setLayout('admin-simple');
    $content_type = $this->_getParam('content_type');
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $managemetatag = Engine_Api::_()->getItem('sesmetatag_managemetatag', $this->_getParam('managemetatag_id'));
        $managemetatag->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete entry.')
      ));
    }
    $this->renderScript('admin-managemetakeywords/delete.tpl');
  }
}