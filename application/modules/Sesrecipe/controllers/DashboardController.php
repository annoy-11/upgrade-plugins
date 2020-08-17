<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesrecipe_DashboardController extends Core_Controller_Action_Standard {
  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('recipe_id', null);
    $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if ($recipe_id) {
      $recipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
      if ($recipe)
        Engine_Api::_()->core()->setSubject($recipe);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isRecipeAdmin = Engine_Api::_()->sesrecipe()->isRecipeAdmin($recipe, 'edit');
    $sesrecipe_edit = Zend_Registry::isRegistered('sesrecipe_edit') ? Zend_Registry::get('sesrecipe_edit') : null;
    if (empty($sesrecipe_edit))
      return $this->_forward('notfound', 'error', 'core');
		if (!$isRecipeAdmin)
    return $this->_forward('requireauth', 'error', 'core');
  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->recipe = $sesrecipe = Engine_Api::_()->core()->getSubject(); 
		$package_id = $sesrecipe->package_id;
		$package = Engine_Api::_()->getItem('sesrecipepackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');
		
		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesrecipe')->profileFieldId();
		$this->view->form = $form = new Sesrecipe_Form_Custom_Dashboardfields(array('item' => $sesrecipe,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();
		
	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->recipe = $sesrecipe = Engine_Api::_()->core()->getSubject(); 
    if (isset($sesrecipe->category_id) && $sesrecipe->category_id != 0)
    $this->view->category_id = $sesrecipe->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
    $this->view->category_id = $_POST['category_id'];
    else
    $this->view->category_id = 0;
    if (isset($sesrecipe->subsubcat_id) && $sesrecipe->subsubcat_id != 0)
    $this->view->subsubcat_id = $sesrecipe->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
    $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
    $this->view->subsubcat_id = 0;
    if (isset($sesrecipe->subcat_id) && $sesrecipe->subcat_id != 0)
    $this->view->subcat_id = $sesrecipe->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
    $this->view->subcat_id = $_POST['subcat_id'];
    else
    $this->view->subcat_id = 0;
    $sesrecipe_edit = Zend_Registry::isRegistered('sesrecipe_edit') ? Zend_Registry::get('sesrecipe_edit') : null;
    if (empty($sesrecipe_edit))
      return $this->_forward('notfound', 'error', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesrecipe')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('sesrecipe_recipe') )
    Engine_Api::_()->core()->setSubject($sesrecipe);
    
    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesrecipe_main');
      
    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesrecipe_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form
    $form->populate($sesrecipe->toArray());
    $form->getElement('recipestyle')->setValue($sesrecipe->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sesrecipe_recipe',$sesrecipe->recipe_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
      
      if($form->getElement('country'))
      $form->getElement('country')->setValue($latLng->country);
      if($form->getElement('state'))
      $form->getElement('state')->setValue($latLng->state);
      if($form->getElement('city'))
      $form->getElement('city')->setValue($latLng->city);
      if($form->getElement('zip'))
      $form->getElement('zip')->setValue($latLng->zip);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($sesrecipe->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($sesrecipe->category_id);

    $tagStr = '';
    foreach( $sesrecipe->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($sesrecipe, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($sesrecipe, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
      
      if ($form->auth_video){
        if( $auth->isAllowed($sesrecipe, $role, 'video') ) {
          $form->auth_video->setValue($role);
        }
      }
      
      if ($form->auth_music){
        if( $auth->isAllowed($sesrecipe, $role, 'music') ) {
          $form->auth_music->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $sesrecipe->draft == "0" )
    $form->removeElement('draft');


    // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    
    try
    {
      $values = $form->getValues();
      if($_POST['recipestyle'])
      $values['style'] = $_POST['recipestyle'];
      $sesrecipe->setFromArray($values);
      $sesrecipe->modified_date = date('Y-m-d H:i:s');
			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesrecipe->publish_date =$starttime;
			}
			//else{
			//	$sesrecipe->publish_date = '';	
			//}
      $sesrecipe->save();
      unset($_POST['title']);
      unset($_POST['tags']);
      unset($_POST['category_id']);
      unset($_POST['subcat_id']);
      unset($_POST['MAX_FILE_SIZE']);
      unset($_POST['body']);
      unset($_POST['search']);
      unset($_POST['execute']);
      unset($_POST['token']);
      unset($_POST['submit']);
      $values['fields'] = $_POST;
      $values['fields']['0_0_1'] = '2';
      
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && $_POST['location'] && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $sesrecipe->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesrecipe_recipe") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else if($_POST['location']) {
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "sesrecipe_recipe" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesrecipe->getIdentity().'";');
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $sesrecipe->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesrecipe_recipe", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else if(empty($_POST['location'])) {
        $sesrecipe->location = '';
        $sesrecipe->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "sesrecipe_recipe" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesrecipe->getIdentity().'";');
      }
      
      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($sesrecipe->publish_date < $currentDate) {
          $sesrecipe->publish_date = $currentDate;
          $sesrecipe->save();
        }
      }
    
      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($sesrecipe);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($sesrecipe);
      $profile_field_value = $view->FieldValueLoop($sesrecipe, $fieldStructure);

      // Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search($values['auth_video'], $roles);
      $musicMax = array_search($values['auth_music'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sesrecipe, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesrecipe, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesrecipe, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesrecipe, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sesrecipe->tags()->setTagMaps($viewer, $tags);
			
			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$sesrecipe->setPhoto($form->photo_file,'direct');	
			}
			
      // insert new activity if sesrecipe is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesrecipe);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$sesrecipe->publish_date || strtotime($sesrecipe->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesrecipe, 'sesrecipe_new');
          // make sure action exists before attaching the sesrecipe to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesrecipe);
        }
        $sesrecipe->is_publish = 1;
      	$sesrecipe->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($sesrecipe) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'sesrecipe')
          ->sendNotifications($sesrecipe);

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'sesrecipe_dashboard', 'action' => 'edit', 'recipe_id' => $sesrecipe->custom_url));
  }
	
	public function upgradeAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->recipe = $sesrecipe = Engine_Api::_()->core()->getSubject(); 
    //current package
		if(!empty($sesrecipe->orderspackage_id)){
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesrecipepackage_orderspackage',$sesrecipe->orderspackage_id);
			if(!$this->view->currentPackage ){
				$this->view->currentPackage = 	Engine_Api::_()->getItem('sesrecipepackage_package',$sesrecipe->package_id);	
			}
		}
		else
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesrecipepackage_package',$sesrecipe->package_id);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		//get upgrade packages
		$this->view->upgradepackage =  Engine_Api::_()->getDbTable('packages','sesrecipepackage')->getPackage(array('show_upgrade'=>1,'member_level'=>$viewer->level_id,'not_in_id'=>$sesrecipe->package_id));
		
	}
		
	 public function removeMainphotoAction() {
      //GET Recipe ID AND ITEM
	    $recipe = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('recipes', 'sesrecipe')->getAdapter();
      $db->beginTransaction();
      try {
        $recipe->photo_id = '';
				$recipe->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'recipe_id' => $recipe->custom_url), "sesrecipe_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->recipe = $recipe = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $recipe->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesrecipe_Form_Dashboard_Mainphoto();
    $form->populate($recipe->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getAdapter();
    $db->beginTransaction();
    try {
      $recipe->setPhoto($_FILES['background']);
      $recipe->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'recipe_id' => $recipe->custom_url), "sesrecipe_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->recipe = $recipe = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $recipe->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'sesrecipe_recipe')
            ->where('id = ?', $recipe->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesrecipe_Form_Dashboard_Style();
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
      $row->type = 'sesrecipe_recipe';
      $row->id = $recipe->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }
  
    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->recipe = $recipe = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $recipe->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesrecipe_Form_Dashboard_Seo();
    
    $form->populate($recipe->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getAdapter();
    $db->beginTransaction();
    try {
      $recipe->setFromArray($_POST);
      $recipe->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
  
  public function editPhotoAction() {
  
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    
    $this->view->recipe = $recipe = Engine_Api::_()->core()->getSubject(); 

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesrecipe_Form_Edit_Photo();

    if( empty($recipe->photo_id) ) {
      $form->removeElement('remove');
    }

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Uploading a new photo
    if( $form->Filedata->getValue() !== null ) {
      $db = $recipe->getTable()->getAdapter();
      $db->beginTransaction();
      
      try {
      
        $fileElement = $form->Filedata;

       // $recipe->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'sesrecipe','sesrecipe_recipe','',$recipe,true);
        $recipe->photo_id = $photo_id;
        $recipe->save();
        $db->commit();
      }

      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e )
      {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      }

      // Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
    }
  }
  
  public function removePhotoAction() {
  
    //Get form
    $this->view->form = $form = new Sesrecipe_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $recipe = Engine_Api::_()->core()->getSubject();
    $recipe->photo_id = 0;
    $recipe->save();
    
    $this->view->status = true;
    
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }
  
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $sesrecipe_edit = Zend_Registry::isRegistered('sesrecipe_edit') ? Zend_Registry::get('sesrecipe_edit') : null;
    if (empty($sesrecipe_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->recipe = $recipe = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $recipe->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesrecipe_Form_Dashboard_Contactinformation();
    
    $form->populate($recipe->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
  
    $db = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getAdapter();
    $db->beginTransaction();
    try {
      $recipe->recipe_contact_name = isset($_POST['recipe_contact_name']) ? $_POST['recipe_contact_name'] : '';
      $recipe->recipe_contact_email = isset($_POST['recipe_contact_email']) ? $_POST['recipe_contact_email'] : '';
      $recipe->recipe_contact_phone = isset($_POST['recipe_contact_phone']) ? $_POST['recipe_contact_phone'] : '';
      $recipe->recipe_contact_website = isset($_POST['recipe_contact_website']) ? $_POST['recipe_contact_website'] : '';
      $recipe->recipe_contact_facebook = isset($_POST['recipe_contact_facebook']) ? $_POST['recipe_contact_facebook'] : '';
      $recipe->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }
  
  public function recipeRoleAction() {
  
    $this->view->recipe = $sesrecipe = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'sesrecipe')->getRecipeAdmins(array('recipe_id' => $sesrecipe->recipe_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('sesrecipe_recipe', $this->_getParam('recipe_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $recipeRoleTable = Engine_Api::_()->getDbTable('roles', 'sesrecipe');
    $roleIds = $recipeRoleTable->select()->from($recipeRoleTable->info('name'), 'user_id')->where('recipe_id =?',$this->_getParam('recipe_id', null))->query()->fetchAll();
    foreach($roleIds as $roleID) {
      $roleIDArray[] = $roleID['user_id'];
    }
    $diffIds = array_diff($users, $roleIDArray);  
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $usersTableName = $users_table->info('name');
    $select = $users_table->select()->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');                   
		if ($diffIds)
		$select->where($usersTableName . '.user_id IN (?)', $diffIds);
// 		else
// 		$select->where($usersTableName . '.user_id IN (?)', 0);
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
  
  public function saveRecipeAdminAction() {
    $data = explode(',',$_POST['data']);
    $sesrecipe_edit = Zend_Registry::isRegistered('sesrecipe_edit') ? Zend_Registry::get('sesrecipe_edit') : null;
    if (empty($sesrecipe_edit))
      return $this->_forward('notfound', 'error', 'core');
    $recipe_id = $this->_getParam('recipe_id', null);
    $this->view->owner_id = Engine_Api::_()->getItem('sesrecipe_recipe',$recipe_id)->owner_id; 
    foreach($data as $recipeAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'sesrecipe')->isRecipeAdmin($recipe_id, $recipeAdminId);
      if($checkUser)
      continue;
			$roleTable = Engine_Api::_()->getDbtable('roles', 'sesrecipe');
			$row = $roleTable->createRow();
			$row->recipe_id = $recipe_id;
			$row->user_id = $recipeAdminId;
			$row->save();
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'sesrecipe')->getRecipeAdmins(array('recipe_id' => $recipe_id));
  }
  
  public function deleteRecipeAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_sesrecipe_roles', array(
			'recipe_id = ?' => $_POST['recipe_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }
  
  public function editLocationAction() {

    $this->view->recipe = $sesrecipe = Engine_Api::_()->core()->getSubject();
    $userLocation = $sesrecipe->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sesrecipe->getType(), $sesrecipe->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Sesrecipe_Form_Locationedit();
    $form->populate(array(
        'ses_edit_location' => $userLocation,
        'ses_lat' => $locationLatLng['lat'],
        'ses_lng' => $locationLatLng['lng'],
        'ses_zip' => $locationLatLng['zip'],
        'ses_city' => $locationLatLng['city'],
        'ses_state' => $locationLatLng['state'],
        'ses_country' => $locationLatLng['country'],
    ));
    if ($this->getRequest()->getPost()) {
      Engine_Api::_()->getItemTable('sesrecipe_recipe')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'recipe_id = ?' => $sesrecipe->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $sesrecipe->recipe_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "sesrecipe_recipe")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'sesrecipe_dashboard', 'action' => 'edit-location', 'recipe_id' => $sesrecipe->custom_url));
    }
    //Render
  }

}
