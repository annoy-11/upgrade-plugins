<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_RecentPeopleActivityController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('stores'))
      return $this->setNoRender();
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $show_criterias = $params['criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $likeMembers = $favMembers = $followMembers = 0;
    if (isset($this->view->likeActive))
      $this->view->likeMembers = $likeMembers = Engine_Api::_()->estore()->getMemberByLike($store->store_id);
    if (isset($this->view->favouriteActive))
      $this->view->favMembers = $favMembers = Engine_Api::_()->estore()->getMemberFavourite($store->store_id);
    if (isset($this->view->followActive))
      $this->view->followMembers = $followMembers = Engine_Api::_()->estore()->getMemberFollow($store->store_id);
    if (isset($this->view->reviewActive))
      $this->view->reviewMembers = $reviewMembers = Engine_Api::_()->estore()->getMemberReview($store->store_id);
    if (count($likeMembers) == 0 && count($favMembers) == 0 && count($followMembers) == 0 && count($reviewMembers) == 0) {
      return $this->setNoRender();
    }
  }

}
