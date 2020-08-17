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

class Eblog_Widget_ViewBlogDescriptionController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $t=$this->view->allparams=$all=$this->_getAllParams();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('blog_id', null);
    $this->view->blog_id = $blog_id = Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $eblog = Engine_Api::_()->getItem('eblog_blog', $blog_id);
    else
    $eblog = Engine_Api::_()->core()->getSubject();
    $eblog_profileblogs = Zend_Registry::isRegistered('eblog_profileblogs') ? Zend_Registry::get('eblog_profileblogs') : null;
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
	  $this->view->image_height = $this->_getParam('heightss','500');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    if (empty($eblog_profileblogs))
      return $this->setNoRender();
    // Prepare data
    $this->view->eblog = $eblog;
    $this->view->owner = $owner = $eblog->getOwner();
    $this->view->viewer = $viewer;

    if( !$eblog->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('blogs', 'eblog')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'blog_id = ?' => $eblog->getIdentity(),
      ));
    }

    // Get tags

    $this->view->eblogTags = $eblog->tags()->getTagMaps();

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
      }
      // silence any exception, exceptin in development mode
      catch (Exception $e) {
        if (APPLICATION_ENV === 'development') {
          throw $e;
        }
      }
    }
  }
}
