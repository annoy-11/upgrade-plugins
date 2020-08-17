<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_IndexController extends Core_Controller_Action_Standard
{
  public function init() {
		// only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesjob_job', null, 'view')->isValid() ) return;
    $id = $this->_getParam('job_id', $this->_getParam('id', null));
    $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
    if ($job_id) {
      $job = Engine_Api::_()->getItem('sesjob_job', $job_id);
      if ($job) {
		Engine_Api::_()->core()->setSubject($job);
      }
    }
  }


  public function downloadAction() {

    $application = Engine_Api::_()->getItem('sesjob_application', $this->_getParam('id'));
    $storage = Engine_Api::_()->getItem('storage_file', $application->file_id);

    if($storage->service_id == 2) {
      $servicesTable = Engine_Api::_()->getDbtable('services', 'storage');
      $result  = $servicesTable->select()
                  ->from($servicesTable->info('name'), 'config')
                  ->where('service_id = ?', $storage->service_id)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
      $serviceResults = Zend_Json_Decoder::decode($result);
      if($serviceResults['baseUrl']) {
        $path = 'http://' . $serviceResults['baseUrl'] . '/' . $storage->storage_path;
      } else {
        $path = 'http://' . $serviceResults['bucket'] . '.s3.amazonaws.com/' . $storage->storage_path;
      }
    } else {
      //Song file name and path
      $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . $storage->storage_path;
    }

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

    $baseName = $storage->name; // . '.' . $storage->extension;

    header("Content-Disposition: attachment; filename=" . basename($baseName), true);
    header("Content-Transfer-Encoding: Binary", true);

    header("Content-Type: application/force-download", true);
    header("Content-type: audio/mpeg3");

    header("Content-Description: File Transfer", true);
    header("Content-Length: " . filesize($path), true);
    readfile("$path");
    exit();
    return;
  }

  //Add new team member using auto suggest
  public function getusersAction() {

    $sesdata = array();
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $users_table->select()
                    ->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%')
                    ->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);

    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'email' => $user->email,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
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

  public function indexAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  //Browse Job Contributors
  public function contributorsAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function browseJobsAction() {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'sesjob_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function locationsAction() {
    //Render
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
    $id = $this->_getParam('job_id', null);
    $this->view->job_id = $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesjob = Engine_Api::_()->getItem('sesjob_job', $job_id);
    else
    $sesjob = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
    return;

    if( !$this->_helper->requireAuth()->setAuthParams($sesjob, $viewer, 'view')->isValid() )
    return;

    if( !$sesjob || !$sesjob->getIdentity() || ((!$sesjob->is_approved || $sesjob->draft) && !$sesjob->isOwner($viewer)) )
    return $this->_helper->requireSubject->forward();

    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('sesjob_job', $sesjob->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('sesjob_job', $sesjob->getOwner(), 'allow_networks')) {
        $returnValue = Engine_Api::_()->sesjob()->checkPrivacySetting($sesjob->getIdentity());
        if ($returnValue == false) {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $sesjob->getType())
            ->where('id = ?', $sesjob->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
    $sesjob_profilejobs = Zend_Registry::isRegistered('sesjob_profilejobs') ? Zend_Registry::get('sesjob_profilejobs') : null;
    if (empty($sesjob_profilejobs))
      return $this->_forward('notfound', 'error', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
		if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {

			$view->doctype('XHTML1_RDFA');
			if($sesjob->seo_title)
        $view->headTitle($sesjob->seo_title, 'SET');
			if($sesjob->seo_keywords)
        $view->headMeta()->appendName('keywords', $sesjob->seo_keywords);
			if($sesjob->seo_description)
        $view->headMeta()->appendName('description', $sesjob->seo_description);
		}

    if($sesjob->style == 1)
		$page = 'sesjob_index_view_1';

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
    $this->view->form = $form = new Sesjob_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesjob', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc();
    if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }

  public function createAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesjob_job', null, 'create')->isValid()) return;

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
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesjobpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjobpackage.enable.package', 1)){
			$package = Engine_Api::_()->getItem('sesjobpackage_package',$this->_getParam('package_id',0));
			$existingpackage = Engine_Api::_()->getItem('sesjobpackage_orderspackage',$this->_getParam('existing_package_id',0));
			if($existingpackage){
				$package = Engine_Api::_()->getItem('sesjobpackage_package',$existingpackage->package_id);
			}
			if (!$package && !$existingpackage){
				//check package exists for this member level
				$packageMemberLevel = Engine_Api::_()->getDbTable('packages','sesjobpackage')->getPackage(array('member_level'=>$viewer->level_id));
				if(count($packageMemberLevel)){
					//redirect to package page
					return $this->_helper->redirector->gotoRoute(array('action'=>'job'), 'sesjobpackage_general', true);
				}
			}
		}
    $session = new Zend_Session_Namespace();
		if(empty($_POST))
		unset($session->album_id);
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesjob')->profileFieldId();
    if (isset($sesjob->category_id) && $sesjob->category_id != 0) {
      $this->view->category_id = $sesjob->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($sesjob->subsubcat_id) && $sesjob->subsubcat_id != 0) {
      $this->view->subsubcat_id = $sesjob->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($sesjob->subcat_id) && $sesjob->subcat_id != 0) {
      $this->view->subcat_id = $sesjob->subcat_id;
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
    $sesjob_create = Zend_Registry::isRegistered('sesjob_create') ? Zend_Registry::get('sesjob_create') : null;
    if (empty($sesjob_create))
      return $this->_forward('notfound', 'error', 'core');
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getSesjobsPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesjob_job', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesjob_Form_Create(array('defaultProfileId' => $defaultProfileId,'smoothboxType'=>$sessmoothbox,));

    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;

    if( !$form->isValid($this->getRequest()->getPost()) )
    return;

    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('jobs', 'sesjob')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
				$form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
				return;
      }
    }

    // Process
    $table = Engine_Api::_()->getDbtable('jobs', 'sesjob');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      // Create sesjob
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));

        if(isset($values['levels']))
            $values['levels'] = implode(',',$values['levels']);

        if(isset($values['networks']))
            $values['networks'] = implode(',',$values['networks']);

        if(isset($values['education_id']))
            $values['education_id'] = implode(',',$values['education_id']);

      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $sesjob = $table->createRow();
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
					$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $viewer, 'job_approve');
				}
			}else{
				$values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $viewer, 'job_approve');
				if(isset($sesjob->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesjobpackage') ){
					$values['package_id'] = Engine_Api::_()->getDbTable('packages','sesjobpackage')->getDefaultPackage();
				}
			}

			if($_POST['jobstyle'])
        $values['style'] = $_POST['jobstyle'];

      //SEO By Default Work
      //$values['seo_title'] = $values['title'];
			if($values['tags'])
			$values['seo_keywords'] = $values['tags'];

      $sesjob->setFromArray($values);

			//Upload Main Image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
			  $sesjob->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'sesjob','sesjob_job','',$sesjob,true);
				//$photo_id = 	$sesjob->setPhoto($form->photo_file,'direct');
			}

			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesjob->publish_date =$starttime;
			}

			if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
				//Convert Time Zone
				$oldTz = date_default_timezone_get();
				date_default_timezone_set($viewer->timezone);
				$start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
				date_default_timezone_set($oldTz);
				$sesjob->publish_date = date('Y-m-d H:i:s', $start);
			}

			$sesjob->parent_id = $parentId;
      $sesjob->save();
      $job_id = $sesjob->job_id;

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
      $sesjob->custom_url = $_POST['custom_url'];
      else
      $sesjob->custom_url = $sesjob->job_id;
      $sesjob->save();
      $job_id = $sesjob->job_id;

      $roleTable = Engine_Api::_()->getDbtable('roles', 'sesjob');
			$row = $roleTable->createRow();
			$row->job_id = $job_id;
			$row->user_id = $viewer->getIdentity();
			$row->save();

			// Other module work
			if(!empty($resource_type) && !empty($resource_id)) {
        $sesjob->resource_id = $resource_id;
        $sesjob->resource_type = $resource_type;
        $sesjob->save();
			}

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
					Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $job_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesjob_job")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if($parentType == 'sesevent_job') {
        $sesjob->parent_type = $parentType;
        $sesjob->event_id = $event_id;
        $sesjob->save();
        $seseventjob = Engine_Api::_()->getDbtable('mapevents', 'sesjob')->createRow();
        $seseventjob->event_id = $event_id;
        $seseventjob->job_id = $job_id;
        $seseventjob->save();
      }

      //Save company details

      if(empty($values['company_id'])) {
        $companiesTable = Engine_Api::_()->getDbtable('companies', 'sesjob');
        $companies = $companiesTable->createRow();
        $companies->company_name = $values['company_name'];
				$companies->owner_id = $viewer->getIdentity();
        $companies->company_websiteurl = $values['company_websiteurl'];
        $companies->company_description = $values['company_description'];
        $companies->industry_id = isset($values['industry_id']) ? $values['industry_id'] : 0 ;
        $companies->save();
        $companies->job_count++;
        $companies->save();
				$sesjob->company_id = $companies->company_id;
				$sesjob->save();
      } elseif(!empty($values['company_id'])) {
        $company = Engine_Api::_()->getItem('sesjob_company', $values['company_id']);
        $company->company_name = $values['company_name'];
        $company->company_websiteurl = $values['company_websiteurl'];
        $company->company_description = $values['company_description'];
        $company->industry_id =  isset($values['industry_id']) ? $values['industry_id'] : 0 ;
        $company->save();
        $company->job_count++;
        $company->save();
				$sesjob->company_id = $company->company_id;
				$sesjob->save();
      }


      if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
				$sesjob->photo_id = $_POST['cover'];
				$sesjob->save();
      }

      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
				$customfieldform->setItem($sesjob);
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
        $auth->setAllowed($sesjob, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesjob, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesjob, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesjob, $role, 'music', ($i <= $musicMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
     // $sesjob->seo_keywords = implode(',',$tags);
      //$sesjob->seo_title = $sesjob->title;
      $sesjob->save();
      $sesjob->tags()->addTagMaps($viewer, $tags);

      $session = new Zend_Session_Namespace();
      if(!empty($session->album_id)){
				$album_id = $session->album_id;
				if(isset($job_id) && isset($sesjob->title)){
					Engine_Api::_()->getDbTable('albums', 'sesjob')->update(array('job_id' => $job_id,'owner_id' => $viewer->getIdentity(),'title' => $sesjob->title), array('album_id = ?' => $album_id));
					if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
						Engine_Api::_()->getDbTable('albums', 'sesjob')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
					}
					Engine_Api::_()->getDbTable('photos', 'sesjob')->update(array('job_id' => $job_id), array('album_id = ?' => $album_id));
					unset($session->album_id);
				}
      }

      // Add activity only if sesjob is published
      if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesjob->publish_date || strtotime($sesjob->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesjob, 'sesjob_new');
        // make sure action exists before attaching the sesjob to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesjob);
        }

        //Tag Work
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
        }

        //Send notifications for all company subscribers
        if(!empty($sesjob->company_id)) {
            $company = Engine_Api::_()->getItem('sesjob_company', $sesjob->company_id);
            $getAllsubscribes = Engine_Api::_()->getDbTable('cpnysubscribes', 'sesjob')->getAllsubscribes(array('resource_id' => $company->company_id));
            $companylink = '<a href="' . $company->getHref() . '">' . $company->company_name . '</a>';
            if(count($getAllsubscribes) > 0) {
                foreach($getAllsubscribes as $getAllsubscribe) {
                    $owner = Engine_Api::_()->getItem('user', $getAllsubscribe->poster_id);
                    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $sesjob, 'sesjob_newjobposted', array('companylink' => $companylink));

                    //Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'sesjob_newjobposted', array('sender_title' => $sesjob->getOwner()->getTitle(), 'object_link' => $sesjob->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'company_name' => $company->company_name));
                }
            }
        }
      	$sesjob->is_publish = 1;
        //$sesjob->save();
      }

      $db->commit();
    }

    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

		$redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.redirect.creation', 0);
    if($parentType) {
      $eventCustom_url = Engine_Api::_()->getItem('sesevent_event', $event_id)->custom_url;
      return $this->_helper->redirector->gotoRoute(array('id' => $eventCustom_url), 'sesevent_profile', true);
    } else if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } else if($redirect) {
   	 	return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard','action'=>'edit','job_id'=>$sesjob->custom_url),'sesjob_dashboard',true);
    } else {
		 	return $this->_helper->redirector->gotoRoute(array('action' => 'view','job_id'=>$sesjob->custom_url),'sesjob_entry_view',true);
    }
  }

  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesjob_job';
    $dbTable = 'jobs';
    $resorces_id = 'job_id';
    $notificationType = 'liked';
    $actionType = 'sesjob_job_like';

		if($this->_getParam('type',false) && $this->_getParam('type') == 'sesjob_album'){
			$type = 'sesjob_album';
	    $dbTable = 'albums';
	    $resorces_id = 'album_id';
	    $actionType = 'sesjob_album_like';
		} else if($this->_getParam('type',false) && $this->_getParam('type') == 'sesjob_photo') {
			$type = 'sesjob_photo';
	    $dbTable = 'photos';
	    $resorces_id = 'photo_id';
	    $actionType = 'sesjob_photo_like';
		}

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sesjob');
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
          if($subject && empty($subject->title) && $this->_getParam('type') == 'sesjob_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('sesjob_album', $album_id);
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
    if ($this->_getParam('type') == 'sesjob_job') {
      $type = 'sesjob_job';
      $dbTable = 'jobs';
      $resorces_id = 'job_id';
      $notificationType = 'sesjob_job_favourite';
    } else if ($this->_getParam('type') == 'sesjob_photo') {
      $type = 'sesjob_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
     else if ($this->_getParam('type') == 'sesjob_album') {
      $type = 'sesjob_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
     // $notificationType = 'sesevent_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesjob')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesjob');
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
      $db = Engine_Api::_()->getDbTable('favourites', 'sesjob')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesjob')->createRow();
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

    $sesjob = Engine_Api::_()->getItem('sesjob_job', $this->getRequest()->getParam('job_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($sesjob, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesjob_Form_Delete();

    if( !$sesjob ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Sesjob entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $sesjob->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->sesjob()->deleteJob($sesjob);;

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your sesjob entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesjob_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function styleAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesjob_job', null, 'style')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Require user
    if( !$this->_helper->requireUser()->isValid() ) return;
    $user = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Sesjob_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_sesjob') // @todo this is not a real type
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
      $row->type = 'user_sesjob'; // @todo this is not a real type
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

  public function linkJobAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->job_id = $job_id = $this->_getParam('job_id', '0');
    if ($job_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $eventTable = Engine_Api::_()->getItemTable('sesevent_event');
    $eventTableName = $eventTable->info('name');
    $jobMapTable = Engine_Api::_()->getDbTable('mapevents', 'sesjob');
    $jobMapTableName = $jobMapTable->info('name');
    $select = $eventTable->select()
			->setIntegrityCheck(false)
			->from($eventTableName)
		        ->Joinleft($jobMapTableName, "$jobMapTableName.event_id = $eventTableName.event_id", null)
		        ->where($eventTableName.'.event_id !=?', '')
		        ->where($jobMapTableName.'.job_id !=? or job_id is null', $job_id);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);

   if( !$this->getRequest()->isPost() )
   return;

    $eventIds = $_POST['event'];
    $jobObject = Engine_Api::_()->getItem('sesjob_job', $job_id);
    foreach($eventIds as $eventId) {
      $item = Engine_Api::_()->getItem('sesevent_event', $eventId);
      $owner = $item->getOwner();
      $table = Engine_Api::_()->getDbtable('mapevents', 'sesjob');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $seseventjob = $table->createRow();
	$seseventjob->event_id = $eventId;
	$seseventjob->job_id = $job_id;
	$seseventjob->request_owner_job = 1;
	$seseventjob->approved = 0;
	$seseventjob->save();
	$jobPageLink = '<a href="' . $jobObject->getHref() . '">' . ucfirst($jobObject->getTitle()) . '</a>';
	Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesjob_link_event', array("jobPageLink" => $jobPageLink));


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
  public function jobRequestAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_main');

    $JobTable = Engine_Api::_()->getDbtable('jobs', 'sesjob');
    $JobTableName = $JobTable->info('name');
    $mapJobTable = Engine_Api::_()->getDbtable('mapevents', 'sesjob');
    $mapJobTableName = $mapJobTable->info('name');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $JobTable->select()
                        ->setIntegrityCheck(false)
			->from($JobTableName, array('owner_id', 'job_id'))
		        ->Joinleft($mapJobTableName, "$mapJobTableName.job_id = $JobTableName.job_id", array('event_id','approved'))
		        ->where($JobTableName.'.owner_id =?', $viewerId)
		        ->where($mapJobTableName.'.approved =?', 0)
		         ->where($mapJobTableName.'.request_owner_event =? and request_owner_event IS NOT null', 1);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }

  public function approvedAction() {

    $job_id = $this->_getParam('job_id');
    $event_id = $this->_getParam('event_id');
    $mapJobTable = Engine_Api::_()->getDbtable('mapevents', 'sesjob');
    $selectMapTable = $mapJobTable->select()->where('event_id =?', $event_id)->where('job_id =?', $job_id)->where('request_owner_event =?', 1);
    $mapResult = $mapJobTable->fetchRow($selectMapTable);
    if (!empty($job_id)) {
      $job = Engine_Api::_()->getItem('sesjob_job', $event_id);
      if(!$mapResult->approved)
      $approved = 1;
      else
      $approved = 0;

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->update('engine4_sesjob_mapevents', array(
      'approved' => $approved,
      ), array(
	'event_id = ?' => $event_id,
	'job_id = ?' => $job_id,
      ));
    }
    $this->_redirect('sesjobs/job-request');
  }

  public function rejectRequestAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $job_id = $this->_getParam('job_id');
    $jobObject = Engine_Api::_()->getItem('sesjob_job', $job_id);
    $event_id = $this->_getParam('event_id');
    $eventObject = Engine_Api::_()->getItem('sesevent_event', $event_id);
    $owner = $eventObject->getOwner();
    $mapJobTable = Engine_Api::_()->getDbtable('mapevents', 'sesjob');
    $selectMapTable = $mapJobTable->select()->where('event_id =?', $event_id)->where('job_id =?', $job_id)->where('request_owner_event =?', 1);
    $mapResult = $mapJobTable->fetchRow($selectMapTable);
    $db = $mapResult->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $mapResult->delete();
      $jobPageLink = '<a href="' . $jobObject->getHref() . '">' . ucfirst($jobObject->getTitle()) . '</a>';
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $eventObject, 'sesjob_reject_event_request', array("jobPageLink" => $jobPageLink));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirect('sesjobs/job-request');
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
        'parent_type' => 'sesjob_job',
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
        throw new Sesjob_Model_Exception($e->getMessage(), $e->getCode());
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
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesjob');
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
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesjob');
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
    $this->view->photo = Engine_Api::_()->getItem('sesjob_photo', $photo_id);
  }

  public function saveInformationAction() {

    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'sesjob')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }

  public function removeAction() {

    if(empty($_POST['photo_id']))die('error');
    $photo_id = (int) $this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('sesjob_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'sesjob')->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('photos', 'sesjob')->delete(array('photo_id =?' => $photo_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function getJobAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getjob'] = true;
    $jobs = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getSesjobsSelect($value);
    foreach ($jobs as $job) {
      $video_icon = $this->view->itemPhoto($job, 'thumb.icon');
      $sesdata[] = array(
          'id' => $job->job_id,
          'job_id' => $job->job_id,
          'label' => $job->title,
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
    $typeItem = ucwords(str_replace(array('sesjob_'), '', $attachment->getType()));
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

    $this->view->type = $this->_getParam('type', 'job');
    $this->view->job_id = $job_id = $this->_getParam('job_id');
    $this->view->job = $job = Engine_Api::_()->getItem('sesjob_job', $job_id);
    if (!$job)
      return;
    $this->view->form = $form = new Sesjob_Form_Location();
    $form->populate($job->toArray());
  }

  public function customUrlCheckAction(){
    $value = $this->sanitize($this->_getParam('value', null));
    if(!$value) {
      echo json_encode(array('error'=>true));die;
    }
    $job_id = $this->_getParam('job_id',null);
    $custom_url = Engine_Api::_()->getDbtable('jobs', 'sesjob')->checkCustomUrl($value,$job_id);
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

	public function getJobsAction() {
		$sesdata = array();
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$jobTable = Engine_Api::_()->getDbtable('jobs', 'sesjob');
		$jobTableName = $jobTable->info('name');

		$currentTime = date('Y-m-d H:i:s');
		$select = $jobTable->select()
		->where('draft =?', 0)
		->where("publish_date <= '$currentTime' OR publish_date = ''")
		->where('owner_id !=?', $viewerId)
		->where($jobTableName .'.title  LIKE ? ', '%' .$text. '%');
		$select->order('job_id ASC')->limit('40');
		$jobs = $jobTable->fetchAll($select);
		foreach ($jobs as $job) {
			$job_icon_photo = $this->view->itemPhoto($job, 'thumb.icon');
			$sesdata[] = array(
			'id' => $job->job_id,
			'label' => $job->title,
			'photo' => $job_icon_photo
			);
		}
		return $this->_helper->json($sesdata);
	}
}
