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

class Eclassroom_Widget_ClassroomCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 

    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    if (in_array('countClassrooms', $show_criterias) || $params['criteria'] == 'most_classroom')
      $params['countClassrooms'] = true;
    $params['fetchAll'] = true;
    $params['limit'] = $params['limit_data'];
    $params['type'] = 1;
    // Get pages category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory($params);
    if (count($paginator) == 0)
      return;

  }

}
