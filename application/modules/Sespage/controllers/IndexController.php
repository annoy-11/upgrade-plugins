<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_IndexController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sespage_page', null, 'view')->isValid())
      return;
  }

  public function claimAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() )
    if( !$this->_helper->requireUser()->isValid() ) return;
    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'auth_claim'))
    return $this->_forward('requireauth', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction() {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sespage')->claimCount();
    if(!$checkClaimRequest)
      return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function getPagesAction() {
    $sesdata = array();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $pageTable = Engine_Api::_()->getDbtable('pages', 'sespage');
    $pageTableName = $pageTable->info('name');

    $pageClaimTable = Engine_Api::_()->getDbtable('claims', 'sespage');
    $pageClaimTableName = $pageClaimTable->info('name');
    $text = $this->_getParam('text', null);
    $selectClaimTable = $pageClaimTable->select()
                                  ->from($pageClaimTableName, 'page_id')
                                  ->where('user_id =?', $viewerId);
    $claimedPages = $pageClaimTable->fetchAll($selectClaimTable);

    $currentTime = date('Y-m-d H:i:s');
    $select = $pageTable->select()
                  ->where('draft =?', 1)
                  ->where('owner_id !=?', $viewerId)
                  ->where($pageTableName .'.title  LIKE ? ', '%' .$text. '%');
    if(count($claimedPages) > 0)
  $select->where('page_id NOT IN(?)', $selectClaimTable);
    $select->order('page_id ASC')->limit('40');
    $pages = $pageTable->fetchAll($select);
    foreach ($pages as $page) {
        $page_icon_photo = $this->view->itemPhoto($page, 'thumb.icon');
        $sesdata[] = array(
        'id' => $page->page_id,
        'label' => $page->title,
        'photo' => $page_icon_photo
        );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeAsPageAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->page = $page = Engine_Api::_()->getItem('sespage_page', $id);
    $page_id = $this->_getParam('page_id');
    $table = Engine_Api::_()->getDbTable('pageroles', 'sespage');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('page_id !=?', $page->getIdentity())
            ->where('page_id NOT IN (SELECT page_id FROM engine4_sespage_likepages WHERE like_page_id = ' . $page->page_id . ")");
    $this->view->myPages = ($table->fetchAll($selelct));
    if ($page_id) {
      $table = Engine_Api::_()->getDbTable('likepages', 'sespage');
      $row = $table->createRow();
      $row->page_id = $page_id;
      $row->like_page_id = $page->page_id;
      $row->user_id = $viewer->getIdentity();
      $row->save();
      echo 1;
      die;
    }
  }

  public function unlikeAsPageAction() {
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = $this->view->viewer();
    $this->view->page = $page = Engine_Api::_()->getItem('sespage_page', $id);
    $page_id = $this->_getParam('page_id');
    $table = Engine_Api::_()->getDbTable('pageroles', 'sespage');
    $selelct = $table->select()->where('user_id =?', $viewer->getIdentity())->where('memberrole_id =?', 1)->where('page_id !=?', $page->getIdentity())
            ->where('page_id IN (SELECT page_id FROM engine4_sespage_likepages WHERE like_page_id = ' . $page->page_id . ")");
    $this->view->myPages = ($table->fetchAll($selelct));
    if ($page_id) {
      $table = Engine_Api::_()->getDbTable('likepages', 'sespage');
      $select = $table->select()->where('page_id =?', $page_id)->where('like_page_id =?', $page->getIdentity());
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

  function getMembershipPageAction() {
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    $page = Engine_Api::_()->getItem('sespage_page', $this->_getParam('page_id'));
    if (!($page)) {
      echo 0;
      die;
    }
    $table = $page->membership()->getTable();
    $membershipSelect = $table->select()->where('user_id =?', $viewer->getIdentity())->where('resource_approved =?', 1)->where('resource_id !=?', $page->getIdentity());
    $res = Engine_Api::_()->getItemTable('sespage_page')->fetchAll($membershipSelect);
    if (!count($res)) {
      echo 0;
      die;
    }
    $pages = array();
    foreach ($res as $item) {
      $pages[] = $item->resource_id;
    }
    $select = Engine_Api::_()->getItemTable('sespage_page')->select()->where('page_id IN(?)', $pages);
    $this->view->result = Engine_Api::_()->getItemTable('sespage_page')->fetchAll($select);
    if (!count($this->view->result)) {
      echo 0;
      die;
    }
  }

  public function suggestPageAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity()) {
      $data = null;
    } else {
      $data = array();
      $table = Engine_Api::_()->getItemTable('sespage_page');

      $select = $table->select()->where('search = ?', 1)->where('draft =?', 1);
      if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
        $select->where('`' . $table->info('name') . '`.`title` LIKE ?', '%' . $text . '%');
      }

      if (0 < ($limit = (int) $this->_getParam('limit', 10))) {
        $select->limit($limit);
      }
      foreach ($select->getTable()->fetchAll($select) as $page) {
        $data[] = array(
            'type' => 'sespage_page',
            'id' => $page->getIdentity(),
            'guid' => $page->getGuid(),
            'label' => $page->getTitle(),
            'photo' => $this->view->itemPhoto($page, 'thumb.icon'),
            'url' => $page->getHref(),
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
    $page_guid = $this->_getParam('page_id', 0);
    if (!$page_guid)
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->sespage = $sespage = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sespage, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->callAction = Engine_Api::_()->getDbTable('callactions', 'sespage')->getCallactions(array('page_id' => $sespage->getIdentity()));
  }

  function removeCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $page_guid = $this->_getParam('page', 0);
    $sespage = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$page_guid) {
      echo 0;
      die;
    }
    if (!$this->_helper->requireAuth()->setAuthParams($sespage, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');
    $canCall = Engine_Api::_()->getDbTable('callactions', 'sespage')->getCallactions(array('page_id' => $sespage->getIdentity()));
    $canCall->delete();
    echo 1;
    die;
  }

  function saveCallactionAction() {
    if (count($_POST) == 0) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $page_guid = $this->_getParam('page', 0);
    $fieldValue = $this->_getParam('fieldValue', 0);
    $checkboxVal = $this->_getParam('checkboxVal', 0);
    if (!$page_guid) {
      echo 0;
      die;
    }

    $sespage = Engine_Api::_()->getItemByGuid($page_guid);
    if (!$this->_helper->requireAuth()->setAuthParams($sespage, null, 'edit')->isValid())
      return $this->_forward('requireauth', 'error', 'core');

    $canCall = Engine_Api::_()->getDbTable('callactions', 'sespage')->getCallactions(array('page_id' => $sespage->getIdentity()));
    if ($canCall) {
      $canCall->type = $checkboxVal;
      $canCall->params = $fieldValue;
      $canCall->save();
      echo 1;
      die;
    } else {
      $table = Engine_Api::_()->getDbTable('callactions', 'sespage');
      $res = $table->createRow();
      $res->type = $checkboxVal;
      $res->params = $fieldValue;
      $res->page_id = $sespage->getIdentity();
      $res->creation_date = date('Y-m-d H:i:s');
      $res->user_id = $this->view->viewer()->getIdentity();
      $res->save();
      echo 1;
      die;
    }
  }

  public function contactAction() {
    $ownerId[] = $this->_getParam('owner_id', $this->_getParam('page_owner_id', 0));
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sespage_Form_ContactOwner();
    $form->page_owner_id->setValue($this->_getParam('owner_id', $this->_getParam('page_owner_id', 0)));
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

      if ($values['page_owner_id'] != $viewer->getIdentity()) {

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
    $page_id = $this->_getParam('page_id', null);
    $this->view->resource = $resource = Engine_Api::_()->getItem('sespage_page', $page_id);
    $this->view->results = Engine_Api::_()->getDbTable('locations', 'sespage')->getPageLocationSelect(array('page_id' => $resource->page_id, 'content' => 1));
  }

  public function browseLocationsAction() {
    $sespage_sespagelocation = Zend_Registry::isRegistered('sespage_sespagelocation') ? Zend_Registry::get('sespage_sespagelocation') : null;
    if(!empty($sespage_sespagelocation)) {
      //Render
      $this->_helper->content->setEnabled();
    }
  }

  public function browseAction() {
    //Render
    $sespage_sespagebrowse = Zend_Registry::isRegistered('sespage_sespagebrowse') ? Zend_Registry::get('sespage_sespagebrowse') : null;
    if(!empty($sespage_sespagebrowse)) {
      $this->_helper->content->setEnabled();
    }
  }

  public function packageAction() {
    if (!$this->_helper->requireUser->isValid())return;
    $this->view->viewer = $viewer = $this->view->viewer();
    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sespagepackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));
    $this->_helper->content->setEnabled();
  }

  public function transactionsAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $tableTransaction = Engine_Api::_()->getItemTable('sespagepackage_transaction');
    $tableTransactionName = $tableTransaction->info('name');
    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $pageTableName = $pageTable->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableTransaction->select()
            ->setIntegrityCheck(false)
            ->from($tableTransactionName)
            ->joinLeft($tableUserName, "$tableTransactionName.owner_id = $tableUserName.user_id", 'username')
            ->where($tableUserName . '.user_id IS NOT NULL')
            ->joinLeft($pageTableName, "$tableTransactionName.transaction_id = $pageTableName.transaction_id", 'page_id')
            ->where($pageTableName . '.page_id IS NOT NULL')
            ->where($tableTransactionName . '.owner_id =?', $viewer->getIdentity());
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
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
    $sespage_sespagehome = Zend_Registry::isRegistered('sespage_sespagehome') ? Zend_Registry::get('sespage_sespagehome') : null;
    if(!empty($sespage_sespagehome)) {
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

    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sespage', null, 'create')->checkRequire();
  }

  public function sesbackuplandingppageAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function createAction() {

    if (!$this->_helper->requireUser->isValid())
      return;

    if (!$this->_helper->requireAuth()->setAuthParams('sespage_page', null, 'create')->isValid())
      return;

    $viewer = $this->view->viewer();
    //Start sub page creation privacy check work
    $this->view->parent_id = $parentId = $this->_getParam('parent_id', 0);
    $subPageCreatePemission = false;
    if ($parentId) {
      $subject = Engine_Api::_()->getItem('sespage_page', $parentId);
      if ($subject) {
        if ((!Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'auth_subpage') || $subject->parent_id)) {
          return $this->_forward('notfound', 'error', 'core');
        $subPageCreatePemission = Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($viewer->getIdentity(), $subject->getIdentity(), 'post_behalf_page');
        if (!$subPageCreatePemission)
          return $this->_forward('notfound', 'error', 'core');
        }
      }
    }
    //End work here

    //Start Package Work
    if (SESPAGEPACKAGE == 1) {
      $package = Engine_Api::_()->getItem('sespagepackage_package', $this->_getParam('package_id', 0));
      $existingpackage = Engine_Api::_()->getItem('sespagepackage_orderspackage', $this->_getParam('existing_package_id', 0));
      if ($existingpackage) {
        $package = Engine_Api::_()->getItem('sespagepackage_package', $existingpackage->package_id);
      }
      if (!$package && !$existingpackage) {
        //check package exists for this member level
        $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getPackage(array('member_level' => $viewer->level_id));
        if (count($packageMemberLevel)) {
          //redirect to package page
          return $this->_helper->redirector->gotoRoute(array('action' => 'page'), 'sespagepackage_general', true);
        }
      }
      if ($existingpackage) {
        $canCreate = Engine_Api::_()->getDbTable('Orderspackages', 'sespagepackage')->checkUserPackage($this->_getParam('existing_package_id', 0), $viewer->getIdentity());
        if (!$canCreate)
          return $this->_helper->redirector->gotoRoute(array('action' => 'page'), 'sespagepackage_general', true);
      }
    }
    //End Package Work

    $quckCreate = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('sespage.category.selection', 0) && $settings->getSetting('sespage.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;

    $totalPage = Engine_Api::_()->getDbTable('pages', 'sespage')->countPages($viewer->getIdentity());
    $allowPageCount = Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_count');
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
    if ($totalPage >= $allowPageCount && $allowPageCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.category.selection', 0)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategory(array('fetchAll' => true));
      }
      $this->view->defaultProfileId = 1;
      $sespage_sespagecreate = Zend_Registry::isRegistered('sespage_sespagecreate') ? Zend_Registry::get('sespage_sespagecreate') : null;
      if(!empty($sespage_sespagecreate)) {
        $this->view->form = $form = new Sespage_Form_Create(array(
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
    if (!$quckCreate && $settings->getSetting('sespage.pagemainphoto', 1)) {
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
      $values['approval'] = $settings->getSetting('sespage.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sespage.default.approvaloption', 1) ? 0 : 1;

    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $db = $pageTable->getAdapter();
    $db->beginTransaction();
    try {
      // Create page
      $page = $pageTable->createRow();

      if (!$quckCreate && empty($_POST['lat'])) {
        unset($values['location']);
        unset($values['lat']);
        unset($values['lng']);
        unset($values['venue_name']);
      }

//       $sespage_draft = $settings->getSetting('sespage.draft', 1);
//       if (empty($sespage_draft)) {
//         $values['draft'] = 1;
//       }
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
          if (isset($params['page_approve']) && $params['page_approve'])
            $values['is_approved'] = 1;
        } else
          $values['is_approved'] = 0;
        if ($existingpackage) {
          $values['existing_package_order'] = $existingpackage->getIdentity();
          $values['orderspackage_id'] = $existingpackage->getIdentity();
          $existingpackage->item_count = $existingpackage->item_count - 1;
          $existingpackage->save();
          $params = json_decode($package->params, true);
          if (isset($params['page_approve']) && $params['page_approve'])
            $values['is_approved'] = 1;
          if (isset($params['page_featured']) && $params['page_featured'])
            $values['featured'] = 1;
          if (isset($params['page_sponsored']) && $params['page_sponsored'])
            $values['sponsored'] = 1;
          if (isset($params['page_verified']) && $params['page_verified'])
            $values['verified'] = 1;
          if (isset($params['page_hot']) && $params['page_hot'])
            $values['hot'] = 1;
        }
      } else {
        if (!isset($package) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage')) {
          $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
        }
      }

      $page->setFromArray($values);
      if(!isset($values['search']))
      $page->search = 1;
      else
      $page->search = $values['search'];

      if (isset($_POST['sespage_title'])) {
        $page->title = $_POST['sespage_title'];
        $page->category_id = $_POST['category_id'];
        $page->draft = '1';
        if (isset($_POST['subcat_id']))
          $page->category_id = $_POST['category_id'];
        if (isset($_POST['subsubcat_id']))
          $page->category_id = $_POST['category_id'];
      }
      $page->parent_id = $parentId;
      if (!isset($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      $page->view_privacy = $values['auth_view'];
      $page->save();

      //Start Default Package Order Work
      if (isset($package) && $package->isFree()) {
        if (!$existingpackage) {
          $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sespagepackage');
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
          $page->orderspackage_id = $transactionsOrdersTable->getAdapter()->lastInsertId();
          $page->existing_package_order = 0;
        } else {
          $existingpackage->item_count = $existingpackage->item_count--;
          $existingpackage->save();
        }
      }
      //End Default package Order Work

      if (!$quckCreate) {
        $tags = preg_split('/[,]+/', $values['tags']);
        $page->tags()->addTagMaps($viewer, $tags);
        $page->seo_keywords = implode(',', $tags);
        $page->save();
      }

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_sespage_locations (page_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $page->page_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $page->page_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "sespage_page")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
      } else {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_sespage_locations (page_id,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $page->page_id . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "1") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $page->page_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "sespage_page")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $page->location = $_POST['location'];
        $page->save();
      }

      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_sespage_managepageapps` (`page_id`) VALUES ("' . $page->page_id . '");');

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.auto.join', 1)) {
        $page->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }

      if (!isset($package)) {
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_approve'))
          $page->is_approved = 0;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_featured'))
          $page->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_sponsored'))
          $page->sponsored = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_verified'))
          $page->verified = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_hot'))
        $page->hot = 1;
      }

      // Add photo
      if (!empty($values['photo'])) {
        $page->setPhoto($form->photo, '', 'profile');
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
      $noteMax = array_search($values['auth_note'], $roles);
      $offerMax = array_search($values['auth_offer'], $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($page, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($page, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($page, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($page, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($page, $role, 'note', ($i <= $noteMax));
        $auth->setAllowed($page, $role, 'offer', ($i <= $offerMax));
      }
      if (!$quckCreate) {
        //Add fields
        $customfieldform = $form->getSubForm('fields');
        if ($customfieldform) {
          $customfieldform->setItem($page);
          $customfieldform->saveValues();
        }
      }
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $page->custom_url = $_POST['custom_url'];
      else
        $page->custom_url = $page->page_id;
      $page->save();
      $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.autoopenpopup', 1);
      if ($autoOpenSharePopup && $page->draft && $page->is_approved) {
        $_SESSION['newPage'] = true;
      }
      //insert admin of page
      $pageRole = Engine_Api::_()->getDbTable('pageroles', 'sespage')->createRow();
      $pageRole->user_id = $this->view->viewer()->getIdentity();
      $pageRole->page_id = $page->getIdentity();
      $pageRole->memberrole_id = 1;
      $pageRole->save();

      if(!Engine_Api::_()->sesbasic()->isWordExist('sespage_page', $page->page_id, $_POST['custom_url'])) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
          'resource_type' => 'sespage_page',
          'resource_id' => $page->page_id,
          'word' => $_POST['custom_url'],
        ));
      }

      // Commit
      $db->commit();

      //Start Activity Feed Work
      if ($page->draft == 1 && $page->is_approved == 1) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $page, 'sespage_page_create');
        if ($action) {
          $activityApi->attachActivity($action, $page);
        }
        $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','sespage')->getCategoryFollowers($page->category_id);
        if(count($getCategoryFollowers) > 0) {
          foreach ($getCategoryFollowers as $getCategoryFollower) {
            if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
              continue;
            $categoryTitle = Engine_Api::_()->getDbTable('categories','sespage')->getColumnName(array('category_id' => $page->category_id, 'column_name' => 'category_name'));
            $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($page, $viewer, $user, 'sespage_follow_category',array('category_title' => $categoryTitle));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sespage_follow_category', array('sender_title' => $page->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      //Start Send Approval Request to Admin
      if (!$page->is_approved) {
        if (isset($package) && $package->price > 0) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sespage_payment_notify_page');
        } else {
          $getAdminnSuperAdmins = Engine_Api::_()->sespage()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $page, 'sespage_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sespage_page_adminapproval', array('sender_title' => $page->getOwner()->getTitle(), 'adminmanage_link' => 'admin/sespage/manage', 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'notify_sespage_page_pagesentforapproval', array('page_title' => $page->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $page, 'sespage_page_waitingapproval');

        //Engine_Api::_()->sespage()->sendMailNotification(array('page' => $page));
      }
      //Send mail to all super admin and admins
      if ($page->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->sespage()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sespage_page_superadmin', array('sender_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            if($receiverEmail) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'notify_sespage_page_superadmin', array('sender_title' => $page->getOwner()->getTitle(), 'object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }
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
      $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.redirect', 1);
      if (!$page->is_approved) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
      }
      elseif ($redirection == 1) {
        header('location:' . $page->getHref());
        die;
      } else {
        return $this->_helper->redirector->gotoRoute(array('page_id' => $page->custom_url), 'sespage_dashboard', true);
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

    $sespage = Engine_Api::_()->getItem('sespage_page', $this->getRequest()->getParam('page_id'));

    if (!Engine_Api::_()->getDbTable('pageroles', 'sespage')->toCheckUserPageRole($this->view->viewer()->getIdentity(), $sespage->getIdentity(), 'manage_dashboard', 'delete'))
      if (!$this->_helper->requireAuth()->setAuthParams($sespage, null, 'delete')->isValid())
        return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sespage_Form_Delete();

    if (!$sespage) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Page entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $sespage->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $sespage->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your page has been deleted successfully!');
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sespage_general', true),
                'messages' => Array($this->view->message)
    ));
  }

  public function closeAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sespage_Form_ClosePage();
    // Not post/invalid
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $page = Engine_Api::_()->getItem('sespage_page', $this->getRequest()->getParam('page_id'));
    $page->status = !$page->status;
    $page->save();
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully closed this page.')
    ));
  }
  public function topPagesAction() {
    //Render
    $sespage_sespagebrowse = Zend_Registry::isRegistered('sespage_sespagebrowse') ? Zend_Registry::get('sespage_sespagebrowse') : null;
    if(!empty($sespage_sespagebrowse)) {
      $this->_helper->content->setEnabled();
    }
  }

}
