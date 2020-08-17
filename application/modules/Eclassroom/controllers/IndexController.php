<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_IndexController extends Core_Controller_Action_Standard
{
  public function welcomeAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function homeAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function indexAction()
  {
    $this->_helper->content->setEnabled();
  }
  public function browseAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function browseLocationsAction() {
    //Render
    $this->_helper->content->setEnabled();

  }
  public function featuredAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function sponsoredAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function verifiedAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function hotAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  public function tagsAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  function browseReviewAction(){
      // Render
      $this->_helper->content->setEnabled();
  }
  public function createAction() { 
    if (!$this->_helper->requireUser->isValid())
      return;
    if (!$this->_helper->requireAuth()->setAuthParams('eclassroom', null, 'create')->isValid())
      return;
    $viewer = $this->view->viewer();
    $quckCreate = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('eclassroom.category.selection', 0) && $settings->getSetting('eclassroom.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;
    $totalClassrooms = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->countClassrooms($viewer->getIdentity());
    $allowClassCount = Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'classroom_count');
    $this->view->widget_id = $widget_id = $this->_getParam('widget_id', 0);
     $this->view->parent_id = $parentId = $this->_getParam('parent_id', 0);
    //Render
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      // Render
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
      $this->_helper->layout->setLayout('default-simple');
      $layoutOri = $this->view->layout()->orientation;
      if ($layoutOri == 'right-to-left') {
        $this->view->direction = 'rtl';
      } else {
        $this->view->direction = 'ltr';
      }
      $language = explode('_', $this->view->locale()->getLocale()->__toString());
      $this->view->language = $language[0];
    } else {
      $this->_helper->content->setEnabled();
    }
    $this->view->createLimit = 1;
    if ($totalClassrooms >= $allowClassCount && $allowClassCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.category.selection', 0)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory(array('fetchAll' => true));
      }
        $this->view->defaultProfileId = 1;
        $this->view->form = $form = new Eclassroom_Form_Classroom_Create(array(
            'defaultProfileId' => 1,
            'smoothboxType' => $sessmoothbox,
        ));
    }
    // Not post/invalid
    if (!$this->getRequest()->isPost()) {
       return;
    }
    if (!$quckCreate && !$form->isValid($this->getRequest()->getPost())) {
        return;
    }
    //check custom url
    if (!$quckCreate && isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
        $custom_url = Engine_Api::_()->getDbtable('classrooms', 'eclassroom')->checkCustomUrl($_POST['custom_url']);
        if ($custom_url) {
          $form->addError($this->view->translate("Custom URL is not available. Please select another URL."));
          return;
        }
    }
    $values = array();
    if (!$quckCreate) {
      $values = $form->getValues();
      $values['location'] = isset($_POST['location']) ? $_POST['location'] : '';
    }
    $values['owner_id'] = $viewer->getIdentity();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if (!$quckCreate && $settings->getSetting('eclassroom.classmainphoto', 1)) {
      if (isset($values['photo']) && empty($values['photo'])) {
        $form->addError(Zend_Registry::get('Zend_Translate')->_('Main Photo is a required field.'));
         return;
      }
    }
    if (isset($values['networks'])) {
      //Start Network Work
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkValues[] = $network->network_id;
      }
      if (@$values['networks'])
        $values['networks'] = ',' . implode(',', $values['networks']);
      else
        $values['networks'] = '';
      //End Network Work
    }
    if (!isset($values['can_join']))
      $values['approval'] = $settings->getSetting('eclassroom.default.joinoption', 1) ? 0 : 1;

    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $db = $classroomTable->getAdapter();
    $db->beginTransaction();
    try { 
      // Create classroom
        $classroom = $classroomTable->createRow();
        if (!$quckCreate && empty($_POST['lat'])) {
            unset($values['location']);
            unset($values['lat']);
            unset($values['lng']);
            unset($values['venue_name']);
        }
        $classroom_draft = $settings->getSetting('classroom.draft', 1);
        if (empty($classroom_draft)) {
            $values['draft'] = 1;
        }
        if (!$quckCreate) {
            if (empty($values['category_id']))
            $values['category_id'] = 0;
            if (empty($values['subsubcat_id']))
            $values['subsubcat_id'] = 0;
            if (empty($values['subcat_id']))
            $values['subcat_id'] = 0;
        }
        $classroom->setFromArray($values);
        if(!isset($values['search']))
            $classroom->search = 1;
        else
            $classroom->search = $values['search'];
        if (isset($_POST['title']))
            $classroom->title = $_POST['title'];
        if (isset($_POST['category_id']))
            $classroom->category_id = $_POST['category_id'];
        if (isset($_POST['subcat_id']))
            $classroom->category_id = $_POST['category_id'];
        if (isset($_POST['subsubcat_id']))
            $classroom->category_id = $_POST['category_id'];

        $classroom->parent_id = $parentId;
        if (!isset($values['auth_view'])) {
            $values['auth_view'] = 'everyone';
        }
            $classroom->view_privacy = $values['auth_view'];
            $classroom->save();
        if (!$quckCreate) {
            $tags = preg_split('/[,]+/', $values['tags']);
            $classroom->tags()->addTagMaps($viewer, $tags);
            $classroom->seo_keywords = implode(',', $tags);
            $classroom->save();
        }
        if (!$quckCreate) {
            //Add fields
            $customfieldform = $form->getSubForm('fields');
            if ($customfieldform) {
                $customfieldform->setItem($classroom);
                $customfieldform->saveValues();
            }
        }
        if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
            $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
            $dbGetInsert->query('INSERT INTO engine4_eclassroom_locations (classroom_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $classroom->classroom_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');

            $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $classroom->classroom_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "classroom")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        }

        //Manage Apps
        Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_eclassroom_manageclassroomapps` (`classroom_id`) VALUES ("' . $classroom->classroom_id . '");');
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.auto.join', 1)) {
          $classroom->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
        }
        if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
            $classroom->custom_url = $_POST['custom_url'];
        else
            $classroom->custom_url = $classroom->classroom_id;
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'cls_approve'))
            $classroom->is_approved = 0;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'bs_featured'))
            $classroom->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'bs_sponsored'))
            $classroom->sponsored = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'bs_verified'))
            $classroom->verified = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'classroom_hot'))
            $classroom->hot = 1;
        $classroom->save();
        // Add photo
        if (!empty($values['photo'])) {
            $classroom->setPhoto($form->photo, '', 'profile');
        }

        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        if (!isset($values['auth_view']) || empty($values['auth_view'])) {
            $values['auth_view'] = 'everyone';
        }
        if (!isset($values['auth_comment']) || empty($values['auth_comment'])) {
            $values['auth_comment'] = 'everyone';
        }
        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);

        $albumMax = array_search($values['auth_album'], $roles);

        foreach ($roles as $i => $role) {
            $auth->setAllowed($classroom, $role, 'view', ($i <= $viewMax));
            $auth->setAllowed($classroom, $role, 'comment', ($i <= $commentMax));
            $auth->setAllowed($classroom, $role, 'album', ($i <= $albumMax));
        }
        $db->commit();
        $classroomname = '<a href="'.$classroom->getHref().'">'.$classroom->getTitle().'</a>';
            // Add activity only if sesproduct is published
    if($values['draft'] && $classroom->is_approved == 1) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $classroom, 'eclassroom_classroom_create');
        // make sure action exists before attaching the sesproduct to the activity
        if($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $classroom);
        }
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
            $isRowExists = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->action_id);
            if($isRowExists) {
                $details = Engine_Api::_()->getItem('sesadvancedactivity_detail', $isRowExists);
                $details->sesresource_id = $classroom->getIdentity();
                $details->sesresource_type = $classroom->getType();
                $details->save();

            }
        }
        //Tag Work
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
        }
        $users = array_unique(array_merge($likesClassroom ,$followerClassroom, $favouriteClassroom), SORT_REGULAR);
        foreach($users as $user){ 
            $usersOject = Engine_Api::_()->getItem('user', $user);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($usersOject, $viewer, $classroom, 'eclassroom_classroom_create');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($usersOject->email, 'eclassroom_classroom_create', array('host' => $_SERVER['HTTP_HOST'], 'classroom_name' => $classroomname,'object_link'=>$classroom->getHref()));
        }
     }
  
    $emails = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.receivenewalertemails', null);
    if(!empty($emails)) {
        $emailArray = explode(",",$emails);
        foreach($emailArray as $email) {
            $email = str_replace(' ', '', $email);
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'eclassroom_classroom_create', array('host' => $_SERVER['HTTP_HOST'], 'classroom_name' => $classroomname,'object_link'=>$classroom->getHref()));
        }
    }
     //Start Send Approval Request to Admin
    try {
      if (!$classroom->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {  
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $classroom, 'eclassroom_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'eclassroom_waitingadminapproval', array('sender_title' => $classroom->getOwner()->getTitle(), 'adminmanage_link' => 'admin/eclassroom/manage', 'classroom_name' => $classroomname, 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'eclassroom_waitingadminapproval', array('sender_title' => $classroom->getOwner()->getTitle(), 'classroom_name' => $classroomname, 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($classroom->getOwner(), 'eclassroom_classroom_wtapr', array('course_title' => $classroom->getTitle(),'classroom_name' => $classroomname, 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $classroom, 'eclassroom_classroom_wtapr');
      }
      //Send mail to all super admin and admins
      if ($classroom->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'eclassroom_waitingadminapproval', array('sender_title' => $classroom->getOwner()->getTitle(),'classroom_name' => $classroomname,'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'eclassroom_waitingadminapproval', array('sender_title' => $classroom->getOwner()->getTitle(), 'classroom_name' => $classroomname, 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($classroom->getOwner(), $viewer, $classroom, 'eclassroom_classsroom_adminaapr');
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($classroom->getOwner(), 'eclassroom_classroom_adminaapr', array('course_title' => $classroom->getTitle(),'classroom_name' => $classroomname, 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } 
    } catch(Exception $e) {}
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.autoopenpopup', 1);
      if ($autoOpenSharePopup) {
        $_SESSION['newClassroom'] = true;
      }
      $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.redirect', 1);
      if (!$classroom->is_approved) {
          return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'eclassroom_general', true);
      }elseif ($redirection == 1) {
          header('location:' . $classroom->getHref());
          die;
      } else {
          return $this->_helper->redirector->gotoRoute(array('classroom_id' => $classroom->custom_url), 'eclassroom_dashboard', true);
      }
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('classroom_id');
        if($this->_getParam('is_Ajax_Delete',null) && $id) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
               $classroom = Engine_Api::_()->getItem('classroom', $id);
              //  delete the Classroom entry into the database
               Engine_Api::_()->courses()->deleteClassroom($classroom);
               $db->commit();
                  echo json_encode(array('status'=>1));die;
            }
            catch( Exception $e )
            {
                $db->rollBack();
                throw $e;
            }
             echo json_encode(array('status'=>0));die;
        }
        $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
        $form->setTitle('Delete Classroom?');
        $form->setDescription('Are you sure that you want to delete this Classroom? It will not be recoverable after being deleted.');
        $form->submit->setLabel('Delete');
        $this->view->classroom_id = $id;
        // Check post
        if($this->getRequest()->isPost())
        {
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try
          {
              $classroom = Engine_Api::_()->getItem('classroom', $id);
              // delete the Classroom entry into the database
            Engine_Api::_()->courses()->deleteClassroom($classroom);
              $db->commit();
          }
          catch( Exception $e )
          {
              $db->rollBack();
              throw $e;
          }
          return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'eclassroom_general', true),
                'messages' => array('Your Classroom has been  Deleted successfully')
          ));
        }
    }
    public function contactAction() {
        $ownerId[] = $this->_getParam('owner_id', $this->_getParam('classroom_owner_id', 0));
        $this->view->form = $form = new Courses_Form_ContactOwner();
        $form->classroom_owner_id->setValue($this->_getParam('owner_id', $this->_getParam('classroom_owner_id', 0)));
        // Not post/invalid
        if (!$this->getRequest()->isPost()) {
        return;
        }
        if (!$form->isValid($this->getRequest()->getPost())) {
        return;
        }
        // Process
        $db = Engine_Api::_()->getDbTable('messages', 'messages')->getAdapter();
        $db->beginTransaction();
        try {
            $viewer = Engine_Api::_()->user()->getViewer();
            $values = $form->getValues();
            $recipientsUsers = Engine_Api::_()->getItemMulti('user', $ownerId);
            $attachment = null;
            if ($values['classroom_owner_id'] != $viewer->getIdentity()) {
                // Create conversation
                $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
                        $viewer, $ownerId, $values['title'], $values['body'], $attachment
                );
            }
            // Send notifications
            foreach ($recipientsUsers as $user) {
                if ($user->getIdentity() == $viewer->getIdentity()) {
                continue;
                }
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification(
                        $user, $viewer, $conversation, 'message_new'
                );
            }
            // Increment messages counter
            Engine_Api::_()->getDbTable('statistics', 'core')->increment('messages.creations');
            // Commit
            $db->commit();
            echo json_encode(array('status' => 'true'));
            die;
        } catch (Exception $e) {
            $db->rollBack();
            $this->view->status = false;
            throw $e;
        }
    }
    public function claimAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        if( !$viewer || !$viewer->getIdentity() )
        if( !$this->_helper->requireUser()->isValid() ) return;
        if(!Engine_Api::_()->authorization()->getPermission($viewer, 'eclassroom', 'auth_claim'))
        return $this->_forward('requireauth', 'error', 'core');
        // Render
        $this->_helper->content->setEnabled();
    }
    public function claimRequestsAction() {

        $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'eclassroom')->claimCount();
        if(!$checkClaimRequest)
        return $this->_forward('notfound', 'error', 'core');
        // Render
        $this->_helper->content->setEnabled();
    }
    public function getClassroomsAction() {
        $sesdata = array();
        $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

        $classroomTable = Engine_Api::_()->getDbtable('classrooms', 'eclassroom');
        $classroomTableName = $classroomTable->info('name');

        $classroomClaimTable = Engine_Api::_()->getDbtable('claims', 'eclassroom');
        $classroomClaimTableName = $classroomClaimTable->info('name');
        $text = $this->_getParam('text', null);
        $selectClaimTable = $classroomClaimTable->select()
                                    ->from($classroomClaimTableName, 'classroom_id')
                                    ->where('user_id =?', $viewerId);
        $claimedClassrooms = $classroomClaimTable->fetchAll($selectClaimTable);

        $currentTime = date('Y-m-d H:i:s');
        $select = $classroomTable->select()
                    ->where('draft =?', 1)
                    ->where('owner_id !=?', $viewerId)
                    ->where($classroomTableName .'.title  LIKE ? ', '%' .$text. '%');
        if(count($claimedClassrooms) > 0)
        $select->where('classroom_id NOT IN(?)', $selectClaimTable);
        $select->order('classroom_id ASC')->limit('40');
        $classrooms = $classroomTable->fetchAll($select);
        foreach ($classrooms as $classroom) {
            $classroom_icon_photo = $this->view->itemPhoto($classroom, 'thumb.icon');
            $sesdata[] = array(
            'id' => $classroom->classroom_id,
            'label' => $classroom->title,
            'photo' => $classroom_icon_photo
            );
        }
        return $this->_helper->json($sesdata);
  }
  public function suggestClassroomAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      $data = null;
    } else {
      $data = array();
      $table = Engine_Api::_()->getItemTable('classroom');

      $select = $table->select()->where('search = ?', 1)->where('draft =?', 1);
      if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
        $select->where('`' . $table->info('name') . '`.`title` LIKE ?', '%' . $text . '%');
      }

      if (0 < ($limit = (int) $this->_getParam('limit', 10))) {
        $select->limit($limit);
      }
      foreach ($select->getTable()->fetchAll($select) as $classroom) {
        $data[] = array(
            'type' => 'classroom',
            'id' => $classroom->getIdentity(),
            'guid' => $classroom->getGuid(),
            'label' => $classroom->getTitle(),
            'photo' => $this->view->itemPhoto($classroom, 'thumb.icon'),
            'url' => $classroom->getHref(),
        );
      }
    }

    if ($this->_getParam('sendNow', true)) {
      return $this->_helper->json($data);
    } else {
      $this->_helper->viewRenderer->setNoRender(true);
      $data = Zend_Json::encode($data);
      $this->getResponse()->setBody($data);
    }
  }
  public function callButtonAction() {
    $classroom_guid = $this->_getParam('classroom_id', 0);
    if (!$classroom_guid)
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->eclassroom = $eclassroom = Engine_Api::_()->getItemByGuid($classroom_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($eclassroom, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->callAction = Engine_Api::_()->getDbTable('callactions', 'eclassroom')->getCallactions(array('classroom_id' => $eclassroom->getIdentity()));
  }
  public function manageAction() {
      if( !$this->_helper->requireUser()->isValid() ) return;
      // Render
      $this->_helper->content
          //->setNoRender()
          ->setEnabled();
      // Prepare data
      $viewer = Engine_Api::_()->user()->getViewer();
  }
  function reviewVotesAction() {
      if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
          echo json_encode(array('status' => 'false', 'error' => 'Login'));
          die;
      }
      $item_id = $this->_getParam('id');
      $type = $this->_getParam('type');
      if (intval($item_id) == 0 || ($type != 1 && $type != 2 && $type != 3)) {
          echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
          die;
      }
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $itemTable = Engine_Api::_()->getItemTable('eclassroom_review');
      $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'eclassroom');
      $tableMainVotes = $tableVotes->info('name');
      $review = Engine_Api::_()->getItem('eclassroom_review',$item_id);
      $select = $tableVotes->select()
          ->from($tableMainVotes)
          ->where('review_id = ?', $item_id)
          ->where('user_id = ?', $viewer_id)
          ->where('type =?', $type);
      $result = $tableVotes->fetchRow($select);
      if ($type == 1)
          $votesTitle = 'useful_count';
      else if ($type == 2)
          $votesTitle = 'funny_count';
      else
          $votesTitle = 'cool_count';

      if (count($result) > 0) {
          //delete
          $db = $result->getTable()->getAdapter();
          $db->beginTransaction();
          try {
              $result->delete();
              $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' - 1')), array('review_id = ?' => $item_id));
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }
          $selectReview = $itemTable->select()->where('review_id =?', $item_id);
          $review = $itemTable->fetchRow($selectReview);
          echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $review->{$votesTitle}));
          die;
      } else {
          //update
          $db = Engine_Api::_()->getDbTable('reviewvotes', 'eclassroom')->getAdapter();
          $db->beginTransaction();
          try {
              $votereview = $tableVotes->createRow();
              $votereview->user_id = $viewer_id;
              $votereview->review_id = $item_id;
              $votereview->type = $type;
              $votereview->save();
              $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' + 1')), array('review_id = ?' => $item_id));
              //Commit
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }
          //Send notification and activity feed work.
          $selectReview = $itemTable->select()->where('review_id =?', $item_id);
          $review = $itemTable->fetchRow($selectReview);
          echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $review->{$votesTitle}));
          die;
      }
  }
    function removeCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $page_guid = $this->_getParam('page', 0);
    $eclassroom = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$page_guid) {
      echo 0;
      die;
    }
    if (!$this->_helper->requireAuth()->setAuthParams($eclassroom, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');
    $canCall = Engine_Api::_()->getDbTable('callactions', 'eclassroom')->getCallactions(array('classroom_id' => $eclassroom->getIdentity()));
    $canCall->delete();
    echo 1;
    die;
  }
  function saveCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $classroom_guid = $this->_getParam('page', 0);
    $fieldValue = $this->_getParam('fieldValue', 0);
    $checkboxVal = $this->_getParam('checkboxVal', 0);
    if (!$classroom_guid) {
      echo 0;
      die;
    }
    $eclassroom = Engine_Api::_()->getItemByGuid($classroom_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($eclassroom, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $canCall = Engine_Api::_()->getDbTable('callactions', 'eclassroom')->getCallactions(array('classroom_id' => $eclassroom->getIdentity()));
    if ($canCall) {
      $canCall->type = $checkboxVal;
      $canCall->params = $fieldValue;
      $canCall->save();
      echo 1;
      die;
    } else {
      $table = Engine_Api::_()->getDbTable('callactions', 'eclassroom');
      $res = $table->createRow();
      $res->type = $checkboxVal;
      $res->params = $fieldValue;
      $res->classroom_id = $eclassroom->getIdentity();
      $res->creation_date = date('Y-m-d H:i:s');
      $res->user_id = $this->view->viewer()->getIdentity();
      $res->save();
      echo 1;
      die;
    }
  }
  public function likeAsClassroomAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $id);
    $classroom_id = $this->_getParam('classroom_id');
    $table = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('classroom_id !=?', $classroom->getIdentity())
            ->where('classroom_id NOT IN (SELECT classroom_id FROM engine4_eclassroom_likeclassrooms WHERE like_classroom_id = ' . $classroom->classroom_id . ")");
    $this->view->myStores = ($table->fetchAll($selelct));
    if ($classroom_id) {
      $table = Engine_Api::_()->getDbTable('likeclassrooms', 'eclassroom');
      $row = $table->createRow();
      $row->classroom_id = $classroom_id;
      $row->like_classroom_id = $classroom->classroom_id;
      $row->user_id = $viewer->getIdentity();
      $row->save();
      echo 1;
      die;
    }
  }
  public function showLoginPageAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->_helper->layout->setLayout('default-simple');
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully login.')
    ));
  }
  
  public function unlikeAsClassroomAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $id);
    $classroom_id = $this->_getParam('classroom_id');
    $table = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('classroom_id !=?', $classroom->getIdentity())
            ->where('classroom_id IN (SELECT classroom_id FROM engine4_eclassroom_likeclassrooms WHERE like_classroom_id = ' . $classroom->classroom_id . ")");
    $this->view->myStores = ($table->fetchAll($selelct));
    if ($classroom_id) {
      $table = Engine_Api::_()->getDbTable('likeclassrooms', 'eclassroom');
      $select = $table->select()->where('classroom_id =?', $classroom_id)->where('like_classroom_id =?', $classroom->getIdentity());
      $row = $table->fetchRow($select);
      if ($row)
        $row->delete();
      echo 1;
      die;
    }
  }
  public function likeItemAction() {
    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');
    if (!$item_id || !$item_type)
      return;
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $param['type'] = $this->view->item_type = $item_type;
    $param['id'] = $this->view->item_id = $item->getIdentity();
    $paginator = Engine_Api::_()->sesvideo()->likeItemCore($param);
    $this->view->item_id = $item_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);
  }
}
