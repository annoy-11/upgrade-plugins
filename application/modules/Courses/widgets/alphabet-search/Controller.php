<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_AlphabetSearchController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->request =$request =  Zend_Controller_Front::getInstance()->getRequest();
//     $requestParams = $request->getParams();
//     $this->view->controller = $requestParams['controller'];
//     $this->view->medules = $requestParams['modules'];
  }
}
