<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_ReviewOfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    $this->view->height = $this->_getParam('height', '315');
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('title', 'like', 'view', 'featuredLabel', 'verifiedLabel', 'socialSharing', 'rating', 'by'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->results = Engine_Api::_()->getDbTable('reviews', 'eblog')->getBlogReviewSelect(array('widgetName' => 'oftheday', 'fetchAll' => true), array());
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }

}