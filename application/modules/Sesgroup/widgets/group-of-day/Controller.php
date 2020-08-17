<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_GroupOfDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);
    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    $show_criterias = $params['information'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $item = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getOfTheDayResults($params['category_id']);
    //Get all settings
    $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'likeCount', 'commentCount', 'viewCount', 'followCount', 'songsCount', 'title', 'postedby'));
    $this->view->result = $item;

    if (count($item) < 1)
      return $this->setNoRender();
  }

}
