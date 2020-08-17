<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_FeaturedSponsoredCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    
    $this->view->height = $this->_getParam('height', '340');
    $this->view->width = $this->_getParam('width', '180');
    $this->view->photo_height = $this->_getParam('photo_height', '200');
    $this->view->photo_width = $this->_getParam('photo_width', '200');
    $this->view->title_truncation_grid = $this->_getParam('list_title_truncation', '45');
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->view_type = $this->_getParam('view_type', 'list');
    $this->view->gridInsideOutside = $this->_getParam('gridInsideOutside', 'in');
    $this->view->mouseOver = $this->_getParam('mouseOver', 'over');
    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('like', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'vipLabel', 'verifiedLabel', 'likeButton', 'friendButton', 'likemainButton', 'message', 'followButton', 'rating', 'friendCount', 'profileType', 'mutualFriendCount', 'email', 'location', 'age'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $value['limit'] = $this->_getParam('limit_data', 5);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
    $value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;
    $this->view->paginator = Engine_Api::_()->getDbTable('members', 'sesmember')->getMemberSelect($value, array());
    if (count($this->view->paginator) <= 0)
      return $this->setNoRender();
  }

}