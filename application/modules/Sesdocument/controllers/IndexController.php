<?php

class Sesdocument_IndexController extends Core_Controller_Action_Standard
{
  public function init(){

    if (!$this->_helper->requireAuth()->setAuthParams('sesdocument', null, 'view')->isValid())
      return;
    $id = $this->_getParam('document_id', $this->_getParam('id', null));

    if ($id) {
      $document = Engine_Api::_()->getItem('sesdocument', $id);
      if ($document) {
        Engine_Api::_()->core()->setSubject($document);
      }
    }
  }

    public function indexAction() {

    }

    public function homeAction() {
        $this->_helper->content->setEnabled();
    }


    public function browseAction() {
        $this->_helper->content->setEnabled();
    }

    public function manageAction() {
        $this->_helper->content->setEnabled();
    }

    public function categoriesAction() {
        $this->_helper->content->setEnabled();
    }

  public function createAction() {

    if (!$this->_helper->requireUser->isValid())
      return;
    if (!$this->_helper->requireAuth()->setAuthParams('sesdocument', null, 'create')->isValid())
      return;
     if (null !== ($id = $this->_getParam('id'))) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if (!$level instanceof Authorization_Model_Level) {
      throw new Engine_Exception('missing level');
    }

      include APPLICATION_PATH . DS . 'application' . DS . 'modules' . DS . 'Sesdocument' . DS . 'Api' . DS . 'drive.php';
      $viewer = Engine_Api::_()->user()->getViewer();
      $select = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->select()->where('user_id =?',$viewer->getIdentity());
      $paginator = count(Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->fetchAll($select));
      $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesdocument', 'max_doc');
      $this->view->current_count = $paginator;
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


    $this->view->defaultProfileId = $defaultProfileId = 1; //Engine_Api::_()->getDbTable('metas', 'sesDocument')->profileFieldId();
    $document_id = $this->_getParam('sesdocument_id', false);
    if ($document_id)
      $document = Engine_Api::_()->getItem('sesdocument', $document_id);

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

    $this->view->form = $form = new Sesdocument_Form_Create(array(
        'defaultProfileId' => $defaultProfileId
    )) ;
    $this->_helper->content->setEnabled();
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {

      return;
    }
;
    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url not available.Please select other."));
        return;
      }
    }
    $values = $form->getValues();

     $db = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->getAdapter();
    $db->beginTransaction();
    try {

        $table = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument');

        $document = $table->createRow();

        if(empty($values['category_id']))
            $values['category_id'] = 0;
        if(empty($values['subsubcat_id']))
            $values['subsubcat_id'] = 0;
        if(empty($values['subcat_id']))
            $values['subcat_id'] = 0;

        $values['user_id'] = $viewer->getIdentity();
        $document->setFromArray($values);
        $document->save();

        // Add photo
        if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument_thumbnails','1') && !empty($values['file'])) {
            $document->photo_id = $document->setPhoto($form->file);
            $document->save();
        }

        if(!empty($_FILES['extensions']['name'])) {
            $file = $document->setFile($form->extensions);


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

        }


      // Set auth
      $auth = Engine_Api::_()->authorization()->context;

      $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      if (empty($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      if (empty($values['auth_comment'])) {
        $values['auth_comment'] = 'everyone';
      }
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($document, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($document, $role, 'comment', ($i <= $commentMax));
      }

      $tags = preg_split('/[,]+/', $values['tags']);
      $document->tags()->addTagMaps($viewer, $tags);
      $document->is_approved = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesdocument', $viewer, 'approve')>0 ? 1 : 0;
      $document->sponsored = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesdocument', $viewer, 'sponsored')>0 ? 1 : 0;
      $document->featured = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesdocument', $viewer, 'featured')>0 ? 1 : 0;

      //Add fields
      if($form->getSubForm('fields')) {
        $customfieldform = $form->getSubForm('fields');
        $customfieldform->setItem($document);
        $customfieldform->saveValues();
      }
      $document->save();

      // Commit
      $db->commit();
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $document->custom_url = $_POST['custom_url'];
      else
        $document->custom_url = $document->getIdentity();
      $document->save();

      //Activity Feed Work
      if($document->draft == 1 && $document->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $document, 'sesdocument_create');
        if ($action) {
          $activityApi->attachActivity($action, $document);
        }

        //Tag Work
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
        }
      }

       if (!$document->is_approved) {

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($document->getOwner(), 'sesdocument_waiting_approval', array('page_title' => $document->getTitle(), 'object_link' => $document->getHref(), 'host' => $_SERVER['HTTP_HOST']));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $document, 'sesdocument_waiting_approval');
      }

      // Redirect
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.autoopenpopup', 1);
      if($autoOpenSharePopup && $document->draft && $document->is_approved){
        $_SESSION['newDocument'] = true;
      }
      if(!$document->is_approved){
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sesdocument_general', true);
      }else{
        header('location:'.$document->getHref());
        exit();
      }

    }catch(Exception $e){
      $db->rollback();
      throw $e;

    }
  }
    public function getBaseUrl($staticBaseUrl = true,$url = ""){
        if(strpos($url,'http') !== false)
            return $url;
        $http = '';
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
            $http = '';
        }
        $baseUrl =  APPLICATION_PATH.$url;
        if(Zend_Registry::get('StaticBaseUrl') != "/")
            $baseUrl = str_replace(Zend_Registry::get('StaticBaseUrl'),'/',$baseUrl);
        //if($staticBaseUrl){
       // $baseUrl = $baseUrl.Zend_Registry::get('StaticBaseUrl') ;
        //}
        return $http.str_replace('//','/',$baseUrl);
    }


  public function editAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->document = $document = Engine_Api::_()->getItem('sesdocument',  $this->_getParam('sesdocument_id'));
    //$this->view->document = $document = Engine_Api::_()->core()->getSubject();
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

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = 1; //Engine_Api::_()->getDbTable('metas', 'sesdocument')->profileFieldId();

    if( !Engine_Api::_()->core()->hasSubject('sesdocument') )
        Engine_Api::_()->core()->setSubject($document);

    if( !$this->_helper->requireSubject()->isValid() ) return;

    if( !$this->_helper->requireAuth()->setAuthParams('sesdocument', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesdocument_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesdocument')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesdocument_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form
    $form->populate($document->toArray());

    if($form->getElement('category_id'))
        $form->getElement('category_id')->setValue($document->category_id);

    $tagStr = '';
    foreach( $document->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($document, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($document, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $document->draft == "0" )
        $form->removeElement('draft');


    // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    $values = $form->getValues();

    if(empty($values['file']))
        unset($values['file']);

    try {

      $document->setFromArray($values);
      $document->modified_date = date('Y-m-d H:i:s');
      $document->save();
      $values['fields'] = $_POST;
      $values['fields']['0_0_1'] = '2';

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($document);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($document);
      $profile_field_value = $view->FieldValueLoop($document, $fieldStructure);

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
        $auth->setAllowed($document, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($document, $role, 'comment', ($i <= $commentMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $document->tags()->setTagMaps($viewer, $tags);

//         //upload main image
//         if(isset($_FILES['photo_id']) && $_FILES['photo_file']['name'] != ''){
//             $photo_id = $document->setPhoto($form->file,'direct');
//         }

        // Add photo
        if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument_thumbnails','1') && !empty($values['file'])) {
            $document->photo_id = $document->setPhoto($form->file);
            $document->save();
        }

      // insert new activity if sesdocument is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($document);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$document->publish_date || strtotime($document->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $document, 'sesdocument_create');
          // make sure action exists before attaching the sesdocument to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $document);
        }
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($document) as $action ) {
        $actionTable->resetActivityBindings($action);
      }
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

   function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    if ($this->_getParam('type') == 'sesdocument') {
      $type = 'sesdocument';
      $dbTable = 'sesdocuments';
      $resorces_id = 'sesdocument_id';
      $notificationType = 'sesdocument_like_document';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');

    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', $type)
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

    $item = Engine_Api::_()->getItem($type, $item_id);

    if (count($result) > 0) {

      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $item->like_count--;
      $item->save();

      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => 'like_sesdocument', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));

    } else {

      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {

        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();

        $item->like_count++;
        $item->save();

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      //Send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();

      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {

        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');

        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);

        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  function favouriteAction() {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }
    if ($this->_getParam('type') == 'sesdocument') {
      $type = 'sesdocument';
      $dbTable = 'sesdocuments';
      $resorces_id = 'sesdocument_id';
      $notificationType = 'favourite_sesdocument';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesdocument')->getItemfav($type, $item_id);

      $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesdocument');

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
      $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array($resorces_id . ' = ?' => $item_id));
      $item = Engine_Api::_()->getItem($type, $item_id);
      if(@$notificationType) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesdocument')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesdocument')->createRow();
        $fav->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $fav->resource_type = $type;
        $fav->resource_id = $item_id;
        $fav->save();
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1'),
                ), array(
            $resorces_id . '= ?' => $item_id,
        ));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem(@$type, @$item_id);
      if(@$notificationType) {
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

            $action = $activityTable->addActivity($viewer, $subject, $notificationType);
            if ($action)
              $activityTable->attachActivity($action, $subject);
          }
        }
      }
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
      die;
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
    $typeItem = ucwords(str_replace(array('sesdocument_'), '', $attachment->getType()));
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

  public function getDocumentAction() {

    $sesdata = array();
    $documentTable = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument');
    $selectDocumentTable = $documentTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    $documents = $documentTable->fetchAll($selectDocumentTable);
    foreach ($documents as $document) {
      $document_icon = $this->view->itemPhoto($document, 'thumb.icon');
      $sesdata[] = array(
          'id' => $document->sesdocument_id,
          'sesdocument_id' => $document->sesdocument_id,
          'url'=>$document->getHref(),
          'label' => $document->title,
          'photo' => $document_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
    public function subcategoryAction() {

    $category_id = $this->_getParam('category_id', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesdocument');
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
        $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose a Sub Category") . '</option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesdocument');
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
        $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose a Sub Sub Category") . '</option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }

    public function tagsAction() {
        $this->_helper->content->setEnabled();
    }

    public function rateAction() {

        $notificationType = 'sesdocument_rated';
        $viewer = Engine_Api::_()->user()->getViewer();
        $user_id = $viewer->getIdentity();

        $rating = $this->_getParam('rating');
        $document_id =  $this->_getParam('sesdocument_id');
        $document = $item = Engine_Api::_()->getItem('sesdocument', $document_id);

        $table = Engine_Api::_()->getDbtable('ratings', 'sesdocument');
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->sesdocument()->setRating($document_id, $user_id, $rating);
            $document->rating = Engine_Api::_()->sesdocument()->getRating($document->getIdentity());
            $document->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        if(@$notificationType) {
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

            $action = $activityTable->addActivity($viewer, $subject, $notificationType);
            if ($action)
              $activityTable->attachActivity($action, $subject);
          }
        }
        $total = Engine_Api::_()->sesdocument()->ratingCount($document->getIdentity());
        $data = array();
        $data[] = array(
            'total' => $total,
            'rating' => $rating,
        );
        return $this->_helper->json($data);
    }

    public function deleteAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $document = Engine_Api::_()->getItem('sesdocument', $this->getRequest()->getParam('sesdocument_id'));
        if (!$this->_helper->requireAuth()->setAuthParams($document, null, 'delete')->isValid()) {
            return;
        }

        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        $this->view->form = $form = new Sesdocument_Form_Delete();

        if (!$document) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Document doesn't exists or not authorized to delete");
            return;
        }

        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $document->getTable()->getAdapter();
        $db->beginTransaction();

        try {
            Engine_Api::_()->getApi('core', 'sesdocument')->deleteDocument($document);
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Document has been deleted.');
        return $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesdocument_general', true),
            'messages' => array($this->view->message)
        ));
    }

}
