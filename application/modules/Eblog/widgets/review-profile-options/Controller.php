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
class Eblog_Widget_ReviewProfileOptionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewType = $t= $this->_getParam('viewType', 'vertical');
    $coreMenuApi = Engine_Api::_()->getApi('menus', 'core');
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (!Engine_Api::_()->core()->hasSubject('eblog_review') || !$viewerId)
     return $this->setNoRender();
    
    $review = Engine_Api::_()->core()->getSubject('eblog_review');
    $this->view->content_item = Engine_Api::_()->getItem('eblog_blog', $review->blog_id);
    $this->view->navigation = $coreMenuApi->getNavigation('eblogreview_profile');
  }

}
