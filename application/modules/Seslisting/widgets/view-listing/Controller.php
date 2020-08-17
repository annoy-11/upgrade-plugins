<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_ViewListingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('listing_id', null);
    $this->view->listing_id = $listing_id = Engine_Api::_()->getDbtable('seslistings', 'seslisting')->getListingId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $seslisting = Engine_Api::_()->getItem('seslisting', $listing_id);
    else
    $seslisting = Engine_Api::_()->core()->getSubject();
    $seslisting_profilelistings = Zend_Registry::isRegistered('seslisting_profilelistings') ? Zend_Registry::get('seslisting_profilelistings') : null;
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    if (empty($seslisting_profilelistings))
      return $this->setNoRender();
    // Prepare data
    $this->view->seslisting = $seslisting;
    $this->view->owner = $owner = $seslisting->getOwner();
    $this->view->viewer = $viewer;

    if( !$seslisting->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('seslistings', 'seslisting')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'listing_id = ?' => $seslisting->getIdentity(),
      ));
    }

    // Get tags
    $this->view->seslistingTags = $seslisting->tags()->getTagMaps();

    // Get category
    if( !empty($seslisting->category_id) )
    $this->view->category = Engine_Api::_()->getDbtable('categories', 'seslisting')->find($seslisting->category_id)->current();

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
      ->from($table, 'style')
      ->where('type = ?', 'user_seslisting')
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
