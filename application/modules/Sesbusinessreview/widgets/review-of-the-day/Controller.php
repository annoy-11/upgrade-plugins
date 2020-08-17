<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Widget_ReviewOfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    $this->view->width = $this->_getParam('width', '228');
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('title', 'like', 'view', 'featuredLabel', 'verifiedLabel', 'likeButton', 'socialSharing', 'rating'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->results = Engine_Api::_()->getDbTable('businessreviews', 'sesbusinessreview')->getBusinessReviewSelect(array('widgetName' => 'oftheday', 'fetchAll' => true), array());
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }

}
