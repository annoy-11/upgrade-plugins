<?php

class Estore_AdminManageOfferController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('estore_admin_main', array(), 'estore_admin_main_offer');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('offers', 'estore')->getOffers();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $offer = Engine_Api::_()->getItem('estore_offer', $value)->delete();
          $db->query("DELETE FROM engine4_estore_slides WHERE offer_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }
  public function createSlideAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('estore_admin_main', array(), 'estore_admin_main_offer');
    $this->view->offer_id = $id = $this->_getParam('id');
    $this->view->slide_id = $slide_id = $this->_getParam('slide_id', false);
    if (!$id)
      return;

    $this->view->form = $form = new Estore_Form_Admin_Createslide();
    if ($slide_id) {
      //$form->setTitle("Edit HTML5 Video Background");
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Photo Slide");
      $form->setDescription("Below, You can edit the photo slide for the offer slideshow and configure the settings for the slide.");
      $slide = Engine_Api::_()->getItem('estore_slides', $slide_id);
      $form->populate($slide->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;

        $values = $form->getValues();

      $db = Engine_Api::_()->getDbtable('slides', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('slides', 'estore');

        if (!isset($slide))
          $slide = $table->createRow();

        $slide->setFromArray($values);
				$slide->save();
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
          // Store video in temporary storage object for ffmpeg to handle
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($form->file, array(
              'parent_id' => $slide->slide_id,
              'parent_type' => 'estore_slide',
              'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $slide->file_id = $filename->file_id;
          $slide->file_type = $filename->extension;
        }

        $slide->offer_id = $id;
        $slide->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'estore', 'controller' => 'manage-offer', 'action' => 'manage', 'id' => $id), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function deleteSlideAction() {
    $this->view->type = $this->_getParam('type', null);
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $slide = Engine_Api::_()->getItem('estore_slides', $id);
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
          'messages' => array('Slide Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-offer/delete-slide.tpl');
  }

  public function manageAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $slide = Engine_Api::_()->getItem('estore_slides', $value);
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
            ->getNavigation('estore_admin_main', array(), 'estore_admin_main_manageoffers');
    $this->view->offer_id = $id = $this->_getParam('id');
    if (!$id)
      return;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'estore')->getSlides($id, 'show_all');
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(1000);
    $paginator->setCurrentPageNumber($page);
  }
  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $slidesTable = Engine_Api::_()->getDbtable('slides', 'estore');
    $slides = $slidesTable->fetchAll($slidesTable->select());
    foreach ($slides as $slide) {
      $order = $this->getRequest()->getParam('slide_' . $slide->slide_id);
      if (!$order)
        $order = 999;
      $slide->order = $order;
      $slide->save();
    }
    return;
  }
  public function deleteOfferAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Estore_Form_Delete();
    $form->setTitle('Delete This Offer?');
    $form->setDescription('Are you sure that you want to delete this Offer? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $chanel = Engine_Api::_()->getItem('estore_offer', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_estore_slides WHERE offer_id = " . $id);
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Banner Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-offer/delete-offer.tpl');
  }

  public function createOfferAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    if($viewer->timezone){
        date_default_timezone_set($viewer->timezone);
        $start =  date('Y-m-d h:i:s');
    } else {
        $start =  date('Y-m-d h:i:s');
    }

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);

    $this->view->form = $form = new Estore_Form_Admin_Offer();
    if ($id) {
      $form->setTitle("Edit Offer Slideshow Name");
      $form->submit->setLabel('Save Changes');
      $offer = Engine_Api::_()->getItem('estore_offer', $id);
      $form->populate($offer->toArray());
    }

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;

        if(!empty($values['startdate'])){
            if($values['startdate'] < $start){
                $form->addError($this->view->translate('Start Time must be greater than Current Time.'));
            }
        }

        if($values['startdate'] < $values['enddate']){
            $form->addError($this->view->translate('End Time must be greater than Start Time.'));
        }

      $db = Engine_Api::_()->getDbtable('offers', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('offers', 'estore');
        $values = $form->getValues();
        if (!$id)
          $offer = $table->createRow();
        $offer->setFromArray($values);
        $offer->creation_date = date('Y-m-d h:i:s');
        $offer->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Offer created successfully.')
      ));
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    $offer_id = $this->_getParam('offer_id', 0);
    if (!empty($id)) {
     if(!empty($offer_id))
       $item = Engine_Api::_()->getItem('estore_slides', $id);
      else
      $item = Engine_Api::_()->getItem('estore_offer', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if(!empty($offer_id))
        $this->_redirect('admin/estore/manage-offer/manage/id/'.$offer_id);
    else
        $this->_redirect('admin/estore/manage-offer');
  }
}
