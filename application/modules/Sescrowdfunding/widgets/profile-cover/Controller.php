<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileCoverController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    //Check permission
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $this->view->design = $this->_getParam('desgin', 'desgin1');

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('crowdfunding_id', null);

    $this->view->crowdfunding_id = $crowdfunding_id = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getCrowdfundingId($id);

    if(!Engine_Api::_()->core()->hasSubject())
      $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    else
      $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics'));
    if(is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    //Prepare data
    $this->view->crowdfunding = $sescrowdfunding;
    $this->view->owner = $owner = $sescrowdfunding->getOwner();
    $this->view->viewer = $viewer;

    if( !$sescrowdfunding->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('crowdfunding_id = ?' => $sescrowdfunding->getIdentity()));
    }

    //Get tags
    $this->view->sescrowdfundingTags = $sescrowdfunding->tags()->getTagMaps();

    $this->view->rating_count = Engine_Api::_()->sescrowdfunding()->ratingCount($sescrowdfunding->getIdentity());
    $this->view->rated = Engine_Api::_()->sescrowdfunding()->checkRated($sescrowdfunding->getIdentity(), $viewer->getIdentity());

    //Get category
    if( !empty($sescrowdfunding->category_id))
      $this->view->category = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->find($sescrowdfunding->category_id)->current();
  }

}
