<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Widget_FaqViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
    $subject = Engine_Api::_()->core()->getSubject();
    $this->view->faq = $subject;
    $this->view->faqTags = $subject->tags()->getTagMaps();
    $this->view->categoriesTable = Engine_Api::_()->getDbTable('categories', 'sesfaq');

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    $this->view->showinformation = $this->_getParam('showinformation', array('likecount', 'viewcount', 'commentcount', 'ratingcount', 'category', 'tags', 'socialshare', 'siteshare', 'showhelpful'));
    
    $this->view->canRate = Engine_Api::_()->authorization()->isAllowed('sesfaq_faq', $viewer, 'rating');
    $this->view->canhelpful = Engine_Api::_()->authorization()->isAllowed('sesfaq_faq', $viewer, 'helpful');
    
    $this->view->rating_count = Engine_Api::_()->sesfaq()->ratingCount($subject->getIdentity());
    $this->view->rated = Engine_Api::_()->sesfaq()->checkRated($subject->getIdentity(), $viewer->getIdentity());
  }

}
