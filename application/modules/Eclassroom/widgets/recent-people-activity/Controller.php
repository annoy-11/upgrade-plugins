<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_RecentPeopleActivityController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('classroom'))
      return $this->setNoRender();
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $show_criterias = $params['criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $likeMembers = $favMembers = $followMembers = 0;

    if (isset($this->view->likeActive))
      $this->view->likeMembers = $likeMembers = Engine_Api::_()->eclassroom()->getMemberByLike($classroom->classroom_id);
    if (isset($this->view->favouriteActive))
      $this->view->favMembers = $favMembers = Engine_Api::_()->eclassroom()->getMemberFavourite($classroom->classroom_id);
    if (isset($this->view->followActive))
      $this->view->followMembers = $followMembers = Engine_Api::_()->eclassroom()->getMemberFollow($classroom->classroom_id);
    if (isset($this->view->reviewActive))
      $this->view->reviewMembers = $reviewMembers = Engine_Api::_()->eclassroom()->getMemberReview($classroom->classroom_id);
    if (count($likeMembers) == 0 && count($favMembers) == 0 && count($followMembers) == 0 && count($reviewMembers) == 0) {
      return $this->setNoRender();
    }
  }

}
