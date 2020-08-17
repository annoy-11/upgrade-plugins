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

class Eclassroom_Widget_ClassroomInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('classroom');
    if (!$subject) {
      return $this->setNoRender();
    }
    $locationTable = Engine_Api::_()->getDbTable('locations', 'eclassroom');
    $select = $locationTable->select()
            ->where('classroom_id =?', $subject->classroom_id)
            ->where('is_default =?', 1);
    $this->view->location = $locationTable->fetchRow($select);
    $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->subject = $subject;
    $this->view->classroomTags = $subject->tags()->getTagMaps();
  }

}
