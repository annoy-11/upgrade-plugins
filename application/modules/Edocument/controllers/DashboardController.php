<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_DashboardController extends Core_Controller_Action_Standard {

  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('edocument', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('edocument_id', null);

    $edocument_id = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getDocumentId($id);

    if ($edocument_id) {
      $document = Engine_Api::_()->getItem('edocument', $edocument_id);
      if ($document)
        Engine_Api::_()->core()->setSubject($document);
    } else
      return $this->_forward('requireauth', 'error', 'core');

    $isDocumentAdmin = Engine_Api::_()->edocument()->isDocumentAdmin($document, 'edit');

    if (!$isDocumentAdmin)
        return $this->_forward('requireauth', 'error', 'core');

  }

  public function emailAction() {

    $this->view->document = $edocument = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Edocument_Form_Email();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      Engine_Api::_()->getApi('mail', 'core')->sendSystem($values['to'], 'EDOCUMENT_EMAIL_DOCUMENT', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => $values['subject'],
          'message' => $values['message'],
          'document_link' => "https://drive.google.com/uc?id=".$edocument->file_id_google."&export=download",
      ));

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => false,
          'format' => 'smoothbox',
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('Email has been sent successfully.'))
      ));
    }

  }

  public function editAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->document = $edocument = Engine_Api::_()->core()->getSubject();

    if (isset($edocument->category_id) && $edocument->category_id != 0)
        $this->view->category_id = $edocument->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
        $this->view->category_id = $_POST['category_id'];
    else
        $this->view->category_id = 0;

    if (isset($edocument->subsubcat_id) && $edocument->subsubcat_id != 0)
        $this->view->subsubcat_id = $edocument->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
        $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
        $this->view->subsubcat_id = 0;

    if (isset($edocument->subcat_id) && $edocument->subcat_id != 0)
        $this->view->subcat_id = $edocument->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
        $this->view->subcat_id = $_POST['subcat_id'];
    else
        $this->view->subcat_id = 0;

    $viewer = Engine_Api::_()->user()->getViewer();

    //google library include
    include APPLICATION_PATH . DS . 'application' . DS . 'modules' . DS . 'Edocument' . DS . 'Api' . DS . 'drive.php';

    $this->view->error_doc_full = 0;
    $this->view->driveObject = $driveObject = new drive();
    $storageAvailable = 0;
    if ($driveObject) {
        $storage = $driveObject->getInfo();
        if($storage) {
            $storage = $storage->storageQuota;
            $storageAvailable = $storage->limit - $storage->usage;
        }
    }
    $this->view->error_doc_full = 0;
    if (!$storageAvailable) {
        $this->view->error_doc_full = 1;
        return;
    }

    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'edocument')->profileFieldId();

    if( !Engine_Api::_()->core()->hasSubject('edocument') )
        Engine_Api::_()->core()->setSubject($edocument);

    if( !$this->_helper->requireSubject()->isValid() ) return;

    if( !$this->_helper->requireAuth()->setAuthParams('edocument', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Edocument_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form

    $form->populate($edocument->toArray());
    $form->populate(array(
        'networks' => explode(",",$edocument->networks),
        'levels' => explode(",",$edocument->levels)
    ));

    if($form->getElement('category_id'))
        $form->getElement('category_id')->setValue($edocument->category_id);

    $tagStr = '';
    foreach( $edocument->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }

    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($edocument, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($edocument, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $edocument->draft == "0" )
        $form->removeElement('draft');

    // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $values = $form->getValues();
    if(empty($values['extensions']))
      unset($values['extensions']);
    try {
      $edocument->setFromArray($values);
      $edocument->modified_date = date('Y-m-d H:i:s');
      if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
          $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
          $edocument->publish_date =$starttime;
      }

      if(isset($values['levels']))
          $edocument->levels = implode(',',$values['levels']);

      if(isset($values['networks']))
          $edocument->networks = implode(',',$values['networks']);

      $edocument->save();
      unset($_POST['title']);
      unset($_POST['tags']);
      unset($_POST['category_id']);
      unset($_POST['subcat_id']);
      unset($_POST['MAX_FILE_SIZE']);
      unset($_POST['body']);
      unset($_POST['search']);
      unset($_POST['execute']);
      unset($_POST['token']);
      unset($_POST['submit']);
      $values['fields'] = $_POST;
      $values['fields']['0_0_1'] = '2';

      if(isset($values['draft']) && !$values['draft']) {
          $currentDate = date('Y-m-d H:i:s');
          if($edocument->publish_date < $currentDate) {
          $edocument->publish_date = $currentDate;
          $edocument->save();
          }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
          $customfieldform->setItem($edocument);
          $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($edocument);
      $profile_field_value = $view->FieldValueLoop($edocument, $fieldStructure);

      // Auth
      if( empty($values['auth_view']) ) {
          $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
          $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      foreach( $roles as $i => $role ) {
          $auth->setAllowed($edocument, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($edocument, $role, 'comment', ($i <= $commentMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $edocument->tags()->setTagMaps($viewer, $tags);

      //upload main image
      if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
          $photo_id = $edocument->setPhoto($form->photo_file,'direct');
      }

      if(!empty($_FILES['extensions']['name'])) {

        $file = $edocument->setFile($form->extensions);
        $folderName = $viewer->email . '-' . $viewer->getIdentity();
        $folder = $driveObject->getFolder($folderName);

        //set permission
        $driveObject->setPermissions($folder,Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument_google_email'));
        $parent = $folder;
        $filePath = Engine_Api::_()->edocument()->getBaseUrl(true,$file->map());
        $mimeType = $driveObject->getFileType($filePath);
        $fileName = $_FILES['extensions']['name'];
        $allowDownload = !empty($_POST['download']) ? 1 : 0;
        $fileId = $driveObject->uploadFile($filePath, $fileName, strip_tags($_POST['description']), $parent, $mimeType, $allowDownload);

        $driveObject->setPermissions($fileId,'me', 'reader',  'anyone');
        $edocument->folder_id_google = $folder;
        $edocument->file_id_google = $fileId;
        $edocument->status = 1;
        $edocument->save();
      }

      // insert new activity if edocument is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($edocument);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$edocument->publish_date || strtotime($edocument->publish_date) <= time())) {
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $edocument, 'edocument_new');
          // make sure action exists before attaching the edocument to the activity
          if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $edocument);
          }
          $edocument->is_publish = 1;
          $edocument->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($edocument) as $action ) {
          $actionTable->resetActivityBindings($action);
      }
      $db->commit();
    } catch( Exception $e )
    {
    $db->rollBack();
    throw $e;
    }

    $this->_redirectCustom(array('route' => 'edocument_dashboard', 'action' => 'edit', 'edocument_id' => $edocument->custom_url));
    }


    public function removeMainphotoAction() {

        //GET Document ID AND ITEM
        $document = Engine_Api::_()->core()->getSubject();
        $db = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getAdapter();
        $db->beginTransaction();
        try {
            $document->photo_id = '';
            $document->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'edocument_id' => $document->custom_url), "edocument_dashboard", true);
    }

    public function mainphotoAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->document = $document = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();

        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $document->isOwner($viewer)))
            return;

        // Create form
        $this->view->form = $form = new Edocument_Form_Dashboard_Mainphoto();
        $form->populate($document->toArray());

        if (!$this->getRequest()->isPost())
            return;

        if (!$this->getRequest()->isPost() || $is_ajax_content)
            return;

        if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
            return;

        $db = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getAdapter();
        $db->beginTransaction();
        try {
            $document->setPhoto($_FILES['background']);
            $document->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }

        return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'edocument_id' => $document->custom_url), "edocument_dashboard", true);
    }

    //get seo detail
    public function seoAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->document = $document = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $document->isOwner($viewer)))
            return;

        $this->view->form = $form = new Edocument_Form_Edit_Seo();

        $form->populate($document->toArray());
        if (!$this->getRequest()->isPost())
            return;

        if (!$this->getRequest()->isPost() || $is_ajax_content)
            return;

        if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
            return;

        $db = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getAdapter();
        $db->beginTransaction();
        try {
            $document->setFromArray($_POST);
            $document->save();
            $db->commit();
            $form->addNotice('Your changes have been saved.');
        } catch (Exception $e) {
            $db->rollBack();
        }
    }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->document = $document = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Edocument_Form_Edit_Photo();

    if( empty($document->photo_id) ) {
      $form->removeElement('remove');
    }

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Uploading a new photo
    if( $form->Filedata->getValue() !== null ) {
      $db = $document->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $fileElement = $form->Filedata;
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'edocument','edocument','',$document,true);
        $document->photo_id = $photo_id;
        $document->save();
        $db->commit();
      }
      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e )
      {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      }
      // Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function removePhotoAction() {

    //Get form
    $this->view->form = $form = new Edocument_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $document = Engine_Api::_()->core()->getSubject();
    $document->photo_id = 0;
    $document->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }
}
