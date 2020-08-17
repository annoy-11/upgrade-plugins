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

class Eclassroom_Widget_ClassroomPopularCategoriesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $widgetParams = $this->_getAllParams();
    $this->view->widgetParams = $widgetParams;
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategory(array('limit' => $widgetParams['limit_data'], 'criteria' => $widgetParams['criteria']));
    if (count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
  }

}
