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

class Eclassroom_Widget_ClassroomCategoryCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $value = array();
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->criteria = $value['criteria'] = $params['criteria'];
    if ($params['limit_data'])
      $value['limit'] = $params['limit_data'];
    $value['type'] = 1;
    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory($value);
    if (count($this->view->paginator) == 0)
      return $this->setNoRender();
    
  }

}
