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
class Sesmember_Widget_OfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '315');
    $this->view->width = $this->_getParam('width', '228');
    $this->view->photo_height = $this->_getParam('photo_height', '210');
    $this->view->photo_width = $this->_getParam('photo_width', '180');
    $this->view->title_truncation_list = $this->_getParam('list_title_truncation', '45');
    $this->view->title_truncation_grid = $this->_getParam('grid_title_truncation', '45');
    $this->view->view_type = $this->_getParam('viewType', 'gridInside');
    $this->view->gridInsideOutside = $this->_getParam('gridInsideOutside', 'in');
    $this->view->mouseOver = $this->_getParam('mouseOver', 'over');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('title', 'like', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'likeButton', 'socialSharing', 'location', 'friendButton', 'likemainButton', 'message', 'followButton', 'rating', 'friendCount', 'profileType', 'mutualFriendCount', 'email', 'age'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->results = Engine_Api::_()->getDbTable('members', 'sesmember')->getMemberSelect(array('widgetName' => 'oftheday', 'fetchAll' => true), array());
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }

}
