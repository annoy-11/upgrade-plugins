<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
   $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
   if (!Engine_Api::_()->core()->hasSubject())
       $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $searchParams['coupon_id']);
    else
      $coupon = Engine_Api::_()->core()->getSubject();
    if (!$coupon)
      return $this->setNoRender();
     $this->view->subject = $coupon;
  }

}
