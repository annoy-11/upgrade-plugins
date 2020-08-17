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


class Eclassroom_Widget_MainClassroomDetailsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('classroom'))
      return $this->setNoRender();
    $subject = Engine_Api::_()->core()->getSubject();
    $show_criterias = $this->_getParam('show_criteria', array('classroomPhoto', 'title', 'likeButton', 'favouriteButton', 'followButton', 'joinButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    //Set default title
    if (!$this->getElement()->getTitle())
      $this->getElement()->setTitle('Associated Sub Classroom');
    if (!$subject->parent_id)
      return $this->setNoRender();
    $this->view->classroom = Engine_Api::_()->getItem('classroom', $subject->parent_id);
  }

}
