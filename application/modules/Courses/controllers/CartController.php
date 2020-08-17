<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: CartController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_CartController extends Core_Controller_Action_Standard
{

  function indexAction(){
      $this->_helper->content->setEnabled();
      //update cart values
  }
  function viewAction(){
    $cartId = Engine_Api::_()->courses()->getCartId();
    $this->view->isAdded = $isAdded = Engine_Api::_()->getDbTable('cartcourses','courses')->checkcourseadded(array('cart_id'=>$cartId->getIdentity(),'limit'=>true));
    $classroomId = $this->_getParam('classroom_id',0);
    $this->view->is_Ajax_Delete = $is_Ajax_Delete =  $this->_getParam('is_Ajax_Delete',null);
    if($this->_getParam('isAjax')){
        $status = 0;
        $id = $this->_getParam('id');
        $cartCourseTable = Engine_Api::_()->getDbTable('cartcourses','courses');
        $db = $cartCourseTable->getAdapter();
        $db->beginTransaction();
        try {
            if($id) {
                $select = $cartCourseTable->select()->where('cartcourse_id =?',$id);
                $course = $cartCourseTable->fetchRow($select);
                unset($_SESSION['courses_cart_checkout']['cart_total_price'][$course->course_id]);
                $cartCourseTable->delete(array('cartcourse_id =?' => $id, 'cart_id =?' => $cartId->getIdentity()));
                $status = 1;
            }else if($is_Ajax_Delete){
                $cartCourseTable = Engine_Api::_()->getDbTable('cartcourses','courses');
                $select = $cartCourseTable->select()->where('cart_id =?',$cartId->getIdentity());
                $courses = $cartCourseTable->fetchAll($select);
                foreach ($courses as $course) {
                    $course->delete();
                    unset($_SESSION['courses_cart_checkout']['cart_total_price'][$course->course_id]);
                }
              $status = 1;
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        if($this->_getParam('isDelete',0)){
          $this->view->cartData = $cartData = Engine_Api::_()->courses()->cartTotalPrice();
          echo json_encode(array('status'=>$status,
          'message'=>'',
          'cartTotalAmount'=>Engine_Api::_()->courses()->getCurrencyPrice(array_sum($_SESSION['courses_cart_checkout']['cart_total_price'])),
          'cartTotalPrice'=>Engine_Api::_()->courses()->getCurrencyPrice(round($cartData['totalPrice'],2)),
          'cartCountMessage'=>$this->view->translate('Your Item(%s)',$cartData['cartCoursesCount']),
          'cartCoursesCount'=> $cartData['cartCoursesCount'],
          'total_discounted_amount'=>$cartData['coursesArray'][$classroomId]['total_discounted_amount'],
          'total_discount'=>$cartData['coursesArray'][$classroomId]['total_discount'],
          'total_actual_amount'=>$cartData['coursesArray'][$classroomId]['total_actual_amount'],
         ));die;
        }
    } 
    $this->view->cartviewPage = isset($_POST['cart_page']) ? $_POST['cart_page'] : 0;
    $this->view->cartData = $cartData = Engine_Api::_()->courses()->cartTotalPrice();
  }
  function checkoutAction(){
      $this->_helper->content->setEnabled();
      $viewer = $this->view->viewer();
      $formData = array();
      $overviewFormData = array();
      $viewer_id = $viewer->getIdentity();
      $discount_amount = 0;
      if(!$viewer_id)
        return $this->_forward('requireauth', 'error', 'core');
      if(isset($_POST['formData']))
        parse_str($_POST['formData'], $formData);
      if(isset($_POST['overviewFormData']))
        parse_str($_POST['overviewFormData'], $overviewFormData);
      if(isset($_POST['paymetRequest'])) {
        if(!isset($formData['payment_type'])) {
           echo json_encode(array('status'=>0));die;
        }
        $addressTable = Engine_Api::_()->getDbTable('addresses','courses');
        $orderCourseTable = Engine_Api::_()->getDbTable('ordercourses','courses');
        $orderaddressTable = Engine_Api::_()->getDbTable('orderaddresses','courses');
        $orderTable = Engine_Api::_()->getDbTable('orders','courses');
        $cartData = Engine_Api::_()->courses()->cartTotalPrice();
        $order = $orderTable->createRow();
        $orderArray['ip_address'] = $_SERVER["REMOTE_ADDR"];
        if($formData['payment_type'] == "stripe"){
              $table = Engine_Api::_()->getDbTable('gateways','payment');
              $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
              $stripe = $table->fetchRow($select);
              $orderArray['gateway_id'] = $stripe->getIdentity();
              $orderArray['gateway_type'] = "Stripe";
        }elseif($formData['payment_type'] == "paytm"){
              //paypal
              $table = Engine_Api::_()->getDbTable('gateways','payment');
              $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
              $paypal = $table->fetchRow($select);
              $orderArray['gateway_id'] = $paypal->getIdentity();
              $orderArray['gateway_type'] = "Paytm";
        } else {
              //paypal
              $table = Engine_Api::_()->getDbTable('gateways','payment');
              $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
              $paypal = $table->fetchRow($select);
              $orderArray['gateway_id'] = $paypal->getIdentity();
              $orderArray['gateway_type'] = "Paypal";
        }
        $orderArray['creation_date'] = date('Y-m-d H:i:s');
        $orderArray['modified_date'] = date('Y-m-d H:i:s');
        $orderArray['user_id'] = $viewer_id;
        $orderParams = $orderArray;
        if($orderArray['gateway_id'] == 21 || $orderArray['gateway_id'] == 20){
            $orderParams['state'] = "processing";
        }else {
            $orderParams['state'] = 'initial';
        }
        $currencyValue = 1;
        if($currentCurrency != $defaultCurrency){
            $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
        }
        $orderParams['currency_symbol'] = Engine_Api::_()->courses()->getCurrentCurrency();
        $orderParams['change_rate'] = $currencyValue;
        $order->setFromArray($orderParams);
        $order->save();
        $billingAddress = $addressTable->getAddress(array('user_id'=>$viewer_id));
        if(!empty($viewer_id)) {
            $orderAddressItem = $orderaddressTable->createRow();
            $billingArray['user_id'] = $billingAddress['user_id'];
            $billingArray['first_name'] = $billingAddress['first_name'];
            $billingArray['last_name'] = $billingAddress['last_name'];
            $billingArray['email'] = $billingAddress['email'];
            $billingArray['phone_number'] = $billingAddress['phone_number'];
            $billingArray['address'] = $billingAddress['address'];
            $billingArray['country'] = $billingAddress['country'];
            $billingArray['state'] = $billingAddress['state'];
            $billingArray['city'] = $billingAddress['city'];
            $billingArray['order_id'] = $order->getIdentity();
            $orderAddressItem->setFromArray($billingArray);
            $orderAddressItem->save();
        }else{
            $orderAddressItem = $orderaddressTable->createRow();
            $orderAddressItem->setFromArray($billingAddress);
            $orderAddressItem->save();
        }
        $totalItemCount = 0;
        $totalTaxs = 0;
        $totalCoursePrice = 0;
        $couponDetails = array();
        $requestData = array();
        $responseData = array();
      foreach($cartData['coursesArray'] as $key => $cartCourses){
        foreach($cartCourses['course_id'] as $cart){
            $course = Engine_Api::_()->getItem('courses',$cart->course_id);
            if(empty($course))
              continue;
            $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course);
            $taxes = Engine_Api::_()->getDbTable('taxstates','courses')->getOrderTaxes(array('course_id'=>$course->course_id,'total_price'=>@round($priceData['discountPrice'],2),'user_billing_country'=>$billingAddress['country'],'user_billing_state'=>$billingAddress['state']));
            $ordercourse = $orderCourseTable->createRow();
            $orderCourseArray['user_id'] = $viewer_id;
            $orderCourseArray['classroom_id'] = $course->classroom_id;
            $orderCourseArray['course_id'] = $course->getIdentity();
            $orderCourseArray['title'] = $course->getTitle();
            $orderCourseArray['price'] = $priceData['discountPrice'];
            $orderCourseArray['discount'] = $priceData['discount'];
            $orderCourseArray['order_id'] = $order->getIdentity();
            $orderCourseArray['total'] = $priceData['discountPrice']+$taxes['total_tax'];
            $orderCourseArray['billing_taxes'] = json_encode($taxes['taxes']);
            $orderCourseArray['billingtax_cost'] = $taxes['total_tax'];
            $orderCourseArray['creation_date'] = date('Y-m-d H:i:s');
            $orderCourseArray['modified_date'] = date('Y-m-d H:i:s');
            $ordercourse->setFromArray($orderCourseArray);
            $ordercourse->save();
            $totalItemCount++;
            $totalTaxs += $taxes['total_tax'];
            $totalCoursePrice += $priceData['discountPrice']+$taxes['total_tax'];
        }
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')) {
          $coupon_code = $overviewFormData['coupon_code_value_'.$key];
          $requestData['item_amount'] = @round($cartData['coursesArray'][$key]['total_discounted_amount'] ,2);
          $requestData['coupon_code'] = $coupon_code; 
          $requestData['resource_type'] = 'classroom'; 
          $requestData['resource_id'] = $key;
          $requestData['buyer_id'] = $viewer_id;
          $responseData =  Engine_Api::_()->ecoupon()->applyCoupon($requestData);
          $couponDetails[$key]['coupon_id'][] = $responseData['coupon_detail']->coupon_id;
          $couponDetails[$key]['coupon_deducted_amount'][] = $responseData['discount_amount'];
          $discount_amount = $discount_amount + $responseData['discount_amount'];
          $couponDetails[$key]['coupon_code'][] = $coupon_code;
        }
    }
      $orderParams['coupon_details'] = json_encode($couponDetails);
      $orderCourseArray['user_id'] = $viewer_id;
      $orderParams['total_amount'] = @round(($totalCoursePrice -$discount_amount),2);
      $orderParams['total_billingtax_cost'] = $totalTaxs;
      $orderParams['item_count'] = $totalItemCount;
      $order->setFromArray($orderParams);
      $order->save();
      if($orderParams['total_amount'] <= 0) {
        $coursesTableName = Engine_Api::_()->getDbTable('ordercourses','courses');
        $select = $coursesTableName->select()->where('order_id =?',$order->getIdentity());
        $courses = $coursesTableName->fetchAll($select);
        Engine_Api::_()->courses()->orderComplete($order,$courses);
        $url = $this->view->url(array('module'=>'courses','controller'=>'payment','action'=>'return','order_id'=>$order->getIdentity(),'is_free'=>1),'courses_payment',false);
          echo json_encode(array('url'=>$url,'status'=>1));die;
      }
      if($orderArray['gateway_type'] == "Stripe") {
          $url = $this->view->url(array('module'=>'sesadvpmnt','controller'=>'payment','action'=>'index','order_id'=>$order->getIdentity(),'gateway_id'=>$orderArray['gateway_id'],'type'=>'courses'),'default',true);
          echo json_encode(array('url'=>$url,'status'=>1));die;
      } elseif($orderArray['gateway_type'] == "Paytm") {
          $url = $this->view->url(array('module'=>'epaytm','controller'=>'payment','action'=>'index','order_id'=>$order->getIdentity(),'gateway_id'=>$orderArray['gateway_id'],'type'=>'courses'),'default',false);
          echo json_encode(array('url'=>$url,'status'=>1));die;
      } else {
          $url = $this->view->url(array('module'=>'courses','controller'=>'payment','order_id'=>$order->getIdentity(),'gateway_id'=>$orderArray['gateway_id']),'courses_payment',false);
          echo json_encode(array('url'=>$url,'status'=>1));die;
      }
    }
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!empty($viewer_id)){
        $addressTable = Engine_Api::_()->getDbTable('addresses','courses');
        $userAddress = $addressTable->getAddress(array('user_id'=>$viewer_id));
        if(count($userAddress)){
            $_SESSION['courses_cart_checkout']['user_billing_country'] = $userAddress['country'];
            $_SESSION['courses_cart_checkout']['user_billing_state'] = $userAddress['state'];
        }else{
            $_SESSION['courses_cart_checkout']['user_billing_country'] = 0;
            $_SESSION['courses_cart_checkout']['user_billing_state'] = 0;
            
        }
    } else {
          $_SESSION['courses_cart_checkout']['user_billing_country'] = 0;
          $_SESSION['courses_cart_checkout']['user_billing_state'] = 0;
    }
  }
  function applyCouponAction(){
    
    $coupon_code = $this->_getParam('coupon_code');
    $classroom_id = $this->_getParam('classroom_id',false);
    $responseData = array();
    $requestData = array();
    $requestData['coupon_code'] = $coupon_code; 
    $cartData = Engine_Api::_()->courses()->cartTotalPrice();
    $requestData['item_amount'] = @round($cartData['coursesArray'][$classroom_id]['total_discounted_amount'] ,2);
    $requestData['resource_type'] = 'classroom'; 
    $requestData['resource_id'] = $classroom_id;
    $responseData =  Engine_Api::_()->ecoupon()->applyCoupon($requestData);
    if($responseData['status']) { 
      $cartTotalPrice = Engine_Api::_()->courses()->getCurrencyPrice(round($cartData['totalPrice'],2));
      $total_discounted_amount = Engine_Api::_()->courses()->getCurrencyPrice(@round(($cartData['coursesArray'][$classroom_id]['total_discounted_amount']- $responseData['discount_amount']),2));
      $total_actual_amount = Engine_Api::_()->courses()->getCurrencyPrice(@round($cartData['coursesArray'][$classroom_id]['total_actual_amount'],2));
      $total_discount = Engine_Api::_()->courses()->getCurrencyPrice(@round($cartData['coursesArray'][$classroom_id]['total_discount']+$responseData['discount_amount'],2));
      $cartTotalAmount = Engine_Api::_()->courses()->getCurrencyPrice(@round((array_sum($_SESSION['courses_cart_checkout']['cart_total_price'])- $responseData['discount_amount']), 2));
      echo json_encode(array(
        'status'=>$responseData['status'],
        'message'=>$responseData['error_msg'],
        'cartTotalAmount'=>$cartTotalAmount,
        'cartTotalPrice'=>$cartTotalPrice,
        'cartCountMessage'=>$this->view->translate('Your Item(%s)',$cartData['cartCoursesCount']),
        'cartCoursesCount'=>$cartData['cartCoursesCount'],
        'total_discounted_amount'=>$total_discounted_amount,
        'total_discount'=>$total_discount,
        'coupon_discount'=>$responseData['discount_amount'],
        'total_actual_amount'=>$total_actual_amount
      ));die;
    } else {
      echo json_encode(array('status'=>$responseData['status'],'message'=>$responseData['error_msg']));die;
    }
  }
  function setBillingAddressAction(){
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!empty($viewer_id) && isset($_POST) && !empty($_POST)){
        $addressTable = Engine_Api::_()->getDbTable('addresses','courses');
        $userAddress = $addressTable->getAddress(array('user_id'=>$viewer_id));
        if(count($userAddress)){
            $data['user_id'] = $viewer_id;
            $userAddress->setFromArray($data);
        }else{
            $userAddress = $addressTable->createRow();
            $data['user_id'] = $viewer_id;
        }
        parse_str($_POST['formData'], $formData);
        $userAddress->setFromArray(array_merge($data,$formData));
        $userAddress->save();
        $_SESSION['courses_cart_checkout']['user_billing_country'] = !empty($formData['country']) ? $formData['country'] : 0;
        $_SESSION['courses_cart_checkout']['user_billing_state'] = !empty($formData['state']) ? $formData['state'] : 0;
    }
    $this->view->cartData = $cartData = Engine_Api::_()->courses()->cartTotalPrice();
    $this->renderScript('cart/order-review.tpl');
    return;
  }
  function addtocartAction(){
    if(!$this->getRequest()->isPost() ) return;
    $course_id = $this->_getParam('course_id','');
    $course = Engine_Api::_()->getItem('courses',$course_id);
    //check member level allowed to buy course
    $this->view->status = false;
    //insert item in cart
    $cartId = Engine_Api::_()->courses()->getCartId();
    $courseTable = Engine_Api::_()->getDbTable('cartcourses','courses');
    //check course already added to cart
    $isAlreadyAdded = Engine_Api::_()->getDbTable('cartcourses','courses')->checkcourseadded(array('course_id' => $course_id,'cart_id'=>$cartId->getIdentity()));
    if(!$isAlreadyAdded) {
        $courseTable->insert(array('cart_id' => $cartId->getIdentity(),'course_id' => $course_id));
        $this->view->message = $this->view->translate("You have successfully added course to cart.");
    }else {
        $this->view->message = $this->view->translate("You have already added this course in your court.");
    }
    $this->view->status = true;
  }
  function courseCartAction(){
      $totalCourse = Engine_Api::_()->courses()->cartTotalPrice();
      if($totalCourse['cartCoursesCount']){
          echo ($totalCourse['cartCoursesCount']);die;
      }
      echo 0;die;

  }
  function getStateAction(){
    $country_id = $this->_getParam('country_id');
    $selectedState = $this->_getParam('selected',0);
    if(!$country_id)
    {
        echo "";die;
    }
    $states = Engine_Api::_()->getDbTable('states','courses')->getStates(array('country_id'=>$country_id));
    $statesString = "<option value=''>".$this->view->translate("Select State")."</option>";
    foreach($states as $state){
        $selected = "";
        if($selectedState == $state['state_id']){
            $selected = "selected='selected'";
        }
        $statesString .= "<option value='".$state['state_id']."' ".$selected.">".$state['name'].'</option>';
    }
    echo $statesString;die;
  }
}
