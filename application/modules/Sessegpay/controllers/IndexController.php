<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_IndexController extends Core_Controller_Action_Standard
{
    //postback function for segpay transaction
  function indexAction(){	
       $params = $this->_getAllParams();
       $log = new Zend_Log();
       $log->addWriter(new Zend_Log_Writer_Stream(APPLICATION_PATH . '/temporary/log/sessegpay-payment.log'));
       // Log
        if ($log) {
          $log->log(date('c') . ': ' .
          print_r($params, true), Zend_Log::INFO);
        }  
      if(isset($_GET['segpay_notify']) && $_GET['segpay_notify'] == 1) {
        $executed = false;
        $params = array();
        $action	 = $params["action"]	=	'Auth'; //action
        $stage	= $params["stage"]			= $_REQUEST['stage']; //stage
        $approved	= $params["approved"]		= $_REQUEST['approved']; //approved
        $trantype		= $params["trantype"]	= $_REQUEST['trantype']; //trantype
        $billEmail	= $params["billemail"]		= $_REQUEST['billemail']; //billemail
        $purchaseId	= $params["purchaseid"]		= $_REQUEST['purchaseid']; //purchaseid
        $tranId		= $params["tranid"]		= $_REQUEST['tranid']; //tranid
        $billNameFirst = $params["billnamefirst"]		= $_REQUEST['billnamefirst']; //billnamefirst
        $billNameLast	= $params["billnamelast"]	= $_REQUEST['billnamelast']; //billnamelast
        $orderAmount	= $params["price"]	= $_REQUEST['price']; //price
        $order_id		= $params["order_id"]	= (int)$_REQUEST['invoiceid']; //this is order id
        //payment completed
       
        $order	= Engine_Api::_()->getItem('payment_order',$order_id);
        if($order){
          $user = $order->getUser();
          $subscription = $order->getSource();
          $subscription->active = 1;
          $subscription->gateway_profile_id = $_REQUEST['tranid'];
          $subscription->save();
          $package = $subscription->getPackage();  
        }        
        //first subscription success
        if(($action) == "Auth" && ($approved) == "Yes" && ($trantype) == "Sale" && $order_id > 0 && $order && $stage == "Initial")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentSuccess($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
            $executed = true;
        }
         //first subscription failure
        else	if(($action) == "Auth" && ($approved) == "No" && ($trantype) == "Sale" && $order_id > 0 && $order && $stage == "Initial")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentFailure($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
             $executed = true;
        }
        //recurring subscription success
        else	if(($action) == "Auth" && ($approved) == "Yes" && ($trantype) == "Sale" && $order_id > 0 && $order && $stage == "Rebill")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentSuccess($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
             $executed = true;
        }
        //recurring subscription failuer
        else	if(($action) == "Auth" && ($approved) == "No" && ($trantype) == "Sale" && $order_id > 0 && $order && $stage == "Rebill")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentFailure($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
            $executed = true;
        }else if(($action) == "Void" && ($approved) == "Yes" && ($trantype) == "Sale" && $order_id > 0 && $order && $stage == "Initial")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentFailure($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
            $executed = true;
        }else if(($action) == "Auth" && ($approved) == "Yes" && (($trantype) == "Credit" || $trantype == "Charge") && $order_id > 0 && $order && $stage == "Initial")	{
            $status = Engine_Api::_()->sessegpay()->onPaymentFailure($subscription,$package,$user);
            if($status){
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }
            $executed = true;
        }
        if($executed){
           $db = Engine_Db_Table::getDefaultAdapter();
           $allparams = $this->_getAllParams();
           unset($allparams['action']);
           unset($allparams['controller']);
           unset($allparams['module']);
           unset($allparams['rewrite']);
           unset($allparams['segpay_notify']);
           foreach($allparams as $key=>$value){
              $db->query('INSERT INTO engine4_sessegpay_fields (order_id, type, value) VALUES ("' . $order_id . '", "' . $key . '","' . $value . '")	ON DUPLICATE KEY UPDATE	 type = "' . $key . '" , value = "' . $value . '"');
           }
           echo "OK";
        }
      }
      exit; 
  }
}