<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: 2Checkout.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesevent_Plugin_Gateway_2Checkout extends Engine_Payment_Plugin_Abstract
{
  protected $_gatewayInfo;
  protected $_gateway;
  // General
  /**
   * Constructor
   */
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
    $this->_gatewayInfo = $gatewayInfo;
  }
  /**
   * Get the service API
   *
   * @return Engine_Service_2Checkout
   */
  public function getService()
  {
    return $this->getGateway()->getService();
  }
  /**
   * Get the gateway object
   *
   * @return Engine_Payment_Gateway_2Checkout
   */
  public function getGateway()
  {
    if( null === $this->_gateway ) {
      $class = 'Engine_Payment_Gateway_2Checkout';
      Engine_Loader::loadClass($class);
      $gateway = new $class(array(
        'config' => (array) $this->_gatewayInfo->config,
        'testMode' =>  $this->_gatewayInfo->test_mode,
        'currency' => Engine_Api::_()->sesevent()->getCurrentCurrency()
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
    $transaction->process($this->getGateway());
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
  public function detectIpn(array $params)
  {
    $expectedCommonParams = array(
      'message_type', 'message_description', 'timestamp', 'md5_hash',
      'message_id', 'key_count', 'vendor_id',
    );
    foreach( $expectedCommonParams as $key ) {
      if( !isset($params[$key]) ) {
        return false;
      }
    }
    return true;
  }
  // SE Specific
  /**
   * Create a transaction for a subscription
   *
   * @param User_Model_User $user
   * @param Zend_Db_Table_Row_Abstract $subscription
   * @param Zend_Db_Table_Row_Abstract $package
   * @param array $params
   * @return Engine_Payment_Gateway_Transaction
   */
	public function createSubscriptionTransaction(User_Model_User $user, Zend_Db_Table_Row_Abstract $advertisment, Payment_Model_Package $package, array $params = array()) {}
  public function createOrderTransaction($viewer,
        $order,$event,$params = array(),$sponsorship)
  {
    // Do stuff to params
    $params['fixed'] = true;
    $params['skip_landing'] = true; 
    // Lookup product id for this order
    $productInfo = $this->getService()->detailVendorProduct($order->getGatewayIdentity());
		if (!isset($productInfo['product_id'])) {
        throw new Engine_Payment_Plugin_Exception('Unable to create product on 2checkout.');
    }
    $params['product_id'] = $productInfo['product_id'];
    $params['quantity'] = 1;
    // Create transaction
    $transaction = $this->createTransaction($params);
    return $transaction;
  }
  /**
   * Process return of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param array $params
   */
  public function onSubscriptionTransactionReturn(
      Payment_Model_Order $order, array $params = array())
  {}
	public function orderBookingTransactionReturn($order,$params = array(),$sponsormember){
    // Check that gateways match
    if( $order->gateway_id != $this->_gatewayInfo->gateway_id ) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
     // Get related info
    $user = $order->getUser();
    $orderTicket = $order->getSource();
  	if($orderTicket->state == 'pending' ) {
      return 'pending';
    }
    // Let's log it
    $this->getGateway()->getLog()->log('Return: '
        . print_r($params, true), Zend_Log::INFO);
    // Check for processed
    if( empty($params['credit_card_processed']) ) {
      // This is a sanity error and cannot produce information a user could use
      // to correct the problem.
			 $orderTicket->onOrderFailure();
			Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'failed'));
      throw new Payment_Model_Exception('There was an error processing your ' .
          'transaction. Please try again later.');
    }
    // Ensure product ids match
    if( $params['merchant_product_id'] != $package->getGatewayIdentity() ) {
      // This is a sanity error and cannot produce information a user could use
      // to correct the problem.
			 $orderTicket->onOrderFailure();
			Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'failed'));
      throw new Payment_Model_Exception('There was an error processing your ' .
          'transaction. Please try again later.');
    }
    // Ensure vendor ids match
    if( $params['sid'] != $this->getGateway()->getVendorIdentity() ) {
      // This is a sanity error and cannot produce information a user could use
      // to correct the problem.
      throw new Payment_Model_Exception('There was an error processing your ' .
          'transaction. Please try again later.');
    }
    // Validate return
    try {
      $this->getGateway()->validateReturn($params);
    } catch( Exception $e ) {
      if( !$this->getGateway()->getTestMode() ) {
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      } else {
        echo $e; // For test mode
      }
    }
    // @todo process total?
    // Update order with profile info and complete status?
    $order->state = 'complete';
    $order->gateway_order_id = $params['order_number'];
    $order->save();
    // Transaction is inserted on IPN since it doesn't send the amount back
    // Get benefit setting
    $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')
        ->getBenefitStatus($user);
    // Enable now
    if( $giveBenefit ) {
			$currentCurrency = Engine_Api::_()->sesevent()->getCurrentCurrency();
			$defaultCurrency = Engine_Api::_()->sesevent()->defaultCurrency();
			$settings = Engine_Api::_()->getApi('settings', 'core');
			$currencyValue = 1;
			if($currentCurrency != $defaultCurrency){
					$currencyValue = $settings->getSetting('sesevent.'.$currentCurrency);
			}
      // Update subscription
      $orderTicket->gateway_id = $this->_gatewayInfo->gateway_id;
      $orderTicket->gateway_profile_id = $params['order_number']; // This is the same as sale_id
			$orderTicket->currency_symbol = $currentCurrency;
			$orderTicket->change_rate = $currencyValue;
			$orderTicket->save();
      $orderTicket->onOrderComplete();
				$orderAmount = round($order->total_service_tax + $order->total_entertainment_tax + $order->total_amount,2);
				 $viewer = Engine_Api::_()->user()->getViewer();
				$commissionType = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','event_sponcommio');
				$commissionTypeValue = Engine_Api::_()->authorization()->getPermission($viewer,'sesevent_event','sponcommi_value');
				//%age wise
				if($commissionType == 1 && $commissionTypeValue > 0){
						$commissionValue = round($orderAmount * ($commissionTypeValue/100),2);
				}else if($commissionType == 2 && $commissionTypeValue > 0){
						$commissionValue = $commissionTypeValue;
				}
				if(isset($commissionValue)){
					$orderAmount = $orderAmount - $commissionValue;	
				}
				$memberSponsorship = Engine_Api::_()->getItem('sesevent_sponsorshipmember', $sponsormember->sponsorshipmemeber_id);
				if($memberSponsorship){
					$memberSponsorship->status = 'complete';
					$memberSponsorship->save();
				}	
				//update EVENT OWNER REMAINING amount
				$tableRemaining = Engine_Api::_()->getDbtable('remainingsponsorshippayments', 'sesevent');
				$tableName = $tableRemaining->info('name');
				$select = $tableRemaining->select()->from($tableName)->where('event_id =?',$order->event_id);
				$select = $tableRemaining->fetchAll($select);
				if(count($select)){
					$tableRemaining->update(array('remaining_payment' => new Zend_Db_Expr("remaining_payment + $orderAmount")),array('event_id =?'=>$order->event_id));
				}else{
					$tableRemaining->insert(array(
						'remaining_payment' => $orderAmount,
						'event_id' => $order->event_id,
					));
				}
      // send notification
     /* if( $subscription->didStatusChange() ) {
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
          'subscription_title' => $package->title,
          'subscription_description' => $package->description,
          'subscription_terms' => $package->getPackageDescription(),
          'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
              Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
        ));
      }*/
      return 'active';
    }
	}
	public function onOrderTicketTransactionIpn( Payment_Model_Order $order, Engine_Payment_Ipn $ipn){
    // Check that gateways match
    if( $order->gateway_id != $this->_gatewayInfo->gateway_id ) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
		$user = $order->getUser();
		$orderTicket = $order->getSource();
    // Get IPN data
    $rawData = $ipn->getRawData();
    // Get tx table
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');

    // Update subscription
    $subscriptionUpdated = false;
    if( !empty($rawData['sale_id']) && empty($subscription->gateway_profile_id) ) {
      $subscriptionUpdated = true;
      $subscription->gateway_profile_id = $rawData['sale_id'];
    }
    if( !empty($rawData['invoice_id']) && empty($subscription->gateway_transaction_id) ) {
      $subscriptionUpdated = true;
      $subscription->gateway_profile_id = $rawData['invoice_id'];
    }
    if( $subscriptionUpdated ) {
      $subscription->save();
    }
    // switch message_type
    switch( $rawData['message_type'] ) {
      case 'ORDER_CREATED':
      case 'FRAUD_STATUS_CHANGED':
      case 'INVOICE_STATUS_CHANGED':
        // Check invoice and fraud status
        if( strtolower($rawData['invoice_status']) == 'declined' ||
            strtolower($rawData['fraud_status']) == 'fail' ) {
          // Payment failure
           $orderTicket->onOrderFailure();
					//update ticket state
						Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->sponsorshiporder_id,'state'=>'failed'));
          // send notification
          /*if( $subscription->didStatusChange() ) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
              'subscription_title' => $package->title,
              'subscription_description' => $package->description,
              'subscription_terms' => $package->getPackageDescription(),
              'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                  Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            ));
          }*/
        } else if( strtolower($rawData['fraud_status']) == 'wait' ) {
          // This is redundant, the same thing is done upon return
          /*
          // Get benefit setting
          $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')->getBenefitStatus($user);
          if( $giveBenefit ) {
            $subscription->onPaymentSuccess();
          } else {
            $subscription->onPaymentPending();
          }
           * 
           */
        } else {
          // Payment Success
           $orderTicket->onOrderSuccess();
					//update ticket state
					Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'complete'));
          // send notification
          /*if( $subscription->didStatusChange() ) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
              'subscription_title' => $package->title,
              'subscription_description' => $package->description,
              'subscription_terms' => $package->getPackageDescription(),
              'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                  Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            ));
          }*/
        }
        break;
      case 'REFUND_ISSUED':
        // Payment Refunded
        $orderTicket->onOrderRefund();
				//update ticket state
				Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'refunded'));
        // send notification
        /*if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_refunded', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }*/
        break;
      case 'RECURRING_INSTALLMENT_SUCCESS':
         $orderTicket->onOrderSuccess();
					//update ticket state
					Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'complete'));
        // send notification
        /*if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_recurrence', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }*/
        break;
      case 'RECURRING_INSTALLMENT_FAILED':
				// Payment failure
				$orderTicket->onOrderFailure();
				//update ticket state
				Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'failed'));
        // send notification
        /*if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }*/
        break;
      case 'RECURRING_STOPPED':
         // Payment failure
				 $orderTicket->onOrderFailure();
				//update ticket state
					Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'failed'));
        // send notification
        /*if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_cancelled', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }*/
        break;
      case 'RECURRING_COMPLETE':
         // Payment failure
           $orderTicket->onOrderSuccess();
					//update ticket state
						Engine_Api::_()->getDbtable('sponsorshiporders', 'sesevent')->updateOrderState(array('order_id'=>$orderTicket->order_id,'state'=>'complete'));
        // send notification
        /*if( $subscription->didStatusChange() ) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_expired', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
          ));
        }*/
        break;
      /*
      case 'RECURRING_RESTARTED':
        break;
       * 
       */
      default:
        throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
            'type %1$s', $rawData['message_type']));
        break;
    }
    return $this;
	}
  /**
   * Process ipn of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param Engine_Payment_Ipn $ipn
   */
  public function onSubscriptionTransactionIpn(
      Payment_Model_Order $order,
      Engine_Payment_Ipn $ipn)
  {}
  /**
   * Cancel a subscription (i.e. disable the recurring payment profile)
   *
   * @params $transactionId
   * @return Engine_Payment_Plugin_Abstract
   */
  public function cancelSubscription($transactionId)
  {
    return $this;
  }
  /**
   * Generate href to a page detailing the order
   *
   * @param string $transactionId
   * @return string
   */
  public function getOrderDetailLink($orderId)
  {
    return 'https://www.2checkout.com/va/sales/detail?sale_id=' . $orderId;
  }
  /**
   * Generate href to a page detailing the transaction
   *
   * @param string $transactionId
   * @return string
   */
  public function getTransactionDetailLink($transactionId)
  {
    return 'https://www.2checkout.com/va/sales/get_list_sale_paged?invoice_id=' . $transactionId;
  }
  /**
   * Get raw data about an order or recurring payment profile
   *
   * @param string $orderId
   * @return array
   */
  public function getOrderDetails($orderId)
  {
    return $this->getService()->detailSale($orderId);
  }
  /**
   * Get raw data about a transaction
   *
   * @param $transactionId
   * @return array
   */
  public function getTransactionDetails($transactionId)
  {
    return $this->getService()->detailInvoice($transactionId);
  }
  // IPN
  /**
   * Process an IPN
   *
   * @param Engine_Payment_Ipn $ipn
   * @return Engine_Payment_Plugin_Abstract
   */
  public function onIpn(Engine_Payment_Ipn $ipn)
  {
    $rawData = $ipn->getRawData();
    $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
    // Find transactions -------------------------------------------------------
    $transactionId = null;
    $transaction = null;
    // Fetch by invoice_id
    if( !empty($rawData['invoice_id']) ) {
      $transaction = $transactionsTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_transaction_id = ?' => $rawData['invoice_id'],
      ));
    }
    if( $transaction && !empty($transaction->gateway_transaction_id) ) {
      $transactionId = $transaction->gateway_transaction_id;
    } else {
      $transactionId = @$rawData['invoice_id'];
    }
    // Fetch order -------------------------------------------------------------
    $order = null;
    // Get order by vendor_order_id
    if( !$order && !empty($rawData['vendor_order_id']) ) {
      $order = $ordersTable->find($rawData['vendor_order_id'])->current();
    }
    // Get order by invoice_id
    if( !$order && $transactionId ) {
      $order = $ordersTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_transaction_id = ?' => $transactionId,
      ));
    }
    // Get order by sale_id
    if( !$order && !empty($rawData['sale_id']) ) {
      $order = $ordersTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_order_id = ?' => $rawData['sale_id'],
      ));
    }
    // Get order by order_id through transaction
    if( !$order && $transaction && !empty($transaction->order_id) ) {
      $order = $ordersTable->find($transaction->order_id)->current();
    }
    // Update order with order/transaction id if necessary
    $orderUpdated = false;
    if( !empty($rawData['invoice_id']) && empty($order->gateway_transaction_id) ) {
      $orderUpdated = true;
      $order->gateway_transaction_id = $rawData['invoice_id'];
    }
    if( !empty($rawData['sale_id']) && empty($order->gateway_order_id) ) {
      $orderUpdated = true;
      $order->gateway_order_id = $rawData['sale_id'];
    }
    if( $orderUpdated ) {
      $order->save();
    }
    // Process generic IPN data ------------------------------------------------
    // Build transaction info
    if( !empty($rawData['invoice_id']) ) {
      $transactionData = array(
        'gateway_id' => $this->_gatewayInfo->gateway_id,
      );
      // Get timestamp
      if( !empty($rawData['payment_date']) ) {
        $transactionData['timestamp'] = date('Y-m-d H:i:s', strtotime($rawData['timestamp']));
      } else {
        $transactionData['timestamp'] = new Zend_Db_Expr('NOW()');
      }
      // Get amount
      if( !empty($rawData['invoice_list_amount']) ) {
        $transactionData['amount'] = $rawData['invoice_list_amount'];
      } else if( $transaction ) {
        $transactionData['amount'] = $transaction->amount;
      } else if( !empty($rawData['item_list_amount_1']) ) {
        // For recurring success
        $transactionData['amount'] = $rawData['item_list_amount_1'];
      }
      // Get currency
      if( !empty($rawData['list_currency']) ) {
        $transactionData['currency'] = $rawData['list_currency'];
      } else if( $transaction ) {
        $transactionData['currency'] = $transaction->currency;
      }
      // Get order/user
      if( $order ) {
        $transactionData['user_id'] = $order->user_id;
        $transactionData['order_id'] = $order->order_id;
      }
      // Get transactions
      if( $transactionId ) {
        $transactionData['gateway_transaction_id'] = $transactionId;
      }
      if( !empty($rawData['sale_id']) ) {
        $transactionData['gateway_order_id'] = $rawData['sale_id'];
      }
      // Get payment_status
      if( !empty($rawData['invoice_status']) ) {
        if( $rawData['invoice_status'] == 'declined' ) {
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'failed';
        } else if( $rawData['fraud_status'] == 'fail' ) {
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'failed-fraud';
        } else if( $rawData['fraud_status'] == 'wait' ) {
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'pending-fraud';
        } else {
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'okay';
        }
      }
      if( $transaction &&
          ($transaction->type == 'refund' || $transaction->state == 'refunded') ) {
        $transactionData['type'] = $transaction->type;
        $transactionData['state'] = $transaction->state;
      }
      // Special case for refund_issued
      $childTransactionData = array();
      if( $rawData['message_type'] == 'REFUND_ISSUED' ) {
        $childTransactionData = $transactionData;
        $childTransactionData['gateway_parent_transaction_id'] = $childTransactionData['gateway_transaction_id'];
        //unset($childTransactionData['gateway_transaction_id']); // Should we unset this?
        $childTransactionData['amount'] = - $childTransactionData['amount'];
        $childTransactionData['type'] = 'refund';
        $childTransactionData['state'] = 'refunded';

        // Update parent transaction
        $transactionData['state'] = 'refunded';
      }
      // Insert or update transactions
      if( !$transaction ) {
        $transactionsTable->insert($transactionData);
      }
      // Update transaction
      else {
        unset($transactionData['timestamp']);
        $transaction->setFromArray($transactionData);
        $transaction->save();
      }
      // Insert new child transaction
      if( $childTransactionData ) {
        $childTransactionExists = $transactionsTable->select()
          ->from($transactionsTable, new Zend_Db_Expr('TRUE'))
          ->where('gateway_transaction_id = ?', $childTransactionData['gateway_transaction_id'])
          ->where('type = ?', $childTransactionData['type'])
          ->where('state = ?', $childTransactionData['state'])
          ->limit(1)
          ->query()
          ->fetchColumn();
        if( !$childTransactionExists ) {
          $transactionsTable->insert($childTransactionData);
        }
      }
    }
    // Process specific IPN data -----------------------------------------------
    if( $order ) {
      $ipnProcessed = false;
      // Subscription IPN
      if( $order->source_type == 'sesevent_order' ) {
        $this->onOrderTicketTransactionIpn($order, $ipn);
        $ipnProcessed = true;
      }
      // Unknown IPN - could not be processed
      if( !$ipnProcessed ) {
        throw new Engine_Payment_Plugin_Exception('Unknown order type for IPN');
      }
    }
    // Missing order
    else {
      throw new Engine_Payment_Plugin_Exception('Unknown or unsupported IPN ' .
          'type, or missing transaction or order ID');
    }
    return $this;
  }
  // Forms
  /**
   * Get the admin form for editing the gateway info
   *
   * @return Engine_Form
   */
  public function getAdminGatewayForm()
  {
    return new Sesevent_Form_Admin_Gateway_2Checkout();
  }
  public function processAdminGatewayForm(array $values)
  {
    // Should we get the vendor_id and secret word?
    $info = $this->getService()->detailCompanyInfo();
    $values['vendor_id'] = $info['vendor_id'];
    $values['secret'] = $info['secret_word'];
    return $values;
  }
}