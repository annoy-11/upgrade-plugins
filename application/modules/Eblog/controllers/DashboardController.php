<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_DashboardController extends Core_Controller_Action_Standard {
  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('eblog_blog', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('blog_id', null);
    $blog_id = Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogId($id);
    if ($blog_id) {
      $blog = Engine_Api::_()->getItem('eblog_blog', $blog_id);
      if ($blog)
        Engine_Api::_()->core()->setSubject($blog);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isBlogAdmin = Engine_Api::_()->eblog()->isBlogAdmin($blog, 'edit');
    $eblog_edit = Zend_Registry::isRegistered('eblog_edit') ? Zend_Registry::get('eblog_edit') : null;
    if (empty($eblog_edit))
      return $this->_forward('notfound', 'error', 'core');
		if (!$isBlogAdmin)
    return $this->_forward('requireauth', 'error', 'core');
  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->blog = $eblog = Engine_Api::_()->core()->getSubject();
		$package_id = $eblog->package_id;
		$package = Engine_Api::_()->getItem('eblogpackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'eblog')->profileFieldId();
		$this->view->form = $form = new Eblog_Form_Custom_Dashboardfields(array('item' => $eblog,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->blog = $eblog = Engine_Api::_()->core()->getSubject();
    if (isset($eblog->category_id) && $eblog->category_id != 0)
    $this->view->category_id = $eblog->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
    $this->view->category_id = $_POST['category_id'];
    else
    $this->view->category_id = 0;
    if (isset($eblog->subsubcat_id) && $eblog->subsubcat_id != 0)
    $this->view->subsubcat_id = $eblog->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
    $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
    $this->view->subsubcat_id = 0;
    if (isset($eblog->subcat_id) && $eblog->subcat_id != 0)
    $this->view->subcat_id = $eblog->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
    $this->view->subcat_id = $_POST['subcat_id'];
    else
    $this->view->subcat_id = 0;
    $eblog_edit = Zend_Registry::isRegistered('eblog_edit') ? Zend_Registry::get('eblog_edit') : null;
    if (empty($eblog_edit))
      return $this->_forward('notfound', 'error', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'eblog')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('eblog_blog') )
    Engine_Api::_()->core()->setSubject($eblog);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('eblog_blog', $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('eblog_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'eblog')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Eblog_Form_Edit(array('defaultProfileId' => $defaultProfileId));

    // Populate form

    $form->populate($eblog->toArray());
    $form->populate(array(
        'networks' => explode(",",$eblog->networks),
        'levels' => explode(",",$eblog->levels)
    ));
    $form->getElement('blogstyle')->setValue($eblog->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('eblog_blog',$eblog->blog_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($eblog->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($eblog->category_id);

    $tagStr = '';
    foreach( $eblog->tags()->getTagMaps() as $tagMap ) {
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
    $oldUrl = $eblog->custom_url;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($eblog, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($eblog, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }

      if ($form->auth_video){
        if( $auth->isAllowed($eblog, $role, 'video') ) {
          $form->auth_video->setValue($role);
        }
      }

      if ($form->auth_music){
        if( $auth->isAllowed($eblog, $role, 'music') ) {
          $form->auth_music->setValue($role);
        }
      }
    }

    // hide status change if it has been already published
    if( $eblog->draft == "0" )
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
      if($_POST['blogstyle'])
      $values['style'] = $_POST['blogstyle'];
      $eblog->setFromArray($values);
      $eblog->modified_date = date('Y-m-d H:i:s');
      if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
          $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
  $eblog->publish_date =$starttime;
      }
      if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
        //Convert Time Zone
        $oldTz = date_default_timezone_get();
        date_default_timezone_set($viewer->timezone);
        $start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
        date_default_timezone_set($oldTz);
        $eblog->publish_date = date('Y-m-d H:i:s', $start);
      }
			//else{
			//	$eblog->publish_date = '';
			//}

        if(isset($values['levels']))
            $eblog->levels = implode(',',$values['levels']);

        if(isset($values['networks']))
            $eblog->networks = implode(',',$values['networks']);

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $eblog->custom_url = $_POST['custom_url'];

      $eblog->save();
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
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $eblog->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","eblog_blog") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        $eblog->location = '';
        $eblog->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "eblog_blog" AND `engine4_sesbasic_locations`.`resource_id` = "'.$eblog->getIdentity().'";');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($eblog->publish_date < $currentDate) {
          $eblog->publish_date = $currentDate;
          $eblog->save();
        }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($eblog);
        $customfieldform->saveValues($values['fields']);
      }
      //Custom Fiels Work
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($eblog);
      $profile_field_value = $view->FieldValueLoop($eblog, $fieldStructure);

      // Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }
      
      if( empty($values['auth_music']) ) {
        $values['auth_music'] = 'everyone';
      }
      if( empty($values['auth_video']) ) {
        $values['auth_video'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search($values['auth_video'], $roles);
      $musicMax = array_search($values['auth_music'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($eblog, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($eblog, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($eblog, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($eblog, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $eblog->tags()->setTagMaps($viewer, $tags);

			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$eblog->setPhoto($form->photo_file,'direct');
			}

      // insert new activity if eblog is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($eblog);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$eblog->publish_date || strtotime($eblog->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $eblog, 'eblog_new');
          // make sure action exists before attaching the eblog to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $eblog);
        }
        $eblog->is_publish = 1;
      	$eblog->save();
      }

      if (isset($_POST['custom_url']) && $_POST['custom_url'] != $oldUrl) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->update('engine4_sesbasic_bannedwords', array("word" => $_POST['custom_url']), array("word = ?" => $oldUrl, "resource_type = ?" => 'eblog_blog', "resource_id = ?" => $eblog->blog_id));
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($eblog) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'eblog')
          ->sendNotifications($eblog);

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'eblog_dashboard', 'action' => 'edit', 'blog_id' => $eblog->custom_url));
  }

	public function upgradeAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->blog = $eblog = Engine_Api::_()->core()->getSubject();
    //current package
		if(!empty($eblog->orderspackage_id)){
			$this->view->currentPackage = 	Engine_Api::_()->getItem('eblogpackage_orderspackage',$eblog->orderspackage_id);
			if(!$this->view->currentPackage ){
				$this->view->currentPackage = 	Engine_Api::_()->getItem('eblogpackage_package',$eblog->package_id);
			}
		}
		else
			$this->view->currentPackage = 	Engine_Api::_()->getItem('eblogpackage_package',$eblog->package_id);
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		//get upgrade packages
		$this->view->upgradepackage =  Engine_Api::_()->getDbTable('packages','eblogpackage')->getPackage(array('show_upgrade'=>1,'member_level'=>$viewer->level_id,'not_in_id'=>$eblog->package_id));

	}

	 public function removeMainphotoAction() {
      //GET Blog ID AND ITEM
	    $blog = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('blogs', 'eblog')->getAdapter();
      $db->beginTransaction();
      try {
        $blog->photo_id = '';
				$blog->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'blog_id' => $blog->custom_url), "eblog_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $blog->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Eblog_Form_Dashboard_Mainphoto();
    $form->populate($blog->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('blogs', 'eblog')->getAdapter();
    $db->beginTransaction();
    try {
      $blog->setPhoto($_FILES['background']);
      $blog->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'blog_id' => $blog->custom_url), "eblog_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $blog->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'eblog_blog')
            ->where('id = ?', $blog->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Eblog_Form_Dashboard_Style();
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
      $row->type = 'eblog_blog';
      $row->id = $blog->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $blog->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Eblog_Form_Dashboard_Seo();

    $form->populate($blog->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('blogs', 'eblog')->getAdapter();
    $db->beginTransaction();
    try {
      $blog->setFromArray($_POST);
      $blog->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Eblog_Form_Edit_Photo();

    if( empty($blog->photo_id) ) {
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
      $db = $blog->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

       // $blog->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'eblog','eblog_blog','',$blog,true);
        $blog->photo_id = $photo_id;
        $blog->save();
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
    $this->view->form = $form = new Eblog_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $blog = Engine_Api::_()->core()->getSubject();
    $blog->photo_id = 0;
    $blog->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }

  public function searchMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $userTable = Engine_Api::_()->getItemTable('user');
    $selectUserTable = $userTable->select()->where('displayname LIKE "%' . $this->_getParam('text', '') . '%"')->where('user_id !=?', $this->view->viewer()->getIdentity());
    $users = $userTable->fetchAll($selectUserTable);
    foreach ($users as $user) {
      $user_icon = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
        'id' => $user->user_id,
        'user_id' => $user->user_id,
        'label' => $user->displayname,
        'photo' => $user_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function changeOwnerAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('eblog_blog', $this->view->viewer(), 'auth_changeowner'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->eblog()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $this->view->viewer()->getIdentity(), 'blog_id' => $blog->blog_id));
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'eblog_general', true);
  }


  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $eblog_edit = Zend_Registry::isRegistered('eblog_edit') ? Zend_Registry::get('eblog_edit') : null;
    if (empty($eblog_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->blog = $blog = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $blog->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Eblog_Form_Dashboard_Contactinformation();

    $form->populate($blog->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('blogs', 'eblog')->getAdapter();
    $db->beginTransaction();
    try {
      $blog->blog_contact_name = isset($_POST['blog_contact_name']) ? $_POST['blog_contact_name'] : '';
      $blog->blog_contact_email = isset($_POST['blog_contact_email']) ? $_POST['blog_contact_email'] : '';
      $blog->blog_contact_phone = isset($_POST['blog_contact_phone']) ? $_POST['blog_contact_phone'] : '';
      $blog->blog_contact_website = isset($_POST['blog_contact_website']) ? $_POST['blog_contact_website'] : '';
      $blog->blog_contact_facebook = isset($_POST['blog_contact_facebook']) ? $_POST['blog_contact_facebook'] : '';
      $blog->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }

  public function blogRoleAction() {

    $this->view->blog = $eblog = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('roles', 'eblog')->getBlogAdmins(array('blog_id' => $eblog->blog_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('eblog_blog', $this->_getParam('blog_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $blogRoleTable = Engine_Api::_()->getDbTable('roles', 'eblog');
    $roleIds = $blogRoleTable->select()->from($blogRoleTable->info('name'), 'user_id')->where('blog_id =?',$this->_getParam('blog_id', null))->query()->fetchAll();
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

  public function saveBlogAdminAction() {
    $data = explode(',',$_POST['data']);
    $eblog_edit = Zend_Registry::isRegistered('eblog_edit') ? Zend_Registry::get('eblog_edit') : null;
    if (empty($eblog_edit))
      return $this->_forward('notfound', 'error', 'core');
    $blog_id = $this->_getParam('blog_id', null);
    $blog = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    $this->view->owner_id = $owner_id = Engine_Api::_()->getItem('eblog_blog',$blog_id)->owner_id;
    $owner_blog = Engine_Api::_()->getItem('user',$owner_id);
    foreach($data as $blogAdminId) {
        $checkUser = Engine_Api::_()->getDbTable('roles', 'eblog')->isBlogAdmin($blog_id, $blogAdminId);
        if($checkUser)
            continue;
        $roleTable = Engine_Api::_()->getDbtable('roles', 'eblog');
        $row = $roleTable->createRow();
        $row->blog_id = $blog_id;
        $row->user_id = $blogAdminId;
        $row->resource_approved = '0';
        $row->save();

        //Notification Work for admin
        $owner = Engine_Api::_()->getItem('user',$blogAdminId);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $owner_blog, $blog, 'eblog_blogadmin');
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'eblog')->getBlogAdmins(array('blog_id' => $blog_id));
  }

  public function deleteBlogAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_eblog_roles', array(
			'blog_id = ?' => $_POST['blog_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }

  public function editLocationAction() {

    $this->view->blog = $eblog = Engine_Api::_()->core()->getSubject();
    $userLocation = $eblog->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($eblog->getType(), $eblog->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Eblog_Form_Locationedit();
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
      Engine_Api::_()->getItemTable('eblog_blog')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'blog_id = ?' => $eblog->getIdentity(),
      ));
      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $eblog->blog_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "eblog_blog")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'eblog_dashboard', 'action' => 'edit-location', 'blog_id' => $eblog->custom_url));
    }
    //Render
  }

}
