<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercovervideo_Widget_SesusercovervideoCoverController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $front = Zend_Controller_Front::getInstance();
    $this->view->module = $module = $front->getRequest()->getModuleName();
    $this->view->controller = $controller = $front->getRequest()->getControllerName();
    $this->view->action = $action = $front->getRequest()->getActionName();

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
		$setting = Engine_Api::_()->getApi('settings', 'core');

		if($module == 'user' && $controller == 'index' && $action == 'home') {
      $this->view->subject = $subject = $viewer; //Engine_Api::_()->core()->getSubject();
		} else {
      // Get subject and check auth
      if (!Engine_Api::_()->core()->hasSubject('user'))
        return $this->setNoRender();
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
		}

    $level = $subject;

	 	$tab = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'tab');
		if($tab == ' ')
			$this->view->tab = 'inside';
		else
			$this->view->tab = $tab;

		$options = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo','option');
		$options = json_decode($options);
		if(!count($options) || !$options){
			$options = array('title','addfriend','mutualfriend','totalfriends','message','rating','location','photo','viplabel','featuredlabel','sponsoredLabel','verifiedLabel','dob','videocount','albumcount','eventcount','eventcount','forumcount','musiccount','groupcount','viewcount','likecount','recentlyViewedBy','likebtn','options','membersince','followbtn');
		}
		else
			$options = ($options);

		if(!$subject)
			return $this->setNoRender();
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

 	  $this->view->can_edit = $canEdit = $subject->authorization()->isAllowed($viewer, 'edit');

		$height = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'height');
		if($height == '')
			$this->view->height = '400';
		else
			$this->view->height = $height;


		$show_ver_tip = Engine_Api::_()->authorization()->getPermission($level, 'sesusercover', 'show_ver_tip');
		if($show_ver_tip == 0)
			$this->view->show_ver_tip = '1';
		else
			$this->view->show_ver_tip = $show_ver_tip;
        if($show_ver_tip == 2)
        $this->view->show_ver_tip = '0';

		$is_fullwidth = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'is_fullwidth');
		if($is_fullwidth == 0)
			$this->view->is_fullwidth = '1';
		else
			$this->view->is_fullwidth = $is_fullwidth;
    if($is_fullwidth == 2)
      $this->view->is_fullwidth = '0';

    $showicontype = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'showicontype');
		if($showicontype == 0)
			$this->view->showicontype = '1';
		else
			$this->view->showicontype = $showicontype;


		$userphotoround = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'userphotoround');
		if($userphotoround == 0)
			$this->view->userphotoround = '0';
		else
			$this->view->userphotoround = $userphotoround;
    if($userphotoround == 2)
      $this->view->userphotoround = '0';

		$this->view->viewer_id = $viewer->getIdentity();

		if(!$viewer->getIdentity())
		$levelId = 5;
		else
		$levelId = $viewer;

		$this->view->notshowRating = true;
		//check member plugin installed and activated
		//Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.pluginactivated')

		//Document Verification Plugin Work
		$this->view->sesuserdocverificationenable = $sesuserdocverificationenable = Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesuserdocverification');
		if(!empty($sesuserdocverificationenable)) {
            $this->view->documents = Engine_Api::_()->getDbTable('documents', 'sesuserdocverification')->getAllUserDocuments(array('user_id' => $subject->getIdentity(), 'verified' => '1', 'fetchAll' => '1'));
		}

		$this->view->sesmemberenable = $sesmemberenable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember');
		$canCreateRating = false;
		if($sesmemberenable){
			$canCreateRating = true;
			 if(!Engine_Api::_()->sesbasic()->getIdentityWidget('sesmember.member-reviews','widget','user_profile_index'))
			 	$this->view->notshowRating = false;
			if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.allow.review', 1))
				$canCreateRating = false;

			 if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.allow.owner', 1)){
      	$canCreateRating = true;
			 }else{
					if($subject->user_id == $viewer->getIdentity())
						$canCreateRating = false;
			 }
			 if (!Engine_Api::_()->authorization()->getPermission($levelId, 'sesmember_review', 'view'))
			 	$canCreateRating = false;

			 if(!Engine_Api::_()->authorization()->getPermission($levelId, 'sesmember_review', 'create'))
					$canCreateRating = false;

			$reviewTable = Engine_Api::_()->getDbtable('reviews', 'sesmember');
			$this->view->isReview = $hasReview = $reviewTable->isReview(array('user_id' => $subject->getIdentity(),'column_name' => 'review_id'));

			if($hasReview && !Engine_Api::_()->authorization()->getPermission($levelId, 'sesmember_review', 'edit'))
				$canCreateRating = false;

			$this->view->rating_count  = Engine_Api::_()->getDbTable('reviews', 'sesmember')->ratingCount($subject->getIdentity());
			$getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($subject->getIdentity());
			$this->view->total_rating_average = $getUserInfoItem->rating;


		} else{
			if(isset($options['rating']))
				unset($options['rating']);
		}
		$this->view->canCreateRating = $canCreateRating;
		$this->view->option = $options;


    $canCreate = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'create');
		if($canCreate == 0)
			$this->view->canCreate = 0;
		else
			$this->view->canCreate = 1;
		$coverType = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'viewtype');
		if($coverType)
			$this->view->type = $coverType;
		else
			$this->view->type = 1;

    if(isset($_GET['type'])) {
      if($_GET['type'] == 1 || $_GET['type'] == 2 || $_GET['type'] == 4)
      $this->view->type = $_GET['type'];
    }


    $this->view->existingVideospaginator = Engine_Api::_()->sesusercovervideo()->getUserVideo();

		$defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'defaultcovephoto');
		if($defaultCoverPhoto)
			$this->view->defaultCoverPhoto = $defaultCoverPhoto;
		else
			$this->view->defaultCoverPhoto = 'application/modules/Sesusercovervideo/externals/images/default_cover.jpg';
	}
}
