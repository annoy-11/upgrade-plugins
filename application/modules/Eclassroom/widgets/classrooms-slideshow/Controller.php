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

class Eclassroom_Widget_ClassroomsSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $value['criteria'] = $params['criteria'];
    $value['info'] = $params['info'];
    $value['order'] = $params['order'];
    $value['limit'] = 3;
    $value['left'] = 1;
    $value['category_id'] = $params['category_id'];
    $selectLeft = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($value);
    $limit = $params['limit_data'];
    $valueRight['criteria'] = $params['criteria_right'];
    $valueRight['info'] = $params['info_right'];
    $valueRight['order'] = $params['order'];
    $valueRight['right'] = 1;
    $valueRight['category_id'] = $params['category_id'];
    if ($params['enableSlideshow']) {
      $valueRight['limit'] = $limit;
    } else {
      $valueRight['limit'] = 1;
    }
    $selectRight = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($valueRight);
    $Select = "SELECT t.* FROM (($selectLeft) UNION  ($selectRight)) as t";
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->classrooms = $db->query($Select)->fetchAll();
    if (count($this->view->classrooms) < 4)
      return $this->setNoRender();
  }

}
