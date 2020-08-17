<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Widget_ProfileReviewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.review', 1))
      return $this->setNoRender();
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'new', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject('eclassroom_review'))
      return $this->setNoRender();
    //Get subject and check auth
    $this->view->review = $review = Engine_Api::_()->core()->getSubject();
    $this->view->item = Engine_Api::_()->getItem('user', $review->owner_id);
  }

}
