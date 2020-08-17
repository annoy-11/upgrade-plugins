<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_DashboardController extends Core_Controller_Action_Standard {
  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesdocuments', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('sesdocument_id', null);
    $document_id = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->getEventId($id);
    if ($document_id) {
      $document = Engine_Api::_()->getItem('sesdocument', $document_id);
      if ($document && $document->is_approved)
        Engine_Api::_()->core()->setSubject($document);
      else
        return $this->_forward('requireauth', 'error', 'core');
    } else
      return $this->_forward('requireauth', 'error', 'core');
		if (!$this->_helper->requireAuth()->setAuthParams($document, null, 'edit')->isValid())
      return;
  }
  public function editAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->document = $document = Engine_Api::_()->core()->getSubject();
   
    //Event Category and profile fileds
    $this->view->defaultProfileId = $defaultProfileId = 1; //Engine_Api::_()->getDbTable('metas', 'sesevent')->profileFieldId();
    if (isset($document->category_id) && $document->category_id != 0)
      $this->view->category_id = $document->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($document->subsubcat_id) && $document->subsubcat_id != 0)
      $this->view->subsubcat_id = $document->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($document->subcat_id) && $document->subcat_id != 0)
      $this->view->subcat_id = $document->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;
  
    //Event category and profile fields
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $document->isOwner($viewer)))
     return $this->_forward('notfound', 'error', 'core');
    // Create form
    $this->view->form = $form = new Sesdocument_Form_Edit(array('parent_type' => $document->parent_type, 'parent_id' => $document->parent_id, 'defaultProfileId' => $defaultProfileId));

    $this->view->category_id = $document->category_id;
    $this->view->subcat_id = $document->subcat_id;
    $this->view->subsubcat_id = $document->subsubcat_id;
    $tagStr = '';
   /* foreach ($document->tags()->getTagMaps() as $tagMap) {
      $tag = $tagMap->getTag();
      if (!isset($tag->text))
        continue;
      if ('' !== $tagStr)
        $tagStr .= ', ';
      $tagStr .= $tag->text;
    }*/

    $form->populate(array(
        'tags' => $tagStr,
    ));

    $form->populate(array(
        'networks' => explode(",",$document->networks),
        'levels' => explode(",",$document->levels)
    ));

    if (!$this->getRequest()->isPost()) {
      // Populate auth
      $auth = Engine_Api::_()->authorization()->context;
      if ($document->parent_type == 'group')
        $roles = array('owner', 'member', 'parent_member', 'registered', 'everyone');
      else
        $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      foreach ($roles as $role) {
        if (isset($form->auth_view->options[$role]) && $auth->isAllowed($document, $role, 'view'))
          $form->auth_view->setValue($role);
        if (isset($form->auth_comment->options[$role]) && $auth->isAllowed($document, $role, 'comment'))
          $form->auth_comment->setValue($role);
          }
      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.inviteguest', 1)) {
	      $form->auth_invite->setValue($auth->isAllowed($document, 'member', 'invite'));
      }
      $form->populate($document->toArray());
      if ($form->draft->getValue() == 1)
        $form->removeElement('draft');
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    //check custom url
    /*if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('events', 'sesevent')->checkCustomUrl($_POST['custom_url'], $event->event_id);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url not available.Please select other."));
        return;
      }
    }*/
		

   
    $db = Engine_Api::_()->getItemTable('sesdocuments')->getAdapter();
    $db->beginTransaction();
    try {
	     
    if(isset($values['levels']))
        $values['levels'] = implode(',',$values['levels']);

    if(isset($values['networks']))
        $sesblog['networks'] = implode(',',$values['networks']);

     
      
      /*if (isset($_POST['custom_url']))
        $event->custom_url = $_POST['custom_url'];
      else
        $event->custom_url = $event->event_id;*/
      $document->save();
      $tags = preg_split('/[,]+/', $values['tags']);
      $document->tags()->setTagMaps($viewer, $tags);
      // Add photo
      if (!empty($values['photo'])) {
        $document->setPhoto($form->photo);
      }
      // Add cover photo
      if (!empty($values['cover'])) {
        $document->setCover($form->cover);
      }

      // Set auth
      $auth = Engine_Api::_()->authorization()->context;
      if ($document->parent_type == 'group')
        $roles = array('owner', 'member', 'parent_member', 'registered', 'everyone');
      else
        $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      if (empty($values['auth_view']))
        $values['auth_view'] = 'everyone';
      if (empty($values['auth_comment']))
        $values['auth_comment'] = 'everyone';
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $ratingMax = array_search(@$values['auth_rating'], $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($document, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($document, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($document, $role, 'rating', ($i <= $ratingMax));
      }
      $auth->setAllowed($document, 'member', 'invite', $values['auth_invite']);
      // Add an entry for member_requested
      $auth->setAllowed($document, 'member_requested', 'view', 1);

        $this->view->driveObject = $driveObject = new drive();
        $oldFile = $document->file_id_google;
        if(!empty($_FILES['extensions']['name'])) {
            $file = $document->setFile($form->extensions);
            include APPLICATION_PATH . DS . 'application' . DS . 'modules' . DS . 'Sesdocument' . DS . 'Api' . DS . 'drive.php';

            $folderName = $viewer->email . '-' . $viewer->getIdentity();
            $folder = $driveObject->getFolder($folderName);
            //set permission
            $driveObject->setPermissions($folder,Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument_google_email'));
            $parent = $folder;
            $filePath = $this->getBaseUrl(true,$file->map());
            $mimeType = $driveObject->getFileType($filePath);
            $fileName = $_FILES['extensions']['name'];
            $allowDownload = !empty($_POST['download']) ? 1 : 0;
            $fileId = $driveObject->uploadFile($filePath, $fileName, strip_tags($_POST['description']), $parent, $mimeType, $allowDownload);

            $driveObject->setPermissions($fileId,'me', 'reader',  'anyone');
            $document->folder_id_google = $folder;
            $document->file_id_google = $fileId;
            $document->status = 1;
            $document->save();
            if($oldFile){
                try {
                    $driveObject->deleteFile($oldFile);
                }catch(Exception $e){
                    //silence
                }
            }
        }



        //Add fields
      $customfieldform = $form->getSubForm('fields');
      if($customfieldform) {
          $customfieldform->setItem($document);
          $customfieldform->saveValues();
      }
			$document->save();    

      $db->commit();
    } catch (Engine_Image_Exception $e) {
      $db->rollBack();
      $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $db->beginTransaction();
    try {
      // Rebuild privacy
      //$actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      //foreach( $actionTable->getActionsByObject($event) as $action ) {
      //$actionTable->resetActivityBindings($action);
      //}
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    // Redirect
    $this->_redirectCustom(array('route' => 'sesdocument_dashboard', 'action' => 'edit', 'sesdocument_id' => $document->custom_url));
  }
	