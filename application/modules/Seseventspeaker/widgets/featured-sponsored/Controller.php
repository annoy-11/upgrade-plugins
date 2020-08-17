<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_Widget_FeaturedSponsoredController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $value['limit'] = $this->_getParam('limit_data', 5);
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['popularity'] = $this->_getParam('info', 'recently_created');

    $this->view->height = $this->_getParam('height', '180');
    $this->view->width = $this->_getParam('width', '180');
    $this->view->title_truncation_list = $this->_getParam('title_truncation_list', '45');
    $this->view->title_truncation_grid = $this->_getParam('title_truncation_grid', '45');
    $this->view->view_type = $this->_getParam('viewType', 'list');

    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('like', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->paginator = Engine_Api::_()->getDbTable('eventspeakers', 'seseventspeaker')->getSpeakersPaginator($value);
    if ($this->view->paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}
