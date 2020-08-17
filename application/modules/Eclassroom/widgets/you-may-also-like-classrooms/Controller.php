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

class Eclassroom_Widget_YouMayAlsoLikeClassroomsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $show_criterias = $params['information'];
    $this->view->height_list = $params['height_list'] ? $params['height_list'] : 230;
    $this->view->width_list = $params['width_list'] ? $params['width_list'] : 260;
     $this->view->height_grid = $params['height_grid'] ? $params['height_grid'] : 230;
    $this->view->width_grid = $params['width_grid'] ? $params['width_grid'] : 260;

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $value = array();
    $value['limit'] = $params['limit_data'];
    $value['popularity'] = 'You May Also Like';
    $value['fetchAll'] = 'true';
    $value['category_id'] = $params['category_id'];

    $this->view->results = $results = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($value);

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}
