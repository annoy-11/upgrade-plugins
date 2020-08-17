<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_FeaturedSponsoredVerifiedCategorySlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

  	$value['category_id'] = $this->_getParam('category','');
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
		$this->view->description_truncation = $this->_getParam('description_truncation', '100');
    $this->view->isfullwidth = $this->_getParam('isfullwidth',1);
    $this->view->autoplay = $this->_getParam('autoplay',1);
    $this->view->speed = $this->_getParam('speed',2000);
    $this->view->type = $this->_getParam('type','fade');
    $this->view->navigation = $this->_getParam('navigation','buttons');
    $this->view->height = $this->_getParam('height','400');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
   $this->view->show_criterias =  $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'rating','by', 'favourite','category','favouriteButton','likeButton', 'creationDate','coursePhoto'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $limit =  $this->_getParam('limit_data', 5);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
   	$value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;
		$value['limit'] = $limit;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('courses', 'courses')->getCourseSelect($value);
		if (count($paginator) <= 0)
			return $this->setNoRender();
  }
}
