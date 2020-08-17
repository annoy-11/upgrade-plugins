<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_IndexController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('stores', null, 'view')->isValid())
      return;
  }
  public function currencyConverterAction() {
    //default currency
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency();
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    if ($is_ajax) {
      $curr = $this->_getParam('curr', Engine_Api::_()->estore()->defaultCurrency());
      $val = $this->_getParam('val', '1');
      $currencyVal = $settings->getSetting('sesmultiplecurrency.' . $curr);
      echo round($currencyVal*$val,2);die;
    }
    //currecy Array
    $fullySupportedCurrenciesExists = array();
    $fullySupportedCurrencies = Engine_Api::_()->estore()->getSupportedCurrency();
    foreach ($fullySupportedCurrencies as $key => $values) {
      if ($settings->getSetting('sesmultiplecurrency.' . $key))
        $fullySupportedCurrenciesExists[$key] = $values;
    }
    $this->view->form = $form = new Estore_Form_Conversion();
    $form->currency->setMultioptions($fullySupportedCurrenciesExists);
    $form->currency->setValue($defaultCurrency);
  }

  public function claimAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    if( !$this->_helper->requireUser()->isValid() ) return;
    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'auth_claim'))
    return $this->_forward('requireauth', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction() {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'estore')->claimCount();
    if(!$checkClaimRequest)
      return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function getStoresAction() {
    $sesdata = array();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $storeTable = Engine_Api::_()->getDbtable('stores', 'estore');
    $storeTableName = $storeTable->info('name');

    $storeClaimTable = Engine_Api::_()->getDbtable('claims', 'estore');
    $storeClaimTableName = $storeClaimTable->info('name');
    $text = $this->_getParam('text', null);
    $selectClaimTable = $storeClaimTable->select()
                                  ->from($storeClaimTableName, 'store_id')
                                  ->where('user_id =?', $viewerId);
    $claimedStores = $storeClaimTable->fetchAll($selectClaimTable);

    $currentTime = date('Y-m-d H:i:s');
    $select = $storeTable->select()
                  ->where('draft =?', 1)
                  ->where('owner_id !=?', $viewerId)
                  ->where($storeTableName .'.title  LIKE ? ', '%' .$text. '%');
    if(count($claimedStores) > 0)
  $select->where('store_id NOT IN(?)', $selectClaimTable);
    $select->order('store_id ASC')->limit('40');
    $stores = $storeTable->fetchAll($select);
    foreach ($stores as $store) {
        $store_icon_photo = $this->view->itemPhoto($store, 'thumb.icon');
        $sesdata[] = array(
        'id' => $store->store_id,
        'label' => $store->title,
        'photo' => $store_icon_photo
        );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeAsStoreAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->store = $store = Engine_Api::_()->getItem('stores', $id);
    $store_id = $this->_getParam('store_id');
    $table = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('store_id !=?', $store->getIdentity())
            ->where('store_id NOT IN (SELECT store_id FROM engine4_estore_likestores WHERE like_store_id = ' . $store->store_id . ")");
    $this->view->myStores = ($table->fetchAll($selelct));
    if ($store_id) {
      $table = Engine_Api::_()->getDbTable('likestores', 'estore');
      $row = $table->createRow();
      $row->store_id = $store_id;
      $row->like_store_id = $store->store_id;
      $row->user_id = $viewer->getIdentity();
      $row->save();
      echo 1;
      die;
    }
  }

  public function unlikeAsStoreAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->store = $store = Engine_Api::_()->getItem('stores', $id);
    $store_id = $this->_getParam('store_id');
    $table = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('store_id !=?', $store->getIdentity())
            ->where('store_id IN (SELECT store_id FROM engine4_estore_likestores WHERE like_store_id = ' . $store->store_id . ")");
    $this->view->myStores = ($table->fetchAll($selelct));
    if ($store_id) {
      $table = Engine_Api::_()->getDbTable('likestores', 'estore');
      $select = $table->select()->where('store_id =?', $store_id)->where('like_store_id =?', $store->getIdentity());
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

  function getMembershipStoreAction() {
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    $store = Engine_Api::_()->getItem('stores', $this->_getParam('store_id'));
    if (!($store)) {
      echo 0;
      die;
    }
    $table = $store->membership()->getTable();
    $membershipSelect = $table->select()->where('user_id =?', $viewer->getIdentity())->where('resource_approved =?', 1)->where('resource_id !=?', $store->getIdentity());
    $res = Engine_Api::_()->getItemTable('stores')->fetchAll($membershipSelect);
    if (!count($res)) {
      echo 0;
      die;
    }
    $stores = array();
    foreach ($res as $item) {
      $stores[] = $item->resource_id;
    }
    $select = Engine_Api::_()->getItemTable('stores')->select()->where('store_id IN(?)', $stores);
    $this->view->result = Engine_Api::_()->getItemTable('stores')->fetchAll($select);
    if (!count($this->view->result)) {
      echo 0;
      die;
    }
  }

  public function suggestStoreAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      $data = null;
    } else {
      $data = array();
      $table = Engine_Api::_()->getItemTable('stores');

      $select = $table->select()->where('search = ?', 1)->where('draft =?', 1);
      if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
        $select->where('`' . $table->info('name') . '`.`title` LIKE ?', '%' . $text . '%');
      }

      if (0 < ($limit = (int) $this->_getParam('limit', 10))) {
        $select->limit($limit);
      }
      foreach ($select->getTable()->fetchAll($select) as $store) {
        $data[] = array(
            'type' => 'stores',
            'id' => $store->getIdentity(),
            'guid' => $store->getGuid(),
            'label' => $store->getTitle(),
            'photo' => $this->view->itemPhoto($store, 'thumb.icon'),
            'url' => $store->getHref(),
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
    $store_guid = $this->_getParam('store_id', 0);
    if (!$store_guid)
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->estore = $estore = Engine_Api::_()->getItemByGuid($store_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($estore, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->callAction = Engine_Api::_()->getDbTable('callactions', 'estore')->getCallactions(array('store_id' => $estore->getIdentity()));
  }

  function removeCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $page_guid = $this->_getParam('page', 0);
    $estore = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$page_guid) {
      echo 0;
      die;
    }
    if (!$this->_helper->requireAuth()->setAuthParams($estore, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');
    $canCall = Engine_Api::_()->getDbTable('callactions', 'estore')->getCallactions(array('store_id' => $estore->getIdentity()));
    $canCall->delete();
    echo 1;
    die;
  }

  function saveCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $store_guid = $this->_getParam('page', 0);
    $fieldValue = $this->_getParam('fieldValue', 0);
    $checkboxVal = $this->_getParam('checkboxVal', 0);
    if (!$store_guid) {
      echo 0;
      die;
    }

    $estore = Engine_Api::_()->getItemByGuid($store_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($estore, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $canCall = Engine_Api::_()->getDbTable('callactions', 'estore')->getCallactions(array('store_id' => $estore->getIdentity()));
    if ($canCall) {
      $canCall->type = $checkboxVal;
      $canCall->params = $fieldValue;
      $canCall->save();
      echo 1;
      die;
    } else {
      $table = Engine_Api::_()->getDbTable('callactions', 'estore');
      $res = $table->createRow();
      $res->type = $checkboxVal;
      $res->params = $fieldValue;
      $res->store_id = $estore->getIdentity();
      $res->creation_date = date('Y-m-d H:i:s');
      $res->user_id = $this->view->viewer()->getIdentity();
      $res->save();
      echo 1;
      die;
    }
  }

  public function contactAction() {
    $ownerId[] = $this->_getParam('owner_id', $this->_getParam('store_owner_id', 0));
    $this->view->form = $form = new Estore_Form_ContactOwner();
    $form->store_owner_id->setValue($this->_getParam('owner_id', $this->_getParam('store_owner_id', 0)));
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

      if ($values['store_owner_id'] != $viewer->getIdentity()) {

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
    $store_id = $this->_getParam('store_id', null);
    $this->view->resource = $resource = Engine_Api::_()->getItem('stores', $store_id);
    $this->view->results = Engine_Api::_()->getDbTable('locations', 'estore')->getStoreLocationSelect(array('store_id' => $resource->store_id, 'content' => 1));
  }

  public function browseLocationsAction() {
    $estore_estorelocation = Zend_Registry::isRegistered('estore_estorelocation') ? Zend_Registry::get('estore_estorelocation') : null;
    if(!empty($estore_estorelocation)) {
      //Render
      $this->_helper->content->setEnabled();
    }
  }

  public function browseAction() {
    //Render
    $estore_estorebrowse = Zend_Registry::isRegistered('estore_estorebrowse') ? Zend_Registry::get('estore_estorebrowse') : null;
    if(!empty($estore_estorebrowse)) {
      $this->_helper->content->setEnabled();
    }
  }
  public function packageAction() {
    if (!$this->_helper->requireUser->isValid())return;
    $this->view->viewer = $viewer = $this->view->viewer();
    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'estorepackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));
    $this->_helper->content->setEnabled();
  }
  public function transactionsAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $tableTransaction = Engine_Api::_()->getItemTable('estorepackage_transaction');
    $tableTransactionName = $tableTransaction->info('name');
    $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
    $storeTableName = $storeTable->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableTransaction->select()
            ->setIntegrityCheck(false)
            ->from($tableTransactionName)
            ->joinLeft($tableUserName, "$tableTransactionName.owner_id = $tableUserName.user_id", 'username')
            ->where($tableUserName . '.user_id IS NOT NULL')
            ->joinLeft($storeTableName, "$tableTransactionName.transaction_id = $storeTableName.transaction_id", 'store_id')
            ->where($storeTableName . '.store_id IS NOT NULL')
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
    $estore_estorehome = Zend_Registry::isRegistered('estore_estorehome') ? Zend_Registry::get('estore_estorehome') : null;
    if(!empty($estore_estorehome)) {
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
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('estore', null, 'create')->checkRequire();

  }

  public function sesbackuplandingpstoreAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function createAction() {

    if (!$this->_helper->requireUser->isValid())
      return;

    if (!$this->_helper->requireAuth()->setAuthParams('stores', null, 'create')->isValid())
      return;

    $viewer = $this->view->viewer();
    //Start sub store creation privacy check work
    $this->view->parent_id = $parentId = $this->_getParam('parent_id', 0);
    $subStoreCreatePemission = false;
    if ($parentId) {
      $subject = Engine_Api::_()->getItem('stores', $parentId);
      if ($subject) {
        if ((!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_substore') || $subject->parent_id)) {
          return $this->_forward('notfound', 'error', 'core');
        $subStoreCreatePemission = Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_store');
        if (!$subStoreCreatePemission)
          return $this->_forward('notfound', 'error', 'core');
        }
      }
    }
    //End work here

    //Start Package Work
    if (ESTOREPACKAGE == 1) {
      $package = Engine_Api::_()->getItem('estorepackage_package', $this->_getParam('package_id', 0));
      $existingpackage = Engine_Api::_()->getItem('estorepackage_orderspackage', $this->_getParam('existing_package_id', 0));
      if ($existingpackage) {
        $package = Engine_Api::_()->getItem('estorepackage_package', $existingpackage->package_id);
      }
      if (!$package && !$existingpackage) {
        //check package exists for this member level
        $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getPackage(array('member_level' => $viewer->level_id));
        if (count($packageMemberLevel)) {
          //redirect to package store
          return $this->_helper->redirector->gotoRoute(array('action' => 'stores'), 'estorepackage_general', true);
        }
      }
      if ($existingpackage) {
        $canCreate = Engine_Api::_()->getDbTable('Orderspackages', 'estorepackage')->checkUserPackage($this->_getParam('existing_package_id', 0), $viewer->getIdentity());
        if (!$canCreate)
          return $this->_helper->redirector->gotoRoute(array('action' => 'stores'), 'estorepackage_general', true);
      }
    }
    //End Package Work

    $quckCreate = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('estore.category.selection', 0) && $settings->getSetting('estore.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;

    $totalStore = Engine_Api::_()->getDbTable('stores', 'estore')->countStores($viewer->getIdentity());
    $allowStoreCount = Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'store_count');
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
    if ($totalStore >= $allowStoreCount && $allowStoreCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.category.selection', 0)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategory(array('fetchAll' => true));
      }
      $this->view->defaultProfileId = 1;
      $estore_estorecreate = Zend_Registry::isRegistered('estore_estorecreate') ? Zend_Registry::get('estore_estorecreate') : null;
      if(!empty($estore_estorecreate)) {
        $this->view->form = $form = new Estore_Form_Create(array(
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
        $form->addError($this->view->translate("Custom URL not available.Please select other."));
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
    if (!$quckCreate && $settings->getSetting('estore.storemainphoto', 1)) {
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
      $values['approval'] = $settings->getSetting('estore.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('estore.default.approvaloption', 1) ? 0 : 1;

    $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
    $db = $storeTable->getAdapter();
    $db->beginTransaction();
    try {
      // Create store
      $store = $storeTable->createRow();

      if (!$quckCreate && empty($_POST['lat'])) {
        unset($values['location']);
        unset($values['lat']);
        unset($values['lng']);
        unset($values['venue_name']);
      }

      $estore_draft = $settings->getSetting('estore.draft', 1);
      if (empty($estore_draft)) {
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
          if (isset($params['store_approve']) && $params['store_approve'])
            $values['is_approved'] = 1;
        } else
          $values['is_approved'] = 0;
        if ($existingpackage) {
          $values['existing_package_order'] = $existingpackage->getIdentity();
          $values['orderspackage_id'] = $existingpackage->getIdentity();
          $existingpackage->item_count = $existingpackage->item_count - 1;
          $existingpackage->save();
          $params = json_decode($package->params, true);
          if (isset($params['store_approve']) && $params['store_approve'])
            $values['is_approved'] = 1;
          if (isset($params['store_featured']) && $params['store_featured'])
            $values['featured'] = 1;
          if (isset($params['store_sponsored']) && $params['store_sponsored'])
            $values['sponsored'] = 1;
          if (isset($params['store_verified']) && $params['store_verified'])
            $values['verified'] = 1;
          if (isset($params['store_hot']) && $params['store_hot'])
            $values['hot'] = 1;
        }
      } else {
        if (!isset($package) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('estorepackage')) {
          $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getDefaultPackage();
        }
      }

      $store->setFromArray($values);
      if(!isset($values['search']))
      $store->search = 1;
      else
      $store->search = $values['search'];

      if (isset($_POST['estore_title'])) {
        $store->title = $_POST['estore_title'];
        $store->category_id = $_POST['category_id'];
        if (isset($_POST['subcat_id']))
          $store->category_id = $_POST['category_id'];
        if (isset($_POST['subsubcat_id']))
          $store->category_id = $_POST['category_id'];
      }
      $store->parent_id = $parentId;
      if (!isset($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      $store->view_privacy = $values['auth_view'];
      $store->save();

      //Start Default Package Order Work
      if (isset($package) && $package->isFree()) {
        if (!$existingpackage) {
          $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'estorepackage');
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
          $store->orderspackage_id = $transactionsOrdersTable->getAdapter()->lastInsertId();
          $store->existing_package_order = 0;
        } else {
          $existingpackage->item_count = $existingpackage->item_count--;
          $existingpackage->save();
        }
      }
      //End Default package Order Work

      if (!$quckCreate) {
        $tags = preg_split('/[,]+/', $values['tags']);
        $store->tags()->addTagMaps($viewer, $tags);
        $store->seo_keywords = implode(',', $tags);
        $store->save();
      }

      if (!empty($_POST['location'])) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_estore_locations (store_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $store->store_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $store->store_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "stores")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $store->location = $_POST['location'];
        $store->save();
      }
      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_estore_managestoreapps` (`store_id`) VALUES ("' . $store->store_id . '");');
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.auto.join', 1)) {
        $store->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }
      if (!isset($package)) {
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'store_approve'))
          $store->is_approved = 0;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'bs_featured'))
          $store->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'bs_sponsored'))
          $store->sponsored = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'bs_verified'))
          $store->verified = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'store_hot'))
        $store->hot = 1;
      }

      // Add photo
      if (!empty($values['photo'])) {
        $store->setPhoto($form->photo, '', 'profile');
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

      foreach ($roles as $i => $role) {
        $auth->setAllowed($store, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($store, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($store, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($store, $role, 'video', ($i <= $videoMax));
      }
      if (!$quckCreate) {
        //Add fields
        $customfieldform = $form->getSubForm('fields');
        if ($customfieldform) {
          $customfieldform->setItem($store);
          $customfieldform->saveValues();
        }
      }
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $store->custom_url = $_POST['custom_url'];
      else
        $store->custom_url = $store->store_id;
      $store->save();
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.autoopenpopup', 1);
      if ($autoOpenSharePopup && $store->draft && $store->is_approved) {
        $_SESSION['newStore'] = true;
      }
      //insert admin of store
      $storeRole = Engine_Api::_()->getDbTable('storeroles', 'estore')->createRow();
      $storeRole->user_id = $this->view->viewer()->getIdentity();
      $storeRole->store_id = $store->getIdentity();
      $storeRole->memberrole_id = 1;
      $storeRole->save();

      Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
        'resource_type' => 'stores',
        'resource_id' => $store->store_id,
        'word' => $_POST['custom_url'],
      ));

      // Commit
      $db->commit();

      //Start Activity Feed Work
      if ($store->draft == 1 && $store->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $store, 'estore_store_create');
        if ($action) {
          $activityApi->attachActivity($action, $store);
        }
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','estore')->getCategoryFollowers($store->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','estore')->getColumnName(array('category_id' => $store->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($store, $viewer, $user, 'estore_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_estore_follow_category', array('sender_title' => $store->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      //Start Send Approval Request to Admin
      try {
      if (!$store->is_approved) {
        if (isset($package) && $package->price > 0) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($store->getOwner(), $viewer, $store, 'estore_payment_notify_store');
        } else {
          $getAdminnSuperAdmins = Engine_Api::_()->estore()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $store, 'estore_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_estore_store_adminapproval', array('sender_title' => $store->getOwner()->getTitle(), 'adminmanage_link' => 'admin/estore/manage', 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($store->getOwner(), 'notify_estore_store_storesentforapproval', array('store_title' => $store->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $store, 'estore_store_wtapr');

        //Engine_Api::_()->estore()->sendMailNotification(array('store' => $store));
      }
      //Send mail to all super admin and admins
      if ($store->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->estore()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_estore_store_superadmin', array('sender_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'notify_estore_store_superadmin', array('sender_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }

      } catch(Exception $e) {}
      if (!empty($item)) {
        $tab = "";
        if ($widget_id)
          $tab = "/tab/" . $widget_id;
        header('location:' . $item->getHref() . $tab);
        die;
      }
      //End Work Here.
      $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.redirect', 1);
      if (!$store->is_approved) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'estore_general', true);
      }
      elseif ($redirection == 1) {
        header('location:' . $store->getHref());
        die;
      } else {
        return $this->_helper->redirector->gotoRoute(array('store_id' => $store->custom_url), 'estore_dashboard', true);
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
    $estore = Engine_Api::_()->getItem('stores', $this->getRequest()->getParam('store_id'));
    if (!Engine_Api::_()->getDbTable('storeroles', 'estore')->toCheckUserStoreRole($this->view->viewer()->getIdentity(), $estore->getIdentity(), 'manage_dashboard', 'delete'))
      if (!$this->_helper->requireAuth()->setAuthParams($estore, null, 'delete')->isValid())
        return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Estore_Form_Delete();

    if (!$estore) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Store entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $estore->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->estore()->deleteStore($estore);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your store has been deleted successfully!');
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'estore_general', true),
                'messages' => Array($this->view->message)
    ));
  }

  public function closeAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Estore_Form_CloseStore();
    // Not post/invalid
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $store = Engine_Api::_()->getItem('stores', $this->getRequest()->getParam('store_id'));
    $store->status = !$store->status;
    $store->save();
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully closed this store.')
    ));
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
    $itemTable = Engine_Api::_()->getItemTable('estore_review');
    $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'estore');
    $tableMainVotes = $tableVotes->info('name');

    $review = Engine_Api::_()->getItem('estore_review',$item_id);
    $store = Engine_Api::_()->getItem('stores',$review->store_id);


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

      //get review owner

      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $review->{$votesTitle}));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('reviewvotes', 'estore')->getAdapter();
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

      //get review owner

      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $review->{$votesTitle}));
      die;
    }
  }


}
