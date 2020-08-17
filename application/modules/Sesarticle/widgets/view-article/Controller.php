<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_ViewArticleController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
 
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('article_id', null);
    $this->view->article_id = $article_id = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getArticleId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesarticle = Engine_Api::_()->getItem('sesarticle', $article_id);
    else
    $sesarticle = Engine_Api::_()->core()->getSubject();
    $sesarticle_profilearticles = Zend_Registry::isRegistered('sesarticle_profilearticles') ? Zend_Registry::get('sesarticle_profilearticles') : null;
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    $this->view->image_height = $this->_getParam('height','500');
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    if (empty($sesarticle_profilearticles))
      return $this->setNoRender();
    // Prepare data
    $this->view->sesarticle = $sesarticle;
    $this->view->owner = $owner = $sesarticle->getOwner();
    $this->view->viewer = $viewer;
    
    if( !$sesarticle->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'article_id = ?' => $sesarticle->getIdentity(),
      ));
    }
    
    // Get tags
    $this->view->sesarticleTags = $sesarticle->tags()->getTagMaps();
    
    // Get category
    if( !empty($sesarticle->category_id) )
    $this->view->category = Engine_Api::_()->getDbtable('categories', 'sesarticle')->find($sesarticle->category_id)->current();
    
    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
      ->from($table, 'style')
      ->where('type = ?', 'user_sesarticle')
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
