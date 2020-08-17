<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_DashboardController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('businesses', null, 'view')->isValid())
      return;

    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('business_id', null);
    if (!isset($_POST['locationphoto_id'])) {
      $viewer = $this->view->viewer();
      $business_id = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessId($id);
      if ($business_id) {
        $business = Engine_Api::_()->getItem('businesses', $business_id);
        if ($business && (($business->is_approved || $viewer->level_id == 1 || $viewer->level_id == 2 || $viewer->getIdentity() == $business->owner_id) ))
          Engine_Api::_()->core()->setSubject($business);
        else
          return $this->_forward('requireauth', 'error', 'core');
      } else
        return $this->_forward('requireauth', 'error', 'core');
      if (!Engine_Api::_()->sesbusiness()->businessRolePermission($business, Zend_Controller_Front::getInstance()->getRequest()->getActionName())) {
        return;
      }
      $levelId = Engine_Api::_()->getItem('user', $business->owner_id)->level_id;
    }
  }

  public function managebusinessonoffappsAction() {

    $businessType = $this->_getParam('type', 'photos');
    $businessId = $this->_getParam('business_id', null);
    if (empty($businessId))
      return;

    $isCheck = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $businessId, 'columnname' => $businessType));
    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
    if ($isCheck) {
      $dbGetInsert->update('engine4_sesbusiness_managebusinessapps', array($businessType => 0), array('business_id =?' => $businessId));
    } else {
      $dbGetInsert->update('engine4_sesbusiness_managebusinessapps', array($businessType => 1), array('business_id =?' => $businessId));
    }
    echo true;
    die;
  }

  public function editAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $previousTitle = $business->getTitle();

    //Business Category and profile fileds
    $this->view->defaultProfileId = $defaultProfileId = 1;
    if (isset($business->category_id) && $business->category_id != 0)
      $this->view->category_id = $business->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($business->subsubcat_id) && $business->subsubcat_id != 0)
      $this->view->subsubcat_id = $business->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($business->subcat_id) && $business->subcat_id != 0)
      $this->view->subcat_id = $business->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;
    //Business category and profile fields
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Edit(array('defaultProfileId' => $defaultProfileId));
    $this->view->category_id = $business->category_id;
    $this->view->subcat_id = $business->subcat_id;
    $this->view->subsubcat_id = $business->subsubcat_id;
    $tagStr = '';
    foreach ($business->tags()->getTagMaps() as $tagMap) {
      $tag = $tagMap->getTag();
      if (!isset($tag->text))
        continue;
      if ('' !== $tagStr)
        $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
        'tags' => $tagStr,
        'networks' => ltrim($business['networks'], ',')
    ));
    $oldUrl = $business->custom_url;
    $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
    if (!$this->getRequest()->isPost()) {
      // Populate auth
      $auth = Engine_Api::_()->authorization()->context;
      foreach ($roles as $role) {
        if (isset($form->auth_view->options[$role]) && $auth->isAllowed($business, $role, 'view'))
          $form->auth_view->setValue($role);
        if (isset($form->auth_comment->options[$role]) && $auth->isAllowed($business, $role, 'comment'))
          $form->auth_comment->setValue($role);

        if (isset($form->auth_album->options[$role]) && $auth->isAllowed($business, $role, 'album'))
          $form->auth_album->setValue($role);

        if (isset($form->auth_video->options[$role]) && $auth->isAllowed($business, $role, 'video'))
          $form->auth_video->setValue($role);
        
        if (isset($form->auth_offer->options[$role]) && $auth->isAllowed($business, $role, 'offer'))
          $form->auth_offer->setValue($role);
      }
      $form->populate($business->toArray());
      if ($form->draft->getValue() == 1)
        $form->removeElement('draft');
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->sesbasic()->checkBannedWord($_POST['custom_url'],$business->custom_url);
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
      $values['approval'] = $settings->getSetting('sesbusiness.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sesbusiness.default.approvaloption', 1) ? 0 : 1;
    // Process
    $db = Engine_Api::_()->getItemTable('businesses')->getAdapter();
    $db->beginTransaction();
    try {
      if (!($values['draft']))
        unset($values['draft']);
      $business->setFromArray($values);
      $business->save();
      $tags = preg_split('/[,]+/', $values['tags']);
      $business->tags()->setTagMaps($viewer, $tags);
      if (!$values['vote_type'])
        $values['resulttime'] = '';

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $business->custom_url = $_POST['custom_url'];

      $business->save();

      $newbusinessTitle = $business->getTitle();

      // Add photo
      if (!empty($values['photo'])) {
        $business->setPhoto($form->photo);
      }
      // Add cover photo
      if (!empty($values['cover'])) {
        $business->setCover($form->cover);
      }
      // Set auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      if (empty($values['auth_view']))
        $values['auth_view'] = 'everyone';
      $business->view_privacy = $values['auth_view'];
      if (empty($values['auth_comment']))
        $values['auth_comment'] = 'everyone';
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      $albumMax = array_search(@$values['auth_album'], $roles);
      $videoMax = array_search(@$values['auth_video'], $roles);
      $offerMax = array_search(@$values['auth_offer'], $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($business, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($business, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($business, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($business, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($business, $role, 'offer', ($i <= $offerMax));
      }
      $business->save();

      if(isset($_POST['custom_url']) && $_POST['custom_url'] != $oldUrl) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->update('engine4_sesbasic_bannedwords', array("word" => $_POST['custom_url']),array("word = ?" => $oldUrl,"resource_type = ?" => business,"resource_id = ?" => $business->business_id));
      }

      $db->commit();
      //Start Activity Feed Work
      if (isset($values['draft']) && $business->draft == 1 && $business->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        //$action = $activityApi->addActivity($viewer, $business, 'sesbusiness_create');
        // if ($action) {
        // $activityApi->attachActivity($action, $business);
        //}
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','sesbusiness')->getCategoryFollowers($business->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','sesbusiness')->getColumnName(array('category_id' => $business->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $business, 'sesbusiness_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesbusiness_follow_category', array('sender_title' => $business->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work

      if ($previousTitle != $newbusinessTitle) {
        //Send to all joined members
        $joinedMembers = Engine_Api::_()->sesbusiness()->getallJoinedMembers($business);
        foreach ($joinedMembers as $joinedMember) {
          if ($joinedMember->user_id == $business->owner_id)
            continue;
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $business, 'sesbusiness_businessjoinednamechange', array('old_business_title' => $previousTitle, 'new_business_link' => $newbusinessTitle));
        }

        //Send to all followed members
        $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getFollowers($business->getIdentity());
        foreach ($followerMembers as $followerMember) {
          if ($followerMember->owner_id == $business->owner_id)
            continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $business, 'sesbusiness_businessfollowednamechange', array('old_business_title' => $previousTitle, 'new_business_link' => $newbusinessTitle));

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesbusiness_business_businessnamechanged', array('business_title' => $business->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        //Send to all favourites members
        $followerMembers = Engine_Api::_()->getDbTable('favourites', 'sesbusiness')->getAllFavMembers($business->getIdentity());
        foreach ($followerMembers as $followerMember) {
          if ($followerMember->owner_id == $business->owner_id)
            continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $business, 'sesbusiness_businessfavouritednamechange', array('old_business_title' => $previousTitle, 'new_business_link' => $newbusinessTitle));
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
    $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'edit', 'business_id' => $business->custom_url));
  }

  public function profileFieldAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    //Business Category and profile fileds
    $this->view->defaultProfileId = $defaultProfileId = 1;
    if (isset($business->category_id) && $business->category_id != 0)
      $this->view->category_id = $business->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($business->subsubcat_id) && $business->subsubcat_id != 0)
      $this->view->subsubcat_id = $business->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($business->subcat_id) && $business->subcat_id != 0)
      $this->view->subcat_id = $business->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    //Business category and profile fields
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Profilefield(array('defaultProfileId' => $defaultProfileId));
    $this->view->category_id = $business->category_id;
    $this->view->subcat_id = $business->subcat_id;
    $this->view->subsubcat_id = $business->subsubcat_id;
    $form->populate($business->toArray());

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    // Process
    $db = Engine_Api::_()->getItemTable('businesses')->getAdapter();
    $db->beginTransaction();
    try {
      //Add fields
      $customfieldform = $form->getSubForm('fields');
      if ($customfieldform) {
        $customfieldform->setItem($business);
        $customfieldform->saveValues();
      }
      $business->save();
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
    $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'profile-field', 'business_id' => $business->custom_url));
  }

  public function changeOwnerAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $this->view->viewer(), 'auth_changeowner'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->sesbusiness()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $this->view->viewer()->getIdentity(), 'business_id' => $business->business_id));
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sesbusiness_general', true);
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

  public function manageBusinessappsAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->business = $business = Engine_Api::_()->core()->getSubject();

    $getManagebusinessId = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->getManagebusinessId(array('business_id' => $business->business_id));

    $this->view->managebusinessapps = Engine_Api::_()->getItem('sesbusiness_managebusinessapp', $getManagebusinessId);

    $viewer = Engine_Api::_()->user()->getViewer();
  }

  public function manageServiceAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->business = $business = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableService = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'business_service');
    if (empty($enableService)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $sesbusiness_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.service', 1);
    if(empty($sesbusiness_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'sesbusiness')->getServiceMemers(array('business_id' => $business->business_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function addserviceAction() {

    $sesbusiness_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.service', 1);
    if(empty($sesbusiness_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->business_id = $business_id = $this->_getParam('business_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $business = Engine_Api::_()->getItem('businesses', $business_id);

    if (!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Sesbusiness_Form_Service_Add();
      $form->setTitle('Add New Service');
      $form->setDescription("Here, you can enter your service details.");
    }

    if ($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('services', 'sesbusiness');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {

        $values = $_POST;
        $values['business_id'] = $business_id;
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
              'parent_type' => 'sesbusiness_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $row->photo_id = $filename->file_id;
          $row->save();
        }

        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('services', 'sesbusiness')->getServiceMemers(array('business_id' => $business->business_id));
        $showData = $this->view->partial('_services.tpl', 'sesbusiness', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'business_id' => $business->business_id, 'is_ajax' => true));
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

    $sesbusiness_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.service', 1);
    if(empty($sesbusiness_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->business_id = $business_id = $this->_getParam('business_id', null);

    $business = Engine_Api::_()->getItem('businesses', $business_id);

    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $this->view->service = $service = Engine_Api::_()->getItem('sesbusiness_service', $service_id);

    if (!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesbusiness_Form_Service_Edit();
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
              'parent_type' => 'sesbusiness_service',
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

        $paginator = Engine_Api::_()->getDbTable('services', 'sesbusiness')->getServiceMemers(array('business_id' => $business->business_id));
        $showData = $this->view->partial('_services.tpl', 'sesbusiness', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'business_id' => $business->business_id, 'is_ajax' => true));
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
    $this->view->business_id = $business_id = $this->_getParam('business_id', null);
    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $item = Engine_Api::_()->getItem('sesbusiness_service', $service_id);
    if (!$is_ajax) {
      $this->view->form = $form = new Sesbusiness_Form_Service_Delete();
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

    $this->view->business = $business = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableTeam = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'business_team');
    if (empty($enableTeam)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Designations
    $this->view->designations = Engine_Api::_()->getDbTable('designations', 'sesbusinessteam')->getAllDesignations(array('business_id' => $business->business_id));

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('teams', 'sesbusinessteam')->getTeamMemers(array('business_id' => $business->business_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageLocationAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1) || !Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'allow_mlocation'))
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'sesbusiness')
            ->getBusinessLocationPaginator(array('business_id' => $business->business_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $value = array();
    $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
    if (!$is_search_ajax) {
      $this->view->searchForm = $searchForm = new Sesbusiness_Form_Dashboard_ManageMembers();
    }
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $value['name'] = isset($searchArray['name']) ? $searchArray['name'] : '';
    $value['email'] = isset($searchArray['email']) ? $searchArray['email'] : '';
    $value['status'] = isset($searchArray['status']) ? $searchArray['status'] : '';

    $table = Engine_Api::_()->getDbTable('users', 'user');
    $subtable = Engine_Api::_()->getDbTable('membership', 'sesbusiness');
    $tableName = $table->info('name');
    $subtableName = $subtable->info('name');
    $select = $table->select()
            ->from($tableName, array('user_id', 'displayname', 'email', 'photo_id'))
            ->setIntegrityCheck(false)
            ->joinRight($subtableName, '`' . $subtableName . '`.`user_id` = `' . $tableName . '`.`user_id`', array('resource_approved', 'user_approved', 'active'))
            ->where('`' . $subtableName . '`.`resource_id` = ?', $business->getIdentity());
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
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $this->view->viewer(), 'auth_announce'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'sesbusiness')
            ->getBusinessAnnouncementPaginator(array('business_id' => $business->business_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function postAnnouncementAction() {
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'sesbusiness');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'business_id' => $business->business_id), $form->getValues()));
      $announcement->save();
      $db->commit();

      $getAllBusinessMembers = Engine_Api::_()->sesbusiness()->getAllBusinessMembers($business);
      foreach ($getAllBusinessMembers as $user) {
        $user = Engine_Api::_()->getItem('user', $user);
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, Engine_Api::_()->user()->getViewer(), $business, 'sesbusiness_business_newanc');

        //mail
        //Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesbusiness_businessroll_createbusiness', array('business_title' => $business->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }

      // Redirect
      $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'announcement', 'business_id' => $business->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editAnnouncementAction() {
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sesbusiness_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'announcement', 'business_id' => $business->custom_url));
  }

  public function deleteAnnouncementAction() {
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sesbusiness_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->delete();
    $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'announcement', 'business_id' => $business->custom_url));
  }

  public function addLocationAction() {
    $business = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Addlocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_sesbusiness_locations', array('is_default' => 0), array('business_id =?' => $business->business_id));
      }
      $dbGetInsert->query('INSERT INTO engine4_sesbusiness_locations (business_id,title,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $business->business_id . '","' . $_POST['title'] . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '","' . $_POST['is_default'] . '") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $business->business_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "businesses")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $business->location = $_POST['location'];
        $business->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function designAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Viewdesign();
    $form->businessestyle->setValue($business->businessestyle);
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    $business->businessestyle = $_POST['businessestyle'];
    $business->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'design', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function editLocationAction() {
    $business = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Editlocation();
    $location = Engine_Api::_()->getItem('sesbusiness_location', $this->_getParam('location_id'));
    $form->title->setValue($location->title);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_sesbusiness_locations', array('is_default' => 0), array('business_id =?' => $business->business_id));
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
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $business->business_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "businesses")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $business->location = $_POST['location'];
        $business->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function deleteLocationAction() {
    $business = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Deletelocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $location = Engine_Api::_()->getItem('sesbusiness_location', $this->_getParam('location_id'));
    $location->delete();

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function addPhotosAction() {
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->location = $location = Engine_Api::_()->getItem('sesbusiness_location', $this->_getParam('location_id'));
  }

  public function composeUploadAction() {
    if (!Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->_redirect('login');
      return;
    }
    $location = Engine_Api::_()->getItem('sesbusiness_location', $this->_getParam('location_id'));
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
    $photoTable = Engine_Api::_()->getItemTable('sesbusiness_locationphoto');
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
      $photo->business_id = $location->business_id;
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
    $photo = Engine_Api::_()->getItem('sesbusiness_locationphoto', $photo_id);
    $db = Engine_Api::_()->getItemTable('sesbusiness_locationphoto')->getAdapter();
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
    //GET Business ID AND ITEM
    $business = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $business->photo_id = '';
      $business->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function insightsAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'auth_insightrpt'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->view_type = $interval = isset($_POST['type']) ? $_POST['type'] : 'monthly';
    $dateArray = $this->createDateRangeArray($business->creation_date, $business->creation_date, $interval);

    $likeTable = Engine_Api::_()->getDbTable('likes', 'sesbasic');
    $likeSelect = $likeTable->select()->from($likeTable->info('name'), array(new Zend_Db_Expr('"like" AS type'), 'COUNT(like_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
             ->where('resource_type =?', 'businesses')
             ->where('resource_id =?', $business->business_id);
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
            ->where('resource_type =?', 'businesses')
            ->where('resource_id =?', $business->business_id);
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

    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'sesbusiness');
    $favouritesSelect = $favouriteTable->select()->from($favouriteTable->info('name'), array(new Zend_Db_Expr('"favourite" AS type'), 'COUNT(favourite_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'businesses')
            ->where('resource_id =?', $business->business_id);
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

    $viewTable = Engine_Api::_()->getDbTable('recentlyviewitems', 'sesbusiness');
    $viewSelect = $viewTable->select()->from($viewTable->info('name'), array(new Zend_Db_Expr('"view" AS type'), 'COUNT(recentlyviewed_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'businesses')
            ->where('resource_id =?', $business->business_id);
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
      $this->view->likeHeadingTitle = $this->view->translate("Monthly Like Report For ") . $business->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Monthly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Monthly Comment Report For ") . $business->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Monthly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Monthly Favourite Report For ") . $business->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Monthly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Monthly Views Report For ") . $business->getTitle();
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
      $this->view->likeHeadingTitle = $this->view->translate("Weekly Like Report For ") . $business->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Weekly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Weekly Comment Report For ") . $business->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Weekly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Weekly Favourite Report For ") . $business->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Weekly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Weekly Views Report For ") . $business->getTitle();
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
      $this->view->likeHeadingTitle = $this->view->translate("Daily Like Report for ") . $business->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Daily Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Daily Comment Report for ") . $business->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Daily Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Daily Favourite Report for ") . $business->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Daily Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Daily Views Report for ") . $business->getTitle();
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
      $this->view->likeHeadingTitle = $this->view->translate("Hourly Like Report For ") . $business->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Hourly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Hourly Comment Report For ") . $business->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Hourly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Hourly Favourite Report For ") . $business->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Hourly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Hourly Views Report For ") . $business->getTitle();
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
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Searchreport();
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
    $value['business_id'] = $business->getIdentity();
    $this->view->businessReportData = $data = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getReportData($value);

    if (isset($value['download'])) {
      $name = str_replace(' ', '_', $business->getTitle()) . '_' . time();
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
        $valueVal['Business Name'] = $row['title'];
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
        $valueVal['Business Name'] = $row['title'];
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
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Backgroundphoto();
    $form->populate($business->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $business->setBackgroundPhoto($_FILES['background'], 'background');
      $business->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function removeBackgroundphotoAction() {
    $business = Engine_Api::_()->core()->getSubject();
    $business->background_photo_id = 0;
    $business->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
  }

  public function mainphotoAction() {

    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $this->view->viewer(), 'upload_mainphoto'))
      return $this->_forward('requireauth', 'error', 'core');

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Mainphoto();

    if (empty($business->photo_id)) {
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
      $db = $business->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $fileElement = $form->Filedata;
        //$photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false, false, 'sesbusiness', business, '', $business, true);
        $business->setPhoto($fileElement, '', 'profile');
//         $business->photo_id = $photo_id;
//         $business->save();
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
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_RemovePhoto();

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $business = Engine_Api::_()->core()->getSubject();
    $business->photo_id = 0;
    $business->save();

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
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Overview();
    $form->populate($business->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $business->setFromArray($_POST);
      $business->save();
      $db->commit();
      //Activity Feed Work
//      $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
//      $action = $activityApi->addActivity($viewer, $business, 'sesbusiness_business_editbusinessoverview');
//      if ($action) {
//        $activityApi->attachActivity($action, $business);
//      }
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Seo();

    $form->populate($business->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $business->setFromArray($_POST);
      $business->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get style detail
  public function openHoursAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    if ($this->getRequest()->isPost()) {
      $openHours = Engine_Api::_()->getDbTable('openhours', 'sesbusiness')->getBusinessHours(array('business_id' => $business->getIdentity()));
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
      $openHoursTable = Engine_Api::_()->getDbTable('openhours', 'sesbusiness');
      $db = $openHoursTable->getAdapter();
      $db->beginTransaction();
      try {
        if ($_POST['hours'] == "closed") {
          $business->status = 0;
          $business->save();
        } else {
          $business->status = 1;
          $business->save();
        }
        if (!$openHours)
          $openHours = $openHoursTable->createRow();
        $values['params'] = json_encode($data);
        $values['business_id'] = $business->getIdentity();
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
    $hoursData = Engine_Api::_()->getDbTable('openhours', 'sesbusiness')->getBusinessHours(array('business_id' => $business->getIdentity()));
    if ($hoursData) {
      $this->view->hoursData = json_decode($hoursData->params, true);
      $this->view->timezone = $hoursData->timezone;
    }
  }

  //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get current row
    $table = Engine_Api::_()->getDbTable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'businesses')
            ->where('id = ?', $business->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Style();
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
      $row->type = 'businesses';
      $row->id = $business->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

  public function advertiseBusinessAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
  }

  // Send Update who like, follow and join business
  public function sendUpdatesAction() {

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_id');
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type');

    if (!$id || !$type)
      return;

    // Make form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_SendUpdates();

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
      $likeMembers = Engine_Api::_()->sesbusiness()->getMemberByLike($attachment->getIdentity());
      foreach ($likeMembers as $likeMember) {
        $likeMemberIds[] = $likeMember['poster_id'];
      }
    }
    if (in_array('followed', $values['type'])) {

      $followMembers = Engine_Api::_()->sesbusiness()->getMemberFollow($attachment->getIdentity());
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

  //get business contact information
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Contactinformation();

    $form->populate($business->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    if (!empty($_POST["business_contact_email"]) && !filter_var($_POST["business_contact_email"], FILTER_VALIDATE_EMAIL)) {
      $form->addError($this->view->translate("Invalid email format."));
      return;
    }
    if (!empty($_POST["business_contact_website"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_website"])) {
      $form->addError($this->view->translate("Invalid WebSite URL."));
      return;
    }
    if (!empty($_POST["business_contact_facebook"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_facebook"])) {
      $form->addError($this->view->translate("Invalid Facebook URL."));
      return;
    }
    if (!empty($_POST["business_contact_linkedin"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_linkedin"])) {
      $form->addError($this->view->translate("Invalid Linkedin URL."));
      return;
    }
    if (!empty($_POST["business_contact_twitter"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_twitter"])) {
      $form->addError($this->view->translate("Invalid Twitter URL."));
      return;
    }
    if (!empty($_POST["business_contact_instagram"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_instagram"])) {
      $form->addError($this->view->translate("Invalid Instagram URL."));
      return;
    }
    if (!empty($_POST["business_contact_pinterest"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["business_contact_pinterest"])) {
      $form->addError($this->view->translate("Invalid Pinterest URL."));
      return;
    }
    $db = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $business->setFromArray($form->getValues());
      $business->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
      die;
    }
  }

  public function linkedBusinessAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('linkbusinesses', 'sesbusiness')
        ->getLinkBusinessesPaginator(array('business_id' => $business->business_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    if (!$this->getRequest()->isPost())
      return;
    $linkBusiness = Engine_Api::_()->getItem('businesses', $_POST['business_id']);
    $businessOwner = Engine_Api::_()->getItem('user', $linkBusiness->owner_id);

    $businessLinkTable = Engine_Api::_()->getDbTable('linkbusinesses', 'sesbusiness');
    $db = $businessLinkTable->getAdapter();
    $db->beginTransaction();
    try {
      $linkedBusiness = $businessLinkTable->createRow();
      $linkedBusiness->setFromArray(array(
          'user_id' => $viewer->getIdentity(),
          'business_id' => $business->business_id,
          'link_business_id' => $_POST['business_id']));
      $linkedBusiness->save();
      $db->commit();
      if ($businessOwner->getIdentity() != $viewer->getIdentity())
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($businessOwner, $viewer, $linkBusiness, 'sesbusiness_link_business');
      $this->_redirectCustom(array('route' => 'sesbusiness_dashboard', 'action' => 'linked-business', 'business_id' => $business->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function searchBusinessAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $viewerId = $this->view->viewer()->getIdentity();
    $businessTable = Engine_Api::_()->getItemTable('businesses');
    $linkBusinessTable = Engine_Api::_()->getDbTable('linkbusinesses', 'sesbusiness');
    $select = $linkBusinessTable->select()
            ->from($linkBusinessTable->info('name'), 'link_business_id')
            ->where('user_id =?', $viewerId);
    $linkedBusinesses = $businessTable->fetchAll($select)->toArray();
    $selectBusinessTable = $businessTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    if (count($linkedBusinesses) > 0)
      $selectBusinessTable->where('business_id NOT IN(?)', $linkedBusinesses);

    $businesses = $businessTable->fetchAll($selectBusinessTable);
    foreach ($businesses as $business) {
      $business_icon = $this->view->itemPhoto($business, 'thumb.icon');
      $sesdata[] = array(
          'id' => $business->business_id,
          'user_id' => $business->owner_id,
          'label' => $business->title,
          'photo' => $business_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  function sendMessage($businesses, $business, $is_ajax_content) {
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
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Compose();
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
      if ($actionName == 'contact-businesses') {
        foreach ($businesses as $business)
          $userIds[] = $business->owner_id;
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
    if ($actionName == 'contact-businesses') {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-businesses', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-winners', 'business_id' => $business->custom_url), "sesbusiness_dashboard", true);
    }
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    // $ownerId = Engine_Api::_()->getItem('businesses', $this->_getParam('business_id', null))->user_id;
    //$viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = array();
    $roleTable = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('business_id =?', $this->_getParam('business_id', null))->query()->fetchAll();
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

  public function changeBusinessAdminAction() {
    $businessrole_id = $this->_getParam('businessrole_id', '');
    $businessroleid = $this->_getParam('businessroleid', '');
    $business_id = $this->_getParam('business_id', '');
    $roleTable = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    if (!$businessroleid) {
      $roleId = $this->_getParam('roleId', '');
      $roleIds = $roleTable->select()->from($roleTable->info('name'), '*')->where('business_id =?', $this->_getParam('business_id', null))->where('businessrole_id =?', $businessrole_id);
      $businessRole = $roleTable->fetchRow($roleIds);
      if (!($businessRole)) {
        echo 0;
        die;
      }
      $businessRole->memberrole_id = $roleId;
      $businessRole->save();
    } else {
      $businessRole = Engine_Api::_()->getItem('sesbusiness_businessrole', $businessroleid);
      $businessRole->delete();
    }
    $this->view->business = $business = Engine_Api::_()->getItem('businesses', $business_id);
    $this->view->is_ajax = 1;
    $this->view->businessRoles = Engine_Api::_()->getDbTable('memberroles', 'sesbusiness')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('business_id =?', $business->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/business-roles.tpl');
  }

  public function businessRolesAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'bs_allow_roles'))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->businessRoles = Engine_Api::_()->getDbTable('memberroles', 'sesbusiness')->getLevels(array('status' => true));
    $roleTable = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('business_id =?', $business->getIdentity())->order('memberrole_id ASC')->query()->fetchAll();
  }

  public function addBusinessAdminAction() {
    if (!count($_POST)) {
      echo 0;
      die;
    }

    $user_id = $this->_getParam('user_id', '');
    $business_id = $this->_getParam('business_id', '');
    $roleId = $this->_getParam('roleId', '');
    $roleTable = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('business_id =?', $this->_getParam('business_id', null))->where('user_id =?', $user_id)->query()->fetchAll();
    if (count($roleIds)) {
      echo 0;
      die;
    }

    $businessRoleTable = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $businessRole = $businessRoleTable->createRow();
    $businessRole->user_id = $user_id;
    $businessRole->business_id = $business_id;
    $businessRole->memberrole_id = $roleId;
    $businessRole->save();
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->business = $business = Engine_Api::_()->getItem('businesses', $business_id);
    $businessRole = Engine_Api::_()->getItem('sesbusiness_memberrole', $roleId);
    $title = array('roletitle' => $businessRole->title);
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $business->getOwner(), $business, 'sesbusiness_businessroll_ctbs', $title);

    //mail
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesbusiness_businessroll_createbusiness', array('business_title' => $business->getTitle(), 'sender_title' => $business->getOwner()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'role_title' => $businessRole->title));


    $this->view->is_ajax = 1;
    $this->view->businessRoles = Engine_Api::_()->getDbTable('memberroles', 'sesbusiness')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('business_id =?', $business->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/business-roles.tpl');
  }

  public function crossPostBusinessAction() {
    $query = $this->_getParam('text', '');
    $crossPosts = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->getCrossposts(array('business_id' => $this->_getParam('business_id')));
    $business_ids = array();
    foreach ($crossPosts as $business) {
      $business_ids[] = $business['receiver_business_id'];
      $business_ids[] = $business['sender_business_id'];
    }
    $table = Engine_Api::_()->getItemTable('businesses');
    $businessCrossPostTable = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->info('name');
    $select = $table->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"')->from($table->info('name'))->where('business_id !=?', $this->_getParam('business_id'))->where('search =?', 1)->where('draft =?', 1);
    $select->setIntegrityCheck(false)
            ->joinLeft($businessCrossPostTable, $businessCrossPostTable . '.receiver_business_id = ' . $table->info('name') . '.business_id || ' . $businessCrossPostTable . '.sender_business_id = ' . $table->info('name') . '.business_id');
    if (count($business_ids)) {
      $select->where('(' . $businessCrossPostTable . '.receiver_business_id NOT IN (' . implode(',', $business_ids) . ') AND ' . $businessCrossPostTable . '.sender_business_id NOT IN (' . implode(',', $business_ids) . ')) OR ' . $businessCrossPostTable . '.receiver_business_id IS NULL');
    }

    foreach ($table->fetchAll($select) as $business) {
      $user_icon_photo = $this->view->itemPhoto($business, 'thumb.icon');
      $sesdata[] = array(
          'id' => $business->business_id,
          'label' => $business->getTitle(),
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function createCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $business_id = $business->getIdentity();
    $crossBusiness = $this->_getParam('crossbusiness', 0);
    $crossPostTable = Engine_Api::_()->getItemTable('sesbusiness_crosspost');
    $crossPost = $crossPostTable->createRow();
    $crossPost->sender_business_id = $business_id;
    $crossPost->receiver_business_id = $crossBusiness;
    $crossPost->receiver_approved = 0;
    $crossPost->save();

    $crossBusinessItem = Engine_Api::_()->getItem('businesses', $crossBusiness);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('business_id' => $crossBusinessItem->custom_url, 'action' => 'cross-post', 'id' => $crossPost->getIdentity()), 'sesbusiness_dashboard', true)) . '">' . $business->getTitle() . '</a>';

    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($crossBusinessItem->getOwner(), $business->getOwner(), $business, 'sesbusiness_crosspost_ctbs', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->getCrossposts(array('business_id' => $business->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function approveCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossBusinessid = $this->_getParam('crossbusiness', 0);
    $crossBusiness = Engine_Api::_()->getItem('sesbusiness_crosspost', $crossBusinessid);
    $crossBusiness->receiver_approved = 1;
    $crossBusiness->save();

    $businessItem = Engine_Api::_()->getItem('businesses', $crossBusiness->sender_business_id);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('business_id' => $businessItem->custom_url, 'action' => 'cross-post'), 'sesbusiness_dashboard', true)) . '">' . $businessItem->getTitle() . '</a>';
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($business->getOwner(), $businessItem->getOwner(), $businessItem, 'sesbusiness_crosspost_apbs', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->getCrossposts(array('business_id' => $business->getIdentity(), 'receiver_approved' => true));
    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function crossPostAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $id = $this->_getParam('id', '');
    if ($id) {
      $crossItem = Engine_Api::_()->getItem('sesbusiness_crosspost', $id);
      if ($crossItem) {
        if ($crossItem->receiver_approved == 0 && $crossItem->receiver_business_id == $business->getIdentity()) {
          $item = Engine_Api::_()->getItem('businesses', $crossItem->sender_business_id);
          ;
          if ($item)
            $this->view->crosspostbusiness = $item;
          $this->view->crosspostbusinessid = $id;
        }
      }
    }
    $this->view->crosspost = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->getCrossposts(array('business_id' => $business->getIdentity(), 'receiver_approved' => true));
  }

  function manageNotificationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    ;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Notification();

    if ($this->getRequest()->getPost() && $form->isValid($this->getRequest()->getPost())) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      $dbGetInsert->query("DELETE FROM engine4_sesbusiness_notifications WHERE user_id = " . $viewer->getIdentity() . ' AND business_id =' . $business->getIdentity());
      $values = $form->getValues();
      // Process
      $table = Engine_Api::_()->getDbTable('notifications', 'sesbusiness');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          if ($key != "notification_type") {
            foreach ($value as $noti) {
              $this->createNotification($noti, $table, $business->getIdentity(), $viewer->getIdentity());
            }
          } else {
            $this->createNotification($value, $table, $business->getIdentity(), $viewer->getIdentity(), $key);
          }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }

    $notifications = Engine_Api::_()->getDbTable('notifications', 'sesbusiness')->getNotifications(array('business_id' => $business->getIdentity(), 'getAll' => true));
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

  function createNotification($val, $table, $business_id, $user_id, $key = "") {
    $noti = $table->createRow();
    $noti->business_id = $business_id;
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
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossBusinessid = $this->_getParam('crossbusiness', 0);
    $crossBusiness = Engine_Api::_()->getItem('sesbusiness_crosspost', $crossBusinessid);

    if ($crossBusiness) {
      if ($crossBusiness->sender_business_id == $business->getIdentity() || $crossBusiness->receiver_business_id == $business->getIdentity()) {
        $crossBusiness->delete();
      } else {
        echo 0;
        die;
      }
    }

    $this->view->crosspost = Engine_Api::_()->getItemTable('sesbusiness_crosspost')->getCrossposts(array('business_id' => $business->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function postAttributionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $value = $this->_getParam('value', '');
    if (strlen($value)) {
      $res = Engine_Api::_()->getDbTable('postattributions', 'sesbusiness')->getBusinessPostAttribution(array('business_id' => $business->getIdentity(), 'return' => 1));
      if ($res) {
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      } else {
        $table = Engine_Api::_()->getDbTable('postattributions', 'sesbusiness');
        $res = $table->createRow();
        $res->business_id = $business->getIdentity();
        $res->user_id = $viewer->getIdentity();
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      }
    }
    $this->view->attribution = Engine_Api::_()->getDbTable('postattributions', 'sesbusiness')->getBusinessPostAttribution(array('business_id' => $business->getIdentity()));
    $this->view->form = $form = new Sesbusiness_Form_Attribution(array('businessItem' => $business));
    $form->attribution->setValue($this->view->attribution);
  }

  public function contactAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->business = $business = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    // Create form
    $this->view->form = $form = new Sesbusiness_Form_Dashboard_Contact();
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
      $select = $business->membership()->getMembersObjectSelect();
      $fullMembers = $tableUser->fetchAll($select);
    } else {
      $userTable = Engine_Api::_()->getDbTable('users', 'user');
      $tableName = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->info('name');
      $select = $userTable->select()->from($userTable);
      $select->where($userTable->info('name') . '.user_id IN (SELECT user_id FROM ' . $tableName . ' WHERE business_id = ' . $business->getIdentity() . ' AND memberrole_id IN (' . implode(',', $values['business_roles']) . '))');
      $fullMembers = $userTable->fetchAll($select);
    }

    foreach ($fullMembers as $member) {
      if ($member->user_id != $viewer->getIdentity()) {
        // Create conversation
        $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
                $viewer, array($member->getIdentity()), str_replace('[business_title]', $business->getTitle(), $values['subject']), str_replace('[business_title]', $business->getTitle(), $values['message']), $business
        );

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($member, 'sesbusiness_contact_member', array('subject' => str_replace('[business_title]', $business->getTitle(), $values['subject']), 'message' => str_replace('[business_title]', $business->getTitle(), $values['message']), 'object_link' => $this->view->absoluteUrl($business->getHref()), 'host' => $_SERVER['HTTP_HOST'], 'queue' => false));
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
    $this->view->business = $sesbusiness = Engine_Api::_()->core()->getSubject();
    //current package
    if (!empty($sesbusiness->orderspackage_id)) {
      $this->view->currentPackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $sesbusiness->orderspackage_id);
      if (!$this->view->currentPackage) {
        $this->view->currentPackage = Engine_Api::_()->getItem('sesbusinesspackage_package', $sesbusiness->package_id);
        $price = $this->view->currentPackage->price;
      } else {
        $price = Engine_Api::_()->getItem('sesbusinesspackage_package', $this->view->currentPackage->package_id)->price;
      }
    } else {
      $this->view->currentPackage = array();
      $price = 0;
    }
    $this->view->viewer = $viewer = $this->view->viewer();
    //get upgrade packages
    $this->view->upgradepackage = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getPackage(array('show_upgrade' => 1, 'member_level' => $viewer->level_id, 'not_in_id' => $sesbusiness->package_id, 'price' => $price));
  }

}
