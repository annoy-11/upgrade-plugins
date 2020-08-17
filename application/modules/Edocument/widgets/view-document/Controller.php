<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_ViewDocumentController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('edocument_id', null);
    $subject_id = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getDocumentId($id);

    if(!Engine_Api::_()->core()->hasSubject())
        $this->view->subject = $subject = Engine_Api::_()->getItem('edocument', $subject_id);
    else
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

    $this->view->owner = $subject->getOwner();

    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    if(!$subject->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('edocuments', 'edocument')->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('edocument_id = ?' => $subject->getIdentity()));
    }

    // Get tags
    $this->view->edocumentTags = $subject->tags()->getTagMaps();

    $this->view->rating_count = Engine_Api::_()->edocument()->ratingCount($subject->getIdentity());
    $this->view->rated = Engine_Api::_()->edocument()->checkRated($subject->getIdentity(), $viewer->getIdentity());

    $this->view->isDocumentAdmin = Engine_Api::_()->edocument()->isDocumentAdmin($subject, 'edit');

    $this->view->canEdit =  $subject->authorization()->isAllowed($viewer, 'edit');
    $this->view->canDelete =  $subject->authorization()->isAllowed($viewer, 'delete');

    $this->view->canComment =  $subject->authorization()->isAllowed($viewer, 'comment');

    $LikeStatus = Engine_Api::_()->edocument()->getLikeStatus($subject_id,$subject->getType());
    $this->view->likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
    $this->view->likeText = ($LikeStatus) ?  $this->view->translate('Unlike') : $this->view->translate('Like');

    $this->view->favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$subject_id));
    $this->view->enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1);

    // Get category
    if( !empty($subject->category_id) )
      $this->view->category = Engine_Api::_()->getDbtable('categories', 'edocument')->find($subject->category_id)->current();

  }
}
