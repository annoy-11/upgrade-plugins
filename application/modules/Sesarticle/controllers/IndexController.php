<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_IndexController extends Core_Controller_Action_Standard
{
  public function init() {
		// only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'view')->isValid() ) return;
    $id = $this->_getParam('article_id', $this->_getParam('id', null));
    $article_id = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getArticleId($id);
    if ($article_id) {
      $article = Engine_Api::_()->getItem('sesarticle', $article_id);
      if ($article) {
					Engine_Api::_()->core()->setSubject($article);
      }
    }
  }

  //fetch user like item as per given item id .
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


  public function browseArticlesAction() {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'sesarticle_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  public function indexAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function welcomeAction(){
    //Render
    $this->_helper->content->setEnabled();
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function locationsAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function claimAction() {

		$viewer = Engine_Api::_()->user()->getViewer();
		if( !$viewer || !$viewer->getIdentity() )
		if( !$this->_helper->requireUser()->isValid() ) return;

    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'sesarticle_claim', 'create') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.claim', 1))
    return $this->_forward('requireauth', 'error', 'core');

    // Render
    $this->_helper->content->setEnabled();
  }

  public function claimRequestsAction() {

    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesarticle')->claimCount();
    if(!$checkClaimRequest)
    return $this->_forward('notfound', 'error', 'core');
    // Render
    $this->_helper->content->setEnabled();
  }

  public function tagsAction() {

    //if (!$this->_helper->requireAuth()->setAuthParams('album', null, 'view')->isValid())
   // return;
    //Render
    $this->_helper->content->setEnabled();
  }

  public function homeAction() {
   	//Render
    $this->_helper->content->setEnabled();
  }

  public function viewAction() {

   $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = $this->_getParam('article_id', null);
    $this->view->article_id = $article_id = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getArticleId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesarticle = Engine_Api::_()->getItem('sesarticle', $article_id);
    else
    $sesarticle = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
    return;

    if( !$this->_helper->requireAuth()->setAuthParams($sesarticle, $viewer, 'view')->isValid() )
    return;

    if( !$sesarticle || !$sesarticle->getIdentity() || ((!$sesarticle->is_approved || $sesarticle->draft) && !$sesarticle->isOwner($viewer)) )
    return $this->_helper->requireSubject->forward();


    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('sesarticle', $sesarticle->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('sesarticle', $sesarticle->getOwner(), 'allow_networks')) {
        $returnValue = Engine_Api::_()->sesarticle()->checkPrivacySetting($sesarticle->getIdentity());
        if ($returnValue == false) {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $sesarticle->getType())
            ->where('id = ?', $sesarticle->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
    $sesarticle_profilearticles = Zend_Registry::isRegistered('sesarticle_profilearticles') ? Zend_Registry::get('sesarticle_profilearticles') : null;
    if (empty($sesarticle_profilearticles))
      return $this->_forward('notfound', 'error', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
		if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {

			$view->doctype('XHTML1_RDFA');
			if($sesarticle->seo_title)
        $view->headTitle($sesarticle->seo_title, 'SET');
			if($sesarticle->seo_keywords)
        $view->headMeta()->appendName('keywords', $sesarticle->seo_keywords);
			if($sesarticle->seo_description)
        $view->headMeta()->appendName('description', $sesarticle->seo_description);
		}

		if($sesarticle->style == 1)
		$page = 'sesarticle_index_view_1';
		elseif($sesarticle->style == 2)
		$page = 'sesarticle_index_view_2';
		elseif($sesarticle->style == 3)
		$page = 'sesarticle_index_view_3';
		elseif($sesarticle->style == 4)
		$page = 'sesarticle_index_view_4';

    $this->_helper->content->setContentName($page)->setEnabled();
  }

  // USER SPECIFIC METHODS
  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesarticle_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getCategoriesAssoc();
    if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }

  public function listAction() {

    // Preload info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->owner = $owner = Engine_Api::_()->getItem('user', $this->_getParam('user_id'));
    Engine_Api::_()->core()->setSubject($owner);

    if( !$this->_helper->requireSubject()->isValid() )
    return;

    // Make form
    $form = new Sesarticle_Form_Search();
    $form->populate($this->getRequest()->getParams());
    $values = $form->getValues();
    $this->view->formValues = array_filter($form->getValues());
    $values['user_id'] = $owner->getIdentity();
    $sesarticle_profilearticles = Zend_Registry::isRegistered('sesarticle_profilearticles') ? Zend_Registry::get('sesarticle_profilearticles') : null;
    if (empty($sesarticle_profilearticles))
      return $this->_forward('notfound', 'error', 'core');
    // Prepare data
    $sesarticleTable = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getSesarticlesPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->sesarticle_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }

  public function createAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'create')->isValid()) return;

		$sessmoothbox = $this->view->typesmoothbox = false;
		if($this->_getParam('typesmoothbox',false)){
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
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticlepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticlepackage.enable.package', 1)){
			$package = Engine_Api::_()->getItem('sesarticlepackage_package',$this->_getParam('package_id',0));
			$existingpackage = Engine_Api::_()->getItem('sesarticlepackage_orderspackage',$this->_getParam('existing_package_id',0));
			if($existingpackage){
				$package = Engine_Api::_()->getItem('sesarticlepackage_package',$existingpackage->package_id);
			}
			if (!$package && !$existingpackage){
				//check package exists for this member level
				$packageMemberLevel = Engine_Api::_()->getDbTable('packages','sesarticlepackage')->getPackage(array('member_level'=>$viewer->level_id));
				if(count($packageMemberLevel)){
					//redirect to package page
					return $this->_helper->redirector->gotoRoute(array('action'=>'article'), 'sesarticlepackage_general', true);
				}
			}
		}
    $session = new Zend_Session_Namespace();
		if(empty($_POST))
		unset($session->album_id);
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesarticle')->profileFieldId();
    if (isset($sesarticle->category_id) && $sesarticle->category_id != 0) {
      $this->view->category_id = $sesarticle->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($sesarticle->subsubcat_id) && $sesarticle->subsubcat_id != 0) {
      $this->view->subsubcat_id = $sesarticle->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($sesarticle->subcat_id) && $sesarticle->subcat_id != 0) {
      $this->view->subcat_id = $sesarticle->subcat_id;
    } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);

    // set up data needed to check quota
    $parentType = $this->_getParam('parent_type', null);
    if($parentType)
    $event_id = $this->_getParam('event_id', null);

    $parentId = $this->_getParam('parent_id', 0);
		if($parentId && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1)){
			return $this->_forward('notfound', 'error', 'core');
		}
    $sesarticle_create = Zend_Registry::isRegistered('sesarticle_create') ? Zend_Registry::get('sesarticle_create') : null;
    if (empty($sesarticle_create))
      return $this->_forward('notfound', 'error', 'core');
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getSesarticlesPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesarticle', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesarticle_Form_Create(array('defaultProfileId' => $defaultProfileId,'smoothboxType'=>$sessmoothbox,));

    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;

    if( !$form->isValid($this->getRequest()->getPost()) )
    return;

    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
				$form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
				return;
      }
    }

    // Process
    $table = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      // Create sesarticle
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));

        if(isset($values['levels']))
            $values['levels'] = implode(',',$values['levels']);

        if(isset($values['networks']))
            $values['networks'] = implode(',',$values['networks']);

      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $sesarticle = $table->createRow();
      if (is_null($values['subsubcat_id']))
      $values['subsubcat_id'] = 0;
      if (is_null($values['subcat_id']))
      $values['subcat_id'] = 0;
			if(isset($package)){
				$values['package_id'] = $package->getIdentity();
				$values['is_approved'] = 0;
				if($existingpackage){
					$values['existing_package_order'] = $existingpackage->getIdentity();
					$values['orderspackage_id'] = $existingpackage->getIdentity();
					$existingpackage->item_count = $existingpackage->item_count - 1;
					$existingpackage->save();
					$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesarticle', $viewer, 'article_approve');
				}
			}else{
				$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesarticle', $viewer, 'article_approve');
				if(isset($sesarticle->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticlepackage') ){
					$values['package_id'] = Engine_Api::_()->getDbTable('packages','sesarticlepackage')->getDefaultPackage();
				}
			}

			if(isset($_POST['articlestyle']) && $_POST['articlestyle'])
        $values['style'] = $_POST['articlestyle'];

      //SEO By Default Work
      //$values['seo_title'] = $values['title'];
			if($values['tags'])
			  $values['seo_keywords'] = $values['tags'];

      $sesarticle->setFromArray($values);

			//Upload Main Image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
			  $sesarticle->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'sesarticle','sesarticle','',$sesarticle,true);
				//$photo_id = 	$sesarticle->setPhoto($form->photo_file,'direct');
			}

			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesarticle->publish_date =$starttime;
			}

			if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
				//Convert Time Zone
				$oldTz = date_default_timezone_get();
				date_default_timezone_set($viewer->timezone);
				$start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
				date_default_timezone_set($oldTz);
				$sesarticle->publish_date = date('Y-m-d H:i:s', $start);
			}else{
				$sesarticle->publish_date = "";
			}

			$sesarticle->parent_id = $parentId;
      $sesarticle->save();
      $article_id = $sesarticle->article_id;

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
      $sesarticle->custom_url = $_POST['custom_url'];
      else
      $sesarticle->custom_url = $sesarticle->article_id;
      $sesarticle->save();
      $article_id = $sesarticle->article_id;

      $roleTable = Engine_Api::_()->getDbtable('roles', 'sesarticle');
			$row = $roleTable->createRow();
			$row->article_id = $article_id;
			$row->user_id = $viewer->getIdentity();
			$row->save();

			// Other module work
			if(!empty($resource_type) && !empty($resource_id)) {
        $sesarticle->resource_id = $resource_id;
        $sesarticle->resource_type = $resource_type;
        $sesarticle->save();
			}

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
					Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $article_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesarticle")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if($parentType == 'sesevent_article') {
        $sesarticle->parent_type = $parentType;
        $sesarticle->event_id = $event_id;
        $sesarticle->save();
        $seseventarticle = Engine_Api::_()->getDbtable('mapevents', 'sesarticle')->createRow();
        $seseventarticle->event_id = $event_id;
        $seseventarticle->article_id = $article_id;
        $seseventarticle->save();
      }

      if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
				$sesarticle->photo_id = $_POST['cover'];
				$sesarticle->save();
      }

      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
				$customfieldform->setItem($sesarticle);
				$customfieldform->saveValues();
      }

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video']: '', $roles);
      $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music']: '', $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sesarticle, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesarticle, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesarticle, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesarticle, $role, 'music', ($i <= $musicMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
     // $sesarticle->seo_keywords = implode(',',$tags);
      //$sesarticle->seo_title = $sesarticle->title;
      $sesarticle->save();
      $sesarticle->tags()->addTagMaps($viewer, $tags);

      $session = new Zend_Session_Namespace();
      if(!empty($session->album_id)){
				$album_id = $session->album_id;
				if(isset($article_id) && isset($sesarticle->title)){
					Engine_Api::_()->getDbTable('albums', 'sesarticle')->update(array('article_id' => $article_id,'owner_id' => $viewer->getIdentity(),'title' => $sesarticle->title), array('album_id = ?' => $album_id));
					if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
						Engine_Api::_()->getDbTable('albums', 'sesarticle')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
					}
					Engine_Api::_()->getDbTable('photos', 'sesarticle')->update(array('article_id' => $article_id), array('album_id = ?' => $album_id));
					unset($session->album_id);
				}
      }

      // Add activity only if sesarticle is published
      if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesarticle->publish_date || strtotime($sesarticle->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesarticle, 'sesarticle_new');
        // make sure action exists before attaching the sesarticle to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesarticle);
        }

        //Tag Work
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT IGNORE INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
        }

        //Send notifications for subscribers
      	Engine_Api::_()->getDbtable('subscriptions', 'sesarticle')->sendNotifications($sesarticle);
      	$sesarticle->is_publish = 1;
      	$sesarticle->save();
			}
      // Commit
      $db->commit();
    }

    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
		$redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.redirect.creation', 0);
    if($parentType) {
      $eventCustom_url = Engine_Api::_()->getItem('sesevent_event', $event_id)->custom_url;
      return $this->_helper->redirector->gotoRoute(array('id' => $eventCustom_url), 'sesevent_profile', true);
    } else if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    }
    else if($redirect)
   	 	return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard','action'=>'edit','article_id'=>$sesarticle->custom_url),'sesarticle_dashboard',true);
		 else
		 	return $this->_helper->redirector->gotoRoute(array('action' => 'view','article_id'=>$sesarticle->custom_url),'sesarticle_entry_view',true);
  }

    function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesarticle';
    $dbTable = 'sesarticles';
    $resorces_id = 'article_id';
    $notificationType = 'liked';
    $actionType = 'sesarticle_like';

		if($this->_getParam('type',false) && $this->_getParam('type') == 'sesarticle_album'){
			$type = 'sesarticle_album';
	    $dbTable = 'albums';
	    $resorces_id = 'album_id';
	    $actionType = 'sesarticle_album_like';
		} else if($this->_getParam('type',false) && $this->_getParam('type') == 'sesarticle_photo') {
			$type = 'sesarticle_photo';
	    $dbTable = 'photos';
	    $resorces_id = 'photo_id';
	    $actionType = 'sesarticle_photo_like';
		}

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbTable($dbTable, 'sesarticle');
    $tableLike = Engine_Api::_()->getDbTable('likes', 'core');
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
          if($subject && empty($subject->title) && $this->_getParam('type') == 'sesarticle_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('sesarticle_album', $album_id);
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
  function favouriteAction() {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }
    if ($this->_getParam('type') == 'sesarticle') {
      $type = 'sesarticle';
      $dbTable = 'sesarticles';
      $resorces_id = 'article_id';
      $notificationType = 'sesarticle_favourite';
    } else if ($this->_getParam('type') == 'sesarticle_photo') {
      $type = 'sesarticle_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
     else if ($this->_getParam('type') == 'sesarticle_album') {
      $type = 'sesarticle_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesarticle')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesarticle');
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
      if(@$notificationType) {
	      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesarticle')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesarticle')->createRow();
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
      if(@$notificationType) {
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

  public function deleteAction() {

    $sesarticle = Engine_Api::_()->getItem('sesarticle', $this->getRequest()->getParam('article_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($sesarticle, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesarticle_Form_Delete();

    if( !$sesarticle ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Sesarticle entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $sesarticle->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->sesarticle()->deleteArticle($sesarticle);;

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your sesarticle entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesarticle_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function styleAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'style')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Require user
    if( !$this->_helper->requireUser()->isValid() ) return;
    $user = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Sesarticle_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_sesarticle') // @todo this is not a real type
      ->where('id = ?', $user->getIdentity())
      ->limit(1);

    $row = $table->fetchRow($select);

    // Check post
    if( !$this->getRequest()->isPost() )
    {
      $form->populate(array(
        'style' => ( null === $row ? '' : $row->style )
      ));
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) return;


    // Cool! Process
    $style = $form->getValue('style');

    // Save
    if( null == $row ) {
      $row = $table->createRow();
      $row->type = 'user_sesarticle'; // @todo this is not a real type
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

  public function linkArticleAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->article_id = $article_id = $this->_getParam('article_id', '0');
    if ($article_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $eventTable = Engine_Api::_()->getItemTable('sesevent_event');
    $eventTableName = $eventTable->info('name');
    $articleMapTable = Engine_Api::_()->getDbTable('mapevents', 'sesarticle');
    $articleMapTableName = $articleMapTable->info('name');
    $select = $eventTable->select()
			->setIntegrityCheck(false)
			->from($eventTableName)
		        ->Joinleft($articleMapTableName, "$articleMapTableName.event_id = $eventTableName.event_id", null)
		        ->where($eventTableName.'.event_id !=?', '')
		        ->where($articleMapTableName.'.article_id !=? or article_id is null', $article_id);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);

   if( !$this->getRequest()->isPost() )
   return;

    $eventIds = $_POST['event'];
    $articleObject = Engine_Api::_()->getItem('sesarticle', $article_id);
    foreach($eventIds as $eventId) {
      $item = Engine_Api::_()->getItem('sesevent_event', $eventId);
      $owner = $item->getOwner();
      $table = Engine_Api::_()->getDbtable('mapevents', 'sesarticle');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $seseventarticle = $table->createRow();
	$seseventarticle->event_id = $eventId;
	$seseventarticle->article_id = $article_id;
	$seseventarticle->request_owner_article = 1;
	$seseventarticle->approved = 0;
	$seseventarticle->save();
	$articlePageLink = '<a href="' . $articleObject->getHref() . '">' . ucfirst($articleObject->getTitle()) . '</a>';
	Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesarticle_link_event', array("articlePageLink" => $articlePageLink));


	// Commit
	$db->commit();
      }
      catch( Exception $e ) {
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
  public function articleRequestAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_main');

    $ArticleTable = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');
    $ArticleTableName = $ArticleTable->info('name');
    $mapArticleTable = Engine_Api::_()->getDbtable('mapevents', 'sesarticle');
    $mapArticleTableName = $mapArticleTable->info('name');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $ArticleTable->select()
                        ->setIntegrityCheck(false)
			->from($ArticleTableName, array('owner_id', 'article_id'))
		        ->Joinleft($mapArticleTableName, "$mapArticleTableName.article_id = $ArticleTableName.article_id", array('event_id','approved'))
		        ->where($ArticleTableName.'.owner_id =?', $viewerId)
		        ->where($mapArticleTableName.'.approved =?', 0)
		         ->where($mapArticleTableName.'.request_owner_event =? and request_owner_event IS NOT null', 1);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }

  public function approvedAction() {

    $article_id = $this->_getParam('article_id');
    $event_id = $this->_getParam('event_id');
    $mapArticleTable = Engine_Api::_()->getDbtable('mapevents', 'sesarticle');
    $selectMapTable = $mapArticleTable->select()->where('event_id =?', $event_id)->where('article_id =?', $article_id)->where('request_owner_event =?', 1);
    $mapResult = $mapArticleTable->fetchRow($selectMapTable);
    if (!empty($article_id)) {
      $article = Engine_Api::_()->getItem('sesarticle', $event_id);
      if(!$mapResult->approved)
      $approved = 1;
      else
      $approved = 0;

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->update('engine4_sesarticle_mapevents', array(
      'approved' => $approved,
      ), array(
	'event_id = ?' => $event_id,
	'article_id = ?' => $article_id,
      ));
    }
    $this->_redirect('sesarticles/article-request');
  }

  public function rejectRequestAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $article_id = $this->_getParam('article_id');
    $articleObject = Engine_Api::_()->getItem('sesarticle', $article_id);
    $event_id = $this->_getParam('event_id');
    $eventObject = Engine_Api::_()->getItem('sesevent_event', $event_id);
    $owner = $eventObject->getOwner();
    $mapArticleTable = Engine_Api::_()->getDbtable('mapevents', 'sesarticle');
    $selectMapTable = $mapArticleTable->select()->where('event_id =?', $event_id)->where('article_id =?', $article_id)->where('request_owner_event =?', 1);
    $mapResult = $mapArticleTable->fetchRow($selectMapTable);
    $db = $mapResult->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $mapResult->delete();
      $articlePageLink = '<a href="' . $articleObject->getHref() . '">' . ucfirst($articleObject->getTitle()) . '</a>';
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $eventObject, 'sesarticle_reject_event_request', array("articlePageLink" => $articlePageLink));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirect('sesarticles/article-request');
  }

  protected function setPhoto($photo, $id) {

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
        'parent_type' => 'sesarticle',
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
        throw new Sesarticle_Model_Exception($e->getMessage(), $e->getCode());
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
  public function subcategoryAction() {

    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesarticle');
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
        if($CategoryType == 'search') {
          $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
	  foreach ($subcategory as $category) {
	    $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
	  }
        }
        else {
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
  public function subsubcategoryAction() {

    $category_id = $this->_getParam('subcategory_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesarticle');
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

  public function editPhotoAction() {
    $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
    $this->view->photo = Engine_Api::_()->getItem('sesarticle_photo', $photo_id);
  }

  public function saveInformationAction() {

    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'sesarticle')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }

  public function removeAction() {

    if(empty($_POST['photo_id']))die('error');
    $photo_id = (int) $this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('sesarticle_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'sesarticle')->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('photos', 'sesarticle')->delete(array('photo_id =?' => $photo_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function getArticleAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getarticle'] = true;
    $articles = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getSesarticlesSelect($value);
    foreach ($articles as $article) {
      $video_icon = $this->view->itemPhoto($article, 'thumb.icon');
      $sesdata[] = array(
          'id' => $article->article_id,
          'article_id' => $article->article_id,
          'label' => $article->title,
          'photo' => $video_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function shareAction() {

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
    $typeItem = ucwords(str_replace(array('sesarticle_'), '', $attachment->getType()));
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

  public function locationAction() {

    $this->view->type = $this->_getParam('type', 'article');
    $this->view->article_id = $article_id = $this->_getParam('article_id');
    $this->view->article = $article = Engine_Api::_()->getItem('sesarticle', $article_id);
    if (!$article)
      return;
    $this->view->form = $form = new Sesarticle_Form_Location();
    $form->populate($article->toArray());
  }

  public function customUrlCheckAction(){
    $value = $this->sanitize($this->_getParam('value', null));
    if(!$value) {
      echo json_encode(array('error'=>true));die;
    }
    $article_id = $this->_getParam('article_id',null);
    $custom_url = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->checkCustomUrl($value,$article_id);
    if($custom_url){
      echo json_encode(array('error'=>true,'value'=>$value));die;
    }else{
      echo json_encode(array('error'=>false,'value'=>$value));die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
    "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
    "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
    (function_exists('mb_strtolower')) ?
    mb_strtolower($clean, 'UTF-8') :
    strtolower($clean) :
    $clean;
  }

	public function getArticlesAction() {
		$sesdata = array();
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$articleTable = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');
		$articleTableName = $articleTable->info('name');
		$articleClaimTable = Engine_Api::_()->getDbtable('claims', 'sesarticle');
		$articleClaimTableName = $articleClaimTable->info('name');
		$text = $this->_getParam('text', null);
		$selectClaimTable = $articleClaimTable->select()
		->from($articleClaimTableName, 'article_id')
		->where('user_id =?', $viewerId);
		$claimedArticles = $articleClaimTable->fetchAll($selectClaimTable);

		$currentTime = date('Y-m-d H:i:s');
		$select = $articleTable->select()
		->where('draft =?', 0)
		->where("publish_date <= '$currentTime' OR publish_date = ''")
		->where('owner_id !=?', $viewerId)
		->where($articleTableName .'.title  LIKE ? ', '%' .$text. '%');
		if(count($claimedArticles) > 0)
		$select->where('article_id NOT IN(?)', $selectClaimTable);
		$select->order('article_id ASC')->limit('40');
		$articles = $articleTable->fetchAll($select);
		foreach ($articles as $article) {
			$article_icon_photo = $this->view->itemPhoto($article, 'thumb.icon');
			$sesdata[] = array(
			'id' => $article->article_id,
			'label' => $article->title,
			'photo' => $article_icon_photo
			);
		}
		return $this->_helper->json($sesdata);
	}

	public function rssFeedAction() {

      $this->_helper->layout->disableLayout();
      $value['fetchAll'] = true;
      $value['rss'] = 1;
      $value['orderby'] = 'article_id';
      $this->view->articles  = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle')->getSesarticlesSelect($value);
      $this->getResponse()->setHeader('Content-type', 'text/xml');
	}

}
