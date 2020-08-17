<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_DashboardController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesgroup_group', null, 'view')->isValid())
      return;

    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('group_id', null);
    if (!isset($_POST['locationphoto_id'])) {
      $viewer = $this->view->viewer();
      $group_id = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupId($id);
      if ($group_id) {
        $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
        if ($group && (($group->is_approved || $viewer->level_id == 1 || $viewer->level_id == 2 || $viewer->getIdentity() == $group->owner_id) ))
          Engine_Api::_()->core()->setSubject($group);
        else
          return $this->_forward('requireauth', 'error', 'core');
      } else
        return $this->_forward('requireauth', 'error', 'core');
      if (!Engine_Api::_()->sesgroup()->groupRolePermission($group, Zend_Controller_Front::getInstance()->getRequest()->getActionName())) {
        return;
      }
      $levelId = Engine_Api::_()->getItem('user', $group->owner_id)->level_id;
    }
  }

  public function managegrouponoffappsAction() {

    $groupType = $this->_getParam('type', 'photos');
    $groupId = $this->_getParam('group_id', null);
    if (empty($groupId))
      return;

    $isCheck = Engine_Api::_()->getDbTable('managegroupapps', 'sesgroup')->isCheck(array('group_id' => $groupId, 'columnname' => $groupType));
    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
    if ($isCheck) {
      $dbGetInsert->update('engine4_sesgroup_managegroupapps', array($groupType => 0), array('group_id =?' => $groupId));
    } else {
      $dbGetInsert->update('engine4_sesgroup_managegroupapps', array($groupType => 1), array('group_id =?' => $groupId));
    }
    echo true;
    die;
  }

  public function editAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $previousTitle = $group->getTitle();

    //Group Category and profile fileds
    $this->view->defaultProfileId = $defaultProfileId = 1;
    if (isset($group->category_id) && $group->category_id != 0)
      $this->view->category_id = $group->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($group->subsubcat_id) && $group->subsubcat_id != 0)
      $this->view->subsubcat_id = $group->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($group->subcat_id) && $group->subcat_id != 0)
      $this->view->subcat_id = $group->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;
    //Group category and profile fields
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Edit(array('defaultProfileId' => $defaultProfileId));
    $this->view->category_id = $group->category_id;
    $this->view->subcat_id = $group->subcat_id;
    $this->view->subsubcat_id = $group->subsubcat_id;
    $tagStr = '';
    foreach ($group->tags()->getTagMaps() as $tagMap) {
      $tag = $tagMap->getTag();
      if (!isset($tag->text))
        continue;
      if ('' !== $tagStr)
        $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
        'tags' => $tagStr,
        'networks' => ltrim($group['networks'], ',')
    ));
    $oldUrl = $group->custom_url;
    $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
    if (!$this->getRequest()->isPost()) {
      // Populate auth
      $auth = Engine_Api::_()->authorization()->context;
      foreach ($roles as $role) {
        if (isset($form->auth_view->options[$role]) && $auth->isAllowed($group, $role, 'view'))
          $form->auth_view->setValue($role);
        if (isset($form->auth_comment->options[$role]) && $auth->isAllowed($group, $role, 'comment'))
          $form->auth_comment->setValue($role);

        if (isset($form->auth_album->options[$role]) && $auth->isAllowed($group, $role, 'album'))
          $form->auth_album->setValue($role);

        if (isset($form->auth_video->options[$role]) && $auth->isAllowed($group, $role, 'video'))
          $form->auth_video->setValue($role);
        
        if (isset($form->auth_forum->options[$role]) && $auth->isAllowed($group, $role, 'forum'))
          $form->auth_forum->setValue($role);
      }
      $form->populate($group->toArray());
      if ($form->draft->getValue() == 1)
        $form->removeElement('draft');
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->sesbasic()->checkBannedWord($_POST['custom_url'],$group->custom_url);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url not available.Please select other."));
        return;
      }
    }
    $values = $form->getValues();
    
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
      $values['approval'] = $settings->getSetting('sesgroup.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sesgroup.default.approvaloption', 1) ? 0 : 1;
    // Process
    $db = Engine_Api::_()->getItemTable('sesgroup_group')->getAdapter();
    $db->beginTransaction();
    try {
      if (!($values['draft']))
        unset($values['draft']);
      $group->setFromArray($values);
      $group->save();
      $tags = preg_split('/[,]+/', $values['tags']);
      $group->tags()->setTagMaps($viewer, $tags);
      if (!$values['vote_type'])
        $values['resulttime'] = '';

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $group->custom_url = $_POST['custom_url'];

      $group->save();

      $newgroupTitle = $group->getTitle();

      // Add photo
      if (!empty($values['photo'])) {
        $group->setPhoto($form->photo);
      }
      // Add cover photo
      if (!empty($values['cover'])) {
        $group->setCover($form->cover);
      }
      // Set auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      if (empty($values['auth_view']))
        $values['auth_view'] = 'everyone';
      $group->view_privacy = $values['auth_view'];
      if (empty($values['auth_comment']))
        $values['auth_comment'] = 'everyone';
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      $albumMax = array_search(@$values['auth_album'], $roles);
      $videoMax = array_search(@$values['auth_video'], $roles);
      $forumMax = array_search(@$values['auth_forum'], $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($group, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($group, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($group, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($group, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($group, $role, 'forum', ($i <= $forumMax));
      }
      $group->save();
      
      if(isset($_POST['custom_url']) && $_POST['custom_url'] != $oldUrl) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->update('engine4_sesbasic_bannedwords', array("word" => $_POST['custom_url']),array("word = ?" => $oldUrl,"resource_type = ?" => 'sesgroup_group',"resource_id = ?" => $group->group_id));
      }
      
      $db->commit();
      //Start Activity Feed Work
      if (isset($values['draft']) && $group->draft == 1 && $group->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        //$action = $activityApi->addActivity($viewer, $group, 'sesgroup_create');
        // if ($action) {
        // $activityApi->attachActivity($action, $group);
        //}
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','sesgroup')->getCategoryFollowers($group->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','sesgroup')->getColumnName(array('category_id' => $group->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $group, 'sesgroup_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesgroup_follow_category', array('sender_title' => $group->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work

      if ($previousTitle != $newgroupTitle) {
        //Send to all joined members
        $joinedMembers = Engine_Api::_()->sesgroup()->getallJoinedMembers($group);
        foreach ($joinedMembers as $joinedMember) {
          if ($joinedMember->user_id == $group->owner_id)
            continue;
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $group, 'sesgroup_groupjoinednamechange', array('old_group_title' => $previousTitle, 'new_group_link' => $newgroupTitle));
        }

        //Send to all followed members
        $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getFollowers($group->getIdentity());
        foreach ($followerMembers as $followerMember) {
          if ($followerMember->owner_id == $group->owner_id)
            continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $group, 'sesgroup_gpfollowednamechange', array('old_group_title' => $previousTitle, 'new_group_link' => $newgroupTitle));

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesgroup_group_groupnamechanged', array('group_title' => $group->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        //Send to all favourites members
        $followerMembers = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->getAllFavMembers($group->getIdentity());
        foreach ($followerMembers as $followerMember) {
          if ($followerMember->owner_id == $group->owner_id)
            continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $group, 'sesgroup_gpfavouritednamechange', array('old_group_title' => $previousTitle, 'new_group_link' => $newgroupTitle));
        }
      }
    } catch (Engine_Image_Exception $e) {
      $db->rollBack();
      $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $db->beginTransaction();
    try {
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    // Redirect
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'edit', 'group_id' => $group->custom_url));
  }

  public function profileFieldAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    //Group Category and profile fileds
    $this->view->defaultProfileId = $defaultProfileId = 1;
    if (isset($group->category_id) && $group->category_id != 0)
      $this->view->category_id = $group->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($group->subsubcat_id) && $group->subsubcat_id != 0)
      $this->view->subsubcat_id = $group->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($group->subcat_id) && $group->subcat_id != 0)
      $this->view->subcat_id = $group->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    //Group category and profile fields
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Profilefield(array('defaultProfileId' => $defaultProfileId));
    $this->view->category_id = $group->category_id;
    $this->view->subcat_id = $group->subcat_id;
    $this->view->subsubcat_id = $group->subsubcat_id;
    $form->populate($group->toArray());

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    // Process
    $db = Engine_Api::_()->getItemTable('sesgroup_group')->getAdapter();
    $db->beginTransaction();
    try {
      //Add fields
      $customfieldform = $form->getSubForm('fields');
      if ($customfieldform) {
        $customfieldform->setItem($group);
        $customfieldform->saveValues();
      }
      $group->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $db->beginTransaction();
    try {
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    // Redirect
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'profile-field', 'group_id' => $group->custom_url));
  }

  public function changeOwnerAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->view->viewer(), 'auth_changeowner'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->sesgroup()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $this->view->viewer()->getIdentity(), 'group_id' => $group->group_id));
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sesgroup_general', true);
  }

  public function searchMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $userTable = Engine_Api::_()->getItemTable('user');
    $selectUserTable = $userTable->select()->where('displayname LIKE "%' . $this->_getParam('text', '') . '%"')->where('user_id !=?', $this->view->viewer()->getIdentity());
    $users = $userTable->fetchAll($selectUserTable);
    foreach ($users as $user) {
      $user_icon = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'user_id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function manageGroupappsAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->group = $group = Engine_Api::_()->core()->getSubject();

    $getManagegroupId = Engine_Api::_()->getDbTable('managegroupapps', 'sesgroup')->getManagegroupId(array('group_id' => $group->group_id));

    $this->view->managegroupapps = Engine_Api::_()->getItem('sesgroup_managegroupapp', $getManagegroupId);

    $viewer = Engine_Api::_()->user()->getViewer();
  }

  public function manageServiceAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->group = $group = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableService = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'group_service');
    if (empty($enableService)) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    
    $sesgroup_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.service', 1);
    if(empty($sesgroup_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'sesgroup')->getServiceMemers(array('group_id' => $group->group_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function addserviceAction() {

    $sesgroup_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.service', 1);
    if(empty($sesgroup_allow_service))
      return $this->_forward('requireauth', 'error', 'core');
  
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->group_id = $group_id = $this->_getParam('group_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);

    if (!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Sesgroup_Form_Service_Add();
      $form->setTitle('Add New Service');
      $form->setDescription("Here, you can enter your service details.");
    }

    if ($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('services', 'sesgroup');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {

        $values = $_POST;
        $values['group_id'] = $group_id;
        $values['owner_id'] = $viewer_id;
        if (empty($values['photo_id'])) {
          $values['photo_id'] = 0;
        }
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();

        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
              'parent_id' => $row->service_id,
              'parent_type' => 'sesgroup_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $row->photo_id = $filename->file_id;
          $row->save();
        }

        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('services', 'sesgroup')->getServiceMemers(array('group_id' => $group->group_id));
        $showData = $this->view->partial('_services.tpl', 'sesgroup', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'group_id' => $group->group_id, 'is_ajax' => true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
        exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }

  public function editserviceAction() {

    $sesgroup_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.service', 1);
    if(empty($sesgroup_allow_service))
      return $this->_forward('requireauth', 'error', 'core');
  
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->group_id = $group_id = $this->_getParam('group_id', null);

    $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);

    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $this->view->service = $service = Engine_Api::_()->getItem('sesgroup_service', $service_id);

    if (!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesgroup_Form_Service_Edit();
      // Populate form
      $form->populate($service->toArray());
    }

    if ($is_ajax) {
      if (empty($_POST['photo_id']))
        unset($_POST['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $service->setFromArray($_POST);
        $service->save();

        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $previousPhoto = $service->photo_id;
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
              'parent_id' => $service->service_id,
              'parent_type' => 'sesgroup_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          if ($previousPhoto) {
            $catIcon = Engine_Api::_()->getItem('storage_file', $previousPhoto);
            $catIcon->delete();
          }
          $service->photo_id = $filename->file_id;
          $service->save();
        }

        if (isset($_POST['remove_profilecover']) && !empty($_POST['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $service->photo_id);
          $service->photo_id = 0;
          $service->save();
          if ($storage)
            $storage->delete();
        }

        $db->commit();

        $paginator = Engine_Api::_()->getDbTable('services', 'sesgroup')->getServiceMemers(array('group_id' => $group->group_id));
        $showData = $this->view->partial('_services.tpl', 'sesgroup', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'group_id' => $group->group_id, 'is_ajax' => true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
        exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }

  public function deleteserviceAction() {

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->group_id = $group_id = $this->_getParam('group_id', null);
    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $item = Engine_Api::_()->getItem('sesgroup_service', $service_id);
    if (!$is_ajax) {
      $this->view->form = $form = new Sesgroup_Form_Service_Delete();
    }
    if ($is_ajax) {
      $db = $item->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }

  public function manageTeamAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->group = $group = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableTeam = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'group_team');
    if (empty($enableTeam)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Designations
    $this->view->designations = Engine_Api::_()->getDbTable('designations', 'sesgroupteam')->getAllDesignations(array('group_id' => $group->group_id));

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('teams', 'sesgroupteam')->getTeamMemers(array('group_id' => $group->group_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageLocationAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.location', 1) || !Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'allow_mlocation'))
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'sesgroup')
            ->getGroupLocationPaginator(array('group_id' => $group->group_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $value = array();
    $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
    if (!$is_search_ajax) {
      $this->view->searchForm = $searchForm = new Sesgroup_Form_Dashboard_ManageMembers();
    }
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $value['name'] = isset($searchArray['name']) ? $searchArray['name'] : '';
    $value['email'] = isset($searchArray['email']) ? $searchArray['email'] : '';
    $value['status'] = isset($searchArray['status']) ? $searchArray['status'] : '';

    $table = Engine_Api::_()->getDbTable('users', 'user');
    $subtable = Engine_Api::_()->getDbTable('membership', 'sesgroup');
    $tableName = $table->info('name');
    $subtableName = $subtable->info('name');
    $select = $table->select()
            ->from($tableName, array('user_id', 'displayname', 'email', 'photo_id'))
            ->setIntegrityCheck(false)
            ->joinRight($subtableName, '`' . $subtableName . '`.`user_id` = `' . $tableName . '`.`user_id`', array('resource_approved', 'user_approved', 'active'))
            ->where('`' . $subtableName . '`.`resource_id` = ?', $group->getIdentity());
    if (isset($value['name']) && $value['name'])
      $select->where($tableName . '.displayname LIKE ?', '%' . $value['name'] . '%');
    if (isset($value['email']) && $value['email'])
      $select->where($tableName . '.email LIKE ?', '%' . $value['email'] . '%');
    if (isset($value['status']) && $value['status'])
      $select->where($subtableName . '.active =?', $value['status']);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($page);
  }

  public function announcementAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->view->viewer(), 'auth_announce'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'sesgroup')
            ->getGroupAnnouncementPaginator(array('group_id' => $group->group_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function postAnnouncementAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'sesgroup');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'group_id' => $group->group_id), $form->getValues()));
      $announcement->save();
      $db->commit();

      $getAllGroupMembers = Engine_Api::_()->sesgroup()->getAllGroupMembers($group);
      foreach ($getAllGroupMembers as $user) {
        $user = Engine_Api::_()->getItem('user', $user);
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, Engine_Api::_()->user()->getViewer(), $group, 'sesgroup_group_newannouncement');

        //mail
        //Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesgroup_grouproll_creategroup', array('group_title' => $group->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }

      // Redirect
      $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'announcement', 'group_id' => $group->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editAnnouncementAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sesgroup_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'announcement', 'group_id' => $group->custom_url));
  }

  public function deleteAnnouncementAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sesgroup_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->delete();
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'announcement', 'group_id' => $group->custom_url));
  }

  public function addLocationAction() {
    $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Addlocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_sesgroup_locations', array('is_default' => 0), array('group_id =?' => $group->group_id));
      }
      $dbGetInsert->query('INSERT INTO engine4_sesgroup_locations (group_id,title,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $group->group_id . '","' . $_POST['title'] . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '","' . $_POST['is_default'] . '") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $group->group_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "sesgroup_group")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $group->location = $_POST['location'];
        $group->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function designAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Viewdesign();
    $form->groupstyle->setValue($group->groupstyle);
    if (!$this->getRequest()->isPost() || ($is_ajax_content))
      return;
    $group->groupstyle = $_POST['groupstyle'];
    $group->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'design', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function editLocationAction() {
    $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Editlocation();
    $location = Engine_Api::_()->getItem('sesgroup_location', $this->_getParam('location_id'));
    $form->title->setValue($location->title);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_sesgroup_locations', array('is_default' => 0), array('group_id =?' => $group->group_id));
      }
      $location->lat = $_POST['lat'];
      $location->title = $_POST['title'];
      $location->lng = $_POST['lng'];
      $location->city = $_POST['city'];
      $location->state = $_POST['state'];
      $location->country = $_POST['country'];
      $location->address = $_POST['address'];
      $location->address2 = $_POST['address2'];
      $location->venue = $_POST['venue'];
      $location->location = $_POST['location'];
      $location->is_default = isset($_POST['is_default']) ? $_POST['is_default'] : 0;
      $location->zip = $_POST['zip'];
      $location->save();
      if ($location->is_default || (isset($_POST['is_default']) && !empty($_POST['is_default']))) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $group->group_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "sesgroup_group")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $group->location = $_POST['location'];
        $group->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function deleteLocationAction() {
    $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Deletelocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $location = Engine_Api::_()->getItem('sesgroup_location', $this->_getParam('location_id'));
    $location->delete();

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function addPhotosAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->location = $location = Engine_Api::_()->getItem('sesgroup_location', $this->_getParam('location_id'));
  }

  public function composeUploadAction() {
    if (!Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->_redirect('login');
      return;
    }
    $location = Engine_Api::_()->getItem('sesgroup_location', $this->_getParam('location_id'));
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid method');
      return;
    }
    if (empty($_FILES['Filedata'])) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    // Get album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('sesgroup_locationphoto');
    $db = $photoTable->getAdapter();
    $db->beginTransaction();
    try {
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => Engine_Api::_()->user()->getViewer()->getIdentity()
      ));
      $photo->save();
      $photo->setPhoto($_FILES['Filedata']);
      $photo->group_id = $location->group_id;
      $photo->location_id = $location->location_id;
      $photo->save();
      $db->commit();
      $this->view->status = true;
      $this->view->locationphoto_id = $photo->locationphoto_id;
      $this->view->src = $this->view->url = $photo->getPhotoUrl('thumb.normalmain');
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected photos have been successfully saved.');
      echo json_encode(array('src' => $this->view->src, 'location_id' => $location->location_id, 'locationphoto_id' => $this->view->locationphoto_id, 'status' => $this->view->status));
      die;
    } catch (Exception $e) {
      throw $e;
      $db->rollBack();
      //throw $e;
      $this->view->status = false;
    }
  }

  //ACTION FOR PHOTO DELETE
  public function removeAction() {
    if (empty($_POST['locationphoto_id']))
      die('error');
    //GET PHOTO ID AND ITEM
    $photo_id = (int) $this->_getParam('locationphoto_id');
    $photo = Engine_Api::_()->getItem('sesgroup_locationphoto', $photo_id);
    $db = Engine_Api::_()->getItemTable('sesgroup_locationphoto')->getAdapter();
    $db->beginTransaction();
    try {
      $photo->delete();
      $db->commit();
      echo true;
      die;
    } catch (Exception $e) {
      $db->rollBack();
    }
    echo false;
    die;
  }

  public function removeMainphotoAction() {
    //GET Group ID AND ITEM
    $group = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      $group->photo_id = '';
      $group->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function insightsAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'auth_insightrpt'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->view_type = $interval = isset($_POST['type']) ? $_POST['type'] : 'monthly';
    $dateArray = $this->createDateRangeArray($group->creation_date, $group->creation_date, $interval);

    $likeTable = Engine_Api::_()->getDbTable('likes', 'sesbasic');
    $likeSelect = $likeTable->select()->from($likeTable->info('name'), array(new Zend_Db_Expr('"like" AS type'), 'COUNT(like_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
             ->where('resource_type =?', 'sesgroup_group')
             ->where('resource_id =?', $group->group_id);
    if ($interval == 'monthly')
      $likeSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $likeSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $likeSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $likeSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $likeSelect->group("HOUR(creation_date)");
    }

    $commentTable = Engine_Api::_()->getDbTable('comments', 'core');
    $commentSelect = $commentTable->select()->from($commentTable->info('name'), array(new Zend_Db_Expr('"comment" AS type'), 'COUNT(comment_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'sesgroup_group')
            ->where('resource_id =?', $group->group_id);
    if ($interval == 'monthly')
      $commentSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $commentSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $commentSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $commentSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $commentSelect->group("HOUR(creation_date)");
    }

    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'sesgroup');
    $favouritesSelect = $favouriteTable->select()->from($favouriteTable->info('name'), array(new Zend_Db_Expr('"favourite" AS type'), 'COUNT(favourite_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'sesgroup_group')
            ->where('resource_id =?', $group->group_id);
    if ($interval == 'monthly')
      $favouritesSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $favouritesSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $favouritesSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $favouritesSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $favouritesSelect->group("HOUR(creation_date)");
    }

    $viewTable = Engine_Api::_()->getDbTable('recentlyviewitems', 'sesgroup');
    $viewSelect = $viewTable->select()->from($viewTable->info('name'), array(new Zend_Db_Expr('"view" AS type'), 'COUNT(recentlyviewed_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'sesgroup_group')
            ->where('resource_id =?', $group->group_id);
    if ($interval == 'monthly')
      $viewSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $viewSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $viewSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $viewSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $viewSelect->group("HOUR(creation_date)");
    }
    $dataSelect = $viewSelect . ' ' . UNION . ' ' . $favouritesSelect . ' ' . UNION . ' ' . $commentSelect . ' ' . UNION . ' ' . $likeSelect;
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $results = $db->query($dataSelect)->fetchAll();

    $var1 = $var2 = $var3 = $var4 = $var5 = $var6 = array();
    $array1 = $array2 = $array3 = $array4 = $array5 = array();
    if ($interval == 'monthly') {
      $this->view->likeHeadingTitle = $this->view->translate("Monthly Like Report For ") . $group->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Monthly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Monthly Comment Report For ") . $group->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Monthly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Monthly Favourite Report For ") . $group->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Monthly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Monthly Views Report For ") . $group->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Monthly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        if (!$is_ajax)
          $var2[] = '"' . date("d", strtotime($date)) . '-' . date("M", strtotime($date)) . '"';
        else
          $var2[] = date("d", strtotime($date)) . '-' . date("M", strtotime($date));
        if (isset($array1[date('Y-m', strtotime($date))])) {
          $var1[] = $array1[date('Y-m', strtotime($date))];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[date('Y-m', strtotime($date))])) {
          $var3[] = $array2[date('Y-m', strtotime($date))];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[date('Y-m', strtotime($date))])) {
          $var4[] = $array3[date('Y-m', strtotime($date))];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[date('Y-m', strtotime($date))])) {
          $var5[] = $array4[date('Y-m', strtotime($date))];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[date('Y-m', strtotime($date))])) {
          $var6[] = $array5[date('Y-m', strtotime($date))];
        } else {
          $var6[] = 0;
        }
      }
    } elseif ($interval == 'weekly') {
      $this->view->likeHeadingTitle = $this->view->translate("Weekly Like Report For ") . $group->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Weekly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Weekly Comment Report For ") . $group->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Weekly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Weekly Favourite Report For ") . $group->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Weekly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Weekly Views Report For ") . $group->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Weekly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
      }
      $previousYear = '';
      foreach ($dateArray as $date) {
        $year = date('Y', strtotime($date));
        if ($previousYear != $year)
          $yearString = '-' . $year;
        else
          $yearString = '';
        if (!$is_ajax)
          $var2[] = '"' . (date("d-M", strtotime($date))) . $yearString . '"';
        else
          $var2[] = (date("d-M", strtotime($date))) . $yearString;
        if (isset($array1[date('Y-m-d', strtotime($date))])) {
          $var1[] = $array1[date('Y-m-d', strtotime($date))];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[date('Y-m-d', strtotime($date))])) {
          $var3[] = $array2[date('Y-m-d', strtotime($date))];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[date('Y-m-d', strtotime($date))])) {
          $var4[] = $array3[date('Y-m-d', strtotime($date))];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[date('Y-m-d', strtotime($date))])) {
          $var5[] = $array4[date('Y-m-d', strtotime($date))];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[date('Y-m-d', strtotime($date))])) {
          $var6[] = $array5[date('Y-m-d', strtotime($date))];
        } else {
          $var6[] = 0;
        }
        $previousYear = $year;
      }
    } elseif ($interval == 'daily') {
      $this->view->likeHeadingTitle = $this->view->translate("Daily Like Report for ") . $group->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Daily Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Daily Comment Report for ") . $group->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Daily Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Daily Favourite Report for ") . $group->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Daily Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Daily Views Report for ") . $group->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Daily Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        if (!$is_ajax)
          $var2[] = '"' . date("d", strtotime($date)) . '-' . date("M", strtotime($date)) . '"';
        else
          $var2[] = date("d", strtotime($date)) . '-' . date("M", strtotime($date));
        if (isset($array1[$date])) {
          $var1[] = $array1[$date];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[$date])) {
          $var3[] = $array2[$date];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[$date])) {
          $var4[] = $array3[$date];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[$date])) {
          $var5[] = $array4[$date];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[$date])) {
          $var6[] = $array5[$date];
        } else {
          $var6[] = 0;
        }
      }
    } elseif ($interval == 'hourly') {
      $this->view->likeHeadingTitle = $this->view->translate("Hourly Like Report For ") . $group->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Hourly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Hourly Comment Report For ") . $group->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Hourly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Hourly Favourite Report For ") . $group->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Hourly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Hourly Views Report For ") . $group->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Hourly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        $time = date("h A", strtotime($date . ':00:00'));
        if (!$is_ajax)
          $var2[] = '"' . $time . '"';
        else
          $var2[] = $time;
        if (isset($array1[$date])) {
          $var1[] = $array1[$date];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[$date])) {
          $var3[] = $array2[$date];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[$date])) {
          $var4[] = $array3[$date];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[$date])) {
          $var5[] = $array4[$date];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[$date])) {
          $var6[] = $array5[$date];
        } else {
          $var6[] = 0;
        }
      }
    }
    if ($is_ajax) {
      echo json_encode(array('date' => $var2, 'voteCount' => $var1, 'likeCount' => $var3, 'commentCount' => $var4, 'favouriteCount' => $var5, 'viewCount' => $var6, 'headingTitle' => $this->view->headingTitle, 'XAxisTitle' => $this->view->XAxisTitle, 'likeHeadingTitle' => $this->view->likeHeadingTitle, 'likeXAxisTitle' => $this->view->likeXAxisTitle, 'commentHeadingTitle' => $this->view->commentHeadingTitle, 'commentXAxisTitle' => $this->view->commentXAxisTitle, 'favouriteHeadingTitle' => $this->view->favouriteHeadingTitle, 'favouriteXAxisTitle' => $this->view->favouriteXAxisTitle, 'viewHeadingTitle' => $this->view->viewHeadingTitle, 'viewXAxisTitle' => $this->view->viewXAxisTitle));
      die;
    } else {
      $this->view->date = $var2;
      $this->view->voteCount = $var1;
      $this->view->like_count = $var3;
      $this->view->comment_count = $var4;
      $this->view->favourite_count = $var5;
      $this->view->view_count = $var6;
    }
  }

  // create date range from 2 given dates.
  public function createDateRangeArray($strDateFrom = '', $strDateTo = '', $interval) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates. 
    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
      if ($interval == 'monthly') {
        array_push($aryRange, date('Y-m', $iDateFrom));
        $iDateFrom = strtotime('+1 Months', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m', $iDateFrom));
          $iDateFrom += strtotime('+1 Months', $iDateFrom);
        }
      } elseif ($interval == 'weekly') {
        array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
        $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
          $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        }
      } elseif ($interval == 'daily') {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
          $iDateFrom += 86400; // add 24 hours
          array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
      } elseif ($interval == 'hourly') {
        $iDateFrom = strtotime(date('Y-m-d 00:00:00'));
        $iDateTo = strtotime('+1 Day', $iDateFrom);

        array_push($aryRange, date('Y-m-d H', $iDateFrom));
        $iDateFrom = strtotime('+1 Hours', ($iDateFrom));

        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d H', $iDateFrom));
          $iDateFrom = strtotime('+1 Hours', ($iDateFrom));
        }
      }
    }
    $preserve = $aryRange;
    return $preserve;
  }

  public function reportsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Searchreport();
    $value = array();
    if (isset($_GET['startdate']))
      $value['startdate'] = $value['start'] = date('Y-m-d', strtotime($_GET['startdate']));
    if (isset($_GET['enddate']))
      $value['enddate'] = $value['end'] = date('Y-m-d', strtotime($_GET['enddate']));
    if (isset($_GET['type']))
      $value['type'] = $_GET['type'];
    if (!count($value)) {
      $value['enddate'] = date('Y-m-d', strtotime(date('Y-m-d')));
      $value['startdate'] = date('Y-m-d', strtotime('-30 days'));
      $value['type'] = $form->type->getValue();
    }
    if (isset($_GET['excel']) && $_GET['excel'] != '')
      $value['download'] = 'excel';
    if (isset($_GET['csv']) && $_GET['csv'] != '')
      $value['download'] = 'csv';

    $form->populate($value);
    $value['group_id'] = $group->getIdentity();
    $this->view->groupReportData = $data = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getReportData($value);

    if (isset($value['download'])) {
      $name = str_replace(' ', '_', $group->getTitle()) . '_' . time();
      switch ($value["download"]) {
        case "excel" :
          // Submission from
          $filename = $name . ".xls";
          header("Content-Type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          $this->exportFile($data);
          exit();
        case "csv" :
          // Submission from
          $filename = $name . ".csv";
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-type: text/csv");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          header("Expires: 0");
          $this->exportCSVFile($data);
          exit();
        default :
          //silence
          break;
      }
    }
  }

  protected function exportCSVFile($records) {
    // create a file pointer connected to the output stream
    $fh = fopen('php://output', 'w');
    $heading = false;
    $counter = 1;
    if (!empty($records))
      foreach ($records as $row) {
        $valueVal['S.No'] = $counter;
        $valueVal['Group Name'] = $row['title'];
        $valueVal['Likes'] = $row['like_count'];
        $valueVal['Comments'] = $row['comment_count'];
        $valueVal['Favourites'] = $row['favourite_count'];
        $valueVal['Followers'] = $row['follow_count'];
        $valueVal['Views'] = $row['view_count'];
        $valueVal['Date'] = date('M d, Y h:i A', strtotime($row['creation_date']));
        $counter++;
        if (!$heading) {
          // output the column headings
          fputcsv($fh, array_keys($valueVal));
          $heading = true;
        }
        // loop over the rows, outputting them
        fputcsv($fh, array_values($valueVal));
      }
    fclose($fh);
  }

  protected function exportFile($records) {
    $heading = false;
    $counter = 1;
    if (!empty($records))
      foreach ($records as $row) {
        $valueVal['S.No'] = $counter;
        $valueVal['Group Name'] = $row['title'];
        $valueVal['Likes'] = $row['like_count'];
         $valueVal['Comments'] = $row['comment_count'];
        $valueVal['Favourites'] = $row['favourite_count'];
        $valueVal['Followers'] = $row['follow_count'];
        $valueVal['Views'] = $row['view_count'];
        $valueVal['Date'] = date('M d, Y h:i A', strtotime($row['creation_date']));
        $counter++;
        if (!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($valueVal)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($valueVal)) . "\n";
      }
    exit;
  }

  public function backgroundphotoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Backgroundphoto();
    $form->populate($group->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      $group->setBackgroundPhoto($_FILES['background'], 'background');
      $group->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function removeBackgroundphotoAction() {
    $group = Engine_Api::_()->core()->getSubject();
    $group->background_photo_id = 0;
    $group->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
  }

  public function mainphotoAction() {

    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->view->viewer(), 'upload_mainphoto'))
      return $this->_forward('requireauth', 'error', 'core');

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Mainphoto();

    if (empty($group->photo_id)) {
      $form->removeElement('remove');
    }

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Uploading a new photo
    if ($form->Filedata->getValue() !== null) {
      $db = $group->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $fileElement = $form->Filedata;
        //$photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false, false, 'sesgroup', 'sesgroup_group', '', $group, true);
        $group->setPhoto($fileElement, '', 'profile');
//         $group->photo_id = $photo_id;
//         $group->save();
        $db->commit();
      }
      // If an exception occurred within the image adapter, it's probably an invalid image
      catch (Engine_Image_Adapter_Exception $e) {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      }

      // Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function removePhotoAction() {
    //Get form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_RemovePhoto();

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $group = Engine_Api::_()->core()->getSubject();
    $group->photo_id = 0;
    $group->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }

  public function overviewAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Overview();
    $form->populate($group->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      $group->setFromArray($_POST);
      $group->save();
      $db->commit();
      //Activity Feed Work
//      $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
//      $action = $activityApi->addActivity($viewer, $group, 'sesgroup_group_editgroupoverview');
//      if ($action) {
//        $activityApi->attachActivity($action, $group);
//      }
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Seo();

    $form->populate($group->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      $group->setFromArray($_POST);
      $group->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get style detail
  public function openHoursAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    if ($this->getRequest()->isPost()) {
      $openHours = Engine_Api::_()->getDbTable('openhours', 'sesgroup')->getGroupHours(array('group_id' => $group->getIdentity()));
      $data = array();
      $dayOption = $_POST['hours'];
      $data['type'] = $dayOption;
      if ($dayOption == "selected") {
        for ($i = 1; $i < 8; $i++) {
          if (!empty($_POST['checkbox' . $i]) && !empty($_POST[$i])) {
            foreach ($_POST[$i] as $key => $value) {
              $startTime = $value['starttime'];
              $endTime = $value['endtime'];
              if ($startTime && $endTime) {
                $data[$i][$key]['starttime'] = $startTime;
                $data[$i][$key]['endtime'] = $endTime;
              }
            }
          }
        }
      }
      $openHoursTable = Engine_Api::_()->getDbTable('openhours', 'sesgroup');
      $db = $openHoursTable->getAdapter();
      $db->beginTransaction();
      try {
        if ($_POST['hours'] == "closed") {
          $group->status = 0;
          $group->save();
        } else {
          $group->status = 1;
          $group->save();
        }
        if (!$openHours)
          $openHours = $openHoursTable->createRow();
        $values['params'] = json_encode($data);
        $values['group_id'] = $group->getIdentity();
        $values['timezone'] = $_POST['timezone'];
        $openHours->setFromArray($values);
        $openHours->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
    $this->view->hoursData = "";
    //fetch data
    $hoursData = Engine_Api::_()->getDbTable('openhours', 'sesgroup')->getGroupHours(array('group_id' => $group->getIdentity()));
    if ($hoursData) {
      $this->view->hoursData = json_decode($hoursData->params, true);
      $this->view->timezone = $hoursData->timezone;
    }
  }

  //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get current row
    $table = Engine_Api::_()->getDbTable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'sesgroup_group')
            ->where('id = ?', $group->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Style();
    // Check post
    if (!$this->getRequest()->isPost()) {
      $form->populate(array(
          'style' => ( null === $row ? '' : $row->style )
      ));
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Cool! Process
    $style = $form->getValue('style');
    // Save
    if (null == $row) {
      $row = $table->createRow();
      $row->type = 'sesgroup_group';
      $row->id = $group->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

  public function advertiseGroupAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
  }

  // Send Update who like, follow and join group
  public function sendUpdatesAction() {

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_id');
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type');

    if (!$id || !$type)
      return;

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_SendUpdates();

    // Try attachment getting stuff
    $attachment = Engine_Api::_()->getItem($type, $id);

    // Check method/data
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $values = $form->getValues();

    $likeMemberIds = $followMemberIds = array();
    if (in_array('liked', $values['type'])) {
      $likeMembers = Engine_Api::_()->sesgroup()->getMemberByLike($attachment->getIdentity());
      foreach ($likeMembers as $likeMember) {
        $likeMemberIds[] = $likeMember['poster_id'];
      }
    }
    if (in_array('followed', $values['type'])) {

      $followMembers = Engine_Api::_()->sesgroup()->getMemberFollow($attachment->getIdentity());
      foreach ($followMembers as $followMember) {
        $followMemberIds[] = $followMember['owner_id'];
      }
    }

    if (in_array('joined', $values['type'])) {
      
    }

    $recipientsUsers = array_unique(array_merge($likeMemberIds, $followMemberIds));

    // Process
    $db = Engine_Api::_()->getDbTable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {

      $viewer = Engine_Api::_()->user()->getViewer();
      // Create conversation
      foreach ($recipientsUsers as $user) {
        $user = Engine_Api::_()->getItem('user', $user);
        if ($user->getIdentity() == $viewer->getIdentity()) {
          continue;
        }
        $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send($viewer, $user, $values['title'], $values['body'], $attachment);
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $conversation, 'message_new');
        Engine_Api::_()->getDbTable('statistics', 'core')->increment('messages.creations');
      }
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if ($this->getRequest()->getParam('format') == 'smoothbox') {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your update message has been sent successfully.')),
                  'smoothboxClose' => true,
      ));
    }
  }

  //get group contact information
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Contactinformation();

    $form->populate($group->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    if (!empty($_POST["group_contact_email"]) && !filter_var($_POST["group_contact_email"], FILTER_VALIDATE_EMAIL)) {
      $form->addError($this->view->translate("Invalid email format."));
      return;
    }
    if (!empty($_POST["group_contact_website"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_website"])) {
      $form->addError($this->view->translate("Invalid WebSite URL."));
      return;
    }
    if (!empty($_POST["group_contact_facebook"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_facebook"])) {
      $form->addError($this->view->translate("Invalid Facebook URL."));
      return;
    }
    if (!empty($_POST["group_contact_linkedin"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_linkedin"])) {
      $form->addError($this->view->translate("Invalid Linkedin URL."));
      return;
    }
    if (!empty($_POST["group_contact_twitter"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_twitter"])) {
      $form->addError($this->view->translate("Invalid Twitter URL."));
      return;
    }
    if (!empty($_POST["group_contact_instagram"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_instagram"])) {
      $form->addError($this->view->translate("Invalid Instagram URL."));
      return;
    }
    if (!empty($_POST["group_contact_pinterest"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["group_contact_pinterest"])) {
      $form->addError($this->view->translate("Invalid Pinterest URL."));
      return;
    }
    $db = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getAdapter();
    $db->beginTransaction();
    try {
      $group->setFromArray($form->getValues());
      $group->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
      die;
    }
  }

  public function linkedGroupAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('linkgroups', 'sesgroup')
        ->getLinkGroupsPaginator(array('group_id' => $group->group_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    if (!$this->getRequest()->isPost())
      return;
    $linkGroup = Engine_Api::_()->getItem('sesgroup_group', $_POST['group_id']);
    $groupOwner = Engine_Api::_()->getItem('user', $linkGroup->owner_id);

    $groupLinkTable = Engine_Api::_()->getDbTable('linkgroups', 'sesgroup');
    $db = $groupLinkTable->getAdapter();
    $db->beginTransaction();
    try {
      $linkedGroup = $groupLinkTable->createRow();
      $linkedGroup->setFromArray(array(
          'user_id' => $viewer->getIdentity(),
          'group_id' => $group->group_id,
          'link_group_id' => $_POST['group_id']));
      $linkedGroup->save();
      $db->commit();
      if ($groupOwner->getIdentity() != $viewer->getIdentity())
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($groupOwner, $viewer, $linkGroup, 'sesgroup_link_group');
      $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'linked-group', 'group_id' => $group->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function searchGroupAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $viewerId = $this->view->viewer()->getIdentity();
    $groupTable = Engine_Api::_()->getItemTable('sesgroup_group');
    $linkGroupTable = Engine_Api::_()->getDbTable('linkgroups', 'sesgroup');
    $select = $linkGroupTable->select()
            ->from($linkGroupTable->info('name'), 'link_group_id')
            ->where('user_id =?', $viewerId);
    $linkedGroups = $groupTable->fetchAll($select)->toArray();
    $selectGroupTable = $groupTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    if (count($linkedGroups) > 0)
      $selectGroupTable->where('group_id NOT IN(?)', $linkedGroups);

    $groups = $groupTable->fetchAll($selectGroupTable);
    foreach ($groups as $group) {
      $group_icon = $this->view->itemPhoto($group, 'thumb.icon');
      $sesdata[] = array(
          'id' => $group->group_id,
          'user_id' => $group->owner_id,
          'label' => $group->title,
          'photo' => $group_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  function sendMessage($groups, $group, $is_ajax_content) {
    // Assign the composing stuff
    $composePartials = array();
    $prohibitedPartials = array('_composeTwitter.tpl', '_composeFacebook.tpl');
    foreach (Zend_Registry::get('Engine_Manifest') as $data) {
      if (empty($data['composer'])) {
        continue;
      }
      foreach ($data['composer'] as $type => $config) {
        // is the current user has "create" privileges for the current plugin
        if (isset($config['auth'], $config['auth'][0], $config['auth'][1])) {
          $isAllowed = Engine_Api::_()
                  ->authorization()
                  ->isAllowed($config['auth'][0], null, $config['auth'][1]);

          if (!empty($config['auth']) && !$isAllowed) {
            continue;
          }
        }
        if (!in_array($config['script'][0], $prohibitedPartials)) {
          $composePartials[] = $config['script'];
        }
      }
    }
    $this->view->composePartials = $composePartials;

    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Compose();
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    // Process
    $db = Engine_Api::_()->getDbTable('messages', 'messages')->getAdapter();
    $db->beginTransaction();

    try {
      // Try attachment getting stuff
      $attachment = null;
      $attachmentData = $this->getRequest()->getParam('attachment');
      if (!empty($attachmentData) && !empty($attachmentData['type'])) {
        $type = $attachmentData['type'];
        $config = null;
        foreach (Zend_Registry::get('Engine_Manifest') as $data) {
          if (!empty($data['composer'][$type])) {
            $config = $data['composer'][$type];
          }
        }
        if ($config) {
          $plugin = Engine_Api::_()->loadClass($config['plugin']);
          $method = 'onAttach' . ucfirst($type);
          $attachment = $plugin->$method($attachmentData);
          $parent = $attachment->getParent();
          if ($parent->getType() === 'user') {
            $attachment->search = 0;
            $attachment->save();
          } else {
            $parent->search = 0;
            $parent->save();
          }
        }
      }

      $viewer = Engine_Api::_()->user()->getViewer();
      $values = $form->getValues();
      $actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
      if ($actionName == 'contact-groups') {
        foreach ($groups as $group)
          $userIds[] = $group->owner_id;
      } else
        $userIds = $_POST['winner'];

      $recipientsUsers = Engine_Api::_()->getItemMulti('user', $userIds);

      // Create conversation
      $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
              $viewer, $userIds, $values['title'], $values['body'], $attachment
      );

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
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $_SESSION['show_message'] = 1;
    if ($actionName == 'contact-groups') {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-groups', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-winners', 'group_id' => $group->custom_url), "sesgroup_dashboard", true);
    }
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    // $ownerId = Engine_Api::_()->getItem('sesgroup_group', $this->_getParam('group_id', null))->user_id;
    //$viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = array();
    $roleTable = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('group_id =?', $this->_getParam('group_id', null))->query()->fetchAll();
    foreach ($roleIds as $roleID) {
      $roleIDArray[] = $roleID['user_id'];
    }
    $diffIds = array_merge($users, $roleIDArray);
    $users_table = Engine_Api::_()->getDbTable('users', 'user');
    $usersTableName = $users_table->info('name');
    $select = $users_table->select()->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');
    if ($diffIds)
      $select->where($usersTableName . '.user_id NOT IN (?)', $diffIds);
    $select->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);
    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function changeGroupAdminAction() {
    $grouprole_id = $this->_getParam('grouprole_id', '');
    $grouproleid = $this->_getParam('grouproleid', '');
    $group_id = $this->_getParam('group_id', '');
    $roleTable = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    if (!$grouproleid) {
      $roleId = $this->_getParam('roleId', '');
      $roleIds = $roleTable->select()->from($roleTable->info('name'), '*')->where('group_id =?', $this->_getParam('group_id', null))->where('grouprole_id =?', $grouprole_id);
      $groupRole = $roleTable->fetchRow($roleIds);
      if (!($groupRole)) {
        echo 0;
        die;
      }
      $groupRole->memberrole_id = $roleId;
      $groupRole->save();
    } else {
      $groupRole = Engine_Api::_()->getItem('sesgroup_grouprole', $grouproleid);
      $groupRole->delete();
    }
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    $this->view->is_ajax = 1;
    $this->view->groupRoles = Engine_Api::_()->getDbTable('memberroles', 'sesgroup')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('group_id =?', $group->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/group-roles.tpl');
  }

  public function groupRolesAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'gp_allow_roles'))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->groupRoles = Engine_Api::_()->getDbTable('memberroles', 'sesgroup')->getLevels(array('status' => true));
    $roleTable = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('group_id =?', $group->getIdentity())->order('memberrole_id ASC')->query()->fetchAll();
  }

  public function addGroupAdminAction() {
    if (!count($_POST)) {
      echo 0;
      die;
    }

    $user_id = $this->_getParam('user_id', '');
    $group_id = $this->_getParam('group_id', '');
    $roleId = $this->_getParam('roleId', '');
    $roleTable = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('group_id =?', $this->_getParam('group_id', null))->where('user_id =?', $user_id)->query()->fetchAll();
    if (count($roleIds)) {
      echo 0;
      die;
    }

    $groupRoleTable = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $groupRole = $groupRoleTable->createRow();
    $groupRole->user_id = $user_id;
    $groupRole->group_id = $group_id;
    $groupRole->memberrole_id = $roleId;
    $groupRole->save();
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    $groupRole = Engine_Api::_()->getItem('sesgroup_memberrole', $roleId);
    $title = array('roletitle' => $groupRole->title);
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $group->getOwner(), $group, 'sesgroup_grouproll_create_group', $title);

    //mail
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesgroup_grouproll_creategroup', array('group_title' => $group->getTitle(), 'sender_title' => $group->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'role_title' => $groupRole->title));


    $this->view->is_ajax = 1;
    $this->view->groupRoles = Engine_Api::_()->getDbTable('memberroles', 'sesgroup')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('group_id =?', $group->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/group-roles.tpl');
  }

  public function crossPostGroupAction() {
    $query = $this->_getParam('text', '');
    $crossPosts = Engine_Api::_()->getItemTable('sesgroup_crosspost')->getCrossposts(array('group_id' => $this->_getParam('group_id')));
    $group_ids = array();
    foreach ($crossPosts as $group) {
      $group_ids[] = $group['receiver_group_id'];
      $group_ids[] = $group['sender_group_id'];
    }
    $table = Engine_Api::_()->getItemTable('sesgroup_group');
    $groupCrossPostTable = Engine_Api::_()->getItemTable('sesgroup_crosspost')->info('name');
    $select = $table->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"')->from($table->info('name'))->where('group_id !=?', $this->_getParam('group_id'))->where('search =?', 1)->where('draft =?', 1);
    $select->setIntegrityCheck(false)
            ->joinLeft($groupCrossPostTable, $groupCrossPostTable . '.receiver_group_id = ' . $table->info('name') . '.group_id || ' . $groupCrossPostTable . '.sender_group_id = ' . $table->info('name') . '.group_id');
    if (count($group_ids)) {
      $select->where('(' . $groupCrossPostTable . '.receiver_group_id NOT IN (' . implode(',', $group_ids) . ') AND ' . $groupCrossPostTable . '.sender_group_id NOT IN (' . implode(',', $group_ids) . ')) OR ' . $groupCrossPostTable . '.receiver_group_id IS NULL');
    }

    foreach ($table->fetchAll($select) as $group) {
      $user_icon_photo = $this->view->itemPhoto($group, 'thumb.icon');
      $sesdata[] = array(
          'id' => $group->group_id,
          'label' => $group->getTitle(),
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function createCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $group_id = $group->getIdentity();
    $crossGroup = $this->_getParam('crossgroup', 0);
    $crossPostTable = Engine_Api::_()->getItemTable('sesgroup_crosspost');
    $crossPost = $crossPostTable->createRow();
    $crossPost->sender_group_id = $group_id;
    $crossPost->receiver_group_id = $crossGroup;
    $crossPost->receiver_approved = 0;
    $crossPost->save();

    $crossGroupItem = Engine_Api::_()->getItem('sesgroup_group', $crossGroup);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('group_id' => $crossGroupItem->custom_url, 'action' => 'cross-post', 'id' => $crossPost->getIdentity()), 'sesgroup_dashboard', true)) . '">' . $group->getTitle() . '</a>';

    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($crossGroupItem->getOwner(), $group->getOwner(), $group, 'sesgroup_crosspost_create_group', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesgroup_crosspost')->getCrossposts(array('group_id' => $group->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function approveCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossGroupid = $this->_getParam('crossgroup', 0);
    $crossGroup = Engine_Api::_()->getItem('sesgroup_crosspost', $crossGroupid);
    $crossGroup->receiver_approved = 1;
    $crossGroup->save();

    $groupItem = Engine_Api::_()->getItem('sesgroup_group', $crossGroup->sender_group_id);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('group_id' => $groupItem->custom_url, 'action' => 'cross-post'), 'sesgroup_dashboard', true)) . '">' . $groupItem->getTitle() . '</a>';
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($group->getOwner(), $groupItem->getOwner(), $groupItem, 'sesgroup_crosspost_approve_group', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesgroup_crosspost')->getCrossposts(array('group_id' => $group->getIdentity(), 'receiver_approved' => true));
    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function crossPostAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $id = $this->_getParam('id', '');
    if ($id) {
      $crossItem = Engine_Api::_()->getItem('sesgroup_crosspost', $id);
      if ($crossItem) {
        if ($crossItem->receiver_approved == 0 && $crossItem->receiver_group_id == $group->getIdentity()) {
          $item = Engine_Api::_()->getItem('sesgroup_group', $crossItem->sender_group_id);
          ;
          if ($item)
            $this->view->crosspostgroup = $item;
          $this->view->crosspostgroupid = $id;
        }
      }
    }
    $this->view->crosspost = Engine_Api::_()->getItemTable('sesgroup_crosspost')->getCrossposts(array('group_id' => $group->getIdentity(), 'receiver_approved' => true));
  }

  function manageNotificationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    ;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $this->view->form = $form = new Sesgroup_Form_Dashboard_Notification();

    if ($this->getRequest()->getPost() && $form->isValid($this->getRequest()->getPost())) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      $dbGetInsert->query("DELETE FROM engine4_sesgroup_notifications WHERE user_id = " . $viewer->getIdentity() . ' AND group_id =' . $group->getIdentity());
      $values = $form->getValues();
      // Process
      $table = Engine_Api::_()->getDbTable('notifications', 'sesgroup');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          if ($key != "notification_type") {
            foreach ($value as $noti) {
              $this->createNotification($noti, $table, $group->getIdentity(), $viewer->getIdentity());
            }
          } else {
            $this->createNotification($value, $table, $group->getIdentity(), $viewer->getIdentity(), $key);
          }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }

    $notifications = Engine_Api::_()->getDbTable('notifications', 'sesgroup')->getNotifications(array('group_id' => $group->getIdentity(), 'getAll' => true));
    if (count($notifications)) {
      $notificationArray = array();
      foreach ($notifications as $noti) {
        if ($noti->type == "notification_type") {
          $form->notification_type->setValue($noti->value);
        } else {
          $notificationArray[] = $noti->type;
        }
      }
      $form->notifications->setValue($notificationArray);
    }
  }

  function createNotification($val, $table, $group_id, $user_id, $key = "") {
    $noti = $table->createRow();
    $noti->group_id = $group_id;
    $noti->user_id = $user_id;
    if ($key == "notification_type") {
      $noti->type = $key;
      $noti->value = $val;
    } else {
      $noti->type = $val;
      $noti->value = 1;
    }
    $noti->save();
    return $noti;
  }

  function deleteCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossGroupid = $this->_getParam('crossgroup', 0);
    $crossGroup = Engine_Api::_()->getItem('sesgroup_crosspost', $crossGroupid);

    if ($crossGroup) {
      if ($crossGroup->sender_group_id == $group->getIdentity() || $crossGroup->receiver_group_id == $group->getIdentity()) {
        $crossGroup->delete();
      } else {
        echo 0;
        die;
      }
    }

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesgroup_crosspost')->getCrossposts(array('group_id' => $group->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function postAttributionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $value = $this->_getParam('value', '');
    if (strlen($value)) {
      $res = Engine_Api::_()->getDbTable('postattributions', 'sesgroup')->getGroupPostAttribution(array('group_id' => $group->getIdentity(), 'return' => 1));
      if ($res) {
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      } else {
        $table = Engine_Api::_()->getDbTable('postattributions', 'sesgroup');
        $res = $table->createRow();
        $res->group_id = $group->getIdentity();
        $res->user_id = $viewer->getIdentity();
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      }
    }
    $this->view->attribution = Engine_Api::_()->getDbTable('postattributions', 'sesgroup')->getGroupPostAttribution(array('group_id' => $group->getIdentity()));
    $this->view->form = $form = new Sesgroup_Form_Attribution(array('groupItem' => $group));
    $form->attribution->setValue($this->view->attribution);
  }

  public function contactAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    // Create form
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Contact();
    if (!empty($_SESSION['send_Mail'])) {
      $form->addNotice("Message send to members.");
      unset($_SESSION['send_Mail']);
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $values = $form->getValues();
    if ($values['type'] == 1) {
      $tableUser = Engine_Api::_()->getDbTable('users', 'user');
      $select = $group->membership()->getMembersObjectSelect();
      $fullMembers = $tableUser->fetchAll($select);
    } else {
      $userTable = Engine_Api::_()->getDbTable('users', 'user');
      $tableName = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->info('name');
      $select = $userTable->select()->from($userTable);
      $select->where($userTable->info('name') . '.user_id IN (SELECT user_id FROM ' . $tableName . ' WHERE group_id = ' . $group->getIdentity() . ' AND memberrole_id IN (' . implode(',', $values['group_roles']) . '))');
      $fullMembers = $userTable->fetchAll($select);
    }

    foreach ($fullMembers as $member) {
      if ($member->user_id != $viewer->getIdentity()) {
        // Create conversation
        $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
                $viewer, array($member->getIdentity()), str_replace('[group_title]', $group->getTitle(), $values['subject']), str_replace('[group_title]', $group->getTitle(), $values['message']), $group
        );

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($member, 'sesgroup_contact_member', array('subject' => str_replace('[group_title]', $group->getTitle(), $values['subject']), 'message' => str_replace('[group_title]', $group->getTitle(), $values['message']), 'object_link' => $this->view->absoluteUrl($group->getHref()), 'host' => $_SERVER['HTTP_HOST'], 'queue' => false));
      }
    }

    if (count($fullMembers)) {
      $_SESSION['send_Mail'] = true;
      $this->_helper->redirector->gotoRoute(array());
    }
  }
  
  public function upgradeAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $sesgroup = Engine_Api::_()->core()->getSubject();
    //current package
    if (!empty($sesgroup->orderspackage_id)) {
      $this->view->currentPackage = Engine_Api::_()->getItem('sesgrouppackage_orderspackage', $sesgroup->orderspackage_id);
      if (!$this->view->currentPackage) {
        $this->view->currentPackage = Engine_Api::_()->getItem('sesgrouppackage_package', $sesgroup->package_id);
        $price = $this->view->currentPackage->price;
      } else {
        $price = Engine_Api::_()->getItem('sesgrouppackage_package', $this->view->currentPackage->package_id)->price;
      }
    } else {
      $this->view->currentPackage = array();
      $price = 0;
    }
    $this->view->viewer = $viewer = $this->view->viewer();
    //get upgrade packages
    $this->view->upgradepackage = Engine_Api::_()->getDbTable('packages', 'sesgrouppackage')->getPackage(array('show_upgrade' => 1, 'member_level' => $viewer->level_id, 'not_in_id' => $sesgroup->package_id, 'price' => $price    ));
  }
  
  public function groupRulesAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->view->viewer(), 'gp_allow_rules'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('rules', 'sesgroup')
            ->getGroupRulePaginator(array('group_id' => $group->group_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function addRuleAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Addrule();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $ruleTable = Engine_Api::_()->getDbTable('rules', 'sesgroup');
    $db = $ruleTable->getAdapter();
    $db->beginTransaction();
    try {
      $rule = $ruleTable->createRow();
      $rule->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'group_id' => $group->group_id), $form->getValues()));
      $rule->save();
      $db->commit();
      // Redirect
      $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'group-rules', 'group_id' => $group->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editRuleAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $rule = Engine_Api::_()->getItem('sesgroup_rule', $this->_getParam('id'));
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Editrule();
    $form->title->setValue($rule->title);
    $form->body->setValue($rule->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $rule->title = $_POST['title'];
    $rule->body = $_POST['body'];
    $rule->save();
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'group-rules', 'group_id' => $group->custom_url));
  }

  public function deleteRuleAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $rule = Engine_Api::_()->getItem('sesgroup_rule', $this->_getParam('id'));
    $this->view->form = $form = new Sesgroup_Form_Dashboard_Deleterule();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $rule->delete();
    $this->_redirectCustom(array('route' => 'sesgroup_dashboard', 'action' => 'group-rules', 'group_id' => $group->custom_url));
  }
    public function salesStatsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;

    $this->view->todaySale = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getSaleStats(array('stats' => 'today', 'group_id' => $group->group_id));
    $this->view->weekSale = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getSaleStats(array('stats' => 'week', 'group_id' => $group->group_id));
    $this->view->monthSale = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getSaleStats(array('stats' => 'month', 'group_id' => $group->group_id));

    //get getGroupStats
    $this->view->eventStatsSale = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getContestStats(array('group_id' => $group->group_id));
  }

  //get sales report
  public function salesReportsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;

    $this->view->form = $form = new Egroupjoinfees_Form_Searchsalereport();
    $value = array();
    if (isset($_GET['startdate']))
      $value['startdate'] = $value['start'] = date('Y-m-d', strtotime($_GET['startdate']));
    if (isset($_GET['enddate']))
      $value['enddate'] = $value['end'] = date('Y-m-d', strtotime($_GET['enddate']));
    if (isset($_GET['type']))
      $value['type'] = $_GET['type'];
    if (!count($value)) {
      $value['enddate'] = date('Y-m-d', strtotime(date('Y-m-d')));
      $value['startdate'] = date('Y-m-d', strtotime('-30 days'));
      $value['type'] = $form->type->getValue();
    }
    if (isset($_GET['excel']) && $_GET['excel'] != '')
      $value['download'] = 'excel';
    if (isset($_GET['csv']) && $_GET['csv'] != '')
      $value['download'] = 'csv';
    $form->populate($value);
    $value['event_id'] = $group->getIdentity();
    $this->view->groupJoiningData = $data = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getReportData($value);

    if (isset($value['download'])) {
      $name = str_replace(' ', '_', $group->getTitle()) . '_' . time();
      switch ($value["download"]) {
        case "excel" :
          // Submission from
          $filename = $name . ".xls";
          header("Content-Type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          $this->exportFile($data);
          exit();
        case "csv" :
          // Submission from
          $filename = $name . ".csv";
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-type: text/csv");
          header("Content-Disposition: attachment; filename=\"$filename\"");
          header("Expires: 0");
          $this->exportCSVFile($data);
          exit();
        default :
          //silence
          break;
      }
    }
  }

//   protected function exportCSVFile($records) {
//     // create a file pointer connected to the output stream
//     $fh = fopen('php://output', 'w');
//     $heading = false;
//     $counter = 1;
//     if (!empty($records))
//       foreach ($records as $row) {
//         $valueVal['S.No'] = $counter;
//         $valueVal['Date of Purchase'] = Engine_Api::_()->egroupjoinfees()->dateFormat($row['creation_date']);
//         $valueVal['Quatity'] = $row['total_orders'];
//         //$valueVal['Commission Amount'] = Engine_Api::_()->sesevent()->getCurrencyPrice($row['commission_amount'],$defaultCurrency);
//         $valueVal['Total Amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($row['totalAmountSale'], $defaultCurrency);
//         $counter++;
//         if (!$heading) {
//           // output the column headings
//           fputcsv($fh, array_keys($valueVal));
//           $heading = true;
//         }
//         // loop over the rows, outputting them
//         fputcsv($fh, array_values($valueVal));
//       }
//     fclose($fh);
//   }
//   protected function exportFile($records) {
//     $heading = false;
//     $counter = 1;
//     $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
//     if (!empty($records))
//       foreach ($records as $row) {
//         $valueVal['S.No'] = $counter;
//         $valueVal['Date of Purchase'] = Engine_Api::_()->egroupjoinfees()->dateFormat($row['creation_date']);
//         $valueVal['Quatity'] = $row['total_orders'];
//         $valueVal['Total Amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($row['totalAmountSale'], $defaultCurrency);
//         $counter++;
//         if (!$heading) {
//           // display field/column names as a first row
//           echo implode("\t", array_keys($valueVal)) . "\n";
//           $heading = true;
//         }
//         echo implode("\t", array_values($valueVal)) . "\n";
//       }
//     exit;
//   }

  public function createEntryFeesAction() {
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;
    $groupJoinTable = Engine_Api::_()->getDbtable('plans', 'egroupjoinfees');
    $plan = $groupJoinTable->getPlan($group->getIdentity());
    //$gatewayObject = Engine_Api::_()->getItem("egroupjoinfees_usergateway", $userGateway['usergateway_id']);
    if(!empty($plan)) {
      $this->view->form = $form = new Egroupjoinfees_Form_Edit();
      $values = $plan->toArray();
      $values['recurrence'] = array($values['recurrence'], $values['recurrence_type']);
      $values['duration'] = array($values['duration'], $values['duration_type']);
      unset($values['recurrence_type']);
      unset($values['duration_type']);
     // $params = json_decode($values['params'], true);
      //$values = array_merge($values, $params);
      $values['member_level'] = explode(',', $plan->member_level);
      $otherValues = array(
          'price' => $values['price'],
          'recurrence' => $values['recurrence'],
          'duration' => $values['duration'],
      );
      $form->populate($values);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
    } else {
      $this->view->form = $form = new Egroupjoinfees_Form_Create();
      $gateways = array();
      $supportedBillingCycles = array();
      $partiallySupportedBillingCycles = array();
      $fullySupportedBillingCycles = null;
      $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
      foreach ($gatewaysTable->fetchAll() as $gateway) {
        $gateways[$gateway->gateway_id] = $gateway;
        $supportedBillingCycles[$gateway->gateway_id] = $gateway->getGateway()->getSupportedBillingCycles();
        $partiallySupportedBillingCycles = array_merge($partiallySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
        if (null === $fullySupportedBillingCycles) {
          $fullySupportedBillingCycles = $supportedBillingCycles[$gateway->gateway_id];
        } else {
          $fullySupportedBillingCycles = array_intersect($fullySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
        }
      }
      $partiallySupportedBillingCycles = array_diff($partiallySupportedBillingCycles, $fullySupportedBillingCycles);

      $multiOptions = array_combine(array_map('strtolower', $fullySupportedBillingCycles), $fullySupportedBillingCycles);
      // $multiOptions = array_merge(array('day' => "Day"), $multiOptions);
      $form->getElement('recurrence')
              ->setMultiOptions($multiOptions);
      $form->getElement('recurrence')->options['forever'] = 'One-time';

      $form->getElement('duration')
              ->setMultiOptions($multiOptions);
      $form->getElement('duration')->options['forever'] = 'Forever';
      
      $db = $groupJoinTable->getAdapter();
      $db->beginTransaction();
    }
    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    $values = $form->getValues();
    $tmp = $values['recurrence'];
    unset($values['recurrence']);
    if (empty($tmp) || !is_array($tmp)) {
      $tmp = array(null, null);
    }
    $values['recurrence'] = (int) $tmp[0];
    $values['recurrence_type'] = $tmp[1];
    $tmp = $values['duration'];
    unset($values['duration']);
    if (empty($tmp) || !is_array($tmp)) {
      $tmp = array(null, null);
    }
    $values['duration'] = (int) $tmp[0];
    $values['duration_type'] = $tmp[1];
    $values['member_level'] = ',' . implode(',', $values['member_level']) . ',';
    try {
      if(!empty($plan)) {
        $row = $plan;
      } else {
        $row = $groupJoinTable->createRow();
      }
      $row->setFromArray($values);
      $row->group_id = $group->getIdentity();
      $row->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $group->entry_fees = $_POST['entry_fees'];
    $group->save();
    $form->addNotice("Entry fees saved successfully.");
  }

  //Entry controller data
  public function manageOrdersAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return $this->_forward('notfound', 'error', 'core');
  }
  //get payment to admin information
  public function paymentRequestsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;
    $viewer = Engine_Api::_()->user()->getViewer();
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0)) {
      $package = Engine_Api::_()->getItem('sesgrouppackage_package', $group->package_id);
      if ($package) {
        $paramsDecoded = json_decode($package->params, true);
      }
      $this->view->thresholdAmount = $thresholdAmount = $paramsDecoded['sesgroup_threshold_amount'];
    } else {
      $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'group', 'group_threamt');
    }
    $this->view->userGateway = Engine_Api::_()->getDbtable('usergateways', 'egroupjoinfees')->getUserGateway(array('group_id' => $group->group_id));
    $this->view->orderDetails = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getContestStats(array('group_id' => $group->group_id));
    //get ramaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'egroupjoinfees')->getGroupRemainingAmount(array('group_id' => $group->group_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
    $this->view->isAlreadyRequests = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees')->getPaymentRequests(array('group_id' => $group->group_id, 'isPending' => true));
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees')->getPaymentRequests(array('group_id' => $group->group_id, 'isPending' => true));
  }
  public function paymentTransactionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees')->getPaymentRequests(array('group_id' => $group->group_id, 'state' => 'both'));
  }
  public function currencyConverterAction() {
    //default currency
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    if ($is_ajax) {
      $curr = $this->_getParam('curr', 'USD');
      $val = $this->_getParam('val', '1');
      $currencyVal = $settings->getSetting('sesmultiplecurrency.' . $curr);
      echo round($currencyVal * $val, 2);
      die;
    }
    //currecy Array
    $fullySupportedCurrenciesExists = array();
    $fullySupportedCurrencies = Engine_Api::_()->egroupjoinfees()->getSupportedCurrency();
    foreach ($fullySupportedCurrencies as $key => $values) {
      if ($settings->getSetting('sesmultiplecurrency.' . $key))
        $fullySupportedCurrenciesExists[$key] = $values;
    }
    $this->view->form = $form = new Egroupjoinfees_Form_Conversion();
    $form->currency->setMultioptions($fullySupportedCurrenciesExists);
    $form->currency->setValue($defaultCurrency);
  }
   //get user account details
  public function accountDetailsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;
    $gateway_type = isset($_GET['gateway_type']) ? $_GET['gateway_type'] : "paypal";
    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'egroupjoinfees')->getUserGateway(array('group_id' => $group->group_id, 'enabled' => true,'gateway_type'=>$gateway_type,));
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $userGatewayEnable = $settings->getSetting('sesgroup.userGateway', 'paypal');
    if($gateway_type == "paypal") {
        $userGatewayEnable = 'paypal';
        $this->view->form = $form = new Egroupjoinfees_Form_PayPal();
        $gatewayTitle = 'Paypal';
        $gatewayClass= 'Egroupjoinfees_Plugin_Gateway_PayPal';
    } else if($gateway_type == "stripe") {
        $userGatewayEnable = 'stripe';
        $this->view->form = $form = new Sesadvpmnt_Form_Admin_Settings_Stripe();
        $gatewayTitle = 'Stripe';
        $gatewayClass= 'Egroupjoinfees_Plugin_Gateway_Group_Stripe';
    } else if($gateway_type == "paytm") {
        $userGatewayEnable = 'paytm';
        $this->view->form = $form = new Epaytm_Form_Admin_Settings_Paytm();
        $gatewayTitle = 'Paytm';
        $gatewayClass= 'Egroupjoinfees_Plugin_Gateway_Group_Paytm';
    }
    if (count($userGateway)) {
      $form->populate($userGateway->toArray());
      if (is_array($userGateway['config'])) {
        $form->populate($userGateway['config']);
      }
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Process
    $values = $form->getValues();
    $enabled = (bool) $values['enabled'];
    unset($values['enabled']);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'egroupjoinfees');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->group_id = $group->group_id;
        $gatewayObject->user_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->gateway_type = $gateway_type;
        $gatewayObject->save();
      } else {
        $gatewayObject = Engine_Api::_()->getItem("egroupjoinfees_usergateway", $userGateway['usergateway_id']);
      }
      $db->commit();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Validate gateway config
    if ($enabled) {
      $gatewayObjectObj = $gatewayObject->getGateway();
      try {
        $gatewayObjectObj->setConfig($values);
        $response = $gatewayObjectObj->test();
      } catch (Exception $e) {
        $enabled = false;
        $form->populate(array('enabled' => false));
        $form->addError(sprintf('Gateway login failed. Please double check ' .
                        'your connection information. The gateway has been disabled. ' .
                        'The message was: [%2$d] %1$s', $e->getMessage(), $e->getCode()));
      }
    } else {
      $form->addError('Gateway is currently disabled.');
    }
    // Process
    $message = null;
    try {
      $values = $gatewayObject->getPlugin()->processAdminGatewayForm($values);
    } catch (Exception $e) {
      $message = $e->getMessage();
      $values = null;
    }
    if (null !== $values) {
      $gatewayObject->setFromArray(array(
          'enabled' => $enabled,
          'config' => $values,
      ));
      //echo "asdf<pre>";var_dump($gatewayObject);die;
      $gatewayObject->save();
      $form->addNotice('Changes saved.');
    } else {
      $form->addError($message);
    }
  }
    public function paymentRequestAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $group->isOwner($viewer)))
      return;
    $viewer = Engine_Api::_()->user()->getViewer();

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0)) {
      $package = Engine_Api::_()->getItem('sesgrouppackage_package', $group->package_id);
      if ($package) {
        $paramsDecoded = json_decode($package->params, true);
      }
      $this->view->thresholdAmount = $thresholdAmount = $paramsDecoded['sesgroup_threshold_amount'];
    } else {
      $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'group', 'group_threamt');
    }


    //get remaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'egroupjoinfees')->getGroupRemainingAmount(array('group_id' => $group->group_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else {
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
    }
    $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
    $orderDetails = Engine_Api::_()->getDbtable('orders', 'egroupjoinfees')->getContestStats(array('group_id' => $group->group_id));
    $this->view->form = $form = new Egroupjoinfees_Form_Paymentrequest();
    $value = array();
    $value['total_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['totalAmountSale'], $defaultCurrency);
    $value['total_commission_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['commission_amount'], $defaultCurrency);
    $value['remaining_amount'] = Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($remainingAmount->remaining_payment, $defaultCurrency);
    $value['requested_amount'] = round($remainingAmount->remaining_payment, 2);
    //set value to form
    if ($this->_getParam('id', false)) {
      $item = Engine_Api::_()->getItem('egroupjoinfees_userpayrequest', $this->_getParam('id'));
      if ($item) {
        $itemValue = $item->toArray();
        //unset($value['requested_amount']);
        $value = array_merge($itemValue, $value);
      } else {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }
    if (empty($_POST))
      $form->populate($value);

    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    if (@round($thresholdAmount, 2) > @round($remainingAmount->remaining_payment, 2) && empty($_POST)) {
      $this->view->message = 'Remaining amount is less than Threshold amount.';
      $this->view->errorMessage = true;
      return;
    } else if (isset($_POST['requested_amount']) && @round($_POST['requested_amount'], 2) > @round($remainingAmount->remaining_payment, 2)) {
      $form->addError('Requested amount must be less than or equal to remaining amount.');
      return;
    } else if (isset($_POST['requested_amount']) && @round($thresholdAmount) > @round($_POST['requested_amount'], 2)) {
      $form->addError('Requested amount must be greater than or equal to threshold amount.');
      return;
    }
    $db = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees')->getAdapter();
    $db->beginTransaction();
    try {
      $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'egroupjoinfees');
      if (isset($itemValue))
        $order = $item;
      else
        $order = $tableOrder->createRow();
      $order->requested_amount = round($_POST['requested_amount'], 2);
      $order->user_message = $_POST['user_message'];
      $order->group_id = $group->group_id;
      $order->owner_id = $viewer->getIdentity();
      $order->user_message = $_POST['user_message'];
      $order->creation_date = date('Y-m-d h:i:s');
      $order->currency_symbol = $defaultCurrency;
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $userGatewayEnable = $settings->getSetting('sesgroup.userGateway', 'paypal');
      $order->save();
      $db->commit();

      //Notification work
      $owner_admin = Engine_Api::_()->getItem('user', 1);
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner_admin, $viewer, $group, 'egroupjoinfees_group_paymentrequest', array('requestAmount' => round($_POST['requested_amount'], 2)));
      //Payment request mail send to admin
      $group_owner = $group->getOwner();
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'egroupjoinfees_entrypayment_requestadmin', array('group_title' => $group->title, 'object_link' => $group->getHref(), 'group_owner' => $group_owner->getTitle(), 'host' => $_SERVER['HTTP_HOST']));

      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your payment request has been successfully sent to Admin for approval.');
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 1000,
                  'parentRefresh' => 1000,
                  'messages' => array($this->view->message)
      ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  
}
