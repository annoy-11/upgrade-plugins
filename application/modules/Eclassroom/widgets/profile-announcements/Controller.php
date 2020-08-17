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

class Eclassroom_Widget_ProfileAnnouncementsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'eclassroom')
            ->getClassroomAnnouncementPaginator(array('classroom_id' => $classroom->classroom_id),array('title','creation_date','body'));
    $paginator->setItemCountPerPage($this->_getParam('limit_data', 5));
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    if ($paginator->getTotalItemCount() < 1)
       return $this->setNoRender();
  }

}
