<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: PhotoController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epetition_PhotoController extends Core_Controller_Action_Standard
{

  public function init()
  {
    if (!Engine_Api::_()->core()->hasSubject()) {
      if (0 !== ($photo_id = (int)$this->_getParam('photo_id')) &&
        null !== ($photo = Engine_Api::_()->getItem('epetition_photo', $photo_id))) {
        Engine_Api::_()->core()->setSubject($photo);
      } else if (0 !== ($epetition_id = (int)$this->_getParam('epetition_id')) &&
        null !== ($petition = Engine_Api::_()->getItem('epetition', $event_id))) {
        Engine_Api::_()->core()->setSubject($petition);
      }
    }

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1)) {
      if (Engine_Api::_()->core()->hasSubject()) {
        $subject = Engine_Api::_()->core()->getSubject();
        if ($subject == 'epetition') {
          if (!$subject->getPackage()->getItemModule('photo')) {
            return $this->_forward('notfound', 'error', 'core');
          };
        } else {
          if (!$subject->getParent()->getParent()->getPackage()->getItemModule('photo')) {
            return $this->_forward('notfound', 'error', 'core');
          };
        }
      }
    }
  }

//rotate photo action from lightbox and photo view page
  public function rotateAction()
  {
    if (!$this->_helper->requireSubject('epetition_photo')->isValid())
      return;
    $epetition_id = $this->_getParam('epetition_id');
    $petition = Engine_Api::_()->getItem('epetition', $epetition_id);
    if (!$this->_helper->requireAuth()->setAuthParams($petition, null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('epetition_photo');
    $angle = (int)$this->_getParam('angle', 90);
    if (!$angle || !($angle % 360)) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid angle, must not be empty');
      return;
    }
    if (!in_array((int)$angle, array(90, 270))) {
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
  public function flipAction()
  {
    if (!$this->_helper->requireSubject('epetition_photo')->isValid())
      return;
    $epetition_id = $this->_getParam('epetition_id');
    $petition = Engine_Api::_()->getItem('epetition', $epetition_id);
    if (!$this->_helper->requireAuth()->setAuthParams($petition, null, 'edit')->isValid())
      return;
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid method');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $photo = Engine_Api::_()->core()->getSubject('epetition_photo');
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
      $photo->setPhoto($tmpFile, false, 'flip');
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

  public function correspondingImageAction()
  {
    $album_id = $this->_getParam('album_id', false);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('photos', 'epetition')->getPhotoSelect(array('album_id' => $album_id, 'limit_data' => 100));
  }

  public function uploadAction()
  {
    if (isset($_GET['ul']) || isset($_FILES['Filedata']))
      return $this->_forward('upload-photo', null, null, array('format' => 'json', 'epetition_id' => 0));
  }

  public function viewAction()
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
    $epetition_id = $this->_getParam('epetition_id');
    $petition = Engine_Api::_()->getItem('epetition', $epetition_id);
    if (!$this->_helper->requireAuth()->setAuthParams($petition, null, 'view')->isValid()) {
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

  public function uploadPhotoAction()
  {
    if (!$this->_helper->requireAuth()->setAuthParams('epetition', null, 'create')->isValid())
      return;
    if (!$this->_helper->requireUser()->checkRequire()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $values = $this->getRequest()->getPost();

    if (empty($_GET['isURL']) || $_GET['isURL'] == 'false') {
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

    $epetitionPhotoTable = Engine_Api::_()->getDbtable('photos', 'epetition');

    $db = $epetitionPhotoTable->getAdapter();
    $db->beginTransaction();
    $session = new Zend_Session_Namespace();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      if (empty($session->album_id)) {
        $albumtable = Engine_Api::_()->getDbTable('albums', 'epetition');
        $album = $albumtable->createRow();
        $album->setFromArray(array(
          'title' => '',
          'epetition_id' => 0
        ));
        $album->save();
        $session->album_id = $album->getIdentity();
        $album_id = $album->getIdentity();
      } else {
        $album_id = $session->album_id;
        $album = Engine_Api::_()->getItem('epetition_album', $album_id);
      }
      $params = array(
        'collection_id' => $album_id,
        'album_id' => $album_id,
        'epetition_id' => 0,
        'user_id' => $viewer->getIdentity(),
        'owner_id' => $viewer->getIdentity()
      );
      $photo = Engine_Api::_()->sesbasic()->setPhoto($uploadSource, $isURL, false, 'epetition', 'epetition', $params, $album);
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
      //throw $e;

      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      return;
    }
    if (isset($_GET['ul']))
      echo json_encode(array('status' => $this->view->status, 'name' => '', 'photo_id' => $this->view->photo_id));
    die;
  }

  public function editAction()
  {
    if (!$this->_helper->requireAuth()->setAuthParams(null, null, 'photo.edit')->isValid()) return;

    $photo = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Epetition_Form_Photo_Edit();

    if (!$this->getRequest()->isPost()) {
      $form->populate($photo->toArray());
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('photos', 'group')->getAdapter();
    $db->beginTransaction();

    try {
      $photo->setFromArray($form->getValues())->save();

      $db->commit();
    } catch (Exception $e) {
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


  public function deleteAction()
  {
    $photo = Engine_Api::_()->core()->getSubject();
    $petition = $photo->getParent('epetition');
    $album_id = $photo->album_id;
    if (!$this->_helper->requireAuth()->setAuthParams($petition, null, 'edit')->isValid()) {
      return;
    }

    $this->view->form = $form = new Epetition_Form_Photo_Delete();

    if (!$this->getRequest()->isPost()) {
      $form->populate($photo->toArray());
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('photos', 'epetition')->getAdapter();
    $db->beginTransaction();

    try {
      $photo->delete();

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $album = Engine_Api::_()->getItem('epetition_album', $album_id);
    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Photo deleted')),
      'layout' => 'default-simple',
      'parentRedirect' => $album->getHref(),
      'closeSmoothbox' => true,
    ));
  }

}