<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Paytm.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
include_once APPLICATION_PATH . "/application/modules/Epaytm/Api/PaytmKit/lib/encdec_paytm.php";
class Epaytm_Plugin_Gateway_User_Paytm extends Engine_Payment_Plugin_Abstract {
  protected $_gatewayInfo;
  protected $_gateway;
  /**
  * Constructor
  */
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
      $this->_gatewayInfo = $gatewayInfo;
      // @todo
  }
  public function getService()
  {
    return $this->getGateway()->getService();
  }
  /**
  * Get the gateway object
  *
  * @return Engine_Payment_Gateway
  */
  public function getGateway()
  {
    if( null === $this->_gateway ) {
        $class = 'Epaytm_Gateways_Paytm';
        Engine_Loader::loadClass($class);
        $gateway = new $class(array(
            'config' => (array) $this->_gatewayInfo->config,
            'testMode' => $this->_gatewayInfo->test_mode,
        ));
        if( !($gateway instanceof Engine_Payment_Gateway) ) {
            throw new Engine_Exception('Plugin class not instance of Engine_Payment_Gateway');
        }
        $this->_gateway = $gateway;
    }
    return $this->_gateway;
  }
  // Actions
  /**
  * Create a transaction object from specified parameters
  *
  * @return Engine_Payment_Transaction
  */
  public function createTransaction(array $params)
  {
      $transaction = new Engine_Payment_Transaction($params);
      $transaction->process($this->getGateway($params['moduleName']));
      return $transaction;
  }

  /**
  * Create an ipn object from specified parameters
  *
  * @return Engine_Payment_Ipn
  */
  public function createIpn(array $params)
  {
      $ipn = new Engine_Payment_Ipn($params);
      $ipn->process($this->getGateway());
      return $ipn;
  }
	public function createSubscriptionTransaction(User_Model_User $user, Zend_Db_Table_Row_Abstract $user_order, Payment_Model_Package $package, array $params = array()){}
  public function createOrderTransaction($param = array()) {}
  public function createOrderTransactionReturn($order,$transaction) {
        // Get related info
        $user = $order->getUser();
        $orderPayment = $order->getSource();
        $module_name = 'user';
         $viewer = Engine_Api::_()->user()->getViewer();
        $paymentStatus = null;
        $orderStatus = null;
        switch($transaction["STATUS"]) {
            case 'created':
            case 'pending':
            case "TXN_SUCCESS":
              $paymentStatus = 'okay';
              $orderStatus = 'complete';
            break;
            case 'completed':
            case 'processed':
            case 'canceled_reversal': // Probably doesn't apply
                $paymentStatus = 'okay';
                $orderStatus = 'complete';
            break;
            case 'denied':
            case "TXN_FAILURE": 
              $paymentStatus = 'failed';
              $orderStatus = 'failed'; 
            break;
            case 'voided': // Probably doesn't apply
            case 'reversed': // Probably doesn't apply
            case 'refunded': // Probably doesn't apply
            case 'expired':  // Probably doesn't apply
            default: // No idea what's going on here
                $paymentStatus = 'failed';
                $orderStatus = 'failed'; // This should probably be 'failed'
            break;
        }
        // Update order with profile info and complete status?
        $order->state = $orderStatus;
        $order->gateway_transaction_id = isset($transaction['TXNID']) ? $transaction['TXNID'] : '';
        $order->save();
        // Insert transaction
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
        $transactionsTable->insert(array(
            'user_id' => $order->user_id,
            'gateway_id' =>2,
            'timestamp' => new Zend_Db_Expr('NOW()'),
            'order_id' => $order->order_id,
            'type' => 'payment',
            'state' => $paymentStatus,
            'gateway_transaction_id' => isset($transaction['TXNID']) ? $transaction['TXNID'] : '',
            'amount' => $transaction['TXNAMOUNT'], // @todo use this or gross (-fee)?
            'currency' => $transaction['CURRENCY'],
        )); 
        // Get benefit setting 
        $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')->getBenefitStatus($user);
        // Check payment status
        if( $paymentStatus == 'okay' || ($paymentStatus == 'pending' && $giveBenefit) ) {
                // Update order table info
            $orderPayment->gateway_id = $this->_gatewayInfo->usergateway_id;
            $orderPayment->gateway_transaction_id = isset($transaction['TXNID']) ? $transaction['TXNID'] : '';
            $orderPayment->release_date = date('Y-m-d H:i:s');
            $orderPayment->gateway_type = "Paytm";
            $orderPayment->save();
            if($order->source_type == 'sescrowdfunding_userpayrequest') {
                $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding');
            } else if($order->source_type == 'sesvideosell_remainingpayment') {
                $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'sesvideosell');
            } else if($order->source_type == 'sesproduct_userpayrequest') {
                $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'estore');
            }else if($order->source_type == 'courses_userpayrequest') {
                $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'courses');
            } else if($order->source_type == 'sesevent_userpayrequest') {
                $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'sesevent');
            }
            $tableName = $tableRemaining->info('name');
            if($order->source_type == 'sescrowdfunding_userpayrequest') {
                $select = $tableRemaining->select()->from($tableName)->where('crowdfunding_id =?',$orderPayment->crowdfunding_id);
                $select = $tableRemaining->fetchAll($select);
                $remainingAmt = $select[0]['remaining_payment'] - $orderPayment->release_amount;
                if($remainingAmt < 0)
                    $orderAmount = 0;
                else
                    $orderAmount = $remainingAmt;
                $tableRemaining->update(array('remaining_payment' => $remainingAmt),array('crowdfunding_id =?'=>$orderPayment->crowdfunding_id));
                $orderPayment->onOrderComplete();
            } else if($order->source_type == 'sesvideosell_remainingpayment') {
                $select = $tableRemaining->select()->from($tableName)->where('user_id =?',$orderPayment->user_id);
                $select = $tableRemaining->fetchAll($select);
                $remainingAmt = $select[0]['remaining_payment'] - $orderPayment->release_amount;
                if($remainingAmt < 0)
                    $orderAmount = 0;
                else
                    $orderAmount = $remainingAmt;
                $tableRemaining->update(array('remaining_payment' => $remainingAmt),array('user_id =?'=>$orderPayment->user_id));
                $orderPayment->onOrderComplete();
            } else if($order->source_type == 'sesproduct_userpayrequest') {
               //update EVENT OWNER REMAINING amount
              $select = $tableRemaining->select()->from($tableName)->where('store_id =?',$orderPayment->store_id);
              $select = $tableRemaining->fetchAll($select);
              $remainingAmt = $select[0]['remaining_payment'] - $orderPayment->release_amount;
              if($remainingAmt < 0)
                $orderAmount = 0;
              else
                $orderAmount = $remainingAmt;
              $tableRemaining->update(array('remaining_payment' => $remainingAmt),array('store_id =?'=>$orderPayment->store_id));
              $orderPayment->onOrderComplete();
                // send notification
                if( $orderPayment->state == 'complete' ) {
                    $store = Engine_Api::_()->getItem('stores', $orderPayment->store_id);
                    $owner = Engine_Api::_()->getItem('user', $store->owner_id);
                    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner->getOwner(), $viewer, $store, 'estore_approve_request');
                    Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->getOwner()->email, 'estore_approve_request', array('host' => $_SERVER['HTTP_HOST'], 'object_link' => $store->getHref()));
                }
                return 'active';
            } else if($order->source_type == 'courses_userpayrequest') {
               //update EVENT OWNER REMAINING amount
              $select = $tableRemaining->select()->from($tableName)->where('course_id =?',$orderPayment->course_id);
              $select = $tableRemaining->fetchAll($select);
              $remainingAmt = $select[0]['remaining_payment'] - $orderPayment->release_amount;
              if($remainingAmt < 0)
                $orderAmount = 0;
              else
                $orderAmount = $remainingAmt;
              $tableRemaining->update(array('remaining_payment' => $remainingAmt),array('course_id =?'=>$orderPayment->course_id));
              $orderPayment->onOrderComplete();
                // send notification
                if( $orderPayment->state == 'complete' ) {
                    $course = Engine_Api::_()->getItem('courses', $orderPayment->course_id);
                    $owner = Engine_Api::_()->getItem('user', $course->owner_id);
                    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner->getOwner(), $viewer, $course, 'estore_approve_request');
                    Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->getOwner()->email, 'courses_approve_request', array('host' => $_SERVER['HTTP_HOST'], 'object_link' => $course->getHref()));
                }
                return 'active';
            } else if($order->source_type == 'sesevent_userpayrequest') {
              //update EVENT OWNER REMAINING amount
              $select = $tableRemaining->select()->from($tableName)->where('event_id =?',$orderPayment->event_id);
              $select = $tableRemaining->fetchAll($select);
              $remainingAmt = $select[0]['remaining_payment'] - $orderPayment->release_amount;
              if($remainingAmt < 0)
                $orderAmount = 0;
              else
                $orderAmount = $remainingAmt;
                $tableRemaining->update(array('remaining_payment' => $remainingAmt),array('event_id =?'=>$orderPayment->event_id));
              // Payment success
              $orderPayment->onOrderComplete();
            }
            if($order->source_type == 'sescrowdfunding_userpayrequest') {
                // Payment success
                // send notification
                if( $orderPayment->state == 'complete' ) {
                    /*Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
                    'subscription_title' => $package->title,
                    'subscription_description' => $package->description,
                    'subscription_terms' => $package->getPackageDescription(),
                    'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                        Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
                    ));*/
                }
            }
            return 'active';
        }
        else if( $paymentStatus == 'pending' ) {
            // Update order  info
            $orderPayment->gateway_id = $this->_gatewayInfo->usergateway_id;
            $orderPayment->gateway_profile_id = isset($transaction['TXNID']) ? $transaction['TXNID'] : '';
                    $orderPayment->save();
            // Order pending
            $orderPayment->onOrderPending();
            return 'pending';
        }
        else if( $paymentStatus == 'failed' ) {
            // Cancel order and subscription?
            $order->onFailure();
            $orderPayment->onOrderFailure();
            // Payment failed
            throw new Payment_Model_Exception('Your payment could not be ' .
                'completed. Please ensure there are sufficient available funds ' .
                'in your account.');
        }
        else {
            // This is a sanity error and cannot produce information a user could use
            // to correct the problem.
            throw new Payment_Model_Exception('There was an error processing your ' .
                'transaction. Please try again later.');
        }
    }
    /**
    * Process return of subscription transaction
    *
    * @param Payment_Model_Order $order
    * @param array $params
    */
  public function onSubscriptionTransactionReturn(Payment_Model_Order $order, array $params = array()) {}
	public function onOrderTicketTransactionIpn(Payment_Model_Order $order, Engine_Payment_Ipn $ipn) {
	}
  /**
   * Process ipn of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param Engine_Payment_Ipn $ipn
   */
  public function onSubscriptionTransactionIpn(
      Payment_Model_Order $order,
      Engine_Payment_Ipn $ipn){}
  public function cancelSubscription($transactionId, $note = null){}
  /**
   * Generate href to a page detailing the order
   *
   * @param string $transactionId
   * @return string
   */
  public function getOrderDetailLink($orderId){}
  /**
   * Generate href to a page detailing the transaction
   *
   * @param string $transactionId
   * @return string
   */
  public function getTransactionDetailLink($transactionId){}
  /**
   * Get raw data about an order or recurring payment profile
   *
   * @param string $orderId
   * @return array
   */
  public function getOrderDetails($orderId)
  {
    // We don't know if this is a recurring payment profile or a transaction id,
    // so try both
    try {
      return $this->getService()->detailRecurringPaymentsProfile($orderId);
    } catch( Exception $e ) {
      echo $e;
    }
    try {
      return $this->getTransactionDetails($orderId);
    } catch( Exception $e ) {
      echo $e;
    }
    return false;
  }
  /**
   * Get raw data about a transaction
   *
   * @param $transactionId
   * @return array
   */
  public function getTransactionDetails($transactionId)
  {
    return $this->getService()->detailTransaction($transactionId);
  }
  // IPN
  /**
   * Process an IPN
   *
   * @param Engine_Payment_Ipn $ipn
   * @return Engine_Payment_Plugin_Abstract
   */
  public function onIpn(Engine_Payment_Ipn $ipn){ }
  function getSupportedCurrencies(){
        return array('INR'=>'INR');
  }
  // Forms
  /**
   * Get the admin form for editing the gateway info
   *
   * @return Engine_Form
   */
  public function getAdminGatewayForm()
  {
    return new Sesbasic_Form_Admin_Gateway_PayPal();
  }
  public function processAdminGatewayForm(array $values)
  {
    return $values;
  }
}
