<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Widget_ProfileReviewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'new', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject('pagereview'))
      return $this->setNoRender();
    //Get subject and check auth
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon');
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit');
    $this->view->review = $review = Engine_Api::_()->core()->getSubject();
    $this->view->item = Engine_Api::_()->getItem('sespage_page', $review->page_id);
  }

}
