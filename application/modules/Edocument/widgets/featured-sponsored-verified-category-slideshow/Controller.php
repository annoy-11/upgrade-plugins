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
class Edocument_Widget_FeaturedSponsoredVerifiedCategorySlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    $this->view->title_truncation = $this->_getParam('title_truncation', '45');
    $this->view->isfullwidth = $this->_getParam('isfullwidth',1);
    $this->view->autoplay = $this->_getParam('autoplay',1);
    $this->view->speed = $this->_getParam('speed',2000);
    $this->view->type = $this->_getParam('type','fade');
    $this->view->navigation = $this->_getParam('navigation','buttons');
    $this->view->height = $this->_getParam('height','400');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'rating', 'ratingStar', 'by', 'favourite','category','favouriteButton','likeButton', 'creationDate'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['category_id'] = $this->_getParam('category','');
    $value['criteria'] = $this->_getParam('criteria', 5);
    $value['info'] = $this->_getParam('info', 'recently_created');
    $value['order'] = $this->_getParam('order', '');
    $value['fetchAll'] = true;
    $value['limit'] = $this->_getParam('limit_data', 5);

    $this->view->paginator = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getEdocumentsSelect($value);
    if (count($this->view->paginator) <= 0)
        return $this->setNoRender();
  }
}
