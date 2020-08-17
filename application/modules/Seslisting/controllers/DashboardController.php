<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_DashboardController extends Core_Controller_Action_Standard {
  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('seslisting', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('listing_id', null);
    $listing_id = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getListingId($id);
    if ($listing_id) {
      $listing = Engine_Api::_()->getItem('seslisting', $listing_id);
      if ($listing)
        Engine_Api::_()->core()->setSubject($listing);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isListingAdmin = Engine_Api::_()->seslisting()->isListingAdmin($listing, 'edit');
    $seslisting_edit = Zend_Registry::isRegistered('seslisting_edit') ? Zend_Registry::get('seslisting_edit') : null;
    if (empty($seslisting_edit))
      return $this->_forward('notfound', 'error', 'core');
		if (!$isListingAdmin)
    return $this->_forward('requireauth', 'error', 'core');
  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->listing = $seslisting = Engine_Api::_()->core()->getSubject();
		$package_id = $seslisting->package_id;
		$package = Engine_Api::_()->getItem('seslistingpackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'seslisting')->profileFieldId();
		$this->view->form = $form = new Seslisting_Form_Custom_Dashboardfields(array('item' => $seslisting,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->listing = $seslisting = Engine_Api::_()->core()->getSubject();
    if (isset($seslisting->category_id) && $seslisting->category_id != 0)
    $this->view->category_id = $seslisting->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
    $this->view->category_id = $_POST['category_id'];
    else
    $this->view->category_id = 0;
    if (isset($seslisting->subsubcat_id) && $seslisting->subsubcat_id != 0)
    $this->view->subsubcat_id = $seslisting->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
    $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
    $this->view->subsubcat_id = 0;
    if (isset($seslisting->subcat_id) && $seslisting->subcat_id != 0)
    $this->view->subcat_id = $seslisting->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
    $this->view->subcat_id = $_POST['subcat_id'];
    else
    $this->view->subcat_id = 0;
    $seslisting_edit = Zend_Registry::isRegistered('seslisting_edit') ? Zend_Registry::get('seslisting_edit') : null;
    if (empty($seslisting_edit))
      return $this->_forward('notfound', 'error', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'seslisting')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('seslisting') )
    Engine_Api::_()->core()->setSubject($seslisting);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('seslisting', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seslisting_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'seslisting')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Seslisting_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form

    $form->populate($seslisting->toArray());
    $form->populate(array(
        'networks' => explode(",",$seslisting->networks),
        'levels' => explode(",",$seslisting->levels)
    ));
    $form->getElement('listingstyle')->setValue($seslisting->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('seslisting',$seslisting->listing_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($seslisting->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($seslisting->category_id);

    $tagStr = '';
    foreach( $seslisting->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($seslisting, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($seslisting, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }

      if ($form->auth_video){
        if( $auth->isAllowed($seslisting, $role, 'video') ) {
          $form->auth_video->setValue($role);
        }
      }

      if ($form->auth_music){
        if( $auth->isAllowed($seslisting, $role, 'music') ) {
          $form->auth_music->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $seslisting->draft == "0" )
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
      if($_POST['listingstyle'])
      $values['style'] = $_POST['listingstyle'];
      $seslisting->setFromArray($values);
      $seslisting->modified_date = date('Y-m-d H:i:s');
			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$seslisting->publish_date =$starttime;
			}
			//else{
			//	$seslisting->publish_date = '';
			//}

        if(isset($values['levels']))
            $seslisting->levels = implode(',',$values['levels']);

        if(isset($values['networks']))
            $seslisting->networks = implode(',',$values['networks']);

      $seslisting->save();
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

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && $_POST['location']) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $seslisting->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","seslisting") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        $seslisting->location = '';
        $seslisting->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "seslisting" AND `engine4_sesbasic_locations`.`resource_id` = "'.$seslisting->getIdentity().'";');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($seslisting->publish_date < $currentDate) {
          $seslisting->publish_date = $currentDate;
          $seslisting->save();
        }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($seslisting);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($seslisting);
      $profile_field_value = $view->FieldValueLoop($seslisting, $fieldStructure);

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
        $auth->setAllowed($seslisting, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($seslisting, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($seslisting, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($seslisting, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $seslisting->tags()->setTagMaps($viewer, $tags);

			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$seslisting->setPhoto($form->photo_file,'direct');
			}

      // insert new activity if seslisting is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($seslisting);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$seslisting->publish_date || strtotime($seslisting->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $seslisting, 'seslisting_new');
          // make sure action exists before attaching the seslisting to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $seslisting);
        }
        $seslisting->is_publish = 1;
      	$seslisting->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($seslisting) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'seslisting')
          ->sendNotifications($seslisting);

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'seslisting_dashboard', 'action' => 'edit', 'listing_id' => $seslisting->custom_url));
  }

	public function upgradeAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->listing = $seslisting = Engine_Api::_()->core()->getSubject();
    //current package
		if(!empty($seslisting->orderspackage_id)){
			$this->view->currentPackage = 	Engine_Api::_()->getItem('seslistingpackage_orderspackage',$seslisting->orderspackage_id);
			if(!$this->view->currentPackage ){
				$this->view->currentPackage = 	Engine_Api::_()->getItem('seslistingpackage_package',$seslisting->package_id);
			}
		}
		else
			$this->view->currentPackage = 	Engine_Api::_()->getItem('seslistingpackage_package',$seslisting->package_id);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		//get upgrade packages
		$this->view->upgradepackage =  Engine_Api::_()->getDbTable('packages','seslistingpackage')->getPackage(array('show_upgrade'=>1,'member_level'=>$viewer->level_id,'not_in_id'=>$seslisting->package_id));

	}

	 public function removeMainphotoAction() {
      //GET Listing ID AND ITEM
	    $listing = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('seslistings', 'seslisting')->getAdapter();
      $db->beginTransaction();
      try {
        $listing->photo_id = '';
				$listing->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'listing_id' => $listing->custom_url), "seslisting_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->listing = $listing = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $listing->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Seslisting_Form_Dashboard_Mainphoto();
    $form->populate($listing->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getAdapter();
    $db->beginTransaction();
    try {
      $listing->setPhoto($_FILES['background']);
      $listing->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'listing_id' => $listing->custom_url), "seslisting_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->listing = $listing = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $listing->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'seslisting')
            ->where('id = ?', $listing->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Seslisting_Form_Dashboard_Style();
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
      $row->type = 'seslisting';
      $row->id = $listing->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->listing = $listing = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $listing->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Seslisting_Form_Dashboard_Seo();

    $form->populate($listing->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getAdapter();
    $db->beginTransaction();
    try {
      $listing->setFromArray($_POST);
      $listing->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->listing = $listing = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Seslisting_Form_Edit_Photo();

    if( empty($listing->photo_id) ) {
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
      $db = $listing->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

       // $listing->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'seslisting','seslisting','',$listing,true);
        $listing->photo_id = $photo_id;
        $listing->save();
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
    $this->view->form = $form = new Seslisting_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $listing = Engine_Api::_()->core()->getSubject();
    $listing->photo_id = 0;
    $listing->save();

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
    $seslisting_edit = Zend_Registry::isRegistered('seslisting_edit') ? Zend_Registry::get('seslisting_edit') : null;
    if (empty($seslisting_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->listing = $listing = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $listing->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Seslisting_Form_Dashboard_Contactinformation();

    $form->populate($listing->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getAdapter();
    $db->beginTransaction();
    try {
      $listing->listing_contact_name = isset($_POST['listing_contact_name']) ? $_POST['listing_contact_name'] : '';
      $listing->listing_contact_email = isset($_POST['listing_contact_email']) ? $_POST['listing_contact_email'] : '';
      $listing->listing_contact_phone = isset($_POST['listing_contact_phone']) ? $_POST['listing_contact_phone'] : '';
      $listing->listing_contact_website = isset($_POST['listing_contact_website']) ? $_POST['listing_contact_website'] : '';
      $listing->listing_contact_facebook = isset($_POST['listing_contact_facebook']) ? $_POST['listing_contact_facebook'] : '';
      $listing->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }

  public function listingRoleAction() {

    $this->view->listing = $seslisting = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'seslisting')->getListingAdmins(array('listing_id' => $seslisting->listing_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('seslisting', $this->_getParam('listing_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $listingRoleTable = Engine_Api::_()->getDbTable('roles', 'seslisting');
    $roleIds = $listingRoleTable->select()->from($listingRoleTable->info('name'), 'user_id')->where('listing_id =?',$this->_getParam('listing_id', null))->query()->fetchAll();
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

  public function saveListingAdminAction() {
    $data = explode(',',$_POST['data']);
    $seslisting_edit = Zend_Registry::isRegistered('seslisting_edit') ? Zend_Registry::get('seslisting_edit') : null;
    if (empty($seslisting_edit))
      return $this->_forward('notfound', 'error', 'core');
    $listing_id = $this->_getParam('listing_id', null);
    $this->view->owner_id = Engine_Api::_()->getItem('seslisting',$listing_id)->owner_id;
    foreach($data as $listingAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'seslisting')->isListingAdmin($listing_id, $listingAdminId);
      if($checkUser)
      continue;
			$roleTable = Engine_Api::_()->getDbtable('roles', 'seslisting');
			$row = $roleTable->createRow();
			$row->listing_id = $listing_id;
			$row->user_id = $listingAdminId;
			$row->save();
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'seslisting')->getListingAdmins(array('listing_id' => $listing_id));
  }

  public function deleteListingAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_seslisting_roles', array(
			'listing_id = ?' => $_POST['listing_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }

  public function editLocationAction() {
   
    $this->view->listing = $seslisting = Engine_Api::_()->core()->getSubject();
    $userLocation = $seslisting->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($seslisting->getType(), $seslisting->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Seslisting_Form_Locationedit();
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
      Engine_Api::_()->getItemTable('seslisting')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'listing_id = ?' => $seslisting->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $seslisting->listing_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "seslisting")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'seslisting_dashboard', 'action' => 'edit-location', 'listing_id' => $seslisting->custom_url));
    }
    //Render
  }

}
