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

class Sesrecipe_Widget_ViewRecipeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
 
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('recipe_id', null);
    $this->view->recipe_id = $recipe_id = Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->getRecipeId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesrecipe = Engine_Api::_()->getItem('sesrecipe_recipe', $recipe_id);
    else
    $sesrecipe = Engine_Api::_()->core()->getSubject();
    $sesrecipe_profilerecipes = Zend_Registry::isRegistered('sesrecipe_profilerecipes') ? Zend_Registry::get('sesrecipe_profilerecipes') : null;
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
    if (empty($sesrecipe_profilerecipes))
      return $this->setNoRender();
    // Prepare data
    $this->view->sesrecipe = $sesrecipe;
    $this->view->owner = $owner = $sesrecipe->getOwner();
    $this->view->viewer = $viewer;
    
    if( !$sesrecipe->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('recipes', 'sesrecipe')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'recipe_id = ?' => $sesrecipe->getIdentity(),
      ));
    }
    
    // Get tags
    $this->view->sesrecipeTags = $sesrecipe->tags()->getTagMaps();
    
    // Get category
    if( !empty($sesrecipe->category_id) )
    $this->view->category = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->find($sesrecipe->category_id)->current();
    
    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
      ->from($table, 'style')
      ->where('type = ?', 'user_sesrecipe')
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