<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_DashboardController extends Core_Controller_Action_Standard {
  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('article_id', null);
    $article_id = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getArticleId($id);
    if ($article_id) {
      $article = Engine_Api::_()->getItem('sesarticle', $article_id);
      if ($article)
        Engine_Api::_()->core()->setSubject($article);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isArticleAdmin = Engine_Api::_()->sesarticle()->isArticleAdmin($article, 'edit');
    $sesarticle_edit = Zend_Registry::isRegistered('sesarticle_edit') ? Zend_Registry::get('sesarticle_edit') : null;
    if (empty($sesarticle_edit))
      return $this->_forward('notfound', 'error', 'core');
		if (!$isArticleAdmin)
    return $this->_forward('requireauth', 'error', 'core');
  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->article = $sesarticle = Engine_Api::_()->core()->getSubject();
		$package_id = $sesarticle->package_id;
		$package = Engine_Api::_()->getItem('sesarticlepackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesarticle')->profileFieldId();
		$this->view->form = $form = new Sesarticle_Form_Custom_Dashboardfields(array('item' => $sesarticle,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->article = $sesarticle = Engine_Api::_()->core()->getSubject();
    if (isset($sesarticle->category_id) && $sesarticle->category_id != 0)
    $this->view->category_id = $sesarticle->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
    $this->view->category_id = $_POST['category_id'];
    else
    $this->view->category_id = 0;
    if (isset($sesarticle->subsubcat_id) && $sesarticle->subsubcat_id != 0)
    $this->view->subsubcat_id = $sesarticle->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
    $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
    $this->view->subsubcat_id = 0;
    if (isset($sesarticle->subcat_id) && $sesarticle->subcat_id != 0)
    $this->view->subcat_id = $sesarticle->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
    $this->view->subcat_id = $_POST['subcat_id'];
    else
    $this->view->subcat_id = 0;
    $sesarticle_edit = Zend_Registry::isRegistered('sesarticle_edit') ? Zend_Registry::get('sesarticle_edit') : null;
    if (empty($sesarticle_edit))
      return $this->_forward('notfound', 'error', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesarticle')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('sesarticle') )
    Engine_Api::_()->core()->setSubject($sesarticle);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesarticle_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form
    $form->populate($sesarticle->toArray());
    $form->populate(array(
        'networks' => explode(",",$sesarticle->networks),
        'levels' => explode(",",$sesarticle->levels)
    ));
    $form->getElement('articlestyle')->setValue($sesarticle->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sesarticle',$sesarticle->article_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($sesarticle->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($sesarticle->category_id);

    $tagStr = '';
    foreach( $sesarticle->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($sesarticle, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($sesarticle, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }

      if ($form->auth_video){
        if( $auth->isAllowed($sesarticle, $role, 'video') ) {
          $form->auth_video->setValue($role);
        }
      }

      if ($form->auth_music){
        if( $auth->isAllowed($sesarticle, $role, 'music') ) {
          $form->auth_music->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $sesarticle->draft == "0" )
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
      if($_POST['articlestyle'])
      $values['style'] = $_POST['articlestyle'];
      $sesarticle->setFromArray($values);
      $sesarticle->modified_date = date('Y-m-d H:i:s');
			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sesarticle->publish_date =$starttime;
			}
			//else{
			//	$sesarticle->publish_date = '';
			//}

        if(isset($values['levels']))
            $sesarticle->levels = implode(',',$values['levels']);

        if(isset($values['networks']))
            $sesarticle->networks = implode(',',$values['networks']);

      $sesarticle->save();
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

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
	Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $this->_getParam('article_id') . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesarticle") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($sesarticle->publish_date < $currentDate) {
          $sesarticle->publish_date = $currentDate;
          $sesarticle->save();
        }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($sesarticle);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($sesarticle);
      $profile_field_value = $view->FieldValueLoop($sesarticle, $fieldStructure);

      // Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
			if(isset($values['auth_video']))
				$videoMax = array_search($values['auth_video'], $roles);
			if(isset($values['auth_music']))
				$musicMax = array_search($values['auth_music'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sesarticle, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesarticle, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesarticle, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesarticle, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sesarticle->tags()->setTagMaps($viewer, $tags);

			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$sesarticle->setPhoto($form->photo_file,'direct');
			}

      // insert new activity if sesarticle is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesarticle);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$sesarticle->publish_date || strtotime($sesarticle->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesarticle, 'sesarticle_new');
          // make sure action exists before attaching the sesarticle to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesarticle);
        }
        $sesarticle->is_publish = 1;
      	$sesarticle->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($sesarticle) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'sesarticle')
          ->sendNotifications($sesarticle);

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'sesarticle_dashboard', 'action' => 'edit', 'article_id' => $sesarticle->custom_url));
  }

	public function upgradeAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->article = $sesarticle = Engine_Api::_()->core()->getSubject();
    //current package
		if(!empty($sesarticle->orderspackage_id)){
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesarticlepackage_orderspackage',$sesarticle->orderspackage_id);
			if(!$this->view->currentPackage ){
				$this->view->currentPackage = 	Engine_Api::_()->getItem('sesarticlepackage_package',$sesarticle->package_id);
			}
		}
		else
			$this->view->currentPackage = 	Engine_Api::_()->getItem('sesarticlepackage_package',$sesarticle->package_id);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		//get upgrade packages
		$this->view->upgradepackage =  Engine_Api::_()->getDbTable('packages','sesarticlepackage')->getPackage(array('show_upgrade'=>1,'member_level'=>$viewer->level_id,'not_in_id'=>$sesarticle->package_id));

	}

	 public function removeMainphotoAction() {
      //GET Article ID AND ITEM
	    $article = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle')->getAdapter();
      $db->beginTransaction();
      try {
        $article->photo_id = '';
				$article->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'article_id' => $article->custom_url), "sesarticle_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->article = $article = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $article->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesarticle_Form_Dashboard_Mainphoto();
    $form->populate($article->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getAdapter();
    $db->beginTransaction();
    try {
      $article->setPhoto($_FILES['background']);
      $article->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'article_id' => $article->custom_url), "sesarticle_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->article = $article = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $article->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'sesarticle')
            ->where('id = ?', $article->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesarticle_Form_Dashboard_Style();
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
      $row->type = 'sesarticle';
      $row->id = $article->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->article = $article = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $article->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesarticle_Form_Dashboard_Seo();

    $form->populate($article->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getAdapter();
    $db->beginTransaction();
    try {
      $article->setFromArray($_POST);
      $article->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->article = $article = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesarticle_Form_Edit_Photo();

    if( empty($article->photo_id) ) {
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
      $db = $article->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

       // $article->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'sesarticle','sesarticle','',$article,true);
        $article->photo_id = $photo_id;
        $article->save();
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
    $this->view->form = $form = new Sesarticle_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $article = Engine_Api::_()->core()->getSubject();
    $article->photo_id = 0;
    $article->save();

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
    $sesarticle_edit = Zend_Registry::isRegistered('sesarticle_edit') ? Zend_Registry::get('sesarticle_edit') : null;
    if (empty($sesarticle_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->article = $article = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $article->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesarticle_Form_Dashboard_Contactinformation();

    $form->populate($article->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getAdapter();
    $db->beginTransaction();
    try {
      $article->article_contact_name = isset($_POST['article_contact_name']) ? $_POST['article_contact_name'] : '';
      $article->article_contact_email = isset($_POST['article_contact_email']) ? $_POST['article_contact_email'] : '';
      $article->article_contact_phone = isset($_POST['article_contact_phone']) ? $_POST['article_contact_phone'] : '';
      $article->article_contact_website = isset($_POST['article_contact_website']) ? $_POST['article_contact_website'] : '';
      $article->article_contact_facebook = isset($_POST['article_contact_facebook']) ? $_POST['article_contact_facebook'] : '';
      $article->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }

  public function articleRoleAction() {

    $this->view->article = $sesarticle = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'sesarticle')->getArticleAdmins(array('article_id' => $sesarticle->article_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('sesarticle', $this->_getParam('article_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $articleRoleTable = Engine_Api::_()->getDbTable('roles', 'sesarticle');
    $roleIds = $articleRoleTable->select()->from($articleRoleTable->info('name'), 'user_id')->where('article_id =?',$this->_getParam('article_id', null))->query()->fetchAll();
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

  public function saveArticleAdminAction() {
    $data = explode(',',$_POST['data']);
    $sesarticle_edit = Zend_Registry::isRegistered('sesarticle_edit') ? Zend_Registry::get('sesarticle_edit') : null;
    if (empty($sesarticle_edit))
      return $this->_forward('notfound', 'error', 'core');
    $article_id = $this->_getParam('article_id', null);
    $this->view->owner_id = Engine_Api::_()->getItem('sesarticle',$article_id)->owner_id;
    foreach($data as $articleAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'sesarticle')->isArticleAdmin($article_id, $articleAdminId);
      if($checkUser)
      continue;
			$roleTable = Engine_Api::_()->getDbtable('roles', 'sesarticle');
			$row = $roleTable->createRow();
			$row->article_id = $article_id;
			$row->user_id = $articleAdminId;
			$row->save();
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'sesarticle')->getArticleAdmins(array('article_id' => $article_id));
  }

  public function deleteArticleAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_sesarticle_roles', array(
			'article_id = ?' => $_POST['article_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }

  public function editLocationAction() {

    $this->view->article = $sesarticle = Engine_Api::_()->core()->getSubject();
    $userLocation = $sesarticle->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sesarticle->getType(), $sesarticle->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Sesarticle_Form_Locationedit();
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
      Engine_Api::_()->getItemTable('sesarticle')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'article_id = ?' => $sesarticle->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $sesarticle->article_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "sesarticle")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'sesarticle_dashboard', 'action' => 'edit-location', 'article_id' => $sesarticle->custom_url));
    }
    //Render
  }

}
