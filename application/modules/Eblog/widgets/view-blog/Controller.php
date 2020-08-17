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

class Eblog_Widget_ViewBlogController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    
    $this->view->allParams = $allparams = $this->_getAllParams();
    
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('blog_id', null);
    $this->view->blog_id = Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogId($id);
    
    if(!Engine_Api::_()->core()->hasSubject())
      $this->view->eblog = $eblog = Engine_Api::_()->getItem('eblog_blog', $this->view->blog_id);
    else
      $this->view->eblog = $eblog = Engine_Api::_()->core()->getSubject();
      
    $this->view->owner = $owner = $eblog->getOwner();
      
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    
	  $this->view->image_height = $this->_getParam('heightss','500');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    $eblog_profileblogs = Zend_Registry::isRegistered('eblog_profileblogs') ? Zend_Registry::get('eblog_profileblogs') : null;
    if (empty($eblog_profileblogs))
      return $this->setNoRender();

    if( !$eblog->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('blogs', 'eblog')->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('blog_id = ?' => $eblog->getIdentity()));
    }
    
    // Get tags
    $this->view->eblogTags = $eblog->tags()->getTagMaps();
    
    $this->view->coreSettings = $coreSettings = Engine_Api::_()->getApi('settings', 'core');
    $coreApi = Engine_Api::_()->eblog();
    
    $this->view->isBlogAdmin = $coreApi->isBlogAdmin($eblog, 'edit');
    $this->view->reviewCount = $coreApi->getTotalReviews($eblog->blog_id);
    $this->view->LikeStatus = $coreApi->getLikeStatus($eblog->getIdentity(), $eblog->getType());
    
    $this->view->likeClass = (!$this->view->LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
    $this->view->likeText = ($this->view->LikeStatus) ?  $this->view->translate('Unlike') : $this->view->translate('Like');

    $this->view->favStatus = Engine_Api::_()->getDbTable('favourites', 'eblog')->isFavourite(array('resource_type'=>$eblog->getType(), 'resource_id' => $eblog->getIdentity())); 
    
    $this->view->canComment =  $eblog->authorization()->isAllowed($viewer, 'comment');

    $this->view->isAllowReview = $coreSettings->getSetting('eblog.allow.review', 1);
    $this->view->enableSharng = $coreSettings->getSetting('eblog.enable.sharing', 1);

    // Get category
    if( !empty($eblog->category_id) )
      $this->view->category = Engine_Api::_()->getDbtable('categories', 'eblog')->find($eblog->category_id)->current();

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
                  ->from($table, 'style')
                  ->where('type = ?', 'user_eblog')
                  ->where('id = ?', $owner->getIdentity())
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
    if( !empty($style) ) {
      try {
        $this->view->headStyle()->appendStyle($style);
      } catch (Exception $e) {
        if (APPLICATION_ENV === 'development') {
          throw $e;
        }
      }
    }
  }
}
