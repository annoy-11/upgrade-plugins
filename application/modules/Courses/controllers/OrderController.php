<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: OrderController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_OrderController extends Core_Controller_Action_Standard {
	public function init() {
	 if (!$this->_helper->requireUser->isValid())
			return;
    $id = $this->_getParam('order_id', null);
    $order = Engine_Api::_()->getItem('courses_order', $id);
    if ($order) {
        Engine_Api::_()->core()->setSubject($order);
    }else{
			 return $this->_forward('requireauth', 'error', 'core');
		}
	}	
  public function viewAction(){ 
    $order_id = $this->_getParam('order_id', null); 
    if(!$order_id)
      return $this->_forward('notfound', 'error', 'core');
    $this->view->format = $this->_getParam('format','');
    $this->view->order = $order = Engine_Api::_()->core()->getSubject();
    $orderCourseTable = Engine_Api::_()->getDbTable('ordercourses','courses');
    $this->view->orderedCourses = $orderCourseTable->orderCourses(array('order_id'=>$order->order_id));
 
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
	}
}
