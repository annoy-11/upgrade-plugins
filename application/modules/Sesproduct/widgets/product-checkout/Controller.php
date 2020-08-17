<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_ProductCheckoutController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
      //get payment gateway settings
      $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
      if(!empty($paymentGateways['noPaymentGatewayEnableByAdmin'])){
          $this->view->noPaymentGatewayEnableByAdmin = true;
      }
      $this->view->paymentMethods = $paymentGateways['methods'];
  }
}
