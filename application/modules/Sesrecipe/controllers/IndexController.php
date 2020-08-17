<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_IndexController extends Core_Controller_Action_Standard
{
  public function init() {
		// only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', null, 'view')->isValid() ) return;
    $id = $this->_getParam('recipe_id', $this->_getParam('id', null));
    $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if ($recipe_id) {
      $recipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
      if ($recipe) {
					Engine_Api::_()->core()->setSubject($recipe);
      }
    }
  }
  

  public function searchAction() {

    $text = $this->_getParam('text', null);

    $table = Engine_Api::_()->getDbTable('recipes', 'sesrecipe');
    $tableName = $table->info('name');
    $id = 'recipe_id';
    $route = 'sesrecipe_entry_view';
    $photo = 'thumb.icon';
    $label = 'title';

    $data = array();
    $select = $table->select()->from($tableName);
    $select->where('title  LIKE ? ', '%' . $text . '%')->order('title ASC');
    $select->where('search = ?', 1);

    $select->limit('40'); 
    $results = $table->fetchAll($select);

    foreach ($results as $result) {
      $url = $this->view->url(array($id => $result->custom_url), $route, true);
      $photo = $this->view->itemPhoto($result, $photo);
      $data[] = array(
        'id' => $result->$id,
        'label' => $result->$label,
        'photo' => $photo,
        'url' => $url,
      );
    }
    return $this->_helper->json($data);
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

  public function browseRecipesAction() {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'sesrecipe_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }
  
  public function indexAction() {
    // Render
    $this->_helper->content->setEnabled();
  }
  
  //Browse Recipe Contributors
  public function contributorsAction() {
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
		
    if(!Engine_Api::_()->authorization()->getPermission($viewer, 'sesrecipe_claim', 'create') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.claim', 1)) 
    return $this->_forward('requireauth', 'error', 'core');
  
    // Render
    $this->_helper->content->setEnabled();
  }
  
  public function claimRequestsAction() {
  
    $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'sesrecipe')->claimCount();
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
    $id = $this->_getParam('recipe_id', null);
    $this->view->recipe_id = $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesrecipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    else
    $sesrecipe = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
    return;
  
    if( !$this->_helper->requireAuth()->setAuthParams($sesrecipe, $viewer, 'view')->isValid() )
    return;
      
    if( !$sesrecipe || !$sesrecipe->getIdentity() || ($sesrecipe->draft && !$sesrecipe->isOwner($viewer)) )
    return $this->_helper->requireSubject->forward();
    
    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $sesrecipe->getType())
            ->where('id = ?', $sesrecipe->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
    $sesrecipe_profilerecipes = Zend_Registry::isRegistered('sesrecipe_profilerecipes') ? Zend_Registry::get('sesrecipe_profilerecipes') : null;
    if (empty($sesrecipe_profilerecipes))
      return $this->_forward('notfound', 'error', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
		if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
		
			$view->doctype('XHTML1_RDFA');
			if($sesrecipe->seo_title)
        $view->headTitle($sesrecipe->seo_title, 'SET');
			if($sesrecipe->seo_keywords)
        $view->headMeta()->appendName('keywords', $sesrecipe->seo_keywords);
			if($sesrecipe->seo_description)
        $view->headMeta()->appendName('description', $sesrecipe->seo_description);
		}
		
		if($sesrecipe->style == 1)
		$page = 'sesrecipe_index_view_1';
		elseif($sesrecipe->style == 2)
		$page = 'sesrecipe_index_view_2';
		elseif($sesrecipe->style == 3)
		$page = 'sesrecipe_index_view_3';
		elseif($sesrecipe->style == 4)
		$page = 'sesrecipe_index_view_4';

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
    $this->view->form = $form = new Sesrecipe_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesrecipe', null, 'create')->checkRequire();

    $form->removeElement('show');
    
    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->getCategoriesAssoc();
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
    $form = new Sesrecipe_Form_Search();
    $form->populate($this->getRequest()->getParams());
    $values = $form->getValues();
    $this->view->formValues = array_filter($form->getValues());
    $values['user_id'] = $owner->getIdentity();
    $sesrecipe_profilerecipes = Zend_Registry::isRegistered('sesrecipe_profilerecipes') ? Zend_Registry::get('sesrecipe_profilerecipes') : null;
    if (empty($sesrecipe_profilerecipes))
      return $this->_forward('notfound', 'error', 'core');
    // Prepare data
    $sesrecipeTable = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
    
    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getSesrecipesPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->sesrecipe_page;
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
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', null, 'create')->isValid()) return;
    
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
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipepackage.enable.package', 1)){
			$package = Engine_Api::_()->getItem('sesrecipepackage_package',$this->_getParam('package_id',0));
			$existingpackage = Engine_Api::_()->getItem('sesrecipepackage_orderspackage',$this->_getParam('existing_package_id',0));
			if($existingpackage){
				$package = Engine_Api::_()->getItem('sesrecipepackage_package',$existingpackage->package_id);
			}
			if (!$package && !$existingpackage){
				//check package exists for this member level
				$packageMemberLevel = Engine_Api::_()->getDbTable('packages','sesrecipepackage')->getPackage(array('member_level'=>$viewer->level_id));
				if(count($packageMemberLevel)){
					//redirect to package page
					return $this->_helper->redirector->gotoRoute(array('action'=>'recipe'), 'sesrecipepackage_general', true);
				}
			}
		}
    $session = new Zend_Session_Namespace();
		if(empty($_POST))
		unset($session->album_id);
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesrecipe')->profileFieldId();
    if (isset($sesrecipe->category_id) && $sesrecipe->category_id != 0) {
      $this->view->category_id = $sesrecipe->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($sesrecipe->subsubcat_id) && $sesrecipe->subsubcat_id != 0) {
      $this->view->subsubcat_id = $sesrecipe->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($sesrecipe->subcat_id) && $sesrecipe->subcat_id != 0) {
      $this->view->subcat_id = $sesrecipe->subcat_id;
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
		if($parentId && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1)){
			return $this->_forward('notfound', 'error', 'core');	
		}
    $sesrecipe_create = Zend_Registry::isRegistered('sesrecipe_create') ? Zend_Registry::get('sesrecipe_create') : null;
    if (empty($sesrecipe_create))
      return $this->_forward('notfound', 'error', 'core');
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getSesrecipesPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesrecipe_recipe', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();
    
    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->getCategoriesAssoc();
        
    // Prepare form
    $this->view->form = $form = new Sesrecipe_Form_Create(array('defaultProfileId' => $defaultProfileId,'smoothboxType'=>$sessmoothbox,));
    
    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;
    
    if( !$form->isValid($this->getRequest()->getPost()) )
    return;
    
    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
				$form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
				return;
      }
    }
    
    // Process
    $table = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      // Create sesrecipe
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));
      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $sesrecipe = $table->createRow();
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
					$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesrecipe_recipe', $viewer, 'recipe_approve');
				}
			}else{
				$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesrecipe_recipe', $viewer, 'recipe_approve');
				if(isset($sesrecipe->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') ){
					$values['package_id'] = Engine_Api::_()->getDbTable('packages','sesrecipepackage')->getDefaultPackage();
				}
			}
			
			if($_POST['recipestyle'])
        $values['style'] = $_POST['recipestyle'];
      
      //SEO By Default Work
      $values['seo_title'] = $values['title'];
			if($values['tags'])
			$values['seo_keywords'] = $values['tags'];
        
      $sesrecipe->setFromArray($values);
			
			//Upload Main Image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
			  $sesrecipe->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'sesrecipe','sesrecipe_recipe','',$sesrecipe,true);
				//$photo_id = 	$sesrecipe->setPhoto($form->photo_file,'direct');	
			}
			
			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesrecipe->publish_date =$starttime;
			}
			
			if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
				//Convert Time Zone
				$oldTz = date_default_timezone_get();
				date_default_timezone_set($viewer->timezone);
				$start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
				date_default_timezone_set($oldTz);
				$sesrecipe->publish_date = date('Y-m-d H:i:s', $start);
			}else{
				$sesrecipe->publish_date = date('Y-m-d H:i:s',strtotime("-2 minutes", time()));
			}
		
			$sesrecipe->parent_id = $parentId;
      $sesrecipe->save();
      $recipe_id = $sesrecipe->recipe_id;

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
      $sesrecipe->custom_url = $_POST['custom_url'];
      else
      $sesrecipe->custom_url = $sesrecipe->recipe_id;
      $sesrecipe->save();
      $recipe_id = $sesrecipe->recipe_id;
      
      $roleTable = Engine_Api::_()->getDbtable('roles', 'sesrecipe');
			$row = $roleTable->createRow();
			$row->recipe_id = $recipe_id;
			$row->user_id = $viewer->getIdentity();
			$row->save();
			
			// Other module work
			if(!empty($resource_type) && !empty($resource_id)) {
        $sesrecipe->resource_id = $resource_id;
        $sesrecipe->resource_type = $resource_type;
        $sesrecipe->save();
			}
      
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $recipe_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesrecipe_recipe")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $recipe_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesrecipe_recipe", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }
      
      if($parentType == 'sesevent_recipe') {
        $sesrecipe->parent_type = $parentType;
        $sesrecipe->event_id = $event_id;
        $sesrecipe->save();
        $seseventrecipe = Engine_Api::_()->getDbtable('mapevents', 'sesrecipe')->createRow();
        $seseventrecipe->event_id = $event_id;
        $seseventrecipe->recipe_id = $recipe_id;
        $seseventrecipe->save();
      }

      if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
				$sesrecipe->photo_id = $_POST['cover'];
				$sesrecipe->save();
      }
      
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
				$customfieldform->setItem($sesrecipe);
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
        $auth->setAllowed($sesrecipe, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesrecipe, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesrecipe, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesrecipe, $role, 'music', ($i <= $musicMax));
      }
      
      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
     // $sesrecipe->seo_keywords = implode(',',$tags);
      //$sesrecipe->seo_title = $sesrecipe->title;
      $sesrecipe->save();
      $sesrecipe->tags()->addTagMaps($viewer, $tags);
      
      $session = new Zend_Session_Namespace();
      if(!empty($session->album_id)){
				$album_id = $session->album_id;
				if(isset($recipe_id) && isset($sesrecipe->title)){
					Engine_Api::_()->getDbTable('albums', 'sesrecipe')->update(array('recipe_id' => $recipe_id,'owner_id' => $viewer->getIdentity(),'title' => $sesrecipe->title), array('album_id = ?' => $album_id));
					if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
						Engine_Api::_()->getDbTable('albums', 'sesrecipe')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
					}
					Engine_Api::_()->getDbTable('photos', 'sesrecipe')->update(array('recipe_id' => $recipe_id), array('album_id = ?' => $album_id));
					unset($session->album_id);
				}
      }

      // Add activity only if sesrecipe is published
      if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesrecipe->publish_date || strtotime($sesrecipe->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesrecipe, 'sesrecipe_new');
        // make sure action exists before attaching the sesrecipe to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesrecipe);
        }
        
        //Tag Work
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');  
          }
        }
        
        //Send notifications for subscribers
      	Engine_Api::_()->getDbtable('subscriptions', 'sesrecipe')->sendNotifications($sesrecipe);
      	$sesrecipe->is_publish = 1;
      	$sesrecipe->save();
			}
      // Commit
      $db->commit();
    }

    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    
		$redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.redirect.creation', 1);
    if($parentType) {
      $eventCustom_url = Engine_Api::_()->getItem('sesevent_event', $event_id)->custom_url;
      return $this->_helper->redirector->gotoRoute(array('id' => $eventCustom_url), 'sesevent_profile', true);
    } else if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } else if($redirect) {
   	 	return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard','action'=>'edit','recipe_id'=>$sesrecipe->custom_url),'sesrecipe_dashboard',true);
    } else {
		 	return $this->_helper->redirector->gotoRoute(array('action' => 'view','recipe_id'=>$sesrecipe->custom_url),'sesrecipe_entry_view',true);
    }
  }
  
  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesrecipe_recipe';
    $dbTable = 'recipes';
    $resorces_id = 'recipe_id';
    $notificationType = 'liked';
    $actionType = 'sesrecipe_recipe_like';
		
		if($this->_getParam('type',false) && $this->_getParam('type') == 'sesrecipe_album'){
			$type = 'sesrecipe_album';
	    $dbTable = 'albums';
	    $resorces_id = 'album_id';
	    $actionType = 'sesrecipe_album_like';
		} else if($this->_getParam('type',false) && $this->_getParam('type') == 'sesrecipe_photo') {
			$type = 'sesrecipe_photo';
	    $dbTable = 'photos';
	    $resorces_id = 'photo_id';	    
	    $actionType = 'sesrecipe_photo_like';
		}
		
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sesrecipe');
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
          if($subject && empty($subject->title) && $this->_getParam('type') == 'sesrecipe_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('sesrecipe_album', $album_id);
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
    if ($this->_getParam('type') == 'sesrecipe_recipe') {
      $type = 'sesrecipe_recipe';
      $dbTable = 'recipes';
      $resorces_id = 'recipe_id';
      $notificationType = 'sesrecipe_recipe_favourite';
    } else if ($this->_getParam('type') == 'sesrecipe_photo') {
      $type = 'sesrecipe_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
     else if ($this->_getParam('type') == 'sesrecipe_album') {
      $type = 'sesrecipe_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesrecipe')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesrecipe');
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
      $db = Engine_Api::_()->getDbTable('favourites', 'sesrecipe')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesrecipe')->createRow();
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

    $sesrecipe = Engine_Api::_()->getItem('sesrecipe_recipe', $this->getRequest()->getParam('recipe_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($sesrecipe, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesrecipe_Form_Delete();

    if( !$sesrecipe ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Sesrecipe entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $sesrecipe->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->sesrecipe()->deleteRecipe($sesrecipe);;
      
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your sesrecipe entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesrecipe_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function styleAction() {
  
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', null, 'style')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Require user
    if( !$this->_helper->requireUser()->isValid() ) return;
    $user = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Sesrecipe_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_sesrecipe') // @todo this is not a real type
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
      $row->type = 'user_sesrecipe'; // @todo this is not a real type
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
  
  public function linkRecipeAction() {
  
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
  
    $this->view->recipe_id = $recipe_id = $this->_getParam('recipe_id', '0');
    if ($recipe_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : ''; 
    
    $eventTable = Engine_Api::_()->getItemTable('sesevent_event');
    $eventTableName = $eventTable->info('name');
    $recipeMapTable = Engine_Api::_()->getDbTable('mapevents', 'sesrecipe');
    $recipeMapTableName = $recipeMapTable->info('name');
    $select = $eventTable->select()
			->setIntegrityCheck(false)
			->from($eventTableName)
		        ->Joinleft($recipeMapTableName, "$recipeMapTableName.event_id = $eventTableName.event_id", null)
		        ->where($eventTableName.'.event_id !=?', '')
		        ->where($recipeMapTableName.'.recipe_id !=? or recipe_id is null', $recipe_id);
		     
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
    
   if( !$this->getRequest()->isPost() ) 
   return;
    
    $eventIds = $_POST['event'];
    $recipeObject = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    foreach($eventIds as $eventId) {
      $item = Engine_Api::_()->getItem('sesevent_event', $eventId);
      $owner = $item->getOwner();
      $table = Engine_Api::_()->getDbtable('mapevents', 'sesrecipe');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $seseventrecipe = $table->createRow();
	$seseventrecipe->event_id = $eventId;
	$seseventrecipe->recipe_id = $recipe_id;
	$seseventrecipe->request_owner_recipe = 1;
	$seseventrecipe->approved = 0;
	$seseventrecipe->save();
	$recipePageLink = '<a href="' . $recipeObject->getHref() . '">' . ucfirst($recipeObject->getTitle()) . '</a>';
	Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesrecipe_link_event', array("recipePageLink" => $recipePageLink));
      
	
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
  public function recipeRequestAction() {
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesrecipe_main');
    
    $RecipeTable = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
    $RecipeTableName = $RecipeTable->info('name');
    $mapRecipeTable = Engine_Api::_()->getDbtable('mapevents', 'sesrecipe');
    $mapRecipeTableName = $mapRecipeTable->info('name');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $RecipeTable->select()
                        ->setIntegrityCheck(false)
			->from($RecipeTableName, array('owner_id', 'recipe_id'))
		        ->Joinleft($mapRecipeTableName, "$mapRecipeTableName.recipe_id = $RecipeTableName.recipe_id", array('event_id','approved'))
		        ->where($RecipeTableName.'.owner_id =?', $viewerId)
		        ->where($mapRecipeTableName.'.approved =?', 0)
		         ->where($mapRecipeTableName.'.request_owner_event =? and request_owner_event IS NOT null', 1);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }
  
  public function approvedAction() {
  
    $recipe_id = $this->_getParam('recipe_id');
    $event_id = $this->_getParam('event_id');
    $mapRecipeTable = Engine_Api::_()->getDbtable('mapevents', 'sesrecipe');
    $selectMapTable = $mapRecipeTable->select()->where('event_id =?', $event_id)->where('recipe_id =?', $recipe_id)->where('request_owner_event =?', 1);
    $mapResult = $mapRecipeTable->fetchRow($selectMapTable);
    if (!empty($recipe_id)) {
      $recipe = Engine_Api::_()->getItem('sesrecipe_recipe', $event_id);
      if(!$mapResult->approved)
      $approved = 1;
      else
      $approved = 0;
    
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->update('engine4_sesrecipe_mapevents', array(
      'approved' => $approved,
      ), array(
	'event_id = ?' => $event_id,
	'recipe_id = ?' => $recipe_id,
      ));
    }
    $this->_redirect('sesrecipes/recipe-request');
  }
  
  public function rejectRequestAction() {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $recipe_id = $this->_getParam('recipe_id');
    $recipeObject = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    $event_id = $this->_getParam('event_id');
    $eventObject = Engine_Api::_()->getItem('sesevent_event', $event_id);
    $owner = $eventObject->getOwner();
    $mapRecipeTable = Engine_Api::_()->getDbtable('mapevents', 'sesrecipe');
    $selectMapTable = $mapRecipeTable->select()->where('event_id =?', $event_id)->where('recipe_id =?', $recipe_id)->where('request_owner_event =?', 1);
    $mapResult = $mapRecipeTable->fetchRow($selectMapTable);
    $db = $mapResult->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $mapResult->delete();
      $recipePageLink = '<a href="' . $recipeObject->getHref() . '">' . ucfirst($recipeObject->getTitle()) . '</a>';
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $eventObject, 'sesrecipe_reject_event_request', array("recipePageLink" => $recipePageLink));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirect('sesrecipes/recipe-request');
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
        'parent_type' => 'sesrecipe_recipe',
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
        throw new Sesrecipe_Model_Exception($e->getMessage(), $e->getCode());
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
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesrecipe');
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
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesrecipe');
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
    $this->view->photo = Engine_Api::_()->getItem('sesrecipe_photo', $photo_id);
  }
  
  public function saveInformationAction() {
  
    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'sesrecipe')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }
  
  public function removeAction() {

    if(empty($_POST['photo_id']))die('error');
    $photo_id = (int) $this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('sesrecipe_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'sesrecipe')->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('photos', 'sesrecipe')->delete(array('photo_id =?' => $photo_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  
  public function getRecipeAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getrecipe'] = true;
    $recipes = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getSesrecipesSelect($value);
    foreach ($recipes as $recipe) {
      $video_icon = $this->view->itemPhoto($recipe, 'thumb.icon');
      $sesdata[] = array(
          'id' => $recipe->recipe_id,
          'recipe_id' => $recipe->recipe_id,
          'label' => $recipe->title,
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
    $typeItem = ucwords(str_replace(array('sesrecipe_'), '', $attachment->getType()));
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
 
    $this->view->type = $this->_getParam('type', 'recipe');
    $this->view->recipe_id = $recipe_id = $this->_getParam('recipe_id');
    $this->view->recipe = $recipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    if (!$recipe)
      return;
    $this->view->form = $form = new Sesrecipe_Form_Location();
    $form->populate($recipe->toArray());
  }
  
  public function customUrlCheckAction(){
    $value = $this->sanitize($this->_getParam('value', null));
    if(!$value) {
      echo json_encode(array('error'=>true));die;
    }
    $recipe_id = $this->_getParam('recipe_id',null);
    $custom_url = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->checkCustomUrl($value,$recipe_id);
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
  
	public function getRecipesAction() {
		$sesdata = array();
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$recipeTable = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
		$recipeTableName = $recipeTable->info('name');
		$recipeClaimTable = Engine_Api::_()->getDbtable('claims', 'sesrecipe');
		$recipeClaimTableName = $recipeClaimTable->info('name');
		$text = $this->_getParam('text', null);
		$selectClaimTable = $recipeClaimTable->select()
		->from($recipeClaimTableName, 'recipe_id')
		->where('user_id =?', $viewerId);
		$claimedRecipes = $recipeClaimTable->fetchAll($selectClaimTable);
	
		$currentTime = date('Y-m-d H:i:s');
		$select = $recipeTable->select()
		->where('draft =?', 0)
		->where("publish_date <= '$currentTime' OR publish_date = ''")
		->where('owner_id !=?', $viewerId)
		->where($recipeTableName .'.title  LIKE ? ', '%' .$text. '%');
		if(count($claimedRecipes) > 0)
		$select->where('recipe_id NOT IN(?)', $selectClaimTable);
		$select->order('recipe_id ASC')->limit('40');
		$recipes = $recipeTable->fetchAll($select);
		foreach ($recipes as $recipe) {
			$recipe_icon_photo = $this->view->itemPhoto($recipe, 'thumb.icon');
			$sesdata[] = array(
			'id' => $recipe->recipe_id,
			'label' => $recipe->title,
			'photo' => $recipe_icon_photo
			);
		}
		return $this->_helper->json($sesdata);
	}
	
	public function rssFeedAction() {

      $this->_helper->layout->disableLayout();
      $value['fetchAll'] = true;
      $value['rss'] = 1;
      $value['orderby'] = 'recipe_id';
      $this->view->recipes  = Engine_Api::_()->getDbTable('recipes', 'sesrecipe')->getSesrecipesSelect($value);
      $this->getResponse()->setHeader('Content-type', 'text/xml');
	}
  
}
