<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_IndexController extends Core_Controller_Action_Standard {

  public function init() {

    if( !$this->_helper->requireAuth()->setAuthParams('edocument', null, 'view')->isValid() ) return;

    $id = $this->_getParam('edocument_id', $this->_getParam('id', null));
    $edocument_id = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getDocumentId($id);
    if ($edocument_id) {
      $document = Engine_Api::_()->getItem('edocument', $edocument_id);
      if ($document) {
		Engine_Api::_()->core()->setSubject($document);
      }
    }
  }
  public function rateAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $user_id = $viewer->getIdentity();

    $rating = $this->_getParam('rating');
    $edocument_id =  $this->_getParam('edocument_id');

    $table = Engine_Api::_()->getDbtable('ratings', 'edocument');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
        Engine_Api::_()->edocument()->setRating($edocument_id, $user_id, $rating);

        $edocument = Engine_Api::_()->getItem('edocument', $edocument_id);
        $edocument->rating = Engine_Api::_()->edocument()->getRating($edocument->getIdentity());
        $edocument->save();

        $owner = $edocument->getOwner();
        if($viewer_id != $owner->getIdentity()) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "edocument_rate", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $edocument->getType(), "object_id = ?" => $edocument->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $edocument, 'edocument_rate');
        }
        
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        $result = $activityTable->fetchRow(array('type =?' => "edocument_rate", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $edocument->getType(), "object_id = ?" => $edocument->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $edocument, 'edocument_rate');
          if ($action)
            $activityTable->attachActivity($action, $edocument);
        }

        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }

    $total = Engine_Api::_()->edocument()->ratingCount($edocument->getIdentity());
    $data = array();
    $data[] = array(
        'total' => $total,
        'rating' => $rating,
    );
    return $this->_helper->json($data);
  }

  public function likeItemAction() {

    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');

    if (!$item_id || !$item_type)
      return;

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);

    $this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;

    $edocument = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $param['type'] = $this->view->item_type = $item_type;
    $param['id'] = $this->view->item_id = $item->getIdentity();

    $this->view->paginator = $paginator = Engine_Api::_()->edocument()->likeItemCore($param);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($edocument);
  }

  public function indexAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function tagsAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function homeAction() {
   	//Render
    $this->_helper->content->setEnabled();
  }

  public function viewAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $this->view->edocument_id = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getDocumentId($this->_getParam('edocument_id', null));
    if(!Engine_Api::_()->core()->hasSubject())
        $edocument = Engine_Api::_()->getItem('edocument', $this->view->edocument_id);
    else
        $edocument = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
        return;

    if( !$this->_helper->requireAuth()->setAuthParams($edocument, $viewer, 'view')->isValid() )
        return;

    if( !$edocument || !$edocument->getIdentity() || ((!$edocument->is_approved || $edocument->draft) && !$edocument->isOwner($viewer)) )
        return $this->_helper->requireSubject->forward();

    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $view->doctype('XHTML1_RDFA');
        if($edocument->seo_title)
        $view->headTitle($edocument->seo_title, 'SET');
        if($edocument->seo_keywords)
        $view->headMeta()->appendName('keywords', $edocument->seo_keywords);
        if($edocument->seo_description)
        $view->headMeta()->appendName('description', $edocument->seo_description);
    }

    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('edocument', $edocument->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('edocument', $edocument->getOwner(), 'allow_networks')) {
        $returnValue = Engine_Api::_()->edocument()->checkPrivacySetting($edocument->getIdentity());
        if ($returnValue == false) {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }
    $this->_helper->content->setContentName('edocument_index_view')->setEnabled();
  }

  // USER SPECIFIC METHODS
  public function manageAction() {

      if( !$this->_helper->requireUser()->isValid() ) return;

      // Render
      $this->_helper->content->setEnabled();

      // Prepare data
      $this->view->form = $form = new Edocument_Form_Search();
      $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('edocument', null, 'create')->checkRequire();
      $form->removeElement('show');
      $categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc();
      if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
          $form->getElement('category')->addMultiOptions($categories);
      }
  }

  public function createAction() {

      if( !$this->_helper->requireUser()->isValid() ) return;
      if( !$this->_helper->requireAuth()->setAuthParams('edocument', null, 'create')->isValid()) return;

      $this->_helper->content->setEnabled();

      $viewer = Engine_Api::_()->user()->getViewer();

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
      if (isset($edocument->category_id) && $edocument->category_id != 0) {
          $this->view->category_id = $edocument->category_id;
      } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
          $this->view->category_id = $_POST['category_id'];
      else
          $this->view->category_id = 0;
      if (isset($edocument->subsubcat_id) && $edocument->subsubcat_id != 0) {
          $this->view->subsubcat_id = $edocument->subsubcat_id;
      } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
          $this->view->subsubcat_id = $_POST['subsubcat_id'];
      else
          $this->view->subsubcat_id = 0;
      if (isset($edocument->subcat_id) && $edocument->subcat_id != 0) {
          $this->view->subcat_id = $edocument->subcat_id;
      } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
          $this->view->subcat_id = $_POST['subcat_id'];
      else
          $this->view->subcat_id = 0;

      $values['user_id'] = $viewer->getIdentity();
      $paginator = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getEdocumentsPaginator($values);

      $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'edocument', 'max');
      $this->view->current_count = $paginator->getTotalItemCount();

      $this->view->categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc();

      // Prepare form
      $this->view->form = $form = new Edocument_Form_Create(array('defaultProfileId' => $defaultProfileId));

      // If not post or form not valid, return
      if( !$this->getRequest()->isPost() )
          return;

      if( !$form->isValid($this->getRequest()->getPost()) )
          return;

      //check custom url
      if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
          $custom_url = Engine_Api::_()->getDbtable('edocuments', 'edocument')->checkCustomUrl($_POST['custom_url']);
          if ($custom_url) {
              $form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
              return;
          }
      }

      // Process
      $table = Engine_Api::_()->getDbtable('edocuments', 'edocument');
      $db = $table->getAdapter();
      $db->beginTransaction();

      try {
          // Create edocument
          $viewer = Engine_Api::_()->user()->getViewer();
          $values = array_merge($form->getValues(), array(
              'owner_type' => $viewer->getType(),
              'owner_id' => $viewer->getIdentity(),
          ));

          if(isset($values['levels']))
              $values['levels'] = implode(',',$values['levels']);

          if(isset($values['networks']))
              $values['networks'] = implode(',',$values['networks']);

          $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
          $edocument = $table->createRow();
          if (is_null(@$values['subsubcat_id']))
              $values['subsubcat_id'] = 0;
          if (is_null(@$values['subcat_id']))
              $values['subcat_id'] = 0;

          $values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('edocument', $viewer, 'document_approve');

          //SEO By Default Work
          if($values['tags'])
              $values['seo_keywords'] = $values['tags'];

          $edocument->setFromArray($values);


          //Upload Main Image
          if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != '') {
              $edocument->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'edocument','edocument','',$edocument,true);
          }

          if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
              $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
              $edocument->publish_date =$starttime;
          }

          if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != '') {
              $oldTz = date_default_timezone_get();
              date_default_timezone_set($viewer->timezone);
              $start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
              date_default_timezone_set($oldTz);
              $edocument->publish_date = date('Y-m-d H:i:s', $start);
          }
          $edocument->save();
          $edocument_id = $edocument->edocument_id;

          if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
              $edocument->custom_url = $_POST['custom_url'];
          else
              $edocument->custom_url = $edocument->edocument_id;

          $edocument->save();
          $edocument_id = $edocument->edocument_id;

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

          $customfieldform = $form->getSubForm('fields');
          if (!is_null($customfieldform)) {
              $customfieldform->setItem($edocument);
              $customfieldform->saveValues();
          }

          // Auth
          $auth = Engine_Api::_()->authorization()->context;
          $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

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

          // Add tags
          $tags = preg_split('/[,]+/', $values['tags']);
          $edocument->save();
          $edocument->tags()->addTagMaps($viewer, $tags);

        //Start Send Approval Request to Admin
        if (!$edocument->is_approved) {

          $getAdminnSuperAdmins = Engine_Api::_()->edocument()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
              $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $edocument, 'edocument_waitingadminapproval');
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_edocument_adminapproval', array('sender_title' => $edocument->getOwner()->getTitle(), 'adminmanage_link' => 'admin/edocument/manage', 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($edocument->getOwner(), 'notify_edocument_documentsentforapproval', array('document_title' => $edocument->getTitle(), 'object_link' => $edocument->getHref(), 'host' => $_SERVER['HTTP_HOST']));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $edocument, 'edocument_waitingapproval');
        }

          // Add activity only if edocument is published
          if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$edocument->publish_date || strtotime($edocument->publish_date) <= time())) {
              $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $edocument, 'edocument_new');
              if( $action ) {
                  Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $edocument);
              }

              //Tag Work
              if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
                  $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
                  foreach($tags as $tag) {
                      $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
                  }
              }
          }
          $db->commit();
      } catch( Exception $e ) {
          $db->rollBack();
          throw $e;
      }

      $redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.redirect.creation', 0);
      if($redirect) {
          return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard','action'=>'edit','edocument_id'=>$edocument->custom_url),'edocument_dashboard',true);
      } else {
          return $this->_helper->redirector->gotoRoute(array('action' => 'view','edocument_id'=>$edocument->custom_url),'edocument_entry_view',true);
      }
  }

  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
        echo json_encode(array('status' => 'false', 'error' => 'Login'));
        die;
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
        echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
        die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');

    $select = $tableLike->select()
            ->from($tableLike->info('name'))
            ->where('resource_type = ?', 'edocument')
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

    $item = Engine_Api::_()->getItem('edocument', $item_id);

    if (count($result) > 0) {
        $db = $result->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $result->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
        die;
    } else {

      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {
          $like = $tableLike->createRow();
          $like->poster_id = $viewer_id;
          $like->resource_type = 'edocument';
          $like->resource_id = $item_id;
          $like->poster_type = 'user';
          $like->save();
          Engine_Api::_()->getDbtable('edocuments', 'edocument')->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('edocument_id = ?' => $item_id));
          //Commit
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }

      //Send notification and activity feed work.
      $owner = $item->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'edocument_like', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'edocument_like');
          $result = $activityTable->fetchRow(array('type =?' => 'edocument_like', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

          if (!$result) {
              $action = $activityTable->addActivity($viewer, $item, 'edocument_like');
              if ($action)
                  $activityTable->attachActivity($action, $item);
          }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  function favouriteAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
        echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
        echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'edocument')->getItemfav('edocument', $item_id);

    $favItem = Engine_Api::_()->getDbtable('edocuments', 'edocument');

    $item = Engine_Api::_()->getItem('edocument', $item_id);

    if (count($Fav) > 0) {
        //delete
        $db = $Fav->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $Fav->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array('edocument_id = ?' => $item_id));

        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'edocument_favourite', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => 'edocument_favourite', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

        Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);

        echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
        $this->view->favourite_id = 0;
        die;
    } else {
        //update
        $db = Engine_Api::_()->getDbTable('favourites', 'edocument')->getAdapter();
        $db->beginTransaction();
        try {
            $fav = Engine_Api::_()->getDbTable('favourites', 'edocument')->createRow();
            $fav->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
            $fav->resource_type = 'edocument';
            $fav->resource_id = $item_id;
            $fav->save();
            $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1')), array('edocument_id = ?' => $item_id));
            // Commit
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        //send notification and activity feed work.
        $owner = $item->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {

            $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');

            Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'edocument_favourite', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'edocument_favourite');

            $result = $activityTable->fetchRow(array('type =?' => 'edocument_favourite', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

            if (!$result) {
                $action = $activityTable->addActivity($viewer, $item, 'edocument_favourite');
                if ($action)
                    $activityTable->attachActivity($action, $item);
            }
        }
        $this->view->favourite_id = 1;
        echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
        die;
    }
  }

  public function deleteAction() {

    $edocument = Engine_Api::_()->getItem('edocument', $this->getRequest()->getParam('edocument_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($edocument, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = new Edocument_Form_Delete();

    if( !$edocument ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Document entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $edocument->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->edocument()->deleteDocument($edocument);;
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'edocument_general', true),
      'messages' => Array(Zend_Registry::get('Zend_Translate')->_('Your document entry has been deleted.'))
    ));
  }

  public function subcategoryAction() {

    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'edocument');
      $category_select = $categoryTable->select()
              ->from($categoryTable->info('name'))
              ->where('subcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if($CategoryType == 'search') {
            $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
            foreach ($subcategory as $category) {
                $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
            }
        }
        else {
            $data .= '<option value=""></option>';
            foreach ($subcategory as $category) {
                $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
            }
        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }

  public function subsubcategoryAction() {

    $category_id = $this->_getParam('subcategory_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'edocument');
      $category_select = $categoryTable->select()
              ->from($categoryTable->info('name'))
              ->where('subsubcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
	  $data .= '<option value=""></option>';
	  foreach ($subcategory as $category) {
	    $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
	  }

      }
    } else
      $data = '';
    echo $data;
    die;
  }

  public function getDocumentAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getdocument'] = true;
    $documents = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getEdocumentsSelect($value);
    foreach ($documents as $document) {
      $icon = $this->view->itemPhoto($document, 'thumb.icon');
      $sesdata[] = array(
          'id' => $document->edocument_id,
          'edocument_id' => $document->edocument_id,
          'label' => $document->title,
          'photo' => $icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function shareAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->attachment = $attachment = Engine_Api::_()->getItem($type, $id);
    if (empty($_POST['is_ajax']))
      $this->view->form = $form = new Activity_Form_Share();
    if (!$attachment) {
      // tell smoothbox to close
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('You cannot share this item because it has been removed.');
      $this->view->smoothboxClose = true;
      return $this->render('deletedItem');
    }
    // hide facebook and twitter option if not logged in
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
    if (!$facebookTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_facebook');
    }
    $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
    if (!$twitterTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_twitter');
    }
    if (empty($_POST['is_ajax']) && !$this->getRequest()->isPost()) {
      return;
    }
    if (empty($_POST['is_ajax']) && !$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbtable('actions', 'activity')->getAdapter();
    $db->beginTransaction();
    try {
      // Get body
      if (empty($_POST['is_ajax']))
        $body = $form->getValue('body');
      else
        $body = '';
      // Set Params for Attachment
      $params = array(
          'type' => '<a href="' . $attachment->getHref() . '">' . $attachment->getMediaType() . '</a>',
      );
      // Add activity
      $api = Engine_Api::_()->getDbtable('actions', 'activity');
      //$action = $api->addActivity($viewer, $viewer, 'post_self', $body);
      $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);
      if ($action) {
        $api->attachActivity($action, $attachment);
      }
      $db->commit();
      // Notifications
      $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
      // Add notification for owner of activity (if user and not viewer)
      if ($action->subject_type == 'user' && $attachment->getOwner()->getIdentity() != $viewer->getIdentity()) {
        $notifyApi->addNotification($attachment->getOwner(), $viewer, $action, 'shared', array(
            'label' => $attachment->getMediaType(),
        ));
      }
      // Preprocess attachment parameters
      if (empty($_POST['is_ajax']))
        $publishMessage = html_entity_decode($form->getValue('body'));
      else
        $publishMessage = '';
      $publishUrl = null;
      $publishName = null;
      $publishDesc = null;
      $publishPicUrl = null;
      // Add attachment
      if ($attachment) {
        $publishUrl = $attachment->getHref();
        $publishName = $attachment->getTitle();
        $publishDesc = $attachment->getDescription();
        if (empty($publishName)) {
          $publishName = ucwords($attachment->getShortType());
        }
        if (($tmpPicUrl = $attachment->getPhotoUrl())) {
          $publishPicUrl = $tmpPicUrl;
        }
        // prevents OAuthException: (#100) FBCDN image is not allowed in stream
        if ($publishPicUrl &&
                preg_match('/fbcdn.net$/i', parse_url($publishPicUrl, PHP_URL_HOST))) {
          $publishPicUrl = null;
        }
      } else {
        $publishUrl = $action->getHref();
      }
      // Check to ensure proto/host
      if ($publishUrl &&
              false === stripos($publishUrl, 'http://') &&
              false === stripos($publishUrl, 'https://')) {
        $publishUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishUrl;
      }
      if ($publishPicUrl &&
              false === stripos($publishPicUrl, 'http://') &&
              false === stripos($publishPicUrl, 'https://')) {
        $publishPicUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishPicUrl;
      }
      // Add site title
      if ($publishName) {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title
                . ": " . $publishName;
      } else {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title;
      }
      // Publish to facebook, if checked & enabled
      if ($this->_getParam('post_to_facebook', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
        try {
          $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
          $facebookApi = $facebook = $facebookTable->getApi();
          $fb_uid = $facebookTable->find($viewer->getIdentity())->current();
          if ($fb_uid &&
                  $fb_uid->facebook_uid &&
                  $facebookApi &&
                  $facebookApi->getUser() &&
                  $facebookApi->getUser() == $fb_uid->facebook_uid) {
            $fb_data = array(
                'message' => $publishMessage,
            );
            if ($publishUrl) {
              $fb_data['link'] = $publishUrl;
            }
            if ($publishName) {
              $fb_data['name'] = $publishName;
            }
            if ($publishDesc) {
              $fb_data['description'] = $publishDesc;
            }
            if ($publishPicUrl) {
              $fb_data['picture'] = $publishPicUrl;
            }
            $res = $facebookApi->api('/me/feed', 'POST', $fb_data);
          }
        } catch (Exception $e) {
          // Silence
        }
      } // end Facebook
      // Publish to twitter, if checked & enabled
      if ($this->_getParam('post_to_twitter', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_twitter_enable) {
        try {
          $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
          if ($twitterTable->isConnected()) {
            // Get attachment info
            $title = $attachment->getTitle();
            $url = $attachment->getHref();
            $picUrl = $attachment->getPhotoUrl();
            // Check stuff
            if ($url && false === stripos($url, 'http://')) {
              $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
            }
            if ($picUrl && false === stripos($picUrl, 'http://')) {
              $picUrl = 'http://' . $_SERVER['HTTP_HOST'] . $picUrl;
            }
            // Try to keep full message
            // @todo url shortener?
            $message = html_entity_decode($form->getValue('body'));
            if (strlen($message) + strlen($title) + strlen($url) + strlen($picUrl) + 9 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
              if ($picUrl) {
                $message .= ' - ' . $picUrl;
              }
            } else if (strlen($message) + strlen($title) + strlen($url) + 6 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            } else {
              if (strlen($title) > 24) {
                $title = Engine_String::substr($title, 0, 21) . '...';
              }
              // Sigh truncate I guess
              if (strlen($message) + strlen($title) + strlen($url) + 9 > 140) {
                $message = Engine_String::substr($message, 0, 140 - (strlen($title) + strlen($url) + 9)) - 3 . '...';
              }
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            }
            $twitter = $twitterTable->getApi();
            $twitter->statuses->update($message);
          }
        } catch (Exception $e) {
          // Silence
        }
      }
      // Publish to janrain
      if (//$this->_getParam('post_to_janrain', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_janrain_enable) {
        try {
          $session = new Zend_Session_Namespace('JanrainActivity');
          $session->unsetAll();
          $session->message = $publishMessage;
          $session->url = $publishUrl ? $publishUrl : 'http://' . $_SERVER['HTTP_HOST'] . _ENGINE_R_BASE;
          $session->name = $publishName;
          $session->desc = $publishDesc;
          $session->picture = $publishPicUrl;
        } catch (Exception $e) {
          // Silence
        }
      }
    } catch (Exception $e) {
      $db->rollBack();
      throw $e; // This should be caught by error handler
    }
    // If we're here, we're done
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Success!');
    $typeItem = ucwords(str_replace(array('edocument_'), '', $attachment->getType()));
    // Redirect if in normal context
    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      $return_url = $form->getValue('return_url', false);
      if (!$return_url) {
        $return_url = $this->view->url(array(), 'default', true);
      }
      return $this->_helper->redirector->gotoUrl($return_url, array('prependBase' => false));
    } else if ('smoothbox' === $this->_helper->contextSwitch->getCurrentContext()) {
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => false,
          'messages' => array($typeItem . ' share successfully.')
      ));
    } else if (isset($_POST['is_ajax'])) {
      echo "true";
      die();
    }
  }

  public function customUrlCheckAction(){
    $value = $this->sanitize($this->_getParam('value', null));
    if(!$value) {
      echo json_encode(array('error'=>true));die;
    }
    $edocument_id = $this->_getParam('edocument_id',null);
    $custom_url = Engine_Api::_()->getDbtable('edocuments', 'edocument')->checkCustomUrl($value,$edocument_id);
    if($custom_url){
      echo json_encode(array('error'=>true,'value'=>$value));die;
    }else{
      echo json_encode(array('error'=>false,'value'=>$value));die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
    "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
    "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
    (function_exists('mb_strtolower')) ?
    mb_strtolower($clean, 'UTF-8') :
    strtolower($clean) :
    $clean;
  }
}
