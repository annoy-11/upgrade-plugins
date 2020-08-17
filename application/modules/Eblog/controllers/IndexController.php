<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_IndexController extends Core_Controller_Action_Standard {

  public function init() {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer || !$viewer->getIdentity()) {
      $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
      if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', $action) && $action!="view") {
        $_SESSION['redirect_url'] = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        $this->_redirect('login');
      }
    }

    if (!$this->_helper->requireAuth()->setAuthParams('eblog_blog', null, 'view')->isValid()) 
      return;

    $item_id = Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogId($this->_getParam('blog_id', $this->_getParam('id', null)));
    if ($item_id) {
      $item = Engine_Api::_()->getItem('eblog_blog', $item_id);
      if ($item) {
        Engine_Api::_()->core()->setSubject($item);
      }
    }
  }


  public function viewpagescrollAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['settings'])  && !empty($_POST['settings']) && !empty($_POST['id']))
    {
      if(isset($_POST['id']) && !empty($_POST['id']))
      {
        $eblog=Engine_Api::_()->getItem('eblog_blog', $_POST['id']);
        $params = array();
        $params=$_POST['settings'];
        $viewer = Engine_Api::_()->user()->getViewer();
        $params['viewer_id'] = $viewer->getIdentity();
        if (is_array($_POST['settings']['show_criteria']) && !empty($_POST['settings']['show_criteria'])) {
          foreach ($_POST['settings']['show_criteria'] as $show_criteria)
            $params[$show_criteria . 'Active'] = $show_criteria;
        }
        if( !empty($eblog->category_id) )
        { $category = Engine_Api::_()->getDbtable('categories', 'eblog')->find($eblog->category_id)->current();}

        echo include APPLICATION_PATH . '/application/modules/Eblog/views/scripts/viewfileloadbyajax.tpl';
        exit();

      }
    }
    exit();
  }

  public function nonloginredirectAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer || !$viewer->getIdentity() && isset($_POST['sessionurl'])) {
      $_SESSION['redirect_url']=$_POST['sessionurl'];
      echo 1;
      exit();
    }
  }

  public function acceptAction()
  {

    // Check auth
    if (!$this->_helper->requireUser()->isValid()) return;
    if (!$this->_helper->requireSubject('eblog_blog')->isValid()) return;

    $viewer = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Eblog_Form_Accept();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }


    // Process
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    $checkBlogUserAdmin = Engine_Api::_()->eblog()->checkBlogUserAdmin($subject->getIdentity());
    try {

      $checkBlogUserAdmin->resource_approved = '1';
      $checkBlogUserAdmin->save();

      $getAllBlogAdmins = Engine_Api::_()->getDbTable('roles', 'eblog')->getAllBlogAdmins(array('blog_id' => $subject->getIdentity()));
      foreach ($getAllBlogAdmins as $getAllBlogAdmin) {
        //Notification Work for admin
        $owner = Engine_Api::_()->getItem('user', $getAllBlogAdmin->user_id);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'eblog_acceptadminre');
      }
    } catch (Exception $e) {
    }

    $this->view->status = true;
    $this->view->error = false;

    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the request to the blog %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => array($message),
        'layout' => 'default-simple',
        'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction()
  {
    // Check auth
    if (!$this->_helper->requireUser()->isValid()) return;
    if (!$this->_helper->requireSubject('eblog_blog')->isValid()) return;

    // Make form
    $this->view->form = $form = new Eblog_Form_Reject();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }

    // Process
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $checkBlogUserAdmin = Engine_Api::_()->eblog()->checkBlogUserAdmin($subject->getIdentity());
    try {
      $checkBlogUserAdmin->delete();
      $getAllBlogAdmins = Engine_Api::_()->getDbTable('roles', 'eblog')->getAllBlogAdmins(array('blog_id' => $subject->getIdentity()));
      foreach ($getAllBlogAdmins as $getAllBlogAdmin) {
        //Notification Work for admin
        $owner = Engine_Api::_()->getItem('user', $getAllBlogAdmin->user_id);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'eblog_rejestadminre');
      }
    } catch (Exception $e) {

    }

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have decline the request to the blog %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => array($message),
        'layout' => 'default-simple',
        'parentRefresh' => true,
      ));
    }
  }

  public function removeasadminAction()
  {
    // Check auth
    if (!$this->_helper->requireUser()->isValid()) return;
    if (!$this->_helper->requireSubject('eblog_blog')->isValid()) return;

    // Make form
    $this->view->form = $form = new Eblog_Form_Remove();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }

    // Process
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $checkBlogUserAdmin = Engine_Api::_()->eblog()->checkBlogUserAdmin($subject->getIdentity());
    try {
      $checkBlogUserAdmin->delete();
      $getAllBlogAdmins = Engine_Api::_()->getDbTable('roles', 'eblog')->getAllBlogAdmins(array('blog_id' => $subject->getIdentity()));
      foreach ($getAllBlogAdmins as $getAllBlogAdmin) {
        //Notification Work for admin
        $owner = Engine_Api::_()->getItem('user', $getAllBlogAdmin->user_id);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'eblog_removeadminre');
      }
    } catch (Exception $e) {

    }

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have successfully remove as admin to the blog %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => array($message),
        'layout' => 'default-simple',
        'parentRefresh' => true,
      ));
    }
  }


  //fetch user like item as per given item id .
  public function likeItemAction()
  {
    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');
    if (!$item_id || !$item_type)
      return;
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title', 0);
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

  public function browseBlogsAction()
  {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'eblog_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  public function indexAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  //Browse Blog Contributors
  public function contributorsAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function welcomeAction()
  {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function browseAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function locationsAction()
  {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function claimAction()
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity())
      if (!$this->_helper->requireUser()->isValid()) return;

    if (!Engine_Api::_()->authorization()->getPermission($viewer, 'eblog_claim', 'create') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.claim', 1))
      return $this->_forward('requireauth', 'error', 'core');

    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction()
  {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'eblog')->claimCount();
    if (!$checkClaimRequest)
      return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function tagsAction()
  {

    //if (!$this->_helper->requireAuth()->setAuthParams('album', null, 'view')->isValid())
    // return;
    //Render
    $this->_helper->content->setEnabled();
  }

  public function homeAction()
  {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function viewAction()
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = $this->_getParam('blog_id', null);
    $this->view->blog_id = $blog_id = Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $eblog = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    else
      $eblog = Engine_Api::_()->core()->getSubject();

    if (!$this->_helper->requireSubject()->isValid())
      return;


    if (!$this->_helper->requireAuth()->setAuthParams($eblog, $viewer, 'view')->isValid())
      return;



    if (!$eblog || !$eblog->getIdentity() || ((!$eblog->is_approved || $eblog->draft) && !$eblog->isOwner($viewer)))
     {
       $viewer = Engine_Api::_()->user()->getViewer();
       if(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eblog_blog', 'view')!=2)
       {
         return $this->_helper->requireSubject->forward();
       }
     }

    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('eblog_blog', $eblog->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('eblog_blog', $eblog->getOwner(), 'allow_networks')) {
      $returnValue = Engine_Api::_()->eblog()->checkPrivacySetting($eblog->getIdentity());
      if ($returnValue == false) {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }


    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', $eblog->getType())
      ->where('id = ?', $eblog->getIdentity())
      ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
    $eblog_profileblogs = Zend_Registry::isRegistered('eblog_profileblogs') ? Zend_Registry::get('eblog_profileblogs') : null;
    if (empty($eblog_profileblogs))
      return $this->_forward('notfound', 'error', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {

      $view->doctype('XHTML1_RDFA');
      if ($eblog->seo_title)
        $view->headTitle($eblog->seo_title, 'SET');
      if ($eblog->seo_keywords)
        $view->headMeta()->appendName('keywords', $eblog->seo_keywords);
      if ($eblog->seo_description)
        $view->headMeta()->appendName('description', $eblog->seo_description);
    }

    if ($eblog->style == 1)
      $page = 'eblog_index_view_1';
    elseif ($eblog->style == 2)
      $page = 'eblog_index_view_2';
    elseif ($eblog->style == 3)
      $page = 'eblog_index_view_3';
    elseif ($eblog->style == 4)
      $page = 'eblog_index_view_4';

    $this->_helper->content->setContentName($page)->setEnabled();
  }

  // USER SPECIFIC METHODS
  public function manageAction()
  {

    if (!$this->_helper->requireUser()->isValid()) return;

    // Render
    $this->_helper->content
      //->setNoRender()
      ->setEnabled();

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Eblog_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('eblog', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'eblog')->getCategoriesAssoc();
    if (!empty($categories) && is_array($categories) && $form->getElement('category')) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }

  public function listAction()
  {

    // Preload info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->owner = $owner = Engine_Api::_()->getItem('user', $this->_getParam('user_id'));
    Engine_Api::_()->core()->setSubject($owner);

    if (!$this->_helper->requireSubject()->isValid())
      return;

    // Make form
    $form = new Eblog_Form_Search();
    $form->populate($this->getRequest()->getParams());
    $values = $form->getValues();
    $this->view->formValues = array_filter($form->getValues());
    $values['user_id'] = $owner->getIdentity();
    $eblog_profileblogs = Zend_Registry::isRegistered('eblog_profileblogs') ? Zend_Registry::get('eblog_profileblogs') : null;
    if (empty($eblog_profileblogs))
      return $this->_forward('notfound', 'error', 'core');
    // Prepare data
    $eblogTable = Engine_Api::_()->getDbtable('blogs', 'eblog');

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('blogs', 'eblog')->getEblogsPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->eblog_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber($values['page']);

    // Render
    $this->_helper->content
      //->setNoRender()
      ->setEnabled();
  }

  public function createAction() {
  
    if (!$this->_helper->requireUser()->isValid()) 
      return;
    
    if (!$this->_helper->requireAuth()->setAuthParams('eblog_blog', null, 'create')->isValid()) 
      return;

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

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblogpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblogpackage.enable.package', 1)) {
      $package = Engine_Api::_()->getItem('eblogpackage_package', $this->_getParam('package_id', 0));
      $existingpackage = Engine_Api::_()->getItem('eblogpackage_orderspackage', $this->_getParam('existing_package_id', 0));
      if ($existingpackage) {
        $package = Engine_Api::_()->getItem('eblogpackage_package', $existingpackage->package_id);
      }
      if (!$package && !$existingpackage) {
        //check package exists for this member level
        $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'eblogpackage')->getPackage(array('member_level' => $viewer->level_id));
        if (count($packageMemberLevel)) {
          //redirect to package page
          return $this->_helper->redirector->gotoRoute(array('action' => 'blog'), 'eblogpackage_general', true);
        }
      }
    }
    
    $session = new Zend_Session_Namespace();
    if (empty($_POST))
      unset($session->album_id);

    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'eblog')->profileFieldId();
    
    if (isset($eblog->category_id) && $eblog->category_id != 0) {
      $this->view->category_id = $eblog->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
      
    if (isset($eblog->subsubcat_id) && $eblog->subsubcat_id != 0) {
      $this->view->subsubcat_id = $eblog->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
      
    if (isset($eblog->subcat_id) && $eblog->subcat_id != 0) {
      $this->view->subcat_id = $eblog->subcat_id;
    } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);

    //set up data needed to check quota
    $parentType = $this->_getParam('parent_type', null);
    if ($parentType)
      $event_id = $this->_getParam('event_id', null);

    $parentId = $this->_getParam('parent_id', 0);
    if ($parentId && !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1))
      return $this->_forward('notfound', 'error', 'core');
    
    $eblog_create = Zend_Registry::isRegistered('eblog_create') ? Zend_Registry::get('eblog_create') : null;
    if (empty($eblog_create))
      return $this->_forward('notfound', 'error', 'core');
      
    $values['user_id'] = $viewer_id;
    
    $paginator = Engine_Api::_()->getDbtable('blogs', 'eblog')->getEblogsPaginator($values);
    $this->view->current_count = $paginator->getTotalItemCount();
    
    $this->view->quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eblog_blog', 'max');
    
    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'eblog')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Eblog_Form_Index_Create(array('defaultProfileId' => $defaultProfileId, 'smoothboxType' => $sessmoothbox,));

    // If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbTable('blogs', 'eblog')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
        return;
      }
    }
    
    $authApi = Engine_Api::_()->authorization()->getAdapter('levels');

    // Process
    $table = Engine_Api::_()->getDbtable('blogs', 'eblog');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
    
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer_id,
      ));
      if (isset($values['levels']))
        $values['levels'] = implode(',', $values['levels']);
      if (isset($values['networks']))
        $values['networks'] = implode(',', $values['networks']);
      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      
      $eblog = $table->createRow();
      
      if (is_null($values['subsubcat_id']))
        $values['subsubcat_id'] = 0;
        
      if (is_null($values['subcat_id']))
        $values['subcat_id'] = 0;
        
      if(isset($_POST['body']))
        $values['readtime'] = Engine_Api::_()->eblog()->estimatedReadingTime(addslashes($_POST['body']));

      if (isset($package)) {
        $values['package_id'] = $package->getIdentity();
        $values['is_approved'] = 0;
        if ($existingpackage) {
          $values['existing_package_order'] = $existingpackage->getIdentity();
          $values['orderspackage_id'] = $existingpackage->getIdentity();
          $existingpackage->item_count = $existingpackage->item_count - 1;
          $existingpackage->save();
          $values['is_approved'] = $authApi->getAllowed('eblog_blog', $viewer, 'blog_approve');
        }
      } else {
        $values['is_approved'] = $authApi->getAllowed('eblog_blog', $viewer, 'blog_approve');
        $values['featured'] = $authApi->getAllowed('eblog_blog', $viewer, 'autofeatured');
        $values['sponsored'] = $authApi->getAllowed('eblog_blog', $viewer, 'autosponsored');
        $values['verified'] = $authApi->getAllowed('eblog_blog', $viewer, 'autoverified');
        if (isset($eblog->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblogpackage')) {
          $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'eblogpackage')->getDefaultPackage();
        }
      }

      if ($_POST['blogstyle'])
        $values['style'] = $_POST['blogstyle'];

      //SEO By Default Work
      if ($values['tags'])
        $values['seo_keywords'] = $values['tags'];

      $eblog->setFromArray($values);

      //Upload Main Image
      if (isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != '') {
        $eblog->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false, false, 'eblog', 'eblog_blog', '', $eblog, true);
      }

      if (isset($_POST['start_date']) && $_POST['start_date'] != '') {
        $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s', strtotime($_POST['start_date'] . ' ' . $_POST['start_time'])) : '';
        $eblog->publish_date = $starttime;
      }

      if (isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != '') {
        //Convert Time Zone
        $oldTz = date_default_timezone_get();
        date_default_timezone_set($viewer->timezone);
        $start = strtotime($_POST['start_date'] . ' ' . $_POST['start_time']);
        date_default_timezone_set($oldTz);
        $eblog->publish_date = date('Y-m-d H:i:s', $start);
      }

      $eblog->parent_id = $parentId;
      $eblog->save();
      
      $blog_id = $eblog->blog_id;

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $eblog->custom_url = $_POST['custom_url'];
      else
        $eblog->custom_url = $eblog->blog_id;
      $eblog->save();

      $roleTable = Engine_Api::_()->getDbtable('roles', 'eblog');
      $row = $roleTable->createRow();
      $row->blog_id = $blog_id;
      $row->user_id = $viewer->getIdentity();
      $row->resource_approved = '1';
      $row->save();

      // Other module work
      if (!empty($resource_type) && !empty($resource_id)) {
        $eblog->resource_id = $resource_id;
        $eblog->resource_type = $resource_type;
        $eblog->save();
      }

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $blog_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","eblog_blog")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if ($parentType == 'sesevent_blog') {
        $eblog->parent_type = $parentType;
        $eblog->event_id = $event_id;
        $eblog->save();
        $seseventblog = Engine_Api::_()->getDbtable('mapevents', 'eblog')->createRow();
        $seseventblog->event_id = $event_id;
        $seseventblog->blog_id = $blog_id;
        $seseventblog->save();
      }

      if (isset ($_POST['cover']) && !empty($_POST['cover'])) {
        $eblog->photo_id = $_POST['cover'];
        $eblog->save();
      }

      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($eblog);
        $customfieldform->saveValues();
      }

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      if (empty($values['auth_view']))
        $values['auth_view'] = 'everyone';
      if (empty($values['auth_comment']))
        $values['auth_comment'] = 'everyone';
      if (empty($values['auth_video']))
        $values['auth_video'] = 'everyone';
      if (empty($values['auth_music']))
        $values['auth_music'] = 'everyone';

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video'] : '', $roles);
      $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music'] : '', $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($eblog, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($eblog, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($eblog, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($eblog, $role, 'music', ($i <= $musicMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);  
      $eblog->tags()->addTagMaps($viewer, $tags);
      
      $eblog->body = isset($_POST['body']) ? addslashes($_POST['body']) : null;
      $eblog->save();

      $session = new Zend_Session_Namespace();
      if (!empty($session->album_id)) {
        $album_id = $session->album_id;
        if (isset($blog_id) && isset($eblog->title)) {
          Engine_Api::_()->getDbTable('albums', 'eblog')->update(array('blog_id' => $blog_id, 'owner_id' => $viewer->getIdentity(), 'title' => $eblog->title), array('album_id = ?' => $album_id));
          if (isset ($_POST['cover']) && !empty($_POST['cover'])) {
            Engine_Api::_()->getDbTable('albums', 'eblog')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
          }
          Engine_Api::_()->getDbTable('photos', 'eblog')->update(array('blog_id' => $blog_id), array('album_id = ?' => $album_id));
          unset($session->album_id);
        }
      }

      // Add activity only if eblog is published
      if ($values['draft'] == 0 && $values['is_approved'] == 1 && (!$eblog->publish_date || strtotime($eblog->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $eblog, 'eblog_new');
        // make sure action exists before attaching the eblog to the activity
        if ($action)
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $eblog);

        //Tag Work
        if ($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach ($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("' . $action->getIdentity() . '", "' . $tag . '")');
          }
        }

        //Send notifications for subscribers
        Engine_Api::_()->getDbtable('subscriptions', 'eblog')->sendNotifications($eblog);
        $eblog->is_publish = 1;
        $eblog->save();
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.autoopenpopup', 1);
    if ($autoOpenSharePopup && $eblog->draft && $eblog->is_approved) {
      $_SESSION['newPage'] = true;
    }

    $redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.redirect.creation', 0);
    if ($parentType) {
      $eventCustom_url = Engine_Api::_()->getItem('sesevent_event', $event_id)->custom_url;
      return $this->_helper->redirector->gotoRoute(array('id' => $eventCustom_url), 'sesevent_profile', true);
    } else if (!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } else if ($redirect) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard', 'action' => 'edit', 'blog_id' => $eblog->custom_url), 'eblog_dashboard', true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'view', 'blog_id' => $eblog->custom_url), 'eblog_entry_view', true);
    }
  }

  function likeAction()
  {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'eblog_blog';
    $dbTable = 'blogs';
    $resorces_id = 'blog_id';
    $notificationType = 'liked';
    $actionType = 'eblog_blog_like';

    if ($this->_getParam('type', false) && $this->_getParam('type') == 'eblog_album') {
      $type = 'eblog_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $actionType = 'eblog_album_like';
    } else if ($this->_getParam('type', false) && $this->_getParam('type') == 'eblog_photo') {
      $type = 'eblog_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $actionType = 'eblog_photo_like';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'eblog');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');

    $select = $tableLike->select()
      ->from($tableMainLike)
      ->where('resource_type = ?', $type)
      ->where('poster_id = ?', $viewer_id)
      ->where('poster_type = ?', 'user')
      ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

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
      $item = Engine_Api::_()->getItem($type, $item_id);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
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

        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($resorces_id . '= ?' => $item_id));

        //Commit
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
        $result = $activityTable->fetchRow(array('type =?' => $actionType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

        if (!$result) {
          if ($subject && empty($subject->title) && $this->_getParam('type') == 'eblog_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('eblog_album', $album_id);
          }
          $action = $activityTable->addActivity($viewer, $subject, $actionType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }


  //item favourite as per item tye given
  function favouriteAction()
  {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    if ($this->_getParam('type') == 'eblog_blog') {
      $type = 'eblog_blog';
      $dbTable = 'blogs';
      $resorces_id = 'blog_id';
      $notificationType = 'eblog_blog_favourite';
    } else if ($this->_getParam('type') == 'eblog_photo') {
      $type = 'eblog_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      // $notificationType = 'sesevent_favourite_playlist';
    } else if ($this->_getParam('type') == 'eblog_album') {
      $type = 'eblog_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      // $notificationType = 'sesevent_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'eblog')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'eblog');
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
      if (@$notificationType) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'eblog')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'eblog')->createRow();
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
      if (@$notificationType) {
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          if (!$result) {
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
  }

  public function deleteAction()
  {

    $eblog = Engine_Api::_()->getItem('eblog_blog', $this->getRequest()->getParam('blog_id'));
    if (!$this->_helper->requireAuth()->setAuthParams($eblog, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Eblog_Form_Delete();

    if (!$eblog) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Eblog entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $eblog->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->eblog()->deleteBlog($eblog);;

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your eblog entry has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'eblog_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function styleAction()
  {

    if (!$this->_helper->requireUser()->isValid()) return;
    if (!$this->_helper->requireAuth()->setAuthParams('eblog_blog', null, 'style')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Require user
    if (!$this->_helper->requireUser()->isValid()) return;
    $user = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Eblog_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_eblog') // @todo this is not a real type
      ->where('id = ?', $user->getIdentity())
      ->limit(1);

    $row = $table->fetchRow($select);

    // Check post
    if (!$this->getRequest()->isPost()) {
      $form->populate(array(
        'style' => (null === $row ? '' : $row->style)
      ));
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) return;


    // Cool! Process
    $style = $form->getValue('style');

    // Save
    if (null == $row) {
      $row = $table->createRow();
      $row->type = 'user_eblog'; // @todo this is not a real type
      $row->id = $user->getIdentity();
    }

    $row->style = $style;
    $row->save();

    $this->view->draft = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Your changes have been saved.");
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => false,
      'messages' => array($this->view->message)
    ));
  }

  public function linkBlogAction()
  {

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->blog_id = $blog_id = $this->_getParam('blog_id', '0');
    if ($blog_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $eventTable = Engine_Api::_()->getItemTable('sesevent_event');
    $eventTableName = $eventTable->info('name');
    $blogMapTable = Engine_Api::_()->getDbTable('mapevents', 'eblog');
    $blogMapTableName = $blogMapTable->info('name');
    $select = $eventTable->select()
      ->setIntegrityCheck(false)
      ->from($eventTableName)
      ->Joinleft($blogMapTableName, "$blogMapTableName.event_id = $eventTableName.event_id", null)
      ->where($eventTableName . '.event_id !=?', '')
      ->where($blogMapTableName . '.blog_id !=? or blog_id is null', $blog_id);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);

    if (!$this->getRequest()->isPost())
      return;

    $eventIds = $_POST['event'];
    $blogObject = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    foreach ($eventIds as $eventId) {
      $item = Engine_Api::_()->getItem('sesevent_event', $eventId);
      $owner = $item->getOwner();
      $table = Engine_Api::_()->getDbtable('mapevents', 'eblog');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $seseventblog = $table->createRow();
        $seseventblog->event_id = $eventId;
        $seseventblog->blog_id = $blog_id;
        $seseventblog->request_owner_blog = 1;
        $seseventblog->approved = 0;
        $seseventblog->save();
        $blogPageLink = '<a href="' . $blogObject->getHref() . '">' . ucfirst($blogObject->getTitle()) . '</a>';
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'eblog_link_event', array("blogPageLink" => $blogPageLink));


        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Your changes have been saved.");
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => false,
      'messages' => array($this->view->message)
    ));
  }

  public function blogRequestAction()
  {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('eblog_main');

    $BlogTable = Engine_Api::_()->getDbtable('blogs', 'eblog');
    $BlogTableName = $BlogTable->info('name');
    $mapBlogTable = Engine_Api::_()->getDbtable('mapevents', 'eblog');
    $mapBlogTableName = $mapBlogTable->info('name');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $BlogTable->select()
      ->setIntegrityCheck(false)
      ->from($BlogTableName, array('owner_id', 'blog_id'))
      ->Joinleft($mapBlogTableName, "$mapBlogTableName.blog_id = $BlogTableName.blog_id", array('event_id', 'approved'))
      ->where($BlogTableName . '.owner_id =?', $viewerId)
      ->where($mapBlogTableName . '.approved =?', 0)
      ->where($mapBlogTableName . '.request_owner_event =? and request_owner_event IS NOT null', 1);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }

  public function approvedAction()
  {

    $blog_id = $this->_getParam('blog_id');
    $event_id = $this->_getParam('event_id');
    $mapBlogTable = Engine_Api::_()->getDbtable('mapevents', 'eblog');
    $selectMapTable = $mapBlogTable->select()->where('event_id =?', $event_id)->where('blog_id =?', $blog_id)->where('request_owner_event =?', 1);
    $mapResult = $mapBlogTable->fetchRow($selectMapTable);
    if (!empty($blog_id)) {
      $blog = Engine_Api::_()->getItem('eblog_blog', $event_id);
      if (!$mapResult->approved)
        $approved = 1;
      else
        $approved = 0;

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->update('engine4_eblog_mapevents', array(
        'approved' => $approved,
      ), array(
        'event_id = ?' => $event_id,
        'blog_id = ?' => $blog_id,
      ));
    }
    $this->_redirect('eblogs/blog-request');
  }

  public function rejectRequestAction()
  {

    $viewer = Engine_Api::_()->user()->getViewer();
    $blog_id = $this->_getParam('blog_id');
    $blogObject = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    $event_id = $this->_getParam('event_id');
    $eventObject = Engine_Api::_()->getItem('sesevent_event', $event_id);
    $owner = $eventObject->getOwner();
    $mapBlogTable = Engine_Api::_()->getDbtable('mapevents', 'eblog');
    $selectMapTable = $mapBlogTable->select()->where('event_id =?', $event_id)->where('blog_id =?', $blog_id)->where('request_owner_event =?', 1);
    $mapResult = $mapBlogTable->fetchRow($selectMapTable);
    $db = $mapResult->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $mapResult->delete();
      $blogPageLink = '<a href="' . $blogObject->getHref() . '">' . ucfirst($blogObject->getTitle()) . '</a>';
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $eventObject, 'eblog_reject_event_request', array("blogPageLink" => $blogPageLink));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirect('eblogs/blog-request');
  }

  public function subcategoryAction()
  {

    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'eblog');
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
        if ($CategoryType == 'search') {
          $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
          foreach ($subcategory as $category) {
            $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
          }
        } else {
          //$data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
          $data .= '<option value=""></option>';
          foreach ($subcategory as $category) {
            $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
          }

        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }

  public function subsubcategoryAction()
  {

    $category_id = $this->_getParam('subcategory_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'eblog');
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
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }

      }
    } else
      $data = '';
    echo $data;
    die;
  }

  public function editPhotoAction()
  {
    $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
    $this->view->photo = Engine_Api::_()->getItem('eblog_photo', $photo_id);
  }

  public function saveInformationAction()
  {

    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'eblog')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }

  public function removeAction()
  {

    if (empty($_POST['photo_id'])) die('error');
    $photo_id = (int)$this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('eblog_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'eblog')->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('photos', 'eblog')->delete(array('photo_id =?' => $photo_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function getBlogAction()
  {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getblog'] = true;
    $blogs = Engine_Api::_()->getDbtable('blogs', 'eblog')->getEblogsSelect($value);
    foreach ($blogs as $blog) {
      $video_icon = $this->view->itemPhoto($blog, 'thumb.icon');
      $sesdata[] = array(
        'id' => $blog->blog_id,
        'blog_id' => $blog->blog_id,
        'label' => $blog->title,
        'photo' => $video_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function shareAction()
  {

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
    $typeItem = ucwords(str_replace(array('eblog_'), '', $attachment->getType()));
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

  public function locationAction()
  {

    $this->view->type = $this->_getParam('type', 'blog');
    $this->view->blog_id = $blog_id = $this->_getParam('blog_id');
    $this->view->blog = $blog = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    if (!$blog)
      return;
    $this->view->form = $form = new Eblog_Form_Location();
    $form->populate($blog->toArray());
  }

  public function customUrlCheckAction()
  {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $blog_id = $this->_getParam('blog_id', null);
    $custom_url = Engine_Api::_()->getDbtable('blogs', 'eblog')->checkCustomUrl($value, $blog_id);
    if ($custom_url) {
      echo json_encode(array('error' => true, 'value' => $value));
      die;
    } else {
      echo json_encode(array('error' => false, 'value' => $value));
      die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  public function getBlogsAction()
  {
    $sesdata = array();
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $blogTable = Engine_Api::_()->getDbtable('blogs', 'eblog');
    $blogTableName = $blogTable->info('name');
    $blogClaimTable = Engine_Api::_()->getDbtable('claims', 'eblog');
    $blogClaimTableName = $blogClaimTable->info('name');
    $text = $this->_getParam('text', null);
    $selectClaimTable = $blogClaimTable->select()
      ->from($blogClaimTableName, 'blog_id')
      ->where('user_id =?', $viewerId);
    $claimedBlogs = $blogClaimTable->fetchAll($selectClaimTable);

    $currentTime = date('Y-m-d H:i:s');
    $select = $blogTable->select()
      ->where('draft =?', 0)
      ->where("publish_date <= '$currentTime' OR publish_date = ''")
      ->where('owner_id !=?', $viewerId)
      ->where($blogTableName . '.title  LIKE ? ', '%' . $text . '%');
    if (count($claimedBlogs) > 0)
      $select->where('blog_id NOT IN(?)', $selectClaimTable);
    $select->order('blog_id ASC')->limit('40');
    $blogs = $blogTable->fetchAll($select);
    foreach ($blogs as $blog) {
      $blog_icon_photo = $this->view->itemPhoto($blog, 'thumb.icon');
      $sesdata[] = array(
        'id' => $blog->blog_id,
        'label' => $blog->title,
        'photo' => $blog_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function rssFeedAction()
  {

    $this->_helper->layout->disableLayout();
    $value['fetchAll'] = true;
    $value['rss'] = 1;
    $value['orderby'] = 'blog_id';
    $this->view->blogs = Engine_Api::_()->getDbTable('blogs', 'eblog')->getEblogsSelect($value);
    $this->getResponse()->setHeader('Content-type', 'text/xml');
  }

  protected function setPhoto($photo, $id)
  {

    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = $file;
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
      'parent_type' => 'eblog_blog',
      'parent_id' => $id,
      'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
      'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_main.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(500, 500)
      ->write($mainPath)
      ->destroy();
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Eblog_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }

}
