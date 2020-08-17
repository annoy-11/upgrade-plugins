<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_RecentPeopleActivityController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('sespage_page'))
      return $this->setNoRender();
    $this->view->page = $page = Engine_Api::_()->core()->getSubject();
    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);
    $show_criterias = $params['criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $likeMembers = $favMembers = $followMembers = 0;
    if (isset($this->view->likeActive))
      $this->view->likeMembers = $likeMembers = Engine_Api::_()->sespage()->getMemberByLike($page->page_id);
    if (isset($this->view->favouriteActive))
      $this->view->favMembers = $favMembers = Engine_Api::_()->sespage()->getMemberFavourite($page->page_id);
    if (isset($this->view->followActive))
      $this->view->followMembers = $followMembers = Engine_Api::_()->sespage()->getMemberFollow($page->page_id);
    if (count($likeMembers) == 0 && count($favMembers) == 0 && count($followMembers) == 0) {
      return $this->setNoRender();
    }
  }

}
