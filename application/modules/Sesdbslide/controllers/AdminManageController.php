<?php

/**
* SocialEngineSolutions
*
* @category Application_Sesdbslide
* @package Sesdbslide
* @copyright Copyright 2018-2019 SocialEngineSolutions
* @license http://www.socialenginesolutions.com/license/
* @version $Id: AdminManageController.php 2018-07-05 00:00:00 SocialEngineSolutions $
* @author SocialEngineSolutions
*/

class Sesdbslide_AdminManageController extends Core_Controller_Action_Admin {

    public function indexAction() {
        // Admin navigation Menus
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('sesdbslide_admin_main', array(), 'sesdbslide_admin_main_manage');
        $page = $this->_getParam('page', 1);
        // galleries's paginator
        $this->view->paginator = Engine_Api::_()->getDbtable('galleries', 'sesdbslide')->getDbslidePaginator(array(
            'orderby' => 'gallery_id',
        ));
        // if request is post check
        if ($this->getRequest()->isPost()) {
          // get adapter
          $db = Engine_Db_Table::getDefaultAdapter();
          // get values from request
          $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                  // delete gallery
                  $gallery = Engine_Api::_()->getItem('sesdbslide_gallery', $value)->delete();
                    $db->query("DELETE FROM engine4_sesdbslide_slides WHERE gallery_id = " . $value);
                }
            }
        }
        $this->view->paginator->setItemCountPerPage(25);
        $this->view->paginator->setCurrentPageNumber($page);
    }

    public function createGalleryAction() {
        $this->_helper->layout->setLayout('admin-simple');
        // get ID in case of Edit Gallery
        $id = $this->_getParam('id', 0);
        // gallery form
        $this->view->form = $form = new Sesdbslide_Form_Admin_Gallery();
        if ($id) {
              $form->setTitle("Edit Slidshow Title");
              $form->submit->setLabel('Save Changes');
              $gallery = Engine_Api::_()->getItem('sesdbslide_gallery', $id);
              // populate form in case of edit
              $form->populate($gallery->toArray());
          }
        // check for request type
        if ($this->getRequest()->isPost()) {
          // check for form validation
          if (!$form->isValid($this->getRequest()->getPost()))
                return;
            $db = Engine_Api::_()->getDbtable('galleries', 'sesdbslide')->getAdapter();
            $db->beginTransaction();
            try {
                $table = Engine_Api::_()->getDbtable('galleries', 'sesdbslide');
              // get values from form
              $values = $form->getValues();
                if (!$id)
                    $gallery = $table->createRow();
                $gallery->setFromArray($values);
                $gallery->creation_date = date('Y-m-d h:i:s');
                $gallery->save();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
          // success message
          $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('Gallery created successfully.')
            ));
        }
    }

    public function deleteGalleryAction() {
        $this->_helper->layout->setLayout('admin-simple');
        // get delete form
        $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
        $form->setTitle('Delete This Slideshow?');
        $form->setDescription('Are you sure that you want to delete this Slideshow ? It will not be recoverable after being deleted.');
        $form->submit->setLabel('Delete');
        $id = $this->_getParam('id');
        $this->view->item_id = $id;
        // Check post
        if ($this->getRequest()->isPost()) {
            $chanel = Engine_Api::_()->getItem('sesdbslide_gallery', $id)->delete();
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->query("DELETE FROM engine4_sesdbslide_slides WHERE gallery_id = " . $id);
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('Gallery Delete Successfully.')
            ));
        }
        // Output
        $this->renderScript('admin-manage/delete-gallery.tpl');
    }

    public function manageAction() {
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                    $slide = Engine_Api::_()->getItem('sesdbslide_slide', $value);
                    if ($slide->large_image_for_slide) {
                        $item = Engine_Api::_()->getItem('storage_file', $slide->large_image_for_slide);
                        if ($item->storage_path) {
                            @unlink($item->storage_path);
                            $item->remove();
                        }
                    }
                    if ($slide->large_image_for_slide) {
                        $item = Engine_Api::_()->getItem('storage_file', $slide->large_image_for_slide);
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
                ->getNavigation('sesdbslide_admin_main', array(), 'sesdbslide_admin_main_manage');
        $this->view->gallery_id = $id = $this->_getParam('id');
        if (!$id)
            return;
        $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesdbslide')->getDbslidePaginator($id, 'show_all');
        $page = $this->_getParam('page', 1);
        $paginator->setItemCountPerPage(1000);
        $paginator->setCurrentPageNumber($page);
    }

    public function createSlideAction() {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('sesdbslide_admin_main', array(), 'sesdbslide_admin_main_manage');
        $this->view->gallery_id = $id = $this->_getParam('id');
        $this->view->slide_id = $slide_id = $this->_getParam('slide_id', false);
        if (!$id)
            return;
        $this->view->form = $form = new Sesdbslide_Form_Admin_Createslide();
        if ($slide_id) {
            //$form->setTitle("Edit HTML5 Video Background");
            $form->save->setLabel('Save Changes');
            $form->setTitle("Edit Slides");
            $form->setDescription("Below, edit the details for the Slides.");
            $slide = Engine_Api::_()->getItem('sesdbslide_slide', $slide_id);
            $values = $slide->toArray();
            $values['member_level_view_privacy'] = (explode(",", $slide->member_level_view_privacy));
            $values['network_view_privacy'] = (explode(",", $slide->network_view_privacy));
            $form->populate($values);
        }
        if ($this->getRequest()->isPost()) {
            if (!$form->isValid($this->getRequest()->getPost()))
                return;
            $db = Engine_Api::_()->getDbtable('slides', 'sesdbslide')->getAdapter();
            $db->beginTransaction();
            try {
                $table = Engine_Api::_()->getDbtable('slides', 'sesdbslide');
                $values = $form->getValues();
                if($values['slide_opacity']>1 && $values['enable_overlay']){
                    $form->addError('Slide Opacity can not be greater than 1.');
                    return;
                }
				if ($values['remove_main_image']) {
					$mainImageStorage = Engine_Api::_()->getItem('storage_file', $slide->large_image_for_slide);
					$slide->large_image_for_slide = 0;
					$slide->save();
					$mainImageStorage->delete();
				}
				if ($values['remove_video']) {
					
					if($slide->video_video_url == 4){
						$videoStorage = Engine_Api::_()->getItem('storage_file', $slide->file_id);
						$slide->file_id = 0;
						$slide->save();
						$videoStorage->delete();
					}else{
						$slide->video_video_file_url = '';
						$slide->save();
					}	
				}
				if ($values['remove_dbslide_image']) {
					$dbslideImageStorage = Engine_Api::_()->getItem('storage_file', $slide->dbslide_double_slide_image);
					$slide->dbslide_double_slide_image = 0;
					$slide->save();
					$dbslideImageStorage->delete();
				}
                $buttonOneString = $values['cta1_button_url'];
                $buttonTwoString =$values['cta2_button_url'];
                $buttonOneStringFourCharacter = substr($buttonOneString, 0, 4);
                $buttonTwoStringFourCharacter = substr($buttonTwoString, 0, 4);
                if($buttonOneStringFourCharacter != 'http')
                    $values['cta1_button_url'] = 'http://'.$buttonOneString;
                if($buttonTwoStringFourCharacter != 'http')
                    $values['cta2_button_url'] = 'http://'.$buttonTwoString;

                if (isset($_FILES['large_image_for_slide']['name']) && $_FILES['video_video_upload']['name'] == '') {
                    unset($values['large_image_for_slide']);
                }
                if (isset($_FILES['dbslide_double_slide_image']['name']) && $_FILES['dbslide_double_slide_image']['name'] == '') {
                    unset($values['large_image_for_slide']);
                }
                if (isset($_FILES['video_video_upload']['name']) && $_FILES['video_video_upload']['name'] == '') {
                    unset($values['video_video_upload']);
                }
                
                $member_level_view_privacy = implode(",", $values['member_level_view_privacy']);
                $network_view_privacy = implode(",", $values['network_view_privacy']);
                $values['member_level_view_privacy'] = $member_level_view_privacy;
                $values['network_view_privacy'] = $network_view_privacy;
                if (!isset($slide)){
                    $slide = $table->createRow();
                    $slide->status = '1';
                }
                $slide->setFromArray($values);
                $slide->save();
                if (isset($_FILES['video_upload']['name']) && $_FILES['video_upload']['name'] != '') {
                    // Store video in temporary storage object for ffmpeg to handle
                    $storage = Engine_Api::_()->getItemTable('storage_file');
                    $filename = $storage->createFile($form->video_upload, array(
                        'parent_id' => $slide->slide_id,
                        'parent_type' => 'sesdbslide_slide',
                        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                    ));
                    // Remove temporary file
                    @unlink($file['tmp_name']);
                    $slide->file_id = $filename->file_id;
                    $slide->file_type = $filename->extension;
                }
                if (isset($_FILES['dbslide_slide_img']['name']) && $_FILES['dbslide_slide_img']['name'] != '') {
                    // Store video in temporary storage object for ffmpeg to handle
                    $storage = Engine_Api::_()->getItemTable('storage_file');
                    $thumbname = $storage->createFile($form->dbslide_slide_img, array(
                        'parent_id' => $slide->slide_id,
                        'parent_type' => 'sesdbslide_slide',
                        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                    ));
                    // Remove temporary file
                    @unlink($file['tmp_name']);
                    $slide->dbslide_double_slide_image = $thumbname->file_id;
                }
                if (isset($_FILES['image_for_slide']['name']) && $_FILES['image_for_slide']['name'] != '') {
                    // Store video in temporary storage object for ffmpeg to handle
                    $storage = Engine_Api::_()->getItemTable('storage_file');
                    $thumbname = $storage->createFile($form->image_for_slide, array(
                        'parent_id' => $slide->slide_id,
                        'parent_type' => 'sesdbslide_slide',
                        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                    ));
                    // Remove temporary file
                    @unlink($file['tmp_name']);
                    $slide->large_image_for_slide = $thumbname->file_id;
                }
                $slide->gallery_id = $id;
                $slide->save();
                $db->commit();
                if(!$slide_id){
                  $slide->order = $slide->slide_id;
                  $slide->save();
                  $slideId = $slide->slide_id;
                }else{
                  $slideId = $slide_id;
                }
                if (isset($_POST['save']))
                    return $this->_helper->redirector->gotoRoute(array('module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'create-slide','slide_id'=>$slideId, 'id' => $id), 'admin_default', true);
                else
                    return $this->_helper->redirector->gotoRoute(array('module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'manage', 'id' => $id), 'admin_default', true);
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
            $slide = Engine_Api::_()->getItem('sesdbslide_slide', $id);
            if ($slide->dbslide_double_slide_image) {
                $item = Engine_Api::_()->getItem('storage_file', $slide->dbslide_double_slide_image);
                if ($item->storage_path) {
                    @unlink($item->storage_path);
                    $item->remove();
                }
            }
            if ($slide->large_image_for_slide) {
                $item = Engine_Api::_()->getItem('storage_file', $slide->large_image_for_slide);
                if ($item->storage_path) {
                    @unlink($item->storage_path);
                    $item->remove();
                }
            }
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
        $this->renderScript('admin-manage/delete-slide.tpl');
    }

    public function enabledAction() {
        $id = $this->_getParam('id');
        $gallery_id = $this->_getParam('gallery_id', 0);
        if (!empty($id)) {
            if (!empty($gallery_id))
                $item = Engine_Api::_()->getItem('sesdbslide_slide', $id);
            else
                $item = Engine_Api::_()->getItem('sesdbslide_gallery', $id);
            $item->status = !$item->status;
            $item->save();
        }
        if (!empty($gallery_id))
            $this->_redirect('admin/sesdbslide/manage/manage/id/' . $gallery_id);
        else
            $this->_redirect('admin/sesdbslide/manage');
    }
	 public function enabledgalleryAction() {
        $gallery_id = $this->_getParam('gallery_id', 0);
        if (!empty($gallery_id)) {
			$item = Engine_Api::_()->getItem('sesdbslide_gallery', $gallery_id);
            $item->status = !$item->status;
            $item->save();
        }
        $this->_redirect('admin/sesdbslide/manage');
    }
    public function orderAction() {
        if (!$this->getRequest()->isPost())
            return;
        $slidesTable = Engine_Api::_()->getDbtable('slides', 'sesdbslide');
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

    public function addSlideshowAction() {
        $form = $this->view->form = new Sesdbslide_Form_Admin_Slideshow_Addslideshow();
        $form->setAction($this->view->url(array()));
        // Check post
        if (!$this->getRequest()->isPost()) {
            $this->renderScript('admin-manage/form.tpl');
            return;
        }
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->renderScript('admin-settings/form.tpl');
            return;
        }
        $values = $form->getValues();
    }

}
