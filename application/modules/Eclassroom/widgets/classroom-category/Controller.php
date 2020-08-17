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
class Classroom_Widget_ClassroomCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($this->view->identity);
    if (!empty($_GET['category_id']))
      $this->view->category_id = $_GET['category_id'];
    else
      $this->view->category_id = 0;
    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory(array('column_name' => '*', 'limit' => $params['count_category']));
    if (count($this->view->categories) <= 0)
      return $this->setNoRender();
  }

}
