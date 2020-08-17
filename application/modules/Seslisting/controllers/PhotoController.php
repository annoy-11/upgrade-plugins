<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: PhotoController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_PhotoController extends Core_Controller_Action_Standard {

  public function init() {
    if (!Engine_Api::_()->core()->hasSubject()) {
      if (0 !== ($photo_id = (int) $this->_getParam('photo_id')) &&
              null !== ($photo = Engine_Api::_()->getItem('seslisting_photo', $photo_id))) {
        Engine_Api::_()->core()->setSubject($photo);
      } else if (0 !== ($listing_id = (int) $this->_getParam('listing_id')) &&
              null !== ($listing = Engine_Api::_()->getItem('seslisting', $event_id))) {
        Engine_Api::_()->core()->setSubject($listing);
      }
    }

		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslistingpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslistingpackage.enable.package', 1)){
			if(Engine_Api::_()->core()->hasSubject()){
				$subject = Engine_Api::_()->core()->getSubject();
				if($subject  == 'seslisting'){
					if(!$subject->getPackage()->getItemModule('photo')){
						return $this->_forward('notfound', 'error', 'core');
					};
				}else{
					if(!$subject->getParent()->getParent()->getPackage()->getItemModule('photo')){
						return $this->_forward('notfound', 'error', 'core');
					};
				}
			}
		}
  }
//rotate photo action from lightbox and photo view page
  public function rotateAction() {
    if (!$this->_helper->requireSubject('seslisting_photo')->isValid())
      return;
		$listing_id = $this->_getParam('listing_id');
		$listing = Engine_Api::_()->getItem('seslisting', $listing_id);
    if (!$this->_helper->requireAuth()->setAuthParams($listing, null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('seslisting_photo');
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
            ->destroy()
    ;
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
   if (!$this->_helper->requireSubject('seslisting_photo')->isValid())
      return;
		$listing_id = $this->_getParam('listing_id');
		$listing = Engine_Api::_()->getItem('seslisting', $listing_id);
    if (!$this->_helper->requireAuth()->setAuthParams($listing, null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('seslisting_photo');
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
            ->destroy()
    ;
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
  	public function correspondingImageAction(){
		$album_id = $this->_getParam('album_id', false);
		$this->view->paginator = $paginator = Engine_Api::_()->getDbtable('photos', 'seslisting')->getPhotoSelect(array('album_id'=>$album_id,'limit_data'=>100));
	}
  public function uploadAction() {

    if (isset($_GET['ul']) || isset($_FILES['Filedata']))
    return $this->_forward('upload-photo', null, null, array('format' => 'json', 'listing_id'=> 0));
  }
  public function viewAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
		$listing_id = $this->_getParam('listing_id');
		$listing = Engine_Api::_()->getItem('seslisting', $listing_id);
    if (!$this->_helper->requireAuth()->setAuthParams($listing, null, 'view')->isValid()) {
      return;
    }

    if (!$viewer || !$viewer->getIdentity() || $photo->user_id != $viewer->getIdentity()) {
      $photo->view_count = new Zend_Db_Expr('view_count + 1');
      $photo->save();
    }
		// Render
    $this->_helper->content
            ->setEnabled();
  }
  public function uploadPhotoAction() {
 		 if (!$this->_helper->requireAuth()->setAuthParams('seslisting', null, 'create')->isValid())
      return;
    if( !$this->_helper->requireUser()->checkRequire() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if( !$this->getRequest()->isPost() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $values = $this->getRequest()->getPost();

		if(empty($_GET['isURL']) || $_GET['isURL'] == 'false'){
			$isURL = false;
			$values = $this->getRequest()->getPost();
			if (empty($values['Filename']) && !isset($_FILES['Filedata'])) {
				$this->view->status = false;
				$this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
				return;
			}
			if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
				$this->view->status = false;
				$this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
				return;
			}
			$uploadSource = $_FILES['Filedata'];
		}else{
			$uploadSource = $_POST['Filedata'];
			$isURL = true;
		}

    $seslistingPhotoTable = Engine_Api::_()->getDbtable('photos', 'seslisting');

    $db = $seslistingPhotoTable->getAdapter();
    $db->beginTransaction();
		$session = new Zend_Session_Namespace();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      if(empty($session->album_id)) {
			$album = Engine_Api::_()->getItemTable('seslisting_album')->createRow();
			$album->setFromArray(array(
				'title' => '',
				'listing_id' => 0
			));
			$album->save();
			$session->album_id = $album->getIdentity();
			$album_id = $album->getIdentity();
     }else{
      	$album_id = $session->album_id;
				$album = Engine_Api::_()->getItem('seslisting_album', $album_id);
		 }
      $params = array(
          'collection_id' => $album_id,
          'album_id' => $album_id,
          'listing_id' => 0,
          'user_id' => $viewer->getIdentity(),
          'owner_id' => $viewer->getIdentity()
      );
      $photo = Engine_Api::_()->sesbasic()->setPhoto($uploadSource, $isURL,false,'seslisting','seslisting',$params,$album);
			$photo->album_id = $album->getIdentity();
			$photo->save();
      $this->view->status = true;
      $this->view->photo_id = $photo->photo_id;
			$this->view->url = $photo->getPhotoUrl('thumb.normal');
      $db->commit();
    } catch (Exception $e) {
			$session = new Zend_Session_Namespace();
      unset($session->album_id);
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      return;
    }
    if(isset($_GET['ul']))
    echo json_encode(array('status'=>$this->view->status,'name'=>'','photo_id'=> $this->view->photo_id));die;
  }

  public function editAction()
  {
    if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'photo.edit')->isValid() ) return;

    $photo = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Seslisting_Form_Photo_Edit();

    if( !$this->getRequest()->isPost() )
    {
      $form->populate($photo->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('photos', 'group')->getAdapter();
    $db->beginTransaction();

    try
    {
      $photo->setFromArray($form->getValues())->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array('Changes saved'),
      'layout' => 'default-simple',
      'parentRefresh' => true,
      'closeSmoothbox' => true,
    ));
  }



  public function deleteAction() {
    $photo = Engine_Api::_()->core()->getSubject();
    $listing = $photo->getParent('seslisting');
		$album_id = $photo->album_id;
    if (!$this->_helper->requireAuth()->setAuthParams($listing, null, 'edit')->isValid()) {
      return;
    }

    $this->view->form = $form = new Seslisting_Form_Photo_Delete();

    if (!$this->getRequest()->isPost()) {
      $form->populate($photo->toArray());
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('photos', 'seslisting')->getAdapter();
    $db->beginTransaction();

    try {
      $photo->delete();

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
		$album = Engine_Api::_()->getItem('seslisting_album', $album_id);
    return $this->_forward('success', 'utility', 'core', array(
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('Photo deleted')),
                'layout' => 'default-simple',
                'parentRedirect' => $album->getHref(),
                'closeSmoothbox' => true,
    ));
  }

}
