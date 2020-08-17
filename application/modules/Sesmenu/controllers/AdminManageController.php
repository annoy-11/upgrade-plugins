<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_menus');
	$this->view->menu_id =$menu_id=  $this->_getParam('menu_id',null);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('items', 'sesmenu')->getDashboard(array('menu_id'=>$menu_id));
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $banner = Engine_Api::_()->getItem('sesmenu_item', $value)->delete();
          $db->query("DELETE FROM engine4_sesmenu_itemlinks WHERE item_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }


  public function createAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);
	$menu_id = $this->_getParam('menu_id', 0);

    $this->view->form = $form = new Sesmenu_Form_Admin_Dashboard();
    if ($id) {
      $form->setTitle("Edit Dashboard Name");
      $form->submit->setLabel('Save Changes');
      $banner = Engine_Api::_()->getItem('sesmenu_item', $id);
      $form->populate($banner->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('items', 'sesmenu')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('items', 'sesmenu');
        $values = $form->getValues();
        if (!$id)
          $banner = $table->createRow();
        $banner->setFromArray($values);
        $banner->creation_date = date('Y-m-d h:i:s');
        $banner->menu_id = $menu_id;
        $banner->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Dashboard created successfully.')
      ));
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesmenu_item', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesmenu/manage');
  }

  public function deleteDashboardAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesmenu_Form_Admin_Delete();
    $form->setTitle('Delete This Dashboard?');
    $form->setDescription('Are you sure that you want to delete this Dashboard? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $this->view->item_id = $id = $this->_getParam('id');

    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sesmenu_item', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      //$db->query("DELETE FROM engine4_sescusdash_slides WHERE banner_id = " . $id);
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Dashboard Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage/delete-dashboard.tpl');
  }


  public function dashboardLinksAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_menus');
    $this->view->item_id = $item_id = $this->_getParam('menu_id', null);
    $this->view->paginator = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu')->getInfo(array('sublink' => 0, 'item_id' => $item_id, 'admin' => 1));
    $this->view->storage = Engine_Api::_()->storage();

  }

  public function addheadingAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesmenu_Form_Admin_AddHeading();
    $form->setTitle('Add New Heading');
    $form->button->setLabel('Add');
    $item_id = $this->_getParam('item_id', null);

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $table = Engine_Api::_()->getDbtable('itemlinks', 'sesmenu');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
		$privacy = implode(",", $values['privacy']);
        $row = $table->createRow();
        $row->item_id = $item_id;
        $row->name = $values["name"];
        $row->sublink = 0;
		$row->url = $values["url"];
        $row->privacy = $privacy;
        $row->type = $values["type"];
		$row->save();


		if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
			$photoFile = $this->setPhoto($form->photo, $row->itemlink_id);
			if (!empty($photoFile->file_id)) {
            $previous_file_id = $photoFile->file_id;
            $db->update('engine4_sesmenu_itemlinks', array('file_id' => $photoFile->file_id), array('itemlink_id = ?' => $row->itemlink_id));
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmenu_itemlinks', array('font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $row->itemlink_id));
        }
        $db->update('engine4_sesmenu_itemlinks', array('icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $row->itemlink_id));

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
   $this->view->item = $item = Engine_Api::_()->getItem('sesmenu_itemlinks', $this->_getParam('itemlink_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesmenu_Form_Admin_Editheading();
    $form->setTitle('Edit Category');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('itemlink_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($item->toArray());
	$item_id = $this->_getParam('item_id', null);
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
	  $privacy = implode(",", $values['privacy']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->name = $values["name"];
        $item->type = $values["type"];
		$item->url = $values["url"];
        $item->privacy = $privacy;

       	if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
			$photoFile = $this->setPhoto($form->photo, $item->itemlink_id);
			if (!empty($photoFile->file_id)) {
            $previous_file_id = $photoFile->file_id;
            $db->update('engine4_sesmenu_itemlinks', array('file_id' => $photoFile->file_id), array('itemlink_id = ?' => $item->itemlink_id));
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmenu_itemlinks', array('font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $item->itemlink_id));
        }
        $db->update('engine4_sesmenu_itemlinks', array('icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $item->itemlink_id));

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
    }
  }

  public function addsublinkAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesmenu_Form_Admin_Addsublink();

    $form->setTitle('Add New Sub Heading');
    $form->button->setLabel('Add');
    $item_id = $this->_getParam('item_id', null);
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $designations_table = Engine_Api::_()->getDbtable('itemlinks', 'sesmenu');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        $privacy = implode(",", $values['privacy']);
        $row = $designations_table->createRow();
        $row->item_id = $item_id;
        $row->name = $values["name"];
        $row->url = $values["url"];
        $row->privacy = $privacy;
        $row->sublink = $this->_getParam('itemlink_id', null);
        $row->save();

        if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
          $photoFile = $this->setPhoto($form->photo, $row->itemlink_id);
          if (!empty($photoFile->file_id)) {
            $previous_file_id = $photoFile->file_id;
            $db->update('engine4_sesmenu_itemlinks', array('file_id' => $photoFile->file_id), array('itemlink_id = ?' => $row->itemlink_id));
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmenu_itemlinks', array('font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $row->itemlink_id));
        }
        $db->update('engine4_sesmenu_itemlinks', array('icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $row->itemlink_id));

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
        'parent_type' => "sesmenu_icons",
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

    $item = Engine_Api::_()->getItem('sesmenu_itemlinks', $this->_getParam('itemlink_id'));
    $this->view->icon_type = $item->icon_type;
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesmenu_Form_Admin_Editheading();
    $form->setTitle('Edit Link');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('itemlink_id')))
      throw new Zend_Exception('No identifier specified');

    $valuess = $item->toArray();
    $valuess['privacy'] = (explode(",", $item->privacy));
    $form->populate($valuess);

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->name = $values["name"];
        $item->url = $values["url"];
        $privacy = implode(",", $values['privacy']);
        $item->privacy = $privacy;
        $item->save();

        if (isset($_FILES['photo']) && empty($_POST['icon_type'])) {
          $photoFile = $this->setPhoto($form->photo, $item->itemlink_id);
          if (!empty($photoFile->file_id)) {
            $previous_file_id = $photoFile->file_id;
            $db->update('engine4_sesmenu_itemlinks', array('file_id' => $photoFile->file_id, 'font_icon' => '', 'icon_type' => 0), array('itemlink_id = ?' => $item->itemlink_id));
            $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          }
        } elseif(!empty($_POST['icon_type'])) {
          $db->update('engine4_sesmenu_itemlinks', array('file_id' => 0, 'font_icon' => $_POST['font_icon'], 'icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $item->itemlink_id));
        }
        $db->update('engine4_sesmenu_itemlinks', array('icon_type' => $_POST['icon_type']), array('itemlink_id = ?' => $item->itemlink_id));

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
    }
  }

  public function deleteAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        Engine_Api::_()->getDbtable('itemlinks', 'sesmenu')->delete(array('sublink =?' => $this->_getParam('itemlink_id')));
        Engine_Api::_()->getDbtable('itemlinks', 'sesmenu')->delete(array('itemlink_id =?' => $this->_getParam('itemlink_id')));
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
    $this->renderScript('admin-manage/deleteheading.tpl');
  }

  public function deletesublinkAction() {

    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('itemlinks', 'sesmenu')->delete(array('itemlink_id =?' => $this->_getParam('itemlink_id')));
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
  public function enabledLinkAction() {
   $id = $this->_getParam('itemlink_id');
    $sublink = $this->_getParam('sublink');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesmenu_itemlinks', $id);
      $item->enabled = !$item->enabled;
      $item->save();
      $this->_redirect('admin/sesmenu/manage/dashboard-links/menu_id/'.$item->item_id);
    }
  }
  public function changeOrderAction() {

    if ($this->_getParam('id', false) || $this->_getParam('nextid', false)) {
      $id = $this->_getParam('id', false);
      $order = $this->_getParam('articleorder', false);
      $order = explode(',', $order);
      $nextid = $this->_getParam('nextid', false);
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      if ($id) {
        $itemlink = $id;
      } else if ($nextid) {
        $itemlink = $id;
      }
      $categoryTypeId = '';
      $checkTypeCategory = $dbObject->query("SELECT * FROM engine4_sesmenu_itemlinks WHERE itemlink_id = " . $itemlink)->fetchAll();
      if (isset($checkTypeCategory[0]['sublink']) && $checkTypeCategory[0]['sublink'] != 0) {
        $categoryType = 'sublink';
        $categoryTypeId = $checkTypeCategory[0]['sublink'];
      } else
        $categoryType = 'itemlink_id';
      if ($checkTypeCategory)
        $currentOrder = Engine_Api::_()->getDbtable('itemlinks', 'sesmenu')->order($categoryType, $categoryTypeId);
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
      $categoryTable = Engine_Api::_()->getDbtable('itemlinks', 'sesmenu');
      //for ($i = count($order) - 1; $i>0; $i--) {
      for ($i = 0; $i < count($order); $i++) {
        $itemlink = $order[$i - $start];
        $categoryTable->update(array('order' => $i), array('itemlink_id = ?' => $itemlink));
      }
      $checkCategoryChildrenCondition = $dbObject->query("SELECT * FROM engine4_sesmenu_itemlinks WHERE sublink = '" . $id . "' || sublink = '" . $nextid . "'")->fetchAll();
      if (empty($checkCategoryChildrenCondition)) {
        echo 'done';
        die;
      }
      echo "children";
      die;
    }
  }
}
