<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: PhotoController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Coursesalbum_PhotoController extends Core_Controller_Action_Standard {

  public function init() {

    if (!Engine_Api::_()->core()->hasSubject()) {
      if (0 !== ($photo_id = (int) $this->_getParam('photo_id')) &&
              null !== ($photo = Engine_Api::_()->getItem('coursesalbum_photo', $photo_id))) {
        Engine_Api::_()->core()->setSubject($photo);
      } else if (0 !== ($course_id = (int) $this->_getParam('course_id')) &&
              null !== ($classroom = Engine_Api::_()->getItem('classroom', $course_id))) {
        Engine_Api::_()->core()->setSubject($classroom);
      }
    }

    $this->_helper->requireUser->addActionRequires(array(
      'upload',
      'upload-photo', // Not sure if this is the right
      'edit',
    ));

    $this->_helper->requireSubject->setActionRequireTypes(array(
      'list' => classroom,
      'upload' => classroom,
      'view' => 'coursesalbum_photo',
      'edit' => 'coursesalbum_photo',
    ));
  }

  public function listAction() {}
	//get images as per album id (advance lightbox)
	public function correspondingImageAction(){
		$album_id = $this->_getParam('album_id', false);
		$this->view->paginator = $paginator = Engine_Api::_()->getDbTable('photos', 'coursesalbum')->getPhotoSelect(array('album_id'=>$album_id,'limit_data'=>100));
	}
	//rotate photo action from lightbox and photo view classroom
  public function rotateAction() {
    if (!$this->_helper->requireSubject('coursesalbum_photo')->isValid())
      return;
		$course_id = $this->_getParam('course_id');
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('coursesalbum_photo');
    $angle = (int) $this->_getParam('angle', 90);
    if (!$angle || !($angle % 360)) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid angle, must not be empty');
      return;
    }
    if (!in_array((int) $angle, array(90, 270))) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid angle, must be 90 or 270');
      return;
    }
    // Get file
    $file = Engine_Api::_()->getItem('storage_file', $photo->file_id);
    if (!($file instanceof Storage_Model_File)) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Could not retrieve file');
      return;
    }
    // Pull photo to a temporary file
    $tmpFile = $file->temporary();
    // Operate on the file
    $image = Engine_Image::factory();
    $image->open($tmpFile)
            ->rotate($angle)
            ->write()
            ->destroy();
    // Set the photo
    $db = $photo->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $photo->setPhoto($tmpFile);
      @unlink($tmpFile);
      $db->commit();
    } catch (Exception $e) {
      @unlink($tmpFile);
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->href = $photo->getPhotoUrl();
  }
	//flip photo action function
  public function flipAction() {
   if (!$this->_helper->requireSubject('coursesalbum_photo')->isValid())
      return;
		$course_id = $this->_getParam('course_id');
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('coursesalbum_photo');
    $direction = $this->_getParam('direction');
    if (!in_array($direction, array('vertical', 'horizontal'))) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid direction');
      return;
    }
    // Get file
    $file = Engine_Api::_()->getItem('storage_file', $photo->file_id);
    if (!($file instanceof Storage_Model_File)) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Could not retrieve file');
      return;
    }
    // Pull photo to a temporary file
    $tmpFile = $file->temporary();
    // Operate on the file
    $image = Engine_Image::factory();
    $image->open($tmpFile)
            ->flip($direction != 'vertical')
            ->write()
            ->destroy();
    // Set the photo
    $db = $photo->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $photo->setPhoto($tmpFile,false,'flip');
      @unlink($tmpFile);
      $db->commit();
    } catch (Exception $e) {
      @unlink($tmpFile);
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->href = $photo->getPhotoUrl();
  }

  public function viewAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();

    $course_id = $this->_getParam('course_id');
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'view')->isValid()) {
      return;
    }
    if (!$viewer || !$viewer->getIdentity() || $photo->user_id != $viewer->getIdentity()) {
      $photo->view_count = new Zend_Db_Expr('view_count + 1');
      $photo->save();
    }
		// Render
    $this->_helper->content->setEnabled();
  }


  public function deleteAction() {
    $photo = Engine_Api::_()->core()->getSubject();
    $classroom = $photo->getParent('classroom');
		$album_id = $photo->album_id;
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'edit')->isValid()) {
      return;
    }
    $this->view->form = $form = new Coursesalbum_Form_Photo_Delete();
    if(!$this->getRequest()->isPost()) {
      $form->populate($photo->toArray());
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbTable('photos', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $photo->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $album = $photo = Engine_Api::_()->getItem('eclassroom_album', $album_id);
    return $this->_forward('success', 'utility', 'core', array(
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('Photo deleted')),
                'layout' => 'default-simple',
                'parentRedirect' => $album->getHref(),
                'closeSmoothbox' => true,
    ));
  }

}
