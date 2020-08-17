<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_Widget_SescontentcoverphotoCoverController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

		$authorizationApi = Engine_Api::_()->authorization();
    $viewer = Engine_Api::_()->user()->getViewer();
    $front = Zend_Controller_Front::getInstance();
    $this->view->module = $module = $front->getRequest()->getModuleName();
    $this->view->controller = $controller = $front->getRequest()->getControllerName();
    $this->view->action = $action = $front->getRequest()->getActionName();

    //Get subject and check auth
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

		if(!$subject)
			return $this->setNoRender();

		$this->view->resource_type = $resource_type = $subject->getType();
		$this->view->resource_id = $resource_id = $subject->getIdentity();

    $typeArray = Engine_Api::_()->sescontentcoverphoto()->getResourceTypeData($resource_type, $subject);

    $userId = $subject->{$typeArray['userId']};
    $item_level = Engine_Api::_()->getItem('user', $userId);

		$options = $authorizationApi->getPermission($item_level, 'sescontcvrpto','option_'.$resource_type);
		$options = json_decode($options);

		if(!count($options) || !$options) {
			$options = array_merge(array("photo", "membersince", "viewcount", "likecount", "commentcount", 'share', "report"), $typeArray['defaultOptions']);
		}
		else
			$options = ($options);

    $this->view->option = $options;
    
    $sescontentcoverphoto_widget = Zend_Registry::isRegistered('sescontentcoverphoto_widget') ? Zend_Registry::get('sescontentcoverphoto_widget') : null;
    if(empty($sescontentcoverphoto_widget))
      return $this->setNoRender();
      
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$this->view->viewer_id = $viewer->getIdentity();
		if(!$viewer->getIdentity())
      $level_id = 5;
		else
      $level_id = $viewer;

 	  $this->view->can_edit = $subject->authorization()->isAllowed($viewer, 'edit');

	 	$tab = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'tab_'.$resource_type);
		if($tab == '')
			$this->view->tab = 'inside';
		else
			$this->view->tab = $tab;

		$height = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'height_'.$resource_type);
		if($height == '')
			$this->view->height = '400';
		else
			$this->view->height = $height;

		$is_fullwidth = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'fulwth_'.$resource_type);
		if($is_fullwidth == 0)
			$this->view->is_fullwidth = '0';
		else
			$this->view->is_fullwidth = $is_fullwidth;
    if($is_fullwidth == 2)
      $this->view->is_fullwidth = '0';

    $showicontype = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'icnty_'.$resource_type);
		if($showicontype == 0)
			$this->view->showicontype = '2';
		else
			$this->view->showicontype = $showicontype;

		$userphotoround = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'urpord_'.$resource_type);
		if($userphotoround == 0)
			$this->view->userphotoround = '0';
		else
			$this->view->userphotoround = $userphotoround;
    if($userphotoround == 2)
      $this->view->userphotoround = '0';

    $canCreate = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'create_'.$resource_type);
		if($canCreate == 0)
			$this->view->canCreate = 0;
		else
			$this->view->canCreate = 1;

		$coverType = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'vwty_'.$resource_type);
		if($coverType)
			$this->view->type = $coverType;
		else
			$this->view->type = 1;
    if(isset($_GET['type'])) {
      if($_GET['type'] == 1 || $_GET['type'] == 2 || $_GET['type'] == 4)
      $this->view->type = $_GET['type'];
    }

		$defaultCoverPhoto = $authorizationApi->getPermission($item_level, 'sescontcvrpto', 'dfpto_'.$resource_type);
		if($defaultCoverPhoto)
			$this->view->defaultCoverPhoto = $defaultCoverPhoto;
		else
			$this->view->defaultCoverPhoto = 'application/modules/Sescontentcoverphoto/externals/images/default_cover.jpg';
	}
}
