<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespopupbuilder_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction(){
		
		$db = Engine_Db_Table::getDefaultAdapter();

		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('sespopupbuilder_admin_main', array(), 'sespopupbuilder_admin_main_manage');
		$this->view->formFilter = $formFilter = new Sespopupbuilder_Form_Admin_Filter();
		$params = array();
		$params['popup_type'] = $this->_getParam('popup_type',null);
		$params['title'] = $this->_getParam('title',null);
		$params['is_deleted'] = $this->_getParam('is_deleted',null);
    $formFilter->populate($params);

		$this->view->paginator = $paginator = $popupinactive = Engine_Api::_()->getDbtable('popups', 'sespopupbuilder')->getPopup($params);
		$urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
		$this->view->urlParams = $urlParams;
		if ($this->getRequest()->isPost()){
			$db = Engine_Db_Table::getDefaultAdapter();
			$values = $this->getRequest()->getPost();
			foreach ($values as $key => $value){
				if ($key == 'delete_' . $value) {
					$popup = Engine_Api::_()->getItem('sespopupbuilder_popup', $value);
					if($popup){
						$popup->delete();
					}
				}
			}
		}
		$paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
	public function deletePopupAction() {
		$this->view->type = $this->_getParam('type', null);
		// In smoothbox
		$this->_helper->layout->setLayout('admin-simple');
		$id = $this->_getParam('id');
		$this->view->item_id = $id;
		// Check post
		if ($this->getRequest()->isPost()) {
				$popup = Engine_Api::_()->getItem('sespopupbuilder_popup', $id);
				if($popup){
					$popup->delete();
				}
				
				$this->_forward('success', 'utility', 'core', array(
						'smoothboxClose' => 10,
						'parentRefresh' => 10,
						'messages' => array('Popup Delete Successfully.')
				));
		}
		// Output
		$this->renderScript('admin-manage/delete-popup.tpl');
	}

	public function enabledpopupAction(){
		$popup_id = $this->_getParam('popup_id', 0);
		if (!empty($popup_id)) {
			$item = Engine_Api::_()->getItem('sespopupbuilder_popup', $popup_id);
			$item->is_deleted = !$item->is_deleted;
			$item->save();
		}
		if (!empty($popup_id))
				$this->_redirect('admin/sespopupbuilder/manage');
		else
				$this->_redirect('admin/sespopupbuilder/manage');
	}
	public function createAction(){
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('sespopupbuilder_admin_main', array(), 'sespopupbuilder_admin_main_manage');
		$this->view->somevale = true;
  }
	public function getIframelyInformationAction(){
		$url = trim(strip_tags($this->_getParam('uri')));
		$ajax = $this->_getParam('ajax', false);
		$information = $this->handleIframelyInformation($url);
		$this->view->ajax = $ajax;
		$thisvalid = !empty($information['code']);
		$iframely = $information;
		echo $thisvalid;die;
  }
	public function handleIframelyInformation($uri){
		$iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('video_iframely_disallow');
		if (parse_url($uri, PHP_URL_SCHEME) === null) {
				$uri = "http://" . $uri;
		}
		$uriHost = Zend_Uri::factory($uri)->getHost();
		if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
				return;
		}
		$config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
		$iframely = Engine_Iframely::factory($config)->get($uri);
		if (!in_array('player', array_keys($iframely['links']))) {
				return;
		}
		$information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
		if (!empty($iframely['links']['thumbnail'])) {
				$information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
				if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
						$information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
						$information['thumbnail'] = "http://" . $information['thumbnail'];
				}
		}
		if (!empty($iframely['meta']['title'])) {
				$information['title'] = $iframely['meta']['title'];
		}
		if (!empty($iframely['meta']['description'])) {
				$information['description'] = $iframely['meta']['description'];
		}
		if (!empty($iframely['meta']['duration'])) {
				$information['duration'] = $iframely['meta']['duration'];
		}
		$information['code'] = $iframely['html'];
		return $information;
  }
	public function showincreaseAction(){
		if(!$this->_getParam('popup_id',0))
			return ;
		$viewer = Engine_Api::_()->user()->getViewer();
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			$cip = $_SERVER['HTTP_CLIENT_IP'];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$cip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$cip = $_SERVER['REMOTE_ADDR'];
		}
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $cip));
		$nonLogedInUserIp = @$ipdat->geoplugin_request;
		$db = Engine_Api::_()->getDbTable('visits','sespopupbuilder')->getAdapter();
		$visitTable = Engine_Api::_()->getDbTable('visits','sespopupbuilder');
		$visitTableName = $visitTable->info('name');
		$db = $visitTable->getAdapter();
    $db->beginTransaction();
		try{
				$values = array();
				if($viewer->getIdentity()>0){
					$values['user_id'] = $viewer->getIdentity();
				}else{
					$values['viewer_ip'] = $nonLogedInUserIp;
				}
				$values['popup_visit_date'] = date('Y-m-d H:i:s');
				$values['popup_id'] = $this->_getParam('popup_id',0);
				$select = $visitTable->select()->from($visitTableName,array("visit_id"));
				$select->where('popup_id =?', $this->_getParam('popup_id'));
				
				if(isset($values['user_id']))
					$select->where('user_id =?', $viewer->getIdentity());
				if(isset($values['viewer_ip']))
					$select->where('viewer_ip =?', $nonLogedInUserIp);
				$count = $select->query()->fetchColumn();
				if($count){
					$visit = Engine_Api::_()->getItem('sespopupbuilder_visit', $count);
					$visit->popup_visit_date = date('Y-m-d H:i:s');
				}else{
					$visit = $visitTable->createRow();
					$visit->setFromArray($values);
				}
					
			$visit->save();
			$db->commit();	
		}catch(Exception $e){
			throw $e;
		}
		echo 1;die;
	}
	public function createPopupAction(){
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('sespopupbuilder_admin_main', array(), 'sespopupbuilder_admin_main_manage');
		$viewer = Engine_Api::_()->user()->getViewer();
		
		$popup_id = $this->_getParam('popup_id',null);
		if($popup_id || $this->_getParam('type')){
			$showcreate = true;
		}else{
			$showcreate = false;
		}
		
		if($showcreate){
			$this->view->form = $form = new Sespopupbuilder_Form_Create();
		}else{
			return;
		}
		if($popup_id){
			$this->view->popup = $popup = Engine_Api::_()->getItem('sespopupbuilder_popup', $popup_id);
			$form->save->setLabel('Save Changes');
			$form->setTitle("Edit Popups");
			$form->setDescription("Below, edit the details for the Popups.");
			$values = $popup->toArray();
			$values['networks'] = (explode(",", $popup->networks));
			$values['level_id'] = (explode(",", $popup->level_id));
			$values['profile_type'] = (explode(",", $popup->profile_type));
			if(($values['starttime'] == "0000-00-00 00:00:00") ){
				unset($values['starttime']);
				unset($values['endtime']);
			}
			$form->populate($values);
		}
		if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())){
      return;
    }
	
			$popupTable = Engine_Api::_()->getDbTable('popups','sespopupbuilder');
			$db = $popupTable->getAdapter();
			$db->beginTransaction();
			try{
				$values = $form->getValues();
				if(isset($values['video_url'])){
						$iframeUrl = $this->handleIframelyInformation($values['video_url']);
						$values['video_code'] = $iframeUrl['code'];
				}
				if(!empty($values['devices'])){
					$values['devices'] = implode(",", $values['devices']);
				}
				
				if(!empty($values['networks'])){
					$values['networks'] = implode(",", $values['networks']);
				}
				if(!empty($values['profile_type']) && is_array($values['profile_type']) && count($values['profile_type'])){
					$values['profile_type'] = implode(",", $values['profile_type']);
				}
				if(!empty($values['level_id'])){
					$values['level_id'] = implode(",", $values['level_id']);
				}
				
				if(isset($values['whenshow']) && $values['whenshow'] == '6' && count($_POST['showspecicurl'])){
					$values['showspecicurl'] = implode(",",  $_POST['showspecicurl']);
				}
				
				
				/*----------- unset values if type of file -----------------------*/
				if(key_exists('pdf_file',$values))
					unset($values['pdf_file']);
				if(key_exists('photo',$values))
					unset($values['photo']);
				if(key_exists('background_photo',$values))
					unset($values['background_photo']);
				if(key_exists('popup_sound_file',$values))
					unset($values['popup_sound_file']);
				if(key_exists('christmas_image1_upload',$values))
					unset($values['christmas_image1_upload']);
				
				if(key_exists('christmas_image2_upload',$values))
					unset($values['christmas_image2_upload']);
				$values['user_id'] = $viewer->getIdentity();
				if(empty($popup))
					$popup = $popupTable->createRow();
				$popup->setFromArray($values);
				$popup->save();
				
				if(!empty($values['geo_location'])){
					if(!empty($popup_id)){
						$db = Engine_Db_Table::getDefaultAdapter();
						$db->query('Delete from engine4_sespopupbuilder_countries where popup_id='.$popup_id);
					}
					$countries = $values['geo_location'];
					$countryTable = Engine_Api::_()->getDbTable('countries','sespopupbuilder');
					$dbcountry = $countryTable->getAdapter();
					//$dbcountry->beginTransaction();
					try{
						foreach($countries as $item){
							$valueArray = array();
							$valueArray['country_title'] = $item;
							$valueArray['popup_id'] = $popup->getIdentity();
							$country = $countryTable->createRow();
							$country->setFromArray($valueArray);
							$country->save();
						}
					//	$dbcountry->commit();	
					}catch(Exception $e){
						$dbcountry->rollback();
						throw $e;
					}
				}
				if(!empty($_POST['remove_popup_sound_file'])){
					$dbslideImageStorage = Engine_Api::_()->getItem('storage_file', $popup->popup_sound_file);
					$popup->popup_sound_file = 0;
					if($dbslideImageStorage)
						$dbslideImageStorage->delete();
				}
				if(!empty($_POST['remove_christmas_image1_upload'])){
					$dbslideImageStorage = Engine_Api::_()->getItem('storage_file', $popup->christmas_image1_upload);
					$popup->christmas_image1_upload = 0;
					if($dbslideImageStorage)
						$dbslideImageStorage->delete();
				}
				if(!empty($_POST['remove_christmas_image2_upload'])){
					$dbslideImageStorage = Engine_Api::_()->getItem('storage_file', $popup->christmas_image2_upload);
					$popup->christmas_image2_upload = 0;
					if($dbslideImageStorage)
						$dbslideImageStorage->delete();
				}
				if(!empty($_POST['remove_background_photo'])){
					$dbslideImageStorage = Engine_Api::_()->getItem('storage_file', $popup->background_photo);
					$popup->background_photo = 0;
					if($dbslideImageStorage)
						$dbslideImageStorage->delete();
				}
				
				if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->photo, array(
							'parent_id' => $popup->getIdentity(),
							'parent_type' => 'sespopupbuilder_popup',
							'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->image = $thumbname->file_id;
				}
				if (isset($_FILES['christmas_image1_upload']['name']) && $_FILES['christmas_image1_upload']['name'] != '') { 
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->christmas_image1_upload, array(
							'parent_id' => $popup->getIdentity(),
							'parent_type' => 'sespopupbuilder_popup',
							'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->christmas_image1_upload = $thumbname->file_id;
				}
				if (isset($_FILES['christmas_image2_upload']['name']) && $_FILES['christmas_image2_upload']['name'] != '') {
					
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->christmas_image2_upload, array(
							'parent_id' => $popup->getIdentity(),
							'parent_type' => 'sespopupbuilder_popup',
							'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->christmas_image2_upload = $thumbname->file_id;
				}
				
				if (isset($_FILES['pdf_file']['name']) && $_FILES['pdf_file']['name'] != '') {
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->pdf_file, array(
							'parent_id' => $popup->getIdentity(),
							'parent_type' => 'sespopupbuilder_popup',
							'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->pdf_file = $thumbname->file_id;
				}
				if (isset($_FILES['background_photo']['name']) && $_FILES['background_photo']['name'] != '') {
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->background_photo, array(
							'parent_id' => $popup->getIdentity(),
							'parent_type' => 'sespopupbuilder_popup',
							'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->background_photo = $thumbname->file_id;
				}
				if (isset($_FILES['popup_sound_file']['name']) && $_FILES['popup_sound_file']['name'] != '') {
					$storage = Engine_Api::_()->getItemTable('storage_file');
					$thumbname = $storage->createFile($form->popup_sound_file, array(
						'parent_id' => $popup->getIdentity(),
						'parent_type' => 'sespopupbuilder_popup',
						'user_id' => $viewer->getIdentity(),
					));
					// Remove temporary file
					@unlink($file['tmp_name']);
					$popup->popup_sound_file = $thumbname->file_id;
				}
				$popup->save();
				$db->commit();
			}catch(Exception $e){
				$db->rollback();
				throw $e;
			}
			if (isset($_POST['save']))
				return $this->_helper->redirector->gotoRoute(array('module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup','popup_id'=>$popup->getIdentity()), 'admin_default', true);
			else
				return $this->_helper->redirector->gotoRoute(array('module' => 'sespopupbuilder', 'controller' => 'manage'), 'admin_default', true);
	}
}
