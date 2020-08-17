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
class Eclassroom_Widget_ClassroomBannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);
    $value = array();
    $value['order'] = $params['order'];
    $value['info'] = $params['info'];
    if ($params['show_popular_classroom']) {
      $this->view->paginator =$paginator=  Engine_Api::_()->getDbTable('classrooms', 'eclassroom')
              ->getClassroomSelect(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3)));
    }
  }

}
