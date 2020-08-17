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
class Courses_Widget_CourseCheckoutController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->cartData = $cartData = Engine_Api::_()->courses()->cartTotalPrice();
    $paymentGateways = Engine_Api::_()->courses()->checkPaymentGatewayEnable();
    $this->view->noPaymentGatewayEnableByAdmin = false;
    if(!empty($paymentGateways['noPaymentGatewayEnableByAdmin'])){
        $this->view->noPaymentGatewayEnableByAdmin = true;
    }
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $this->view->paymentMethods = @$paymentGateways['methods'];
    $this->view->paypal = @$paymentGateways['paypal'];
    $this->view->checkDetails = @$paymentGateways['check_details'];
	}

}
