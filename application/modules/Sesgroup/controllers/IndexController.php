<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_IndexController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesgroup_group', null, 'view')->isValid())
      return;
  }

  public function claimAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    if( !$this->_helper->requireUser()->isValid() ) return;
    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'auth_claim'))
    return $this->_forward('requireauth', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction() {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesgroup')->claimCount();
    if(!$checkClaimRequest)
      return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function getGroupsAction() {
    $sesdata = array();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $groupTable = Engine_Api::_()->getDbtable('groups', 'sesgroup');
    $groupTableName = $groupTable->info('name');

    $groupClaimTable = Engine_Api::_()->getDbtable('claims', 'sesgroup');
    $groupClaimTableName = $groupClaimTable->info('name');
    $text = $this->_getParam('text', null);
    $selectClaimTable = $groupClaimTable->select()
                                  ->from($groupClaimTableName, 'group_id')
                                  ->where('user_id =?', $viewerId);
    $claimedGroups = $groupClaimTable->fetchAll($selectClaimTable);

    $currentTime = date('Y-m-d H:i:s');
    $select = $groupTable->select()
                  ->where('draft =?', 1)
                  ->where('owner_id !=?', $viewerId)
                  ->where($groupTableName .'.title  LIKE ? ', '%' .$text. '%');
    if(count($claimedGroups) > 0)
  $select->where('group_id NOT IN(?)', $selectClaimTable);
    $select->order('group_id ASC')->limit('40');
    $groups = $groupTable->fetchAll($select);
    foreach ($groups as $group) {
        $group_icon_photo = $this->view->itemPhoto($group, 'thumb.icon');
        $sesdata[] = array(
        'id' => $group->group_id,
        'label' => $group->title,
        'photo' => $group_icon_photo
        );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeAsGroupAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $id);
    $group_id = $this->_getParam('group_id');
    $table = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('group_id !=?', $group->getIdentity())
            ->where('group_id NOT IN (SELECT group_id FROM engine4_sesgroup_likegroups WHERE like_group_id = ' . $group->group_id . ")");
    $this->view->myGroups = ($table->fetchAll($selelct));
    if ($group_id) {
      $table = Engine_Api::_()->getDbTable('likegroups', 'sesgroup');
      $row = $table->createRow();
      $row->group_id = $group_id;
      $row->like_group_id = $group->group_id;
      $row->user_id = $viewer->getIdentity();
      $row->save();
      echo 1;
      die;
    }
  }

  public function unlikeAsGroupAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $id);
    $group_id = $this->_getParam('group_id');
    $table = Engine_Api::_()->getDbTable('grouproles', 'sesgroup');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('group_id !=?', $group->getIdentity())
            ->where('group_id IN (SELECT group_id FROM engine4_sesgroup_likegroups WHERE like_group_id = ' . $group->group_id . ")");
    $this->view->myGroups = ($table->fetchAll($selelct));
    if ($group_id) {
      $table = Engine_Api::_()->getDbTable('likegroups', 'sesgroup');
      $select = $table->select()->where('group_id =?', $group_id)->where('like_group_id =?', $group->getIdentity());
      $row = $table->fetchRow($select);
      if ($row)
        $row->delete();
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

  function getMembershipGroupAction() {
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    $group = Engine_Api::_()->getItem('sesgroup_group', $this->_getParam('group_id'));
    if (!($group)) {
      echo 0;
      die;
    }
    $table = $group->membership()->getTable();
    $membershipSelect = $table->select()->where('user_id =?', $viewer->getIdentity())->where('resource_approved =?', 1)->where('resource_id !=?', $group->getIdentity());
    $res = Engine_Api::_()->getItemTable('sesgroup_group')->fetchAll($membershipSelect);
    if (!count($res)) {
      echo 0;
      die;
    }
    $groups = array();
    foreach ($res as $item) {
      $groups[] = $item->resource_id;
    }
    $select = Engine_Api::_()->getItemTable('sesgroup_group')->select()->where('group_id IN(?)', $groups);
    $this->view->result = Engine_Api::_()->getItemTable('sesgroup_group')->fetchAll($select);
    if (!count($this->view->result)) {
      echo 0;
      die;
    }
  }

  public function suggestGroupAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      $data = null;
    } else {
      $data = array();
      $table = Engine_Api::_()->getItemTable('sesgroup_group');

      $select = $table->select()->where('search = ?', 1)->where('draft =?', 1);
      if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
        $select->where('`' . $table->info('name') . '`.`title` LIKE ?', '%' . $text . '%');
      }

      if (0 < ($limit = (int) $this->_getParam('limit', 10))) {
        $select->limit($limit);
      }
      foreach ($select->getTable()->fetchAll($select) as $group) {
        $data[] = array(
            'type' => 'sesgroup_group',
            'id' => $group->getIdentity(),
            'guid' => $group->getGuid(),
            'label' => $group->getTitle(),
            'photo' => $this->view->itemPhoto($group, 'thumb.icon'),
            'url' => $group->getHref(),
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
    $group_guid = $this->_getParam('group_id', 0);
    if (!$group_guid)
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->sesgroup = $sesgroup = Engine_Api::_()->getItemByGuid($group_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sesgroup, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->callAction = Engine_Api::_()->getDbTable('callactions', 'sesgroup')->getCallactions(array('group_id' => $sesgroup->getIdentity()));
  }

  function removeCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $page_guid = $this->_getParam('page', 0);
    $sesgroup = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$page_guid) {
      echo 0;
      die;
    }
    if (!$this->_helper->requireAuth()->setAuthParams($sesgroup, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');
    $canCall = Engine_Api::_()->getDbTable('callactions', 'sesgroup')->getCallactions(array('group_id' => $sesgroup->getIdentity()));
    $canCall->delete();
    echo 1;
    die;
  }

  function saveCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $group_guid = $this->_getParam('page', 0);
    $fieldValue = $this->_getParam('fieldValue', 0);
    $checkboxVal = $this->_getParam('checkboxVal', 0);
    if (!$group_guid) {
      echo 0;
      die;
    }

    $sesgroup = Engine_Api::_()->getItemByGuid($group_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sesgroup, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $canCall = Engine_Api::_()->getDbTable('callactions', 'sesgroup')->getCallactions(array('group_id' => $sesgroup->getIdentity()));
    if ($canCall) {
      $canCall->type = $checkboxVal;
      $canCall->params = $fieldValue;
      $canCall->save();
      echo 1;
      die;
    } else {
      $table = Engine_Api::_()->getDbTable('callactions', 'sesgroup');
      $res = $table->createRow();
      $res->type = $checkboxVal;
      $res->params = $fieldValue;
      $res->group_id = $sesgroup->getIdentity();
      $res->creation_date = date('Y-m-d H:i:s');
      $res->user_id = $this->view->viewer()->getIdentity();
      $res->save();
      echo 1;
      die;
    }
  }

  public function contactAction() {
    $ownerId[] = $this->_getParam('owner_id', $this->_getParam('group_owner_id', 0));
    $this->view->form = $form = new Sesgroup_Form_ContactOwner();
    $form->group_owner_id->setValue($this->_getParam('owner_id', $this->_getParam('group_owner_id', 0)));
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

      if ($values['group_owner_id'] != $viewer->getIdentity()) {

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

  public function mapmarkercontentAction() {
    $group_id = $this->_getParam('group_id', null);
    $this->view->resource = $resource = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    $this->view->results = Engine_Api::_()->getDbTable('locations', 'sesgroup')->getGroupLocationSelect(array('group_id' => $resource->group_id, 'content' => 1));
  }

  public function browseLocationsAction() {
    $sesgroup_sesgrouplocation = Zend_Registry::isRegistered('sesgroup_sesgrouplocation') ? Zend_Registry::get('sesgroup_sesgrouplocation') : null;
    if(!empty($sesgroup_sesgrouplocation)) {
      //Render
      $this->_helper->content->setEnabled();
    }
  }

  public function browseAction() {
    //Render
    $sesgroup_sesgroupbrowse = Zend_Registry::isRegistered('sesgroup_sesgroupbrowse') ? Zend_Registry::get('sesgroup_sesgroupbrowse') : null;
    if(!empty($sesgroup_sesgroupbrowse)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function packageAction() {
    if (!$this->_helper->requireUser->isValid())return;
    $this->view->viewer = $viewer = $this->view->viewer();
    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sesgrouppackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));
    $this->_helper->content->setEnabled();
  }

  public function transactionsAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $tableTransaction = Engine_Api::_()->getItemTable('sesgrouppackage_transaction');
    $tableTransactionName = $tableTransaction->info('name');
    $groupTable = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    $groupTableName = $groupTable->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableTransaction->select()
            ->setIntegrityCheck(false)
            ->from($tableTransactionName)
            ->joinLeft($tableUserName, "$tableTransactionName.owner_id = $tableUserName.user_id", 'username')
            ->where($tableUserName . '.user_id IS NOT NULL')
            ->joinLeft($groupTableName, "$tableTransactionName.transaction_id = $groupTableName.transaction_id", 'group_id')
            ->where($groupTableName . '.group_id IS NOT NULL')
            ->where($tableTransactionName . '.owner_id =?', $viewer->getIdentity());
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    $this->_helper->content->setEnabled();
  }

  public function pinboardAction() {
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

  public function localpickAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function welcomeAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function homeAction() {
    //Render
    $sesgroup_sesgrouphome = Zend_Registry::isRegistered('sesgroup_sesgrouphome') ? Zend_Registry::get('sesgroup_sesgrouphome') : null;
    if(!empty($sesgroup_sesgrouphome)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function tagsAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function manageAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;

    // Render
    $this->_helper->content->setEnabled();

    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesgroup', null, 'create')->checkRequire();
  }

  public function sesbackuplandingpgroupAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function createAction() {

    if (!$this->_helper->requireUser->isValid())
      return;

    if (!$this->_helper->requireAuth()->setAuthParams('sesgroup_group', null, 'create')->isValid())
      return;

    $viewer = $this->view->viewer();
    //Start sub group creation privacy check work
    $this->view->parent_id = $parentId = $this->_getParam('parent_id', 0);
    $subGroupCreatePemission = false;
    if ($parentId) {
      $subject = Engine_Api::_()->getItem('sesgroup_group', $parentId);
      if ($subject) {
        if ((!Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'auth_subgroup') || $subject->parent_id)) {
          return $this->_forward('notfound', 'error', 'core');
        $subGroupCreatePemission = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_group');
        if (!$subGroupCreatePemission)
          return $this->_forward('notfound', 'error', 'core');
        }
      }
    }
    //End work here

    //Start Package Work
    if (SESGROUPPACKAGE == 1) {
      $package = Engine_Api::_()->getItem('sesgrouppackage_package', $this->_getParam('package_id', 0));
      $existingpackage = Engine_Api::_()->getItem('sesgrouppackage_orderspackage', $this->_getParam('existing_package_id', 0));
      if ($existingpackage) {
        $package = Engine_Api::_()->getItem('sesgrouppackage_package', $existingpackage->package_id);
      }
      if (!$package && !$existingpackage) {
        //check package exists for this member level
        $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sesgrouppackage')->getPackage(array('member_level' => $viewer->level_id));
        if (count($packageMemberLevel)) {
          //redirect to package group
          return $this->_helper->redirector->gotoRoute(array('action' => 'group'), 'sesgrouppackage_general', true);
        }
      }
      if ($existingpackage) {
        $canCreate = Engine_Api::_()->getDbTable('Orderspackages', 'sesgrouppackage')->checkUserPackage($this->_getParam('existing_package_id', 0), $viewer->getIdentity());
        if (!$canCreate)
          return $this->_helper->redirector->gotoRoute(array('action' => 'group'), 'sesgrouppackage_general', true);
      }
    }
    //End Package Work

    $quckCreate = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('sesgroup.category.selection', 0) && $settings->getSetting('sesgroup.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;

    $totalGroup = Engine_Api::_()->getDbTable('groups', 'sesgroup')->countGroups($viewer->getIdentity());
    $allowGroupCount = Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_count');
    $this->view->widget_id = $widget_id = $this->_getParam('widget_id', 0);
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
    if ($totalGroup >= $allowGroupCount && $allowGroupCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.category.selection', 0)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getCategory(array('fetchAll' => true));
      }
      $this->view->defaultProfileId = 1;
      $sesgroup_sesgroupcreate = Zend_Registry::isRegistered('sesgroup_sesgroupcreate') ? Zend_Registry::get('sesgroup_sesgroupcreate') : null;
      if(!empty($sesgroup_sesgroupcreate)) {
        $this->view->form = $form = new Sesgroup_Form_Create(array(
            'defaultProfileId' => 1,
            'smoothboxType' => $sessmoothbox,
        ));
      }
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
      $custom_url = Engine_Api::_()->sesbasic()->checkBannedWord($_POST['custom_url'],"");
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url not available.Please select other."));
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
    if (!$quckCreate && $settings->getSetting('sesgroup.groupmainphoto', 1)) {
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
      $values['approval'] = $settings->getSetting('sesgroup.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sesgroup.default.approvaloption', 1) ? 0 : 1;

    $groupTable = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    $db = $groupTable->getAdapter();
    $db->beginTransaction();
    try {
      // Create group
      $group = $groupTable->createRow();

      if (!$quckCreate && empty($_POST['lat'])) {
        unset($values['location']);
        unset($values['lat']);
        unset($values['lng']);
        unset($values['venue_name']);
      }

      $sesgroup_draft = $settings->getSetting('sesgroup.draft', 1);
      if (empty($sesgroup_draft)) {
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

      if (isset($package)) {
        $values['package_id'] = $package->getIdentity();
        if ($package->isFree()) {
          if (isset($params['group_approve']) && $params['group_approve'])
            $values['is_approved'] = 1;
        } else
          $values['is_approved'] = 0;
        if ($existingpackage) {
          $values['existing_package_order'] = $existingpackage->getIdentity();
          $values['orderspackage_id'] = $existingpackage->getIdentity();
          $existingpackage->item_count = $existingpackage->item_count - 1;
          $existingpackage->save();
          $params = json_decode($package->params, true);
          if (isset($params['group_approve']) && $params['group_approve'])
            $values['is_approved'] = 1;
          if (isset($params['group_featured']) && $params['group_featured'])
            $values['featured'] = 1;
          if (isset($params['group_sponsored']) && $params['group_sponsored'])
            $values['sponsored'] = 1;
          if (isset($params['group_verified']) && $params['group_verified'])
            $values['verified'] = 1;
          if (isset($params['group_hot']) && $params['group_hot'])
            $values['hot'] = 1;
        }
      } else {
        if (!isset($package) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage')) {
          $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'sesgrouppackage')->getDefaultPackage();
        }
      }

      $group->setFromArray($values);
      if(!isset($values['search']))
      $group->search = 1;
      else
      $group->search = $values['search'];

      if (isset($_POST['sesgroup_title'])) {
        $group->title = $_POST['sesgroup_title'];
        $group->category_id = $_POST['category_id'];
        if (isset($_POST['subcat_id']))
          $group->category_id = $_POST['category_id'];
        if (isset($_POST['subsubcat_id']))
          $group->category_id = $_POST['category_id'];
      }
      $group->parent_id = $parentId;
      if (!isset($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      $group->view_privacy = $values['auth_view'];
      $group->save();

      //Start Default Package Order Work
      if (isset($package) && $package->isFree()) {
        if (!$existingpackage) {
          $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sesgrouppackage');
          $transactionsOrdersTable->insert(array(
              'owner_id' => $viewer->user_id,
              'item_count' => ($package->item_count - 1 ),
              'package_id' => $package->getIdentity(),
              'state' => 'active',
              'expiration_date' => '3000-00-00 00:00:00',
              'ip_address' => $_SERVER['REMOTE_ADDR'],
              'creation_date' => new Zend_Db_Expr('NOW()'),
              'modified_date' => new Zend_Db_Expr('NOW()'),
          ));
          $group->orderspackage_id = $transactionsOrdersTable->getAdapter()->lastInsertId();
          $group->existing_package_order = 0;
        } else {
          $existingpackage->item_count = $existingpackage->item_count--;
          $existingpackage->save();
        }
      }
      //End Default package Order Work

      if (!$quckCreate) {
        $tags = preg_split('/[,]+/', $values['tags']);
        $group->tags()->addTagMaps($viewer, $tags);
        $group->seo_keywords = implode(',', $tags);
        $group->save();
      }

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_sesgroup_locations (group_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $group->group_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $group->group_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "sesgroup_group")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
      }

      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_sesgroup_managegroupapps` (`group_id`) VALUES ("' . $group->group_id . '");');

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.auto.join', 1)) {
        $group->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }

      if (!isset($package)) {
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_approve'))
          $group->is_approved = 0;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_featured'))
          $group->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_sponsored'))
          $group->sponsored = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_verified'))
          $group->verified = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'group_hot'))
        $group->hot = 1;
      }

      // Add photo
      if (!empty($values['photo'])) {
        $group->setPhoto($form->photo, '', 'profile');
      }

      // Set auth
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
      $videoMax = array_search($values['auth_video'], $roles);
      
      $forumMax = array_search($values['auth_forum'], $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($group, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($group, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($group, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($group, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($group, $role, 'forum', ($i <= $forumMax));
      }
      if (!$quckCreate) {
        //Add fields
        $customfieldform = $form->getSubForm('fields');
        if ($customfieldform) {
          $customfieldform->setItem($group);
          $customfieldform->saveValues();
        }
      }
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $group->custom_url = $_POST['custom_url'];
      else
        $group->custom_url = $group->group_id;
      $group->save();
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.autoopenpopup', 1);
      if ($autoOpenSharePopup && $group->draft && $group->is_approved) {
        $_SESSION['newGroup'] = true;
      }
      //insert admin of group
      $groupRole = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->createRow();
      $groupRole->user_id = $this->view->viewer()->getIdentity();
      $groupRole->group_id = $group->getIdentity();
      $groupRole->memberrole_id = 1;
      $groupRole->save();

       if(!Engine_Api::_()->sesbasic()->isWordExist('sesgroup_group', $group->group_id, $_POST['custom_url'])) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
          'resource_type' => 'sesgroup_group',
          'resource_id' => $group->group_id,
          'word' => $_POST['custom_url'],
        ));
       }

      // Commit
      $db->commit();

      //Start Activity Feed Work
      if ($group->draft == 1 && $group->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $group, 'sesgroup_group_create');
        if ($action) {
          $activityApi->attachActivity($action, $group);
        }
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','sesgroup')->getCategoryFollowers($group->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','sesgroup')->getColumnName(array('category_id' => $group->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($group, $viewer, $user, 'sesgroup_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesgroup_follow_category', array('sender_title' => $group->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      //Start Send Approval Request to Admin
      if (!$group->is_approved) {
        if (isset($package) && $package->price > 0) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($group->getOwner(), $viewer, $group, 'sesgroup_payment_notify_group');
        } else {
          $getAdminnSuperAdmins = Engine_Api::_()->sesgroup()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $group, 'sesgroup_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesgroup_group_adminapproval', array('sender_title' => $group->getOwner()->getTitle(), 'adminmanage_link' => 'admin/sesgroup/manage', 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($group->getOwner(), 'notify_sesgroup_group_groupsentforapproval', array('group_title' => $group->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $group, 'sesgroup_waitingapproval');

        //Engine_Api::_()->sesgroup()->sendMailNotification(array('group' => $group));
      }
      //Send mail to all super admin and admins
      if ($group->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->sesgroup()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesgroup_group_superadmin', array('sender_title' => $group->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'notify_sesgroup_group_superadmin', array('sender_title' => $group->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      if (!empty($item)) {
        $tab = "";
        if ($widget_id)
          $tab = "/tab/" . $widget_id;
        header('location:' . $item->getHref() . $tab);
        die;
      }
      //End Work Here.
      $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.redirect', 1);
      if (!$group->is_approved) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sesgroup_general', true);
      }
      elseif ($redirection == 1) {
        header('location:' . $group->getHref());
        die;
      } else {
        return $this->_helper->redirector->gotoRoute(array('group_id' => $group->custom_url), 'sesgroup_dashboard', true);
      }
    } catch (Engine_Image_Exception $e) {
      $db->rollBack();
      $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function deleteAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;

    $sesgroup = Engine_Api::_()->getItem('sesgroup_group', $this->getRequest()->getParam('group_id'));

    if (!Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->toCheckUserGroupRole($this->view->viewer()->getIdentity(), $sesgroup->getIdentity(), 'manage_dashboard', 'delete'))
      if (!$this->_helper->requireAuth()->setAuthParams($sesgroup, null, 'delete')->isValid())
        return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesgroup_Form_Delete();

    if (!$sesgroup) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Group entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $sesgroup->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $sesgroup->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your group has been deleted successfully!');
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesgroup_general', true),
                'messages' => Array($this->view->message)
    ));
  }

  public function closeAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesgroup_Form_CloseGroup();
    // Not post/invalid
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $group = Engine_Api::_()->getItem('sesgroup_group', $this->getRequest()->getParam('group_id'));
    $group->status = !$group->status;
    $group->save();
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully closed this group.')
    ));
  }

  public function showQuestionFormAction() {
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesgroup_Form_QuestionForm();
  }

}
