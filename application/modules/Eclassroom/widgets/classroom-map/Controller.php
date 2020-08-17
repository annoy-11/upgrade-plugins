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

class Eclassroom_Widget_ClassroomMapController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Don't render this if not authorized
    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)) {
       return $this->setNoRender();
    }
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'eclassroom')
            ->getClassroomLocationPaginator(array('classroom_id' => $classroom->classroom_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    if ($paginator->getTotalItemCount() < 1) {
  			return $this->setNoRender();
    }
  }

}
