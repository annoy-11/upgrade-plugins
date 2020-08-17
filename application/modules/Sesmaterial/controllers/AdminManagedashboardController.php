<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageboardController.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_AdminManagedashboardController extends Core_Controller_Action_Admin {
  
  public function dashboardLinksAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmaterial_admin_main', array(), 'sesmaterial_admin_main_dashborad');

    $this->view->paginator = Engine_Api::_()->getDbTable('dashboardlinks', 'sesmaterial')->getInfo(array('sublink' => 0));
    $this->view->storage = Engine_Api::_()->storage();
  }
  

  public function addheadingAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesmaterial_Form_Admin_Dashboard_AddHeading();
    $form->setTitle('Add New Heading');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $table = Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $row = $table->createRow();
        $row->name = $values["name"];
        $row->sublink = 0;
        $row->type = $values["type"];
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

  public function editheadingAction() {

    $item = Engine_Api::_()->getItem('sesmaterial_dashboardlinks', $this->_getParam('dashboardlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesmaterial_Form_Admin_Dashboard_Editheading();
    $form->setTitle('Edit Category');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('dashboardlink_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($item->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->name = $values["name"];
        $item->type = $values["type"];
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
      //$this->_redirect('admin/sesmaterial/manage/edit-link');
    }
  }
  
  public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesmaterial_Form_Admin_Dashboard_Addsublink();
    $form->setTitle('Add New Sub Heading');
    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $row = $designations_table->createRow();
        $row->name = $values["name"];
        $row->url = $values["url"];
        $row->sublink = $this->_getParam('dashboardlink_id', null);
        $row->save();
        
        if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
          $photoFile = $this->setPhoto($form->photo, $row->dashboardlink_id);
          if (!empty($photoFile->file_id)) {
            $previous_file_id = $menu->file_id;
            $db->update('engine4_sesmaterial_dashboardlinks', array('file_id' => $photoFile->file_id), array('dashboardlink_id = ?' => $row->dashboardlink_id));
            $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
            if (!empty($file))
              $file->delete();
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmaterial_dashboardlinks', array('font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('dashboardlink_id = ?' => $row->dashboardlink_id));
        }
        $db->update('engine4_sesmaterial_dashboardlinks', array('icon_type' => $_POST['icon_type']), array('dashboardlink_id = ?' => $row->dashboardlink_id));

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
        'parent_type' => "sesmaterial_icons",
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

    $item = Engine_Api::_()->getItem('sesmaterial_dashboardlinks', $this->_getParam('dashboardlink_id'));
    $this->view->icon_type = $item->icon_type;
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesmaterial_Form_Admin_Dashboard_Editheading();
    $form->setTitle('Edit Link');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('dashboardlink_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($item->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->name = $values["name"];
        $item->url = $values["url"];
        $item->save();
        
        if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
          $photoFile = $this->setPhoto($form->photo, $item->dashboardlink_id);
          if (!empty($photoFile->file_id)) {
            $previous_file_id = $menu->file_id;
            $db->update('engine4_sesmaterial_dashboardlinks', array('file_id' => $photoFile->file_id, 'font_icon' => '', 'icon_type' => 0), array('dashboardlink_id = ?' => $item->dashboardlink_id));
            $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
            if (!empty($file))
              $file->delete();
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmaterial_dashboardlinks', array('file_id' => 0, 'font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('dashboardlink_id = ?' => $item->dashboardlink_id));
        }
        $db->update('engine4_sesmaterial_dashboardlinks', array('icon_type' => $_POST['icon_type']), array('dashboardlink_id = ?' => $item->dashboardlink_id));

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
      //$this->_redirect('admin/sesmaterial/manage/edit-link');
    }
  }
  
  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        
        Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial')->delete(array('sublink =?' => $this->_getParam('dashboardlink_id')));
        Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial')->delete(array('dashboardlink_id =?' => $this->_getParam('dashboardlink_id')));
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
    $this->renderScript('admin-managedashboard/deleteheading.tpl');
  }

  public function deletesublinkAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial')->delete(array('dashboardlink_id =?' => $this->_getParam('dashboardlink_id')));
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
    $this->renderScript('admin-managedashboard/deletesublink.tpl');
  }
  
  public function enabledLinkAction() {

    $id = $this->_getParam('dashboardlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesmaterial_dashboardlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if (!$sublink)
      $this->_redirect('admin/sesmaterial/managedashboard/dashboard-links');
    else
      $this->_redirect('admin/sesmaterial/managedashboard/dashboard-links');
  }
  
  
  public function changeOrderAction() {
  
    if ($this->_getParam('id', false) || $this->_getParam('nextid', false)) {
      $id = $this->_getParam('id', false);
      $order = $this->_getParam('articleorder', false);
      $order = explode(',', $order);
      $nextid = $this->_getParam('nextid', false);
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      if ($id) {
        $dashboardlink = $id;
      } else if ($nextid) {
        $dashboardlink = $id;
      }
      $categoryTypeId = '';
      $checkTypeCategory = $dbObject->query("SELECT * FROM engine4_sesmaterial_dashboardlinks WHERE dashboardlink_id = " . $dashboardlink)->fetchAll();
      if (isset($checkTypeCategory[0]['sublink']) && $checkTypeCategory[0]['sublink'] != 0) {
        $categoryType = 'sublink';
        $categoryTypeId = $checkTypeCategory[0]['sublink'];
      } else
        $categoryType = 'dashboardlink_id';
      if ($checkTypeCategory)
        $currentOrder = Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial')->order($categoryType, $categoryTypeId);
      // Find the starting point?
      $start = null;
      $end = null;
      $order = array_reverse(array_values(array_intersect($order, $currentOrder)));
      for ($i = 0, $l = count($currentOrder); $i < $l; $i++) {
        if (in_array($currentOrder[$i], $order)) {
          $start = $i;
          $end = $i + count($order);
          break;
        }
      }
      if (null === $start || null === $end) {
        echo "false";
        die;
      }
      $categoryTable = Engine_Api::_()->getDbtable('dashboardlinks', 'sesmaterial');
      //for ($i = count($order) - 1; $i>0; $i--) {
      for ($i = 0; $i < count($order); $i++) {
        $dashboardlink = $order[$i - $start];
        $categoryTable->update(array('order' => $i), array('dashboardlink_id = ?' => $dashboardlink));
      }
      $checkCategoryChildrenCondition = $dbObject->query("SELECT * FROM engine4_sesmaterial_dashboardlinks WHERE sublink = '" . $id . "' || sublink = '" . $nextid . "'")->fetchAll();
      if (empty($checkCategoryChildrenCondition)) {
        echo 'done';
        die;
      }
      echo "children";
      die;
    }
  }
}