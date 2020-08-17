<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_ReviewProfileController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
  
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
		if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.review', 1))
		return $this->setNoRender();
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'new', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended','parameter','rating','customfields','likeButton', 'socialSharing', 'share')); 
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject('sesrecipe_review'))
      return $this->setNoRender();
    //Get subject and check auth
    $this->view->review = $review = Engine_Api::_()->core()->getSubject();
		$this->view->item = $event = Engine_Api::_()->getItem('sesrecipe_recipe', $review->recipe_id);
  }
}
