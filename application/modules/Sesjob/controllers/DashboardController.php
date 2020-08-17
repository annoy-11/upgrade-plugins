<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_DashboardController extends Core_Controller_Action_Standard {
  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('sesjob_job', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('job_id', null);
    $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
    if ($job_id) {
      $job = Engine_Api::_()->getItem('sesjob_job', $job_id);
      if ($job)
        Engine_Api::_()->core()->setSubject($job);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isJobAdmin = Engine_Api::_()->sesjob()->isJobAdmin($job, 'edit');
    $sesjob_edit = Zend_Registry::isRegistered('sesjob_edit') ? Zend_Registry::get('sesjob_edit') : null;
    if (empty($sesjob_edit))
      return $this->_forward('notfound', 'error', 'core');
		if (!$isJobAdmin)
    return $this->_forward('requireauth', 'error', 'core');
  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();
		$package_id = $sesjob->package_id;
		$package = Engine_Api::_()->getItem('sesjobpackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesjob')->profileFieldId();
		$this->view->form = $form = new Sesjob_Form_Custom_Dashboardfields(array('item' => $sesjob,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();
    if (isset($sesjob->category_id) && $sesjob->category_id != 0)
    $this->view->category_id = $sesjob->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
    $this->view->category_id = $_POST['category_id'];
    else
    $this->view->category_id = 0;
    if (isset($sesjob->subsubcat_id) && $sesjob->subsubcat_id != 0)
    $this->view->subsubcat_id = $sesjob->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
    $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
    $this->view->subsubcat_id = 0;
    if (isset($sesjob->subcat_id) && $sesjob->subcat_id != 0)
    $this->view->subcat_id = $sesjob->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
    $this->view->subcat_id = $_POST['subcat_id'];
    else
    $this->view->subcat_id = 0;
    $sesjob_edit = Zend_Registry::isRegistered('sesjob_edit') ? Zend_Registry::get('sesjob_edit') : null;
    if (empty($sesjob_edit))
      return $this->_forward('notfound', 'error', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesjob')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('sesjob_job') )
    Engine_Api::_()->core()->setSubject($sesjob);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesjob_job', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesjob_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form

    $form->populate($sesjob->toArray());
    $form->populate(array(
        'networks' => explode(",",$sesjob->networks),
        'levels' => explode(",",$sesjob->levels),
        'education_id' => explode(',', $sesjob->education_id)
    ));

    $company = Engine_Api::_()->getItem('sesjob_company', $sesjob->company_id);
    if($company) {
        $form->populate($company->toArray());
    }

    $form->getElement('jobstyle')->setValue($sesjob->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sesjob_job',$sesjob->job_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($sesjob->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($sesjob->category_id);

    $tagStr = '';
    foreach( $sesjob->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($sesjob, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($sesjob, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $sesjob->draft == "0" )
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
      if($_POST['jobstyle'])
      $values['style'] = $_POST['jobstyle'];
      $sesjob->setFromArray($values);
      $sesjob->modified_date = date('Y-m-d H:i:s');
			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesjob->publish_date =$starttime;
			}
			//else{
			//	$sesjob->publish_date = '';
			//}

        if(isset($values['levels']))
            $sesjob->levels = implode(',',$values['levels']);

        if(isset($values['networks']))
            $sesjob->networks = implode(',',$values['networks']);

        if(isset($values['education_id']))
            $sesjob->education_id = implode(',',$values['education_id']);

      $sesjob->save();
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
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $sesjob->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesjob_job") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        $sesjob->location = '';
        $sesjob->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "sesjob_job" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesjob->getIdentity().'";');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($sesjob->publish_date < $currentDate) {
          $sesjob->publish_date = $currentDate;
          $sesjob->save();
        }
      }

      //Company work
      if($company) {
        $company->company_name = $values['company_name'];
        $company->company_websiteurl = $values['company_websiteurl'];
        $company->company_description = $values['company_description'];
        $company->industry_id = $values['industry_id'];
        $company->save();
      }
      //Company Work End

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($sesjob);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($sesjob);
      $profile_field_value = $view->FieldValueLoop($sesjob, $fieldStructure);

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
        $auth->setAllowed($sesjob, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesjob, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesjob, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesjob, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sesjob->tags()->setTagMaps($viewer, $tags);

			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$sesjob->setPhoto($form->photo_file,'direct');
			}

      // insert new activity if sesjob is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesjob);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$sesjob->publish_date || strtotime($sesjob->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesjob, 'sesjob_new');
          // make sure action exists before attaching the sesjob to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesjob);
        }
        $sesjob->is_publish = 1;
      	$sesjob->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($sesjob) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'sesjob')
          ->sendNotifications($sesjob);

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'sesjob_dashboard', 'action' => 'edit', 'job_id' => $sesjob->custom_url));
  }

	public function upgradeAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();
    //current package
		if(!empty($sesjob->orderspackage_id)){
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesjobpackage_orderspackage',$sesjob->orderspackage_id);
			if(!$this->view->currentPackage ){
				$this->view->currentPackage = 	Engine_Api::_()->getItem('sesjobpackage_package',$sesjob->package_id);
			}
		}
		else
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesjobpackage_package',$sesjob->package_id);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		//get upgrade packages
		$this->view->upgradepackage =  Engine_Api::_()->getDbTable('packages','sesjobpackage')->getPackage(array('show_upgrade'=>1,'member_level'=>$viewer->level_id,'not_in_id'=>$sesjob->package_id));

	}

	 public function removeMainphotoAction() {
      //GET Job ID AND ITEM
	    $job = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('jobs', 'sesjob')->getAdapter();
      $db->beginTransaction();
      try {
        $job->photo_id = '';
				$job->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'job_id' => $job->custom_url), "sesjob_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->job = $job = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $job->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesjob_Form_Dashboard_Mainphoto();
    $form->populate($job->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getAdapter();
    $db->beginTransaction();
    try {
      $job->setPhoto($_FILES['background']);
      $job->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'job_id' => $job->custom_url), "sesjob_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->job = $job = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $job->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'sesjob_job')
            ->where('id = ?', $job->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesjob_Form_Dashboard_Style();
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
      $row->type = 'sesjob_job';
      $row->id = $job->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->job = $job = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $job->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesjob_Form_Dashboard_Seo();

    $form->populate($job->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getAdapter();
    $db->beginTransaction();
    try {
      $job->setFromArray($_POST);
      $job->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->job = $job = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesjob_Form_Edit_Photo();

    if( empty($job->photo_id) ) {
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
      $db = $job->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

       // $job->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'sesjob','sesjob_job','',$job,true);
        $job->photo_id = $photo_id;
        $job->save();
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
    $this->view->form = $form = new Sesjob_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $job = Engine_Api::_()->core()->getSubject();
    $job->photo_id = 0;
    $job->save();

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
    $sesjob_edit = Zend_Registry::isRegistered('sesjob_edit') ? Zend_Registry::get('sesjob_edit') : null;
    if (empty($sesjob_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->job = $job = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $job->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesjob_Form_Dashboard_Contactinformation();

    $form->populate($job->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getAdapter();
    $db->beginTransaction();
    try {
      $job->job_contact_name = isset($_POST['job_contact_name']) ? $_POST['job_contact_name'] : '';
      $job->job_contact_email = isset($_POST['job_contact_email']) ? $_POST['job_contact_email'] : '';
      $job->job_contact_phone = isset($_POST['job_contact_phone']) ? $_POST['job_contact_phone'] : '';
      $job->job_contact_website = isset($_POST['job_contact_website']) ? $_POST['job_contact_website'] : '';
      $job->job_contact_facebook = isset($_POST['job_contact_facebook']) ? $_POST['job_contact_facebook'] : '';
      $job->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }

  public function jobRoleAction() {

    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'sesjob')->getJobAdmins(array('job_id' => $sesjob->job_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('sesjob_job', $this->_getParam('job_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $jobRoleTable = Engine_Api::_()->getDbTable('roles', 'sesjob');
    $roleIds = $jobRoleTable->select()->from($jobRoleTable->info('name'), 'user_id')->where('job_id =?',$this->_getParam('job_id', null))->query()->fetchAll();
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

  public function saveJobAdminAction() {
    $data = explode(',',$_POST['data']);
    $sesjob_edit = Zend_Registry::isRegistered('sesjob_edit') ? Zend_Registry::get('sesjob_edit') : null;
    if (empty($sesjob_edit))
      return $this->_forward('notfound', 'error', 'core');
    $job_id = $this->_getParam('job_id', null);
    $this->view->owner_id = Engine_Api::_()->getItem('sesjob_job',$job_id)->owner_id;
    foreach($data as $jobAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'sesjob')->isJobAdmin($job_id, $jobAdminId);
      if($checkUser)
      continue;
			$roleTable = Engine_Api::_()->getDbtable('roles', 'sesjob');
			$row = $roleTable->createRow();
			$row->job_id = $job_id;
			$row->user_id = $jobAdminId;
			$row->save();
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'sesjob')->getJobAdmins(array('job_id' => $job_id));
  }


  public function sendmailAction() {

    $application = Engine_Api::_()->getItem('sesjob_application', $this->getRequest()->getParam('application_id'));
    $application_id = $application->getIdentity();
    $job_id = $this->_getParam('job_id', null);
    $job = Engine_Api::_()->getItem('sesjob_job', $job_id);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Dashboard_Sendmail();
    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
        return;

    if( !$form->isValid($this->getRequest()->getPost()) )
        return;

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $values = $form->getValues();
    $email = $application->email;

    try {
       Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'sesjob_application_message', array('sender_title' => $job->getOwner()->getTitle(), 'object_link' => $job->getHref(), 'object_title' => $job->getTitle(), 'host' => $_SERVER['HTTP_HOST'], 'message' => $values['message']));

    } catch( Exception $e ) {
      //$db->rollBack();
      //throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('You have successfully sent message to applicant.');
    return $this->_forward('success' ,'utility', 'core', array(
      'smoothboxClose' => true,
      //'parentRefresh' => false,
      'messages' => Array($this->view->message)
    ));
  }


  public function deleteApplicationAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $db->delete('engine4_sesjob_applications', array('application_id = ?' => $_POST['application_id']));
  }

  public function deleteJobAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_sesjob_roles', array(
			'job_id = ?' => $_POST['job_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }

  public function applicationsAction() {

    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();


    $params['job_id'] = $sesjob->job_id;
    $this->view->paginator = Engine_Api::_()->getDbTable('applications', 'sesjob')->getApplications($params);

  }

  public function editLocationAction() {

    $this->view->job = $sesjob = Engine_Api::_()->core()->getSubject();
    $userLocation = $sesjob->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sesjob->getType(), $sesjob->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Sesjob_Form_Locationedit();
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
      Engine_Api::_()->getItemTable('sesjob_job')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'job_id = ?' => $sesjob->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $sesjob->job_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "sesjob_job")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'sesjob_dashboard', 'action' => 'edit-location', 'job_id' => $sesjob->custom_url));
    }
    //Render
  }

}
