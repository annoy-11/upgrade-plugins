<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AlbumController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AlbumController extends Core_Controller_Action_Standard {

  public function uploadAction() {

    if( isset($_GET['ul']) )
      return $this->_forward('upload-photo', null, null, array('format' => 'json'));

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);

    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $this->_getParam('crowdfunding_id', null));

    if( isset($_FILES['Filedata']) )
      $_POST['file'] = $this->uploadPhotoAction($sescrowdfunding);

    //Get form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_UploadPhotos();

    if( !$this->getRequest()->isPost()) {
      if( null !== ($album_id = $this->_getParam('album_id'))) {
        $form->populate(array('album' => $album_id));
      }
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Api::_()->getItemTable('sescrowdfunding_album')->getAdapter();
    $db->beginTransaction();

    try {
      $album = $form->saveValues();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->_helper->redirector->gotoRoute(array('action' => 'manage-photos', 'album_id' => $album->album_id, 'crowdfunding_id' => $sescrowdfunding->custom_url), 'sescrowdfunding_dashboard', true);
  }

    //edit photo details from light function.
    public function saveInformationAction() {
        $photo_id = $this->_getParam('photo_id');
        $description = $this->_getParam('description', null);
        Engine_Api::_()->getDbTable('photos', 'sescrowdfunding')->update(array('description' => $description), array('photo_id = ?' => $photo_id));
    }

    public function editPhotoAction() {
        $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
        $this->view->photo = Engine_Api::_()->getItem('sescrowdfunding_photo', $photo_id);
    }
    //ACTION FOR PHOTO DELETE
    public function removeAction() {
        if(empty($_POST['photo_id']))
            die('error');
        //GET PHOTO ID AND ITEM
        $photo_id = (int) $this->_getParam('photo_id');
        $photo = Engine_Api::_()->getItem('sescrowdfunding_photo', $photo_id);
        $db = Engine_Api::_()->getDbTable('photos', 'sescrowdfunding')->getAdapter();
        $db->beginTransaction();
        try {
            $photo->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

  public function uploadPhotoAction($sescrowdfunding) {

    if( !$this->_helper->requireUser()->checkRequire()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if( !$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

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
    } else {
        $uploadSource = $_POST['Filedata'];
        $isURL = true;
    }

//     $values = $this->getRequest()->getPost();
//     if( empty($values['Filename']) && !isset($_FILES['Filedata'])) {
//       $this->view->status = false;
//       $this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
//       return;
//     }
//
//     if( !isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
//       $this->view->status = false;
//       $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
//       return;
//     }

    $db = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();

    try {

      $viewer = Engine_Api::_()->user()->getViewer();
      $photoTable = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array('user_id' => $viewer->getIdentity()));
      $photo->save();

      $photo->order = $photo->photo_id;
      $photo->setPhoto($uploadSource, $isURL);
      $photo->save();

      $this->view->status = true;
      $this->view->name = $_FILES['Filedata']['name'];
      $this->view->photo_id = $photo->photo_id;
      $photo->crowdfunding_id = $sescrowdfunding->crowdfunding_id;
      $photo->save();

      $db->commit();
      return $photo->photo_id;

    } catch( Sescrowdfunding_Model_Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = $this->view->translate($e->getMessage());
      throw $e;
      return;

    } catch( Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      throw $e;
      return;
    }
  }
}
