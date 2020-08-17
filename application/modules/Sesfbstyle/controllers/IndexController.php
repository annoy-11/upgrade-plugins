<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }

  public function removerecentloginAction() {

    $user_id = $this->_getParam('user_id', null);
    if(empty($user_id))
        return;
    $recent_login = Zend_Json::decode($_COOKIE['ses_login_users']);
    if(count($recent_login) > 0) {
        unset($recent_login['userid_'.$user_id]);
        $cookie_value = Zend_Json::encode($recent_login);
        setcookie('ses_login_users', $cookie_value, time() + 86400, '/');
    } else {
        setcookie('ses_login_users', '', time() + 86400, '/');
    }
  }

  public function poploginfbAction()
  {
    $id = $this->_getParam('user_id');
    $type=$this->_getParam('type',false);
    if($type)
    {
      $_SESSION['popupuserid']=$id;
      $this->_redirect('logout');
    }
    $cookies = Zend_Json::decode($_COOKIE['ses_login_users']);
   if(isset($cookies['userid_'.$id]) && !empty($cookies['userid_'.$id]))
   {
     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
     $this->view->user=Engine_Api::_()->getItem('user', $id);
     $this->view->user_id =$id;
   }
   else
   {
     $this->_redirect('login');
     exit();
   }
  }

  public function loginAction() {
    $id = $this->_getParam('user_id');
    $password = $this->_getParam('password', null);
   // $isValidPassword = Engine_Api::_()->user()->checkCredential($id, $password);
    if(empty($password))
        return;
   // $checkUser = Engine_Api::_()->sesfbstyle()->checkUser($password, $id);
    $user = Engine_Api::_()->getItem('user', $id);
    if(Engine_Api::_()->user()->checkCredential($id, $password, $user) && $user->getIdentity() == $id) {

	    // @todo change this to look up actual superadmin level
	    if (!$this->getRequest()->isPost()) {
	      if (null === $this->_helper->contextSwitch->getCurrentContext()) {
	        return $this->_helper->redirector->gotoRoute(array('action' => 'index', 'id' => null));
	      } else {
	        $this->view->status = false;
	        $this->view->error = true;
	        return;
	      }
	    }

	    // Login
	    Zend_Auth::getInstance()->getStorage()->write($user->getIdentity());

	    // Redirect
	    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
	      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
	    } else {
	      $this->view->status = true;
	      return;
	    }
    }
    $this->view->status=false;
    return;
  }

  public function languageAction(){
    $this->view->identity = $this->_getParam('identity',0);
    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if (!in_array($defaultLanguage, $languageList)) {
      if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

    foreach ($languageList as $localeCode) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if (false !== strpos($localeCode, '_')) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if (isset($territoryDataList[$territory])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if (isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }
    $languageNameList = array_merge(array(
        $defaultLanguage => $defaultLanguage
            ), $languageNameList);
    $this->view->languageNameList = $languageNameList;
  }
  public function searchAction() {

    $text = $this->_getParam('text', null);
    $select = Engine_Api::_()->getDbtable('search', 'core')->select()
              ->where('title LIKE ? OR description LIKE ? OR keywords LIKE ? OR hidden LIKE ?', '%' . $text . '%')
              ->order('id DESC')
              ->limit('10');
    $results = Zend_Paginator::factory($select);

    foreach ($results as $result) {
      $itemType = $result->type;
      if (Engine_Api::_()->hasItemType($itemType)) {
        if ($itemType == 'sesblog')
          continue;
        $item = Engine_Api::_()->getItem($itemType, $result->id);
        $item_type = ucfirst($item->getShortType());
        $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
        $data[] = array(
            'id' => $result->id,
            'label' => $item->getTitle(),
            'photo' => $photo_icon_photo,
            'url' => $item->getHref(),
            'resource_type' => $item_type,
        );
      }
    }
    $data[] = array(
        'id' => 'show_all',
        'label' => $text,
        'url' => 'all',
        'resource_type' => '',
    );
    return $this->_helper->json($data);
  }

  public function friendshipRequestsAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->friendRequests = $newFriendRequests = Engine_Api::_()->getDbtable('notifications', 'sesfbstyle')->getFriendrequestPaginator($viewer);
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesfbstyle')->setUnreadFriendRequest($viewer);

    //People You May Know work
    $userIDS = $viewer->membership()->getMembershipsOfIds();
    $userMembershipTable = Engine_Api::_()->getDbtable('membership', 'user');
    $userMembershipTableName = $userMembershipTable->info('name');
    $select_membership = $userMembershipTable->select()
            ->where('resource_id = ?', $viewer->getIdentity());
    $member_results = $userMembershipTable->fetchAll($select_membership);
    $membershipIDS = array();
    foreach($member_results as $member_result) {
      $membershipIDS[] = $member_result->user_id;
    }
    if(count($membershipIDS)) {
    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $userTableName = $userTable->info('name');
    $select = $userTable->select()
            ->where('user_id <> ?', $viewer->getIdentity())
            ->where('user_id NOT IN (?)', $membershipIDS)
            ->order('user_id DESC');
    $this->view->peopleyoumayknow = $peopleyoumayknow = Zend_Paginator::factory($select);
    $peopleyoumayknow->setCurrentPageNumber($this->_getParam('page'));
    } else {
      $this->view->peopleyoumayknow = 0;
    }
    //People You may know work

  }

  public function newUpdatesAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
  }

  public function newFriendRequestsAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
  }

  public function newMessagesAction() {
    $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesfbstyle')->getMessagesUnreadCount(Engine_Api::_()->user()->getViewer());
  }

  public function markallmessageAction() {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    Engine_Api::_()->getDbtable('recipients', 'messages')->update(array('ariana_read' => 1,  'inbox_read' => 1), array('`user_id` = ?' => $viewer_id));

  }

  public function deleteMessageAction() {

    $message_id = $this->getRequest()->getParam('id');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      $recipients = Engine_Api::_()->getItem('messages_conversation', $message_id)->getRecipientsInfo();
      foreach ($recipients as $r) {
        if ($viewer_id == $r->user_id) {
          $this->view->deleted_conversation_ids[] = $r->conversation_id;
          $r->inbox_deleted = true;
          $r->outbox_deleted = true;
          $r->save();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
  }


  public function inboxAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('messages_conversation')->getInboxPaginator($viewer);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesfbstyle')->setUnreadMessage($viewer);
  }
}
