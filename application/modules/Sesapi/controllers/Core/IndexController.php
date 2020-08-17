<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2018-08-14 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Core_IndexController extends Sesapi_Controller_Action_Standard
{
  public function searchDataAction()
  {
    $searchApi = Engine_Api::_()->getApi('search', 'core');
    $query = (string) @$this->_getParam('query', '');
    $type = (string) @$this->_getParam('type');
    $page = (int)  $this->_getParam('page', 1);
    //if ($query) {
    $table = Engine_Api::_()->getDbtable('search', 'core');
    $db = $table->getAdapter();
    $select = $table->select();
    if ($query)
      $select
        ->where(new Zend_Db_Expr($db->quoteInto('MATCH(`title`, `description`, `keywords`, `hidden`) AGAINST (? IN BOOLEAN MODE)', $query)))
        ->order(new Zend_Db_Expr($db->quoteInto('MATCH(`title`, `description`, `keywords`, `hidden`) AGAINST (?) DESC', $query)));

    // Filter by item types
    $availableTypes = Engine_Api::_()->getItemTypes();
    if ($type && in_array($type, $availableTypes)) {
      $select->where('type = ?', $type);
    } else {
      $select->where('type IN(?)', $availableTypes);
    }
    $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage($this->_getParam('limit', 10));
    // }
    $results = [];
    if (is_array($paginator) || is_object($paginator)) {
      $counter = 0;
      foreach ($paginator as $item) {
        $item = $this->view->item($item->type, $item->id);
        if (!$item)
          continue;
        if ($item->getType() == "album_photo")
          $album_id = $item->album_id;
        if ($item->getType() == "poll")
          $poll_id = $item->poll_id;
        $results[$counter] = array(
          'images' => $this->getBaseUrl(true, $item->getPhotoUrl()),
          'title' => $item->getTitle(),
          'description' => $item->getDescription(),
          'href' => $this->getBaseUrl('', $item->getHref()),
          'id' => $item->getIdentity(),
          'type' => $item->getType(),
        );
        if (!empty($album_id))
          $results[$counter]['album_id'] = $album_id;
        if (!empty($poll_id))
          $results[$counter]['images'] = "{$this->getBaseUrl(true,$item->getPhotoUrl())}application/modules/Poll/externals/images/nophoto_poll_thumb_icon.png";
        $counter++;
      }
    }
    $result['search'] = $results;
    $extraParams['pagging']['total_page'] = $paginator->getPages()->pageCount;
    $extraParams['pagging']['total'] = $paginator->getTotalItemCount();
    $extraParams['pagging']['current_page'] = $paginator->getCurrentPageNumber();
    $extraParams['pagging']['next_page'] = $extraParams['pagging']['current_page'] + 1;
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array_merge(array('error' => '0', 'error_message' => '', 'result' => $result), $extraParams));
  }
  public function searchFormAction()
  {
    $searchApi = Engine_Api::_()->getApi('search', 'core');

    // check public settings
    $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
    if (!$require_check) {
      if (!$this->_helper->requireUser()->isValid()) {
        Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'permission_error', 'result' => ''));
      }
    }
    $form = new Core_Form_Search();
    // Get available types
    $availableTypes = $searchApi->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = strtoupper('ITEM_TYPE_' . $type);
      }
      $form->type->addMultiOptions($options);
    } else {
      $form->removeElement('type');
    }
    $formFields = Engine_Api::_()->getApi('FormFields', 'sesapi')->generateFormFields($form, true);
    $newFormFields = array();
    foreach ($formFields as $fields) {
      if ($fields["name"] == "query") {
        $fields['label'] = $this->view->translate("Search Text");
      } else if ($fields["name"] == "type") {
        $fields['label'] = $this->view->translate("Type");
      }
      $newFormFields[] = $fields;
    }
    $this->generateFormFields($newFormFields);
  }
  public function searchAction()
  { }
  public function settingsAction()
  {
    $deleteBtn = true;
    // Check last super admin
    $user = Engine_Api::_()->user()->getViewer();
    if ($user && $user->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $user->level_id) {
        $deleteBtn = false;
      }
    }
    $userSettingMenu = array();

    // OTP WORK
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerCheck = true;

    if (!$viewer || !$viewer->getIdentity()) {
      $viewerCheck = false;
    }
    $otpSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms_signup_phonenumber', 1);
    if (empty($otpSetting)) {
      $viewerCheck = false;
    }
    // OTP WORK
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('otpsms') && $this->checkVersion(2.7, 1.7) && $viewerCheck && Engine_Api::_()->otpsms()->isServiceEnable()) {
      $userSettingMenu =  array(
        array('class' => 'user_settings_general', 'label' => $this->view->translate('General')),
        array('class' => 'user_settings_privacy', 'label' => $this->view->translate('Privacy')),
        array('class' => 'user_settings_network', 'label' => $this->view->translate('Networks')),
        array('class' => 'user_settings_notifications', 'label' => $this->view->translate('Notifications')),
        array('class' => 'user_settings_password', 'label' => $this->view->translate('Change Password')),
        array('class' => 'user_settings_phone', 'label' => $this->view->translate('Phone Number'))

      );
    } else {
      $userSettingMenu =  array(
        array('class' => 'user_settings_general', 'label' => $this->view->translate('General')),
        array('class' => 'user_settings_privacy', 'label' => $this->view->translate('Privacy')),
        array('class' => 'user_settings_network', 'label' => $this->view->translate('Networks')),
        array('class' => 'user_settings_notifications', 'label' => $this->view->translate('Notifications')),
        array('class' => 'user_settings_password', 'label' => $this->view->translate('Change Password'))

      );
    }
    if ((bool) $user->authorization()->isAllowed($user, 'delete')) {
      $delete = array(array('class' => 'user_settings_delete', 'label' => $this->view->translate('Delete Account')));
      $userSettingMenu = array_merge($userSettingMenu, $delete);
    }
    if ($this->_getParam('getSubscription', 0)) {
      $subscription = array(array('class' => 'user_settings_subscription', 'label' => $this->view->translate('Subscription')));
      $userSettingMenu = array_merge($userSettingMenu, $subscription);
    }
    $userSettingMenus['settings'] = $userSettingMenu;
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $userSettingMenus));
  }
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    //_SESAPI_PLATFORM_SERVICE
    $navigation = Engine_Api::_()->getDbTable('menus', 'sesapi')->getMenus(array('status' => 1, 'device' => _SESAPI_PLATFORM_SERVICE));
    if ($this->view->viewer()->getIdentity() != 0) {
      $permission = Engine_Api::_()->authorization()->getPermission($this->view->viewer()->level_id, 'messages', 'create');
      if (Authorization_Api_Core::LEVEL_DISALLOW === $permission) {
        $messageText = "message_denied";
      }
    }
    $resultArray = array();
    $counter = 0;
    $storage = Engine_Api::_()->storage();
    $user_id = $this->view->viewer()->getIdentity();
    if (_SESAPI_PLATFORM_SERVICE == 2) {
      $version = _SESAPI_VERSION_ANDROID;
    }
    if (_SESAPI_PLATFORM_SERVICE == 1) {
      $version = _SESAPI_VERSION_IOS;
    }
    if (empty($version)) {
      $version = 0;
    }
    $sideData = $this->_getParam('sideData', 0);
    $requireCheck = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    foreach ($navigation as $item) {
      if ($item->module_name) {
        if (!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($item->module_name))
          continue;;
      }
      if (!empty($version) && $item->version) {
        if ($item->version > $version) {
          continue;
        }
      }
      $visibility =  $item->visibility;
      if ($visibility == 1) {
        if ($user_id == 0)
          continue;
      } else if ($visibility == 2) {
        if ($user_id != 0)
          continue;
      }
      if( !$requireCheck && !$viewer->getIdentity() && $item->class == "core_main_members") {
         continue;
      }
      if ($sideData && $item->label == "FAVOURITES")
        continue;
      if ($item->class == "core_mini_messages" && !empty($messageText))
        continue;
      $resultArray[$counter]['type'] = $item->type;
      $resultArray[$counter]['module'] = $item->module_name;
      $resultArray[$counter]['label'] = $item->label;
      $resultArray[$counter]['icon'] = $item->getPhotoUrl() ? $this->getBaseUrl(false, $item->getPhotoUrl()) : "";
      $resultArray[$counter]['url'] = $item->url;
      $resultArray[$counter]['class'] = $item->class ? $item->class : "";
      $counter++;
    }

    $notification_count = $this->hasNotification("");
    $friend_req = $this->hasNotification('friend');
    $message = $this->getMessagesUnreadCount();

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercoverphoto') && $user_id) {
      $defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($this->view->viewer(), 'sesusercoverphoto', 'defaultcoverphoto');
      if ($defaultCoverPhoto)
        $defaultCoverPhoto = $defaultCoverPhoto;
      else
        $defaultCoverPhoto = $this->getBaseUrl(true, 'application/modules/Sesusercoverphoto/externals/images/default_cover.jpg');

      if (isset($this->view->viewer()->coverphoto) && $this->view->viewer()->coverphoto != 0 && $this->view->viewer()->coverphoto != '') {
        $memberCover =  Engine_Api::_()->storage()->get($this->view->viewer()->coverphoto, '');
        if ($memberCover)
          $memberCover = $this->getBaseUrl(false, $memberCover->getPhotoUrl());
      } else
        $memberCover = $defaultCoverPhoto;
      $result['cover_photo'] = $memberCover;
    }
    if ($user_id) {
      $result['title'] = $this->view->viewer()->getTitle();
      $result['user_photo'] = $this->userImage($this->view->viewer(), 'thumb.profile');
      if (isset($viewer->coverphoto) && $viewer->coverphoto != 0 && $viewer->coverphoto != '') {
        $memberCover =  Engine_Api::_()->storage()->get($viewer->coverphoto, '');
        if ($memberCover){
          $memberCover = $this->getBaseUrl(false, $memberCover->map());
          $result['cover_photo'] = $memberCover;
        }
      }
    }
    $result['menus'] = $resultArray;
    if ($this->view->viewer()->getIdentity()) {
      $result['notification_count'] = $notification_count;
      $result['friend_req_count'] = $friend_req;
      $result['message_count'] = $message;
    } else {
      $result['notification_count'] = 0;
      $result['friend_req_count'] = 0;
      $result['message_count'] = 0;
    }
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $result));
  }

  function updatesAction()
  {
    if ($this->view->viewer()->getIdentity()) {
      $notification_count = $this->hasNotification("");
      $friend_req = $this->hasNotification('friend');
      $message = $this->getMessagesUnreadCount();
    } else {
      $notification_count = 0;
      $friend_req = 0;
      $message = 0;
    }
    $result['notification_count'] = $notification_count;
    $result['friend_req_count'] = $friend_req;
    $result['message_count'] = $message;
    $result['total_notification'] = (int) $notification_count + $friend_req + $message;
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $result));
  }
  public function checkVersion($android, $ios)
  {
    if (is_numeric(_SESAPI_VERSION_ANDROID) && _SESAPI_VERSION_ANDROID >= $android)
      return  true;
    if (is_numeric(_SESAPI_VERSION_IOS) && _SESAPI_VERSION_IOS >= $ios)
      return true;
    return false;
  }
  function hasNotification($param)
  {
    $notificationsTable = Engine_Api::_()->getDbtable('notifications', 'activity');
    $notificationsTableName = $notificationsTable->info('name');

    $select = new Zend_Db_Select($notificationsTable->getAdapter());
    $select->from($notificationsTableName, 'COUNT(notification_id) AS notification_count')
      ->where('user_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
      ->where('`read` = ?', 0);

    if ($param == 'friend') {
      $select->where('type = ?', 'friend_request')
        ->where('mitigated 	 = ?', 0)
        ->where('`read` =?', 0);
    } else {
      $select->where('type != ?', 'message_new')
        ->where('`read` =?', 0)
        ->where('type != ?', 'friend_request');
    }

    $results = $notificationsTable->getAdapter()->fetchRow($select);
    return (int) @$results['notification_count'];
  }
  function getMessagesUnreadCount()
  {
    $recipients_table = Engine_Api::_()->getDbtable('recipients', 'messages');
    $recipients_table_name = $recipients_table->info('name');
    $hasColumn = false;
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $sm_read = $db->query('SHOW COLUMNS FROM engine4_messages_recipients LIKE \'sm_read\'')->fetch();
    $select = $recipients_table->select()
      ->from($recipients_table_name, new Zend_Db_Expr('COUNT(conversation_id) AS unread'))
      ->where('inbox_deleted = ?', 0)
      ->where('user_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
      ->where('inbox_read = ?', 0);
    if (($sm_read)) {
      $select->where('sm_read =?', 0);
    }
    $results = $recipients_table->fetchRow($select);
    return (int) $results->unread;
  }
  public function notificationAction()
  {
    $page = $this->_getParam('page', 1);
    $viewer = Engine_Api::_()->user()->getViewer();

    $enabledNotificationTypes = array();
    foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $key => $type) {
      $enabledNotificationTypes[] = $type->type;
      // for live streaming.
      if(_SESAPI_VERSION_IOS < 1.8 && _SESAPI_PLATFORM_SERVICE==1 && $type->module=="elivestreaming"){
        unset($enabledNotificationTypes[$key]);
      }
    }
    Engine_Api::_()->getDbtable('notifications', 'activity')->update(array('read' => 1), array('user_id = ?' => $viewer->getIdentity()));
    $select = Engine_Api::_()->getDbtable('notifications', 'activity')->select()
      ->where('user_id = ?', $viewer->getIdentity())
      ->where('type IN(?)', $enabledNotificationTypes)
      ->where('type != ?', 'message_new')
      ->where('type != ?', 'friend_request')
      ->order('date DESC');
    $notifications =  Zend_Paginator::factory($select);
    $notifications->setCurrentPageNumber($page);
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $notifications->setItemCountPerPage($this->_getParam('limit', 10));
    $this->newInfo($notifications);
  }
  public function markReadAction()
  {
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $action_id = $request->getParam('notification_id', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $notificationsTable = Engine_Api::_()->getDbtable('notifications', 'activity');
    $db = $notificationsTable->getAdapter();
    $db->beginTransaction();
    try {
      $notification = Engine_Api::_()->getItem('activity_notification', $action_id);
      if ($notification) {
        $notification->read = 1;
        $notification->save();
      }
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $e->getMessage(), 'result' => true));
    }
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => true));
  }

  public function friendRequestsAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    //    $enable_type = array();
    //    foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $type) {
    //      $enable_type[] = $type->type;
    //    }
    $where = array(
      '`user_id` = ?' => $this->view->viewer()->getIdentity(),
      '`read` = ?' => 0,
      '`mitigated` = ?' => 0,
    );
    Engine_Api::_()->getDbtable('notifications', 'activity')->update(array('read' => 1), $where);
    //    $select = Engine_Api::_()->getDbtable('notifications', 'activity')->select()
    //            ->where('user_id = ?', $viewer->getIdentity())
    //            ->where('type IN(?)', $enable_type)
    //            ->where('type = ?', 'friend_request')
    //            ->where('mitigated = ?', 0)
    //            ->order('date DESC');
    //
    $enabledModuleNames = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();
    $table = Engine_Api::_()->getDbtable('notifications', 'activity');
    $typeTable = Engine_Api::_()->getDbtable('notificationTypes', 'activity');
    $select = $table->select()
      ->from($table->info('name'))
      ->join($typeTable->info('name'), $typeTable->info('name') . '.type = ' . $table->info('name') . '.type', null)
      ->where('module IN(?)', $enabledModuleNames)
      ->where('user_id = ?', $viewer->getIdentity())
      ->where('is_request = ?', 1)
      ->where('mitigated = ?', 0)
      ->where($table->info('name') . '.type = ?', 'friend_request')
      ->order('date DESC');

    $newFriendRequests =  Zend_Paginator::factory($select);
    $newFriendRequests->setItemCountPerPage($this->_getParam('limit', 10));
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page', 1));
    $this->newInfo($newFriendRequests, 'friend_request');
  }

  public function newInfo($notifications, $typeName = "")
  {
    $result = array();
    $model = Engine_Api::_()->getApi('core', 'activity');
    $counterLoop = 0;
    $baseURL = $this->getBaseUrl();
    $types = Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes();
    $moduleName = array();
    foreach ($types as $type) {
      $moduleName[$type->type] = $type->module;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    if ($typeName && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember')) {
      $memberEnable = true;
    }

    foreach ($notifications as $notification) {
      try {
        $object = $notification->getObject();
        $subject = $notification->getSubject();
        $params = array_merge(
          $notification->toArray(),
          (array) $notification->params,
          array(
            'user' => $notification->getUser(),
            'object' => $object,
            'subject' => $subject,
          )
        );
        $info = Engine_Api::_()->getDbtable('notificationTypes', 'activity')->getNotificationType($notification->type);
        if (!$info)
          continue;
        $title = $model->assemble($info->body, $params);
        $dom = new DOMDocument;
        $dom->loadHTML($title);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//a/@href');
        $hrefValue = array();
        $parentNodeValue = '';
        $counter = 0;
        foreach ($nodes as $href) {
          if ($counter == 0)
            $parentNodeValue =  $href->parentNode->nodeValue;
          $counter++;
          $hrefValue[] = $href->nodeValue;  //remove attribute
        }
        if (count($hrefValue) > 0)
          $href = $this->getBaseUrl('', $hrefValue[count($hrefValue) - 1]);
        else
          $href = $baseURL;
        if ($typeName == "friend_request") {
          $title = $subject->getTitle();
        }
        $user = Engine_Api::_()->getItem('user', $notification->subject_id);
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;;
        $photo = $view->itemPhoto($user, 'thumb.profile');
        $doc = new DOMDocument();
        @$doc->loadHTML($photo);
        $tags = $doc->getElementsByTagName('img');
        $image = '';
        foreach ($tags as $tag) {
          $image = $tag->getAttribute('src');
          if (strpos($image, 'http') === false)
            $image = $this->getBaseUrl(false, $image);
        }
        if (array_key_exists($notification->type, $moduleName)) {
          $typeFind = '.notification_type_' . $notification->type . ":before";
          $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName[$notification->type]) . "/externals/styles/main.css";
          $resultCss = Engine_Api::_()->sesapi()->parseCSSFile($filePath);
          if (!empty($resultCss[$typeFind]['content'])) {
            $explodedData = $resultCss[$typeFind]['content'];
            $notificationIcon = str_replace(array("\"", '\\'), "", $explodedData);
          } else {
            $notificationIcon = "f0e5";
          }
        }
        //commented liked _like
        if (strpos($notification->type, 'commented') !== false || strpos($notification->type, 'liked') !== false || strpos($notification->type, '_like') !== false || strpos($notification->type, '_reacted_') !== false)
          $isCommentLike = true;
        else
          $isCommentLike = false;
        $result['notification'][$counterLoop] = array('notification_id' => $notification->getIdentity(), 'object_id' => $notification->object_id, 'subject_id' => $notification->subject_id, 'notification_icon' => $notificationIcon, 'title' => strip_tags($title), 'body' => '', 'user_image' => $image, 'href' => $href, 'object_type' => $notification->object_type, 'read' => $notification->read, 'date' => strip_tags((($notification->date))), 'isCommentLike' => $isCommentLike);

        if (!empty($memberEnable)) {
          //mutual friends
          $mfriend = Engine_Api::_()->sesmember()->getMutualFriendCount($subject, $viewer);
          if (!$subject->isSelf($viewer) && $mfriend) {
            $result['notification'][$counterLoop]['mutualFriends'] = $mfriend == 1 ? $mfriend . $this->view->translate(" mutual friend") : $mfriend . $this->view->translate(" mutual friends");
          }
        }

        // for activity and core comment like notifications
        if ($notification->object_type == "activity_comment" || $notification->object_type == "core_comment") {
          $nitiItem = Engine_Api::_()->getItem($notification->object_type, $notification->object_id);
          if ($nitiItem) {
            $result['notification'][$counterLoop]['object_id'] = $nitiItem->resource_id;
            $result['notification'][$counterLoop]['object_type'] = 'activity_action';
            $result['notification'][$counterLoop]['isCommentLike'] = true;
          } else {
            continue;
          }
        }

        if ($notification->type == "sesadvancedactivity_tagged_people" && $notification->params != "") {
          if (isset($notification->params['postLink'])) {
            $content = $notification->params['postLink'];
            if (strpos($content, '<a ') !== false && strpos($content, 'action_id') !== false) {
              $a = new SimpleXMLElement($content);
              $result['notification'][$counterLoop]['object_id'] = (int) end(explode('/', $a['href']));
              $result['notification'][$counterLoop]['object_type']  = 'activity_action';
              $result['notification'][$counterLoop]['href']  = Engine_Api::_()->sesapi()->getBaseUrl('', $a['href']);
            }
          }
        }

        if ($notification->object_type == "album_photo") {
          $objectItem = $this->view->item($notification->object_type, $notification->object_id);
          $result['notification'][$counterLoop]['photo_image'] = $this->getBaseUrl('', $objectItem->getPhotoUrl());
          $result['notification'][$counterLoop]['album_id'] = $objectItem->album_id;
        }

        // for live streaming.
        if ($notification->type == "elivestreaming_golive" && $notification->params != "") {
          $result['notification'][$counterLoop]['activity_action_id'] = $notification->params['activity_action_id'];
          $result['notification'][$counterLoop]['host_id'] = $notification->params['host_id'];
        }

        $counterLoop++;
      } catch (Exception $e) {
      }
    }
    $extraParams['pagging']['total_page'] = $notifications->getPages()->pageCount;
    $extraParams['pagging']['current_page'] = $notifications->getCurrentPageNumber();
    $extraParams['pagging']['next_page'] = $extraParams['pagging']['current_page'] + 1;
    if ($result <= 0)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => 'You have no new updates.', 'result' => array()));
    else {
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array_merge(array('error' => '0', 'error_message' => '', 'result' => $result), $extraParams));
    }
  }

  public function followAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $error = 0;
    $message = '';

    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($item_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $item_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      $error = 1;
    }

    $viewer_id = $viewer->getIdentity();
    $itemTable = Engine_Api::_()->getItemTable('user');
    $userInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($item_id);
    $tableFollow = Engine_Api::_()->getDbtable('follows', 'sesmember');
    $tableMainFollow = $tableFollow->info('name');

    $select = $tableFollow->select()
      ->from($tableMainFollow)
      ->where('resource_id = ?', $viewer_id)
      ->where('user_id = ?', $item_id);
    $result = $tableFollow->fetchRow($select);

    if (count($result) > 0) {
      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $userInfoItem->follow_count--;
        $userInfoItem->save();
        //$itemTable->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('user_id = ?' => $item_id));
        $db->commit();

        $user = Engine_Api::_()->getItem('user', $item_id);
        //Unfollow notification Work: Delete follow notification and feed
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "sesmember_follow", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $user->getType(), "object_id = ?" => $user->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => "sesmember_follow", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $user->getType(), "object_id = ?" => $user->getIdentity()));
      } catch (Exception $e) {
        $db->rollBack();
        Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $e->getMessage(), 'result' => array()));
      }
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('follows', 'sesmember')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = $tableFollow->createRow();
        $follow->resource_id = $viewer_id;
        $follow->user_id = $item_id;
        $follow->save();
        $userInfoItem->follow_count++;
        $userInfoItem->save();
        //$itemTable->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('user_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $e->getMessage(), 'result' => array()));
      }
      //Send notification and activity feed work.
      $selectUser = $itemTable->select()->where('user_id =?', $item_id);
      $item = $itemTable->fetchRow($selectUser);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer_id) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'sesmember_follow', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'sesmember_follow');
        $result = $activityTable->fetchRow(array('type =?' => 'sesmember_follow', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesmember_follow');
        }
        //follow mail to another user
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->email, 'sesmember_follow', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
    }

    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
  }

  public function addAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $error = 0;
    $message = '';

    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($user_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $user_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      $error = 1;
    }

    // check that user is not trying to befriend 'self'
    if ($viewer->isSelf($user)) {
      $message = Zend_Registry::get('Zend_Translate')->_('You cannot befriend yourself.');
      $error = 1;
    }

    // check that user is already friends with the member
    if ($user->membership()->isMember($viewer)) {
      $message = Zend_Registry::get('Zend_Translate')->_('You are already friends with this member.');
      $error = 1;
    }

    // check that user has not blocked the member
    if ($viewer->isBlocked($user)) {
      $message = Zend_Registry::get('Zend_Translate')->_('Friendship request was not sent because you blocked this member.');
      $error = 1;
    }

    // Make form
    $this->view->form = $form = new User_Form_Friends_Add(array('user' => $user));

    if (!$this->getRequest()->isPost()) {
      $message = Zend_Registry::get('Zend_Translate')->_('No action taken');
      $error = 1;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $message = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      $error = 1;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
    $db->beginTransaction();

    try {
      // send request
      $user->membership()
        ->addMember($viewer)
        ->setUserApproved($viewer);

      if (!$viewer->membership()->isUserApprovalRequired() && !$viewer->membership()->isReciprocal()) {
        // if one way friendship and verification not required

        // Add activity
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($viewer, $user, 'friends_follow', '{item:$subject} is now following {item:$object}.');

        // Add notification
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $viewer, 'friend_follow');

        $message = Zend_Registry::get('Zend_Translate')->_("You are now following this member.");
      } else if (!$viewer->membership()->isUserApprovalRequired() && $viewer->membership()->isReciprocal()) {
        // if two way friendship and verification not required

        // Add activity
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($user, $viewer, 'friends', '{item:$object} is now friends with {item:$subject}.');
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($viewer, $user, 'friends', '{item:$object} is now friends with {item:$subject}.');

        // Add notification
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $user, 'friend_accepted');

        $message = Zend_Registry::get('Zend_Translate')->_("You are now friends with this member.");
      } else if (!$user->membership()->isReciprocal()) {
        // if one way friendship and verification required

        // Add notification
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $user, 'friend_follow_request');

        $message = Zend_Registry::get('Zend_Translate')->_("Your friend request has been sent.");
      } else if ($user->membership()->isReciprocal()) {
        // if two way friendship and verification required

        // Add notification
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $user, 'friend_request');

        $message = Zend_Registry::get('Zend_Translate')->_("Your friend request has been sent.");
      }
      $error = 0;
      $db->commit();
      $this->view->status = true;
    } catch (Exception $e) {
      $db->rollBack();
      $message = Zend_Registry::get('Zend_Translate')->_($e->getMessage());
      $error = 1;
    }

    if ($error)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    else if ($this->_getParam('guttermenu')) {
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $message));
    } else
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
  }
  public function memberResult($member)
  {
    $result = array();
    $counterLoop = 0;
    $image = $this->_getParam('image', '');
    $result['member']['user_id'] = $member->getIdentity();
    $result['member']['title'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $member->getTitle());
    $viewer = Engine_Api::_()->user()->getViewer();
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember')) {
      $memberEnable = true;
    }
    //$age = $this->userAge($member);
    //if($age){
    //$result['member'][$counterLoop]['age'] =  $age ;
    //}
    //user location
    if (!empty($member->location) && !empty($memberEnable))
      $result['member']['location'] =   $member->location;

    if (!empty($memberEnable)) {
      //mutual friends
      $mfriend = Engine_Api::_()->sesmember()->getMutualFriendCount($member, $viewer);
      if (!$member->isSelf($viewer)) {
        $result['member']['mutualFriends'] = $mfriend == 1 ? $mfriend . $this->view->translate(" mutual friend") : $mfriend . $this->view->translate(" mutual friends");
      }
    }
    $followActive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active', 1);
    if ($followActive) {
      $unfollowText = $this->view->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext', 'Unfollow'));
      $followText = $this->view->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext', 'Follow'));
    }
    //follow
    if (!empty($memberEnable) && $followActive && $viewer->getIdentity() && $viewer->getIdentity() != $member->getIdentity()) {
      $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($member->user_id);
      if (!$FollowUser) {
        $result['member']['follow']['action'] = 'follow';
        $result['member']['follow']['text'] = $followText;
      } else {
        $result['member']['follow']['action'] = 'unfollow';
        $result['member']['follow']['text'] = $unfollowText;
      }
    }
    $result['member']['user_image'] = $this->userImage($member->getIdentity(), "thumb.profile");
    $result['member']['membership'] = $this->friendRequest($member);
    if ($image)
      $result['member']["image"] = $image;
    return $result;
  }
  public function friendRequest($subject)
  {

    $viewer = Engine_Api::_()->user()->getViewer();

    // Not logged in
    if (!$viewer->getIdentity() || $viewer->getGuid(false) === $subject->getGuid(false)) {
      return "";
    }

    // No blocked
    if ($viewer->isBlockedBy($subject)) {
      return "";
    }

    // Check if friendship is allowed in the network
    $eligible = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.eligible', 2);
    if (!$eligible) {
      return '';
    }

    // check admin level setting if you can befriend people in your network
    else if ($eligible == 1) {

      $networkMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $networkMembershipName = $networkMembershipTable->info('name');

      $select = new Zend_Db_Select($networkMembershipTable->getAdapter());
      $select
        ->from($networkMembershipName, 'user_id')
        ->join($networkMembershipName, "`{$networkMembershipName}`.`resource_id`=`{$networkMembershipName}_2`.resource_id", null)
        ->where("`{$networkMembershipName}`.user_id = ?", $viewer->getIdentity())
        ->where("`{$networkMembershipName}_2`.user_id = ?", $subject->getIdentity());

      $data = $select->query()->fetch();

      if (empty($data)) {
        return '';
      }
    }

    // One-way mode
    $direction = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction', 1);
    if (!$direction) {
      $viewerRow = $viewer->membership()->getRow($subject);
      $subjectRow = $subject->membership()->getRow($viewer);
      $params = array();

      // Viewer?
      if (null === $subjectRow) {
        // Follow
        return array(
          'label' => $this->view->translate('Follow'),
          'action' => 'add',
          'icon' => $this->getBaseUrl(true, 'application/modules/User/externals/images/friends/add.png'),
        );
      } else if ($subjectRow->resource_approved == 0) {
        // Cancel follow request
        return array(
          'label' => $this->view->translate('Cancel Request'),
          'action' => 'cancel',
          'icon' => $this->getBaseUrl(true, 'application/modules/User/externals/images/friends/remove.png'),
        );
      } else {
        // Unfollow
        return array(
          'label' => $this->view->translate('Unfollow'),
          'action' => 'remove',
          'icon' => $this->getBaseUrl(true, 'application/modules/User/externals/images/friends/remove.png'),
        );
      }
      // Subject?
      if (null === $viewerRow) {
        // Do nothing
      } else if ($viewerRow->resource_approved == 0) {
        // Approve follow request
        return array(
          'label' => $this->view->translate('Approve Request'),
          'action' => 'confirm',
          'icon' => $this->getBaseUrl(true, 'application/modules/User/externals/images/friends/add.png'),

        );
      } else {
        // Remove as follower?
        return array(
          'label' => $this->view->translate('Unfollow'),
          'action' => 'remove',
          'icon' => $this->getBaseUrl(true, 'application/modules/User/externals/images/friends/remove.png'),

        );
      }
      if (count($params) == 1) {
        return $params[0];
      } else if (count($params) == 0) {
        return "";
      } else {
        return $params;
      }
    }

    // Two-way mode
    else {

      $table =  Engine_Api::_()->getDbTable('membership', 'user');
      $select = $table->select()
        ->where('resource_id = ?', $viewer->getIdentity())
        ->where('user_id = ?', $subject->getIdentity());
      $select = $select->limit(1);
      $row = $table->fetchRow($select);

      if (null === $row) {
        // Add
        return array(
          'label' => $this->view->translate('Add Friend'),
          'icon' => $this->getBaseUrl() . 'application/modules/User/externals/images/friends/add.png',
          'action' => 'add',
        );
      } else if ($row->user_approved == 0) {
        // Cancel request
        return array(
          'label' => $this->view->translate('Cancel Friend'),
          'action' => 'cancel',
          'icon' => $this->getBaseUrl() . 'application/modules/User/externals/images/friends/remove.png',

        );
      } else if ($row->resource_approved == 0) {
        // Approve request
        return array(
          'label' => $this->view->translate('Approve Request'),
          'action' => 'confirm',
          'icon' => $this->getBaseUrl() . 'application/modules/User/externals/images/friends/add.png',

        );
      } else {
        // Remove friend
        return array(
          'label' => $this->view->translate('Remove Friend'),
          'action' => 'remove',
          'icon' => $this->getBaseUrl() . 'application/modules/User/externals/images/friends/remove.png',

        );
      }
    }
  }
  public function userAge($member)
  {
    $getFieldsObjectsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($member);
    if (!empty($getFieldsObjectsByAlias['birthdate'])) {
      $optionId = $getFieldsObjectsByAlias['birthdate']->getValue($member);
      if ($optionId && @$optionId->value) {
        $age = floor((time() - strtotime($optionId->value)) / 31556926);
        return $this->view->translate(array('%s year old', '%s years old', $age), $this->view->locale()->toNumber($age));
      }
    }
    return "";
  }
  public function confirmAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $error = 0;
    $message = '';
    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($user_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $user_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    }

    $friendship = $viewer->membership()->getRow($user);
    if ($friendship->active) {
      $message = Zend_Registry::get('Zend_Translate')->_('Already friends');
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    }

    // Process
    $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
    $db->beginTransaction();

    try {
      $viewer->membership()->setResourceApproved($user);

      // Add activity
      if (!$user->membership()->isReciprocal()) {
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($user, $viewer, 'friends_follow', '{item:$subject} is now following {item:$object}.');
      } else {
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($user, $viewer, 'friends', '{item:$object} is now friends with {item:$subject}.');
        Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($viewer, $user, 'friends', '{item:$object} is now friends with {item:$subject}.');
      }

      // Add notification
      if (!$user->membership()->isReciprocal()) {
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $user, 'friend_follow_accepted');
      } else {
        Engine_Api::_()->getDbtable('notifications', 'activity')
          ->addNotification($user, $viewer, $user, 'friend_accepted');
      }

      // Set the requests as handled
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_follow_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }

      // Increment friends counter
      Engine_Api::_()->getDbtable('statistics', 'core')->increment('user.friendships');

      $db->commit();
      $message = $this->view->translate('You are now friends with %s', $user->getTitle());
    } catch (Exception $e) {
      $db->rollBack();
      $message = $e->getMessage();
      $error = 1;
    }
    if ($error)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    else if ($this->_getParam("browse"))
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
    /* else
      Engine_Api::_()->getApi('response','sesapi')->sendResponse(array('error'=>'0','error_message'=>'', 'result' => $message));
    else if($this->_getParam('guttermenu')){
      return $this->_forward('gutter-menu', 'profile', 'user', array(
        'id' => $user_id,
        'out'=>true,
        'message' => $message
      ));
    }*/
    else
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $message));
  }

  public function rejectAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $error = 0;
    $message = '';

    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($user_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $user_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    }

    // Process
    $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
    $db->beginTransaction();

    try {
      if ($viewer->membership()->isMember($user)) {
        $viewer->membership()->removeMember($user);
      }

      // Set the request as handled
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_follow_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $db->commit();
      $message =  $this->view->translate('You ignored a friend request from %s', $user->getTitle());
    } catch (Exception $e) {
      $db->rollBack();
      $message = $e->getMessage();
      $error = 1;
      $this->view->exception = $e->__toString();
    }

    if ($error)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    else if ($this->_getParam("browse"))
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
    else
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $message));
  }

  public function ignoreAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $error = 0;
    $message = '';

    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($user_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $user_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      $error = 1;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
    $db->beginTransaction();

    try {
      $viewer->membership()->removeMember($user);

      // Set the requests as handled
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_follow_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $db->commit();
      $message = Zend_Registry::get('Zend_Translate')->_('You ignored %s\'s request to follow you', $user);
    } catch (Exception $e) {
      $db->rollBack();
      $message = Zend_Registry::get('Zend_Translate')->_('An error has occurred.');
      $error = 1;
      $this->view->exception = $e->__toString();
    }
    if ($error)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    else if ($this->_getParam("browse"))
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
    else
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $message));
  }

  public function removeAction()
  {
    if (!$this->_helper->requireUser()->isValid())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));

    $error = 0;
    $message = '';

    // Get viewer and other user
    $viewer = Engine_Api::_()->user()->getViewer();
    if (
      null == ($user_id = $this->_getParam('user_id')) ||
      null == ($user = Engine_Api::_()->getItem('user', $user_id))
    ) {
      $message = Zend_Registry::get('Zend_Translate')->_('No member specified');
      $error = 1;
    }

    // Process
    $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
    $db->beginTransaction();

    try {
      if ($this->_getParam('rev')) {
        $viewer->membership()->removeMember($user);
      } else {
        $user->membership()->removeMember($viewer);
      }

      // Remove from lists?
      // @todo make sure this works with one-way friendships
      $user->lists()->removeFriendFromLists($viewer);
      $viewer->lists()->removeFriendFromLists($user);

      // Set the requests as handled
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($user, $viewer, 'friend_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $notification = Engine_Api::_()->getDbtable('notifications', 'activity')
        ->getNotificationBySubjectAndType($viewer, $user, 'friend_follow_request');
      if ($notification) {
        $notification->mitigated = true;
        $notification->read = 1;
        $notification->save();
      }
      $db->commit();
      $message =  Zend_Registry::get('Zend_Translate')->_('This person has been removed from your friends.');
    } catch (Exception $e) {
      $db->rollBack();
      $message = $e->getMessage();
      $error = 1;
      $this->view->exception = $e->__toString();
    }
    if ($error)
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => $message, 'result' => array()));
    else if ($this->_getParam("browse"))
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $this->memberResult($user)));
    else
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $message));
  }
  public function suggestAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity())
      Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '1', 'error_message' => 'user_not_autheticate'));
    $data = array();
    $table = Engine_Api::_()->getItemTable('user');
    $usersAllowed = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', $viewer->level_id, 'auth');
    if ((bool) $this->_getParam('message') && $usersAllowed == "everyone") {
      $select = Engine_Api::_()->getDbtable('users', 'user')->select();
      $select->where('user_id <> ?', $viewer->user_id);
    } else
      $select = Engine_Api::_()->user()->getViewer()->membership()->getMembersObjectSelect();
    if ($this->_getParam('includeSelf', false)) {
      $data[] = array(
        'id' => $viewer->getIdentity(),
        'label' => $viewer->getTitle() . ' (you)',
        'photo' => $this->userImage($friend->getIdentity(), "thumb.icon"),
      );
    }
    if (0 < ($limit = (int) $this->_getParam('limit', 10)))
      $select->limit($limit);
    if (null !== ($text = $this->_getParam('search', $this->_getParam('value'))))
      $select->where('`' . $table->info('name') . '`.`displayname` LIKE ?', '%' . $text . '%');
    foreach ($select->getTable()->fetchAll($select) as $friend) {
      $data['friends'][] = array(
        'id'    => $friend->getIdentity(),
        'label' => $friend->getTitle(),
        'photo' => $this->userImage($friend->getIdentity()),
      );
    }
    Engine_Api::_()->getApi('response', 'sesapi')->sendResponse(array('error' => '0', 'error_message' => '', 'result' => $data));
  }
}
