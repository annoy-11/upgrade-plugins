<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_IndexController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('businesses', null, 'view')->isValid())
      return;
  }

  public function claimAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    if( !$this->_helper->requireUser()->isValid() ) return;
    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'auth_claim'))
    return $this->_forward('requireauth', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction() {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesbusiness')->claimCount();
    if(!$checkClaimRequest)
      return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function getBusinessesAction() {
    $sesdata = array();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $businessTable = Engine_Api::_()->getDbtable('businesses', 'sesbusiness');
    $businessTableName = $businessTable->info('name');

    $businessClaimTable = Engine_Api::_()->getDbtable('claims', 'sesbusiness');
    $businessClaimTableName = $businessClaimTable->info('name');
    $text = $this->_getParam('text', null);
    $selectClaimTable = $businessClaimTable->select()
                                  ->from($businessClaimTableName, 'business_id')
                                  ->where('user_id =?', $viewerId);
    $claimedBusinesses = $businessClaimTable->fetchAll($selectClaimTable);

    $currentTime = date('Y-m-d H:i:s');
    $select = $businessTable->select()
                  ->where('draft =?', 1)
                  ->where('owner_id !=?', $viewerId)
                  ->where($businessTableName .'.title  LIKE ? ', '%' .$text. '%');
    if(count($claimedBusinesses) > 0)
  $select->where('business_id NOT IN(?)', $selectClaimTable);
    $select->order('business_id ASC')->limit('40');
    $businesses = $businessTable->fetchAll($select);
    foreach ($businesses as $business) {
        $business_icon_photo = $this->view->itemPhoto($business, 'thumb.icon');
        $sesdata[] = array(
        'id' => $business->business_id,
        'label' => $business->title,
        'photo' => $business_icon_photo
        );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeAsBusinessAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->business = $business = Engine_Api::_()->getItem('businesses', $id);
    $business_id = $this->_getParam('business_id');
    $table = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('business_id !=?', $business->getIdentity())
            ->where('business_id NOT IN (SELECT business_id FROM engine4_sesbusiness_likebusinesses WHERE like_business_id = ' . $business->business_id . ")");
    $this->view->myBusinesses = ($table->fetchAll($selelct));
    if ($business_id) {
      $table = Engine_Api::_()->getDbTable('likebusinesses', 'sesbusiness');
      $row = $table->createRow();
      $row->business_id = $business_id;
      $row->like_business_id = $business->business_id;
      $row->user_id = $viewer->getIdentity();
      $row->save();
      echo 1;
      die;
    }
  }

  public function unlikeAsBusinessAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->business = $business = Engine_Api::_()->getItem('businesses', $id);
    $business_id = $this->_getParam('business_id');
    $table = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('business_id !=?', $business->getIdentity())
            ->where('business_id IN (SELECT business_id FROM engine4_sesbusiness_likebusinesses WHERE like_business_id = ' . $business->business_id . ")");
    $this->view->myBusinesses = ($table->fetchAll($selelct));
    if ($business_id) {
      $table = Engine_Api::_()->getDbTable('likebusinesses', 'sesbusiness');
      $select = $table->select()->where('business_id =?', $business_id)->where('like_business_id =?', $business->getIdentity());
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

  function getMembershipBusinessAction() {
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    $business = Engine_Api::_()->getItem('businesses', $this->_getParam('business_id'));
    if (!($business)) {
      echo 0;
      die;
    }
    $table = $business->membership()->getTable();
    $membershipSelect = $table->select()->where('user_id =?', $viewer->getIdentity())->where('resource_approved =?', 1)->where('resource_id !=?', $business->getIdentity());
    $res = Engine_Api::_()->getItemTable('businesses')->fetchAll($membershipSelect);
    if (!count($res)) {
      echo 0;
      die;
    }
    $businesses = array();
    foreach ($res as $item) {
      $businesses[] = $item->resource_id;
    }
    $select = Engine_Api::_()->getItemTable('businesses')->select()->where('business_id IN(?)', $businesses);
    $this->view->result = Engine_Api::_()->getItemTable('businesses')->fetchAll($select);
    if (!count($this->view->result)) {
      echo 0;
      die;
    }
  }

  public function suggestBusinessAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      $data = null;
    } else {
      $data = array();
      $table = Engine_Api::_()->getItemTable('businesses');

      $select = $table->select()->where('search = ?', 1)->where('draft =?', 1);
      if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
        $select->where('`' . $table->info('name') . '`.`title` LIKE ?', '%' . $text . '%');
      }

      if (0 < ($limit = (int) $this->_getParam('limit', 10))) {
        $select->limit($limit);
      }
      foreach ($select->getTable()->fetchAll($select) as $business) {
        $data[] = array(
            'type' => 'businesses',
            'id' => $business->getIdentity(),
            'guid' => $business->getGuid(),
            'label' => $business->getTitle(),
            'photo' => $this->view->itemPhoto($business, 'thumb.icon'),
            'url' => $business->getHref(),
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
    $business_guid = $this->_getParam('business_id', 0);
    if (!$business_guid)
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->sesbusiness = $sesbusiness = Engine_Api::_()->getItemByGuid($business_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sesbusiness, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->callAction = Engine_Api::_()->getDbTable('callactions', 'sesbusiness')->getCallactions(array('business_id' => $sesbusiness->getIdentity()));
  }

  function removeCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $page_guid = $this->_getParam('page', 0);
    $sesbusiness = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$page_guid) {
      echo 0;
      die;
    }
    if (!$this->_helper->requireAuth()->setAuthParams($sesbusiness, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');
    $canCall = Engine_Api::_()->getDbTable('callactions', 'sesbusiness')->getCallactions(array('business_id' => $sesbusiness->getIdentity()));
    $canCall->delete();
    echo 1;
    die;
  }

  function saveCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $business_guid = $this->_getParam('page', 0);
    $fieldValue = $this->_getParam('fieldValue', 0);
    $checkboxVal = $this->_getParam('checkboxVal', 0);
    if (!$business_guid) {
      echo 0;
      die;
    }

    $sesbusiness = Engine_Api::_()->getItemByGuid($business_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sesbusiness, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $canCall = Engine_Api::_()->getDbTable('callactions', 'sesbusiness')->getCallactions(array('business_id' => $sesbusiness->getIdentity()));
    if ($canCall) {
      $canCall->type = $checkboxVal;
      $canCall->params = $fieldValue;
      $canCall->save();
      echo 1;
      die;
    } else {
      $table = Engine_Api::_()->getDbTable('callactions', 'sesbusiness');
      $res = $table->createRow();
      $res->type = $checkboxVal;
      $res->params = $fieldValue;
      $res->business_id = $sesbusiness->getIdentity();
      $res->creation_date = date('Y-m-d H:i:s');
      $res->user_id = $this->view->viewer()->getIdentity();
      $res->save();
      echo 1;
      die;
    }
  }

  public function contactAction() {
    $ownerId[] = $this->_getParam('owner_id', $this->_getParam('business_owner_id', 0));
    $this->view->form = $form = new Sesbusiness_Form_ContactOwner();
    $form->business_owner_id->setValue($this->_getParam('owner_id', $this->_getParam('business_owner_id', 0)));
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

      if ($values['business_owner_id'] != $viewer->getIdentity()) {

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
    $business_id = $this->_getParam('business_id', null);
    $this->view->resource = $resource = Engine_Api::_()->getItem('businesses', $business_id);
    $this->view->results = Engine_Api::_()->getDbTable('locations', 'sesbusiness')->getBusinessLocationSelect(array('business_id' => $resource->business_id, 'content' => 1));
  }

  public function browseLocationsAction() {
    $sesbusiness_sesbusinesslocation = Zend_Registry::isRegistered('sesbusiness_sesbusinesslocation') ? Zend_Registry::get('sesbusiness_sesbusinesslocation') : null;
    if(!empty($sesbusiness_sesbusinesslocation)) {
      //Render
      $this->_helper->content->setEnabled();
    }
  }

  public function browseAction() {
    //Render
    $sesbusiness_sesbusinessbrowse = Zend_Registry::isRegistered('sesbusiness_sesbusinessbrowse') ? Zend_Registry::get('sesbusiness_sesbusinessbrowse') : null;
    if(!empty($sesbusiness_sesbusinessbrowse)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function packageAction() {
    if (!$this->_helper->requireUser->isValid())return;
    $this->view->viewer = $viewer = $this->view->viewer();
    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sesbusinesspackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));
    $this->_helper->content->setEnabled();
  }

  public function transactionsAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $tableTransaction = Engine_Api::_()->getItemTable('sesbusinesspackage_transaction');
    $tableTransactionName = $tableTransaction->info('name');
    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $businessTableName = $businessTable->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableTransaction->select()
            ->setIntegrityCheck(false)
            ->from($tableTransactionName)
            ->joinLeft($tableUserName, "$tableTransactionName.owner_id = $tableUserName.user_id", 'username')
            ->where($tableUserName . '.user_id IS NOT NULL')
            ->joinLeft($businessTableName, "$tableTransactionName.transaction_id = $businessTableName.transaction_id", 'business_id')
            ->where($businessTableName . '.business_id IS NOT NULL')
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
    $sesbusiness_sesbusinesshome = Zend_Registry::isRegistered('sesbusiness_sesbusinesshome') ? Zend_Registry::get('sesbusiness_sesbusinesshome') : null;
    if(!empty($sesbusiness_sesbusinesshome)) {
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

    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesbusiness', null, 'create')->checkRequire();
  }

  public function sesbackuplandingpbusinessAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function createAction() {

    if (!$this->_helper->requireUser->isValid())
      return;

    if (!$this->_helper->requireAuth()->setAuthParams('businesses', null, 'create')->isValid())
      return;

    $viewer = $this->view->viewer();
    //Start sub business creation privacy check work
    $this->view->parent_id = $parentId = $this->_getParam('parent_id', 0);
    $subBusinessCreatePemission = false;
    if ($parentId) {
      $subject = Engine_Api::_()->getItem('businesses', $parentId);
      if ($subject) {
        if ((!Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'auth_subbusiness') || $subject->parent_id)) {
          return $this->_forward('notfound', 'error', 'core');
        $subBusinessCreatePemission = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_business');
        if (!$subBusinessCreatePemission)
          return $this->_forward('notfound', 'error', 'core');
        }
      }
    }
    //End work here

    //Start Package Work
    if (SESBUSINESSPACKAGE == 1) {
      $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $this->_getParam('package_id', 0));
      $existingpackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $this->_getParam('existing_package_id', 0));
      if ($existingpackage) {
        $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $existingpackage->package_id);
      }
      if (!$package && !$existingpackage) {
        //check package exists for this member level
        $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getPackage(array('member_level' => $viewer->level_id));
        if (count($packageMemberLevel)) {
          //redirect to package business
          return $this->_helper->redirector->gotoRoute(array('action' => 'business'), 'sesbusinesspackage_general', true);
        }
      }
      if ($existingpackage) {
        $canCreate = Engine_Api::_()->getDbTable('Orderspackages', 'sesbusinesspackage')->checkUserPackage($this->_getParam('existing_package_id', 0), $viewer->getIdentity());
        if (!$canCreate)
          return $this->_helper->redirector->gotoRoute(array('action' => 'business'), 'sesbusinesspackage_general', true);
      }
    }
    //End Package Work

    $quckCreate = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('sesbusiness.category.selection', 0) && $settings->getSetting('sesbusiness.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;

    $totalBusiness = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->countBusinesses($viewer->getIdentity());
    $allowBusinessCount = Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_count');
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
    if ($totalBusiness >= $allowBusinessCount && $allowBusinessCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.category.selection', 0)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('fetchAll' => true));
      }
      $this->view->defaultProfileId = 1;
      $sesbusiness_sesbusinesscreate = Zend_Registry::isRegistered('sesbusiness_sesbusinesscreate') ? Zend_Registry::get('sesbusiness_sesbusinesscreate') : null;
      if(!empty($sesbusiness_sesbusinesscreate)) {
        $this->view->form = $form = new Sesbusiness_Form_Create(array(
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
    if (!$quckCreate && $settings->getSetting('sesbusiness.businessmainphoto', 1)) {
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
      $values['approval'] = $settings->getSetting('sesbusiness.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sesbusiness.default.approvaloption', 1) ? 0 : 1;

    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $db = $businessTable->getAdapter();
    $db->beginTransaction();
    try {
      // Create business
      $business = $businessTable->createRow();

      if (!$quckCreate && empty($_POST['lat'])) {
        unset($values['location']);
        unset($values['lat']);
        unset($values['lng']);
        unset($values['venue_name']);
      }

      $sesbusiness_draft = $settings->getSetting('sesbusiness.draft', 1);
      if (empty($sesbusiness_draft)) {
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
          if (isset($params['business_approve']) && $params['business_approve'])
            $values['is_approved'] = 1;
        } else
          $values['is_approved'] = 0;
        if ($existingpackage) {
          $values['existing_package_order'] = $existingpackage->getIdentity();
          $values['orderspackage_id'] = $existingpackage->getIdentity();
          $existingpackage->item_count = $existingpackage->item_count - 1;
          $existingpackage->save();
          $params = json_decode($package->params, true);
          if (isset($params['business_approve']) && $params['business_approve'])
            $values['is_approved'] = 1;
          if (isset($params['business_featured']) && $params['business_featured'])
            $values['featured'] = 1;
          if (isset($params['business_sponsored']) && $params['business_sponsored'])
            $values['sponsored'] = 1;
          if (isset($params['business_verified']) && $params['business_verified'])
            $values['verified'] = 1;
          if (isset($params['business_hot']) && $params['business_hot'])
            $values['hot'] = 1;
        }
      } else {
        if (!isset($package) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbusinesspackage')) {
          $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getDefaultPackage();
        }
      }

      $business->setFromArray($values);
      if(!isset($values['search']))
      $business->search = 1;
      else
      $business->search = $values['search'];

      if (isset($_POST['sesbusiness_title'])) {
        $business->title = $_POST['sesbusiness_title'];
        $business->category_id = $_POST['category_id'];
        if (isset($_POST['subcat_id']))
          $business->category_id = $_POST['category_id'];
        if (isset($_POST['subsubcat_id']))
          $business->category_id = $_POST['category_id'];
      }
      $business->parent_id = $parentId;
      if (!isset($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      $business->view_privacy = $values['auth_view'];
      $business->save();

      //Start Default Package Order Work
      if (isset($package) && $package->isFree()) {
        if (!$existingpackage) {
          $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sesbusinesspackage');
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
          $business->orderspackage_id = $transactionsOrdersTable->getAdapter()->lastInsertId();
          $business->existing_package_order = 0;
        } else {
          $existingpackage->item_count = $existingpackage->item_count--;
          $existingpackage->save();
        }
      }
      //End Default package Order Work

      if (!$quckCreate) {
        $tags = preg_split('/[,]+/', $values['tags']);
        $business->tags()->addTagMaps($viewer, $tags);
        $business->seo_keywords = implode(',', $tags);
        $business->save();
      }

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_sesbusiness_locations (business_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $business->business_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $business->business_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "businesses")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
      }

      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_sesbusiness_managebusinessapps` (`business_id`) VALUES ("' . $business->business_id . '");');

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.auto.join', 1)) {
        $business->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }

      if (!isset($package)) {
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_approve'))
          $business->is_approved = 0;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'bs_featured'))
          $business->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'bs_sponsored'))
          $business->sponsored = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'bs_verified'))
          $business->verified = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_hot'))
        $business->hot = 1;
      }

      // Add photo
      if (!empty($values['photo'])) {
        $business->setPhoto($form->photo, '', 'profile');
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
      $offerMax = array_search($values['auth_offer'], $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($business, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($business, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($business, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($business, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($business, $role, 'offer', ($i <= $offerMax));
      }
      if (!$quckCreate) {
        //Add fields
        $customfieldform = $form->getSubForm('fields');
        if ($customfieldform) {
          $customfieldform->setItem($business);
          $customfieldform->saveValues();
        }
      }
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $business->custom_url = $_POST['custom_url'];
      else
        $business->custom_url = $business->business_id;
      $business->save();
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.autoopenpopup', 1);
      if ($autoOpenSharePopup && $business->draft && $business->is_approved) {
        $_SESSION['newBusiness'] = true;
      }
      //insert admin of business
      $businessRole = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->createRow();
      $businessRole->user_id = $this->view->viewer()->getIdentity();
      $businessRole->business_id = $business->getIdentity();
      $businessRole->memberrole_id = 1;
      $businessRole->save();

      Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
        'resource_type' => 'businesses',
        'resource_id' => $business->business_id,
        'word' => $_POST['custom_url'],
      ));

      // Commit
      $db->commit();

      //Start Activity Feed Work
      if ($business->draft == 1 && $business->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $business, 'sesbusiness_business_create');
        if ($action) {
          $activityApi->attachActivity($action, $business);
        }
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','sesbusiness')->getCategoryFollowers($business->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','sesbusiness')->getColumnName(array('category_id' => $business->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($business, $viewer, $user, 'sesbusiness_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesbusiness_follow_category', array('sender_title' => $business->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      //Start Send Approval Request to Admin
      if (!$business->is_approved) {
        if (isset($package) && $package->price > 0) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($business->getOwner(), $viewer, $business, 'sesbusiness_payment_notify_business');
        } else {
          $getAdminnSuperAdmins = Engine_Api::_()->sesbusiness()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $business, 'sesbusiness_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesbusiness_business_adminapproval', array('sender_title' => $business->getOwner()->getTitle(), 'adminmanage_link' => 'admin/sesbusiness/manage', 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($business->getOwner(), 'notify_sesbusiness_business_businesssentforapproval', array('business_title' => $business->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $business, 'sesbusiness_business_wtapr');

        //Engine_Api::_()->sesbusiness()->sendMailNotification(array('business' => $business));
      }
      //Send mail to all super admin and admins
      if ($business->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->sesbusiness()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesbusiness_business_superadmin', array('sender_title' => $business->getOwner()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'notify_sesbusiness_business_superadmin', array('sender_title' => $business->getOwner()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
      $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.redirect', 1);
      if (!$business->is_approved) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sesbusiness_general', true);
      }
      elseif ($redirection == 1) {
        header('location:' . $business->getHref());
        die;
      } else {
        return $this->_helper->redirector->gotoRoute(array('business_id' => $business->custom_url), 'sesbusiness_dashboard', true);
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

    $sesbusiness = Engine_Api::_()->getItem('businesses', $this->getRequest()->getParam('business_id'));

    if (!Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($this->view->viewer()->getIdentity(), $sesbusiness->getIdentity(), 'manage_dashboard', 'delete'))
      if (!$this->_helper->requireAuth()->setAuthParams($sesbusiness, null, 'delete')->isValid())
        return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesbusiness_Form_Delete();

    if (!$sesbusiness) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Business entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $sesbusiness->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $sesbusiness->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your business has been deleted successfully!');
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesbusiness_general', true),
                'messages' => Array($this->view->message)
    ));
  }

  public function closeAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbusiness_Form_CloseBusiness();
    // Not post/invalid
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $business = Engine_Api::_()->getItem('businesses', $this->getRequest()->getParam('business_id'));
    $business->status = !$business->status;
    $business->save();
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully closed this business.')
    ));
  }

}
