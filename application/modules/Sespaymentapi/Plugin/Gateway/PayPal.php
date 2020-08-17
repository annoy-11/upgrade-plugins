<?php

class Sespaymentapi_Plugin_Gateway_PayPal extends Engine_Payment_Plugin_Abstract {

  protected $_gatewayInfo;
  protected $_gateway;  
  
  // General
  /**
   * Constructor
   */
  public function __construct(Zend_Db_Table_Row_Abstract $gatewayInfo)
  {
    $this->_gatewayInfo = $gatewayInfo;

    // @todo
  }
  
  /**
   * Get the service API
   *
   * @return Engine_Service_PayPal
   */
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
      $class = 'Engine_Payment_Gateway_PayPal';
      Engine_Loader::loadClass($class);
      $gateway = new $class(array(
        'config' => (array) $this->_gatewayInfo->config,
        'testMode' => $this->_gatewayInfo->test_mode,
        'currency' => Engine_Api::_()->sespaymentapi()->getCurrentCurrency(),
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
  // SEv4 Specific
  /**
   * Create a transaction for a subscription
   *
   * @param User_Model_User $user
   * @param Zend_Db_Table_Row_Abstract $subscription
   * @param Zend_Db_Table_Row_Abstract $package
   * @param array $params
   * @return Engine_Payment_Gateway_Transaction
   */
	public function createSubscriptionTransaction(User_Model_User $user, Zend_Db_Table_Row_Abstract $user_order, Payment_Model_Package $package, array $params = array()){}
	/**
   * Create a transaction for a user order
   *
   * @param User_Model_User $user
   * @param Zend_Db_Table_Row_Abstract $order
   * @param Zend_Db_Table_Row_Abstract $user
   * @param array $params
   * 
	*/
  public function createOrderTransaction($viewer, $order, $user, array $params = array(), $package) {

    //one time payment
//     $description = $user->displayname;
//     if( strlen($description) > 128 ) {
//       $description = substr($description, 0, 125) . '...';
//     } else if( !$description || !strlen($description) ) {
//       $description = 'N/A';
//     }
//     if( function_exists('iconv') && strlen($description) != iconv_strlen($description) ) {
//       // PayPal requires that DESC be single-byte characters
//       $description = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $description);
//     }
    
    
    // Process description
    // Recurring Payment
    $desc = $package->getPackageDescription();
    if( strlen($desc) > 127 ) {
      $desc = substr($desc, 0, 124) . '...';
    } else if( !$desc || strlen($desc) <= 0 ) {
      $desc = 'N/A';
    }
    if( function_exists('iconv') && strlen($desc) != iconv_strlen($desc) ) {
      // PayPal requires that DESC be single-byte characters
      $desc = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
    }
    
    
		$currentCurrency = Engine_Api::_()->sesbasic() ->getCurrentCurrency();
		$defaultCurrency = Engine_Api::_()->sesbasic() ->defaultCurrency();
		$settings = Engine_Api::_()->getApi('settings', 'core');
		$currencyValue = 1;
		if($currentCurrency != $defaultCurrency){
      $currencyValue = $settings->getSetting('sesbasic.'.$currentCurrency);
		}
    $price =  @round(($order->total_amount * $currencyValue) , 2);
    
		$subscriber_order = array();
    $subscriber_order = array(
      'NAME' => $user->getTitle(),
      'DESC' => $desc,
      'AMT' => $order->total_amount, //Total Amount [User Subscribe Amount + commision Amount]
      'QTY' => 1,
    );
    
    if( $package->isOneTime() ) {
      $params['driverSpecificParams']['PayPal'] = array(
        'AMT' => $price,
        'DESC' => $desc,
        'ITEMAMT' => $price,
        'SELLERID' => '1',
        'SHIPPINGAMT' => 0,
        'TAXAMT' => 0,
        'ITEMS' => $subscriber_order,
        'SOLUTIONTYPE' => 'sole',
        //'BILLINGTYPE' => 'RecurringPayments',
        //'BILLINGAGREEMENTDESCRIPTION' => $package->getPackageDescription(),
      );

      //Should fix some issues with GiroPay
      if( !empty($params['return_url']) ) {
        $params['driverSpecificParams']['PayPal']['GIROPAYSUCCESSURL'] = $params['return_url']
          . ( false === strpos($params['return_url'], '?') ? '?' : '&' ) . 'giropay=1';
        $params['driverSpecificParams']['PayPal']['BANKTXNPENDINGURL'] = $params['return_url']
          . ( false === strpos($params['return_url'], '?') ? '?' : '&' ) . 'giropay=1';
      }
      if( !empty($params['cancel_url']) ) {
        $params['driverSpecificParams']['PayPal']['GIROPAYCANCELURL'] = $params['cancel_url']
          . ( false === strpos($params['return_url'], '?') ? '?' : '&' ) . 'giropay=1';
      }
    } else {
       $params['driverSpecificParams']['PayPal'] = array(
        'BILLINGTYPE' => 'RecurringPayments',
        'BILLINGAGREEMENTDESCRIPTION' => $desc,
      );
    }
    
    //Create transaction
    $transaction = $this->createTransaction($params);
    return $transaction;
  }
  
	public function orderTransactionReturn($order, array $params = array())
  {

    // Check that gateways match
    if( $order->gateway_id != $this->_gatewayInfo->gateway_id ) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }    
    
    // Get related info
    $user = $order->getUser();
    $orderSubscriber = $order->getSource();

    $packageTable = Engine_Api::_()->getDbTable('packages', 'sespaymentapi');
    $packageTableName = $packageTable->info('name');
    
    $packageId = $packageTable->select()
              ->from($packageTable->info('name'), 'package_id')
              ->where('resource_id =?', $orderSubscriber->resource_id)
              ->where('resource_type =?', $orderSubscriber->resource_type)
              ->query()
              ->fetchColumn();
    $package = Engine_Api::_()->getItem('sespaymentapi_package', $packageId);

   // $package = $orderSubscriber->getPackage();
   
    // Check subscription state
    if( $orderSubscriber->state == 'active' ||
        $orderSubscriber->state == 'trial') {
      return 'active';
    } else if( $orderSubscriber->state == 'pending' ) {
      return 'pending';
    }
    
//     if ($orderSubscriber->state == 'pending') {
//       return 'pending';
//     }
    
    // Check for cancel state - the user cancelled the transaction
    if( $params['state'] == 'cancel' ) {
      // Cancel order and subscription?
      $order->onCancel();
      $orderSubscriber->onOrderFailure();
      
      if(empty($orderSubscriber->state) || empty($orderSubscriber->order_id))
        return;
      Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));
      // Error
      throw new Payment_Model_Exception('Your payment has been cancelled and ' .
          'not been charged. If this is not correct, please try again later.');
    }
    
    // Check params
    if( empty($params['token']) ) {
      // Cancel order and subscription?
      $order->onFailure();
      $orderSubscriber->onOrderFailure();
      // This is a sanity error and cannot produce information a user could use
      
      if(empty($orderSubscriber->state) || empty($orderSubscriber->order_id))
        return;
        
      Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));

      // to correct the problem.
      throw new Payment_Model_Exception('There was an error processing your ' . 'transaction. Please try again later.');
    }
    
    // Get details
    try {
      $data = $this->getService()->detailExpressCheckout($params['token']);
      
    } catch( Exception $e ) {
      // Cancel order and subscription?
      $order->onFailure();
      $orderSubscriber->onOrderFailure();
      
      if(empty($orderSubscriber->state) || empty($orderSubscriber->order_id))
        return;
        
      Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));

      // This is a sanity error and cannot produce information a user could use
      // to correct the problem.
      throw new Payment_Model_Exception('There was an error processing your ' . 'transaction. Please try again later.');
    }
    
    // Let's log it
    $this->getGateway()->getLog()->log('ExpressCheckoutDetail: ' . print_r($data, true), Zend_Log::INFO);
    
		//payment currency
		$currentCurrency = Engine_Api::_()->sespaymentapi()->getCurrentCurrency();
		$defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency();
		$settings = Engine_Api::_()->getApi('settings', 'core');
		$currencyValue = 1;
		if($currentCurrency != $defaultCurrency){
      $currencyValue = $settings->getSetting('sesbasic.'.$currentCurrency);
		}
		
		if( $package->isOneTime() ) {
      // Do payment
      try {
        $rdata = $this->getService()->doExpressCheckoutPayment($params['token'],
          $params['PayerID'], array(
          'PAYMENTACTION' => 'Sale',
          'AMT' => $data['AMT'],
          'CURRENCYCODE' => $this->getGateway()->getCurrency(),
        ));
      } catch( Exception $e ) {
        // Log the error
        $this->getGateway()->getLog()->log('DoExpressCheckoutPaymentError: '
            . $e->__toString(), Zend_Log::ERR);  
            
        // Cancel order and subscription?
        $order->onFailure();
        $orderSubscriber->onOrderFailure();
        //update ticket state
        if(empty($orderSubscriber->state) || empty($orderSubscriber->order_id))
          return;
        Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));
        
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' . 'transaction. Please try again later.');
      }
      
      // Let's log it
      $this->getGateway()->getLog()->log('DoExpressCheckoutPayment: ' . print_r($rdata, true), Zend_Log::INFO);
      
      // Get payment state
      $paymentStatus = null;
      $orderStatus = null;
      switch( strtolower($rdata['PAYMENTINFO'][0]['PAYMENTSTATUS']) ) {
        case 'created':
        case 'pending':
          $paymentStatus = 'pending';
          $orderStatus = 'complete';
          break;
        case 'completed':
        case 'processed':
        case 'canceled_reversal': // Probably doesn't apply
          $paymentStatus = 'okay';
          $orderStatus = 'complete';
          break;
        case 'denied':
        case 'failed':
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
      $order->gateway_transaction_id = $rdata['PAYMENTINFO'][0]['TRANSACTIONID'];
      $order->save();

      // Insert transaction
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi');
      $transactionsTable->insert(array(
        'user_id' => $order->user_id,
        'gateway_id' => $this->_gatewayInfo->gateway_id,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'order_id' => $orderSubscriber->order_id,
        'type' => 'payment',
        'state' => $paymentStatus,
        'gateway_transaction_id' => $rdata['PAYMENTINFO'][0]['TRANSACTIONID'],
        'amount' => $rdata['AMT'], // @todo use this or gross (-fee)?
        'currency' => $rdata['PAYMENTINFO'][0]['CURRENCYCODE'],
        'resource_id' => $orderSubscriber->resource_id, // content id
        'resource_type' => $orderSubscriber->resource_type, // content type
        'package_id' => $package->getIdentity(), // package id
      ));
      
      // Get benefit setting
      $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi')->getBenefitStatus($user); 

      // Check payment status
      if( $paymentStatus == 'okay' ||
          ($paymentStatus == 'pending' && $giveBenefit) ) {

        // Update order table info
        $orderSubscriber->gateway_id = $this->_gatewayInfo->gateway_id;
        $orderSubscriber->gateway_transaction_id = $rdata['PAYMENTINFO'][0]['TRANSACTIONID'];
        $orderSubscriber->currency_symbol = $rdata['PAYMENTINFO'][0]['CURRENCYCODE'];
        $orderSubscriber->save();
        
        $orderAmount = round($orderSubscriber->total_useramount,2);

        // update owner remaining amount based on resource_type and resource_id
        $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'sespaymentapi');
        
        $results = $tableRemaining->getUserEntry(array('user_id' => $orderSubscriber->resource_id, 'resource_id' => $orderSubscriber->resource_id, 'resource_type' => $orderSubscriber->resource_type));
        if(count($results)) {
          $tableRemaining->update(array('remaining_payment' => new Zend_Db_Expr("remaining_payment + $orderAmount")), array('user_id =?' => $orderSubscriber->resource_id, 'resource_id =?' => $orderSubscriber->resource_id, 'resource_type =?' => $orderSubscriber->resource_type));
        } else {
          $tableRemaining->insert(array(
            'remaining_payment' => $orderAmount,
            'user_id' => $orderSubscriber->resource_id,
            'resource_id' => $orderSubscriber->resource_id,
            'resource_type' => $orderSubscriber->resource_type,
          ));
        }

        //update order state
        Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'complete'), array('order_id =?' => $orderSubscriber->order_id));
        
        // Payment success
        $orderSubscriber->onOrderComplete();

        // send notification to content owner
        // remaining work also send notification to admin for receiving payment
        if( $orderSubscriber->state == 'complete' ) {
          $subject = Engine_Api::_()->getItem('user', $orderSubscriber->resource_id);
          $user = Engine_Api::_()->getItem('user', $orderSubscriber->user_id);
          
          if($orderSubscriber->resource_type == 'uer') { 
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($subject, $user, $subject, 'sesmembersubscription_subscribe_owner');
          }
        }
        $orderSubscriber->creation_date	= date('Y-m-d H:i:s');
        $orderSubscriber->save();
        return 'active';
      }
      else if( $paymentStatus == 'pending' ) {
      
        // Update order  info
        $orderSubscriber->gateway_id = $this->_gatewayInfo->gateway_id;
        $orderSubscriber->gateway_profile_id = $rdata['PAYMENTINFO'][0]['TRANSACTIONID'];
        $orderSubscriber->save();
        // Order pending
        $orderSubscriber->onOrderPending();
        
        //update ticket state
        Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'pending'), array('order_id =?' => $orderSubscriber->order_id));

        //Send Mail
        //$user = Engine_Api::_()->getItem('sesevent_event', $orderSubscriber->event_id);
        
        //Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'sesevent_payment_ticket_pending', array('event_title' => $user->title, 'evnet_description' => $user->description, 'object_link' => $user->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        
        return 'pending';
      }
      else if( $paymentStatus == 'failed' ) {
        // Cancel order and subscription?
        $order->onFailure();
        $orderSubscriber->onOrderFailure();
        
        //update ticket state
        Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));
        
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
    
    // Recurring
    else {

      // Check for errors
      if( empty($data) ) {
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      } else if( empty($data['BILLINGAGREEMENTACCEPTEDSTATUS']) ||
          '0' == $data['BILLINGAGREEMENTACCEPTEDSTATUS'] ) {
        // Cancel order and subscription?
        $order->onCancel();
        $orderSubscriber->onOrderFailure();
        // Error
        throw new Payment_Model_Exception('Your payment has been cancelled and ' .
            'not been charged. If this in not correct, please try again later.');
      } else if( !isset($data['PAYMENTREQUESTINFO'][0]['ERRORCODE']) ||
          '0' != $data['PAYMENTREQUESTINFO'][0]['ERRORCODE'] ) {
        // Cancel order and subscription?
        $order->onFailure();
        $orderSubscriber->onOrderFailure();
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      }

      // Create recurring payments profile
      $desc = $package->getPackageDescription();
      if( strlen($desc) > 127 ) {
        $desc = substr($desc, 0, 124) . '...';
      } else if( !$desc || strlen($desc) <= 0 ) {
        $desc = 'N/A';
      }
      if( function_exists('iconv') && strlen($desc) != iconv_strlen($desc) ) {
        // PayPal requires that DESC be single-byte characters
        $desc = @iconv("UTF-8", "ISO-8859-1//TRANSLIT", $desc);
      }
      
      // Insert transaction
      $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi');
      $transactionsTable->insert(array(
        'user_id' => $order->user_id,
        'gateway_id' => $this->_gatewayInfo->gateway_id,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'order_id' => $orderSubscriber->order_id,
        'type' => 'payment',
        'state' => 'initial',
        'gateway_transaction_id' => '',
        'amount' => $package->price, // @todo use this or gross (-fee)?
        'currency' => $this->getGateway()->getCurrency(),
        'resource_id' => $orderSubscriber->resource_id,
        'resource_type' => $orderSubscriber->resource_type,
        'package_id' => $package->package_id,
      ));
      $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
      $transaction = Engine_Api::_()->getItem('sespaymentapi_transaction', $transaction_id);
      
//       $commission_percentage = 10; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sessubscribeuser.commison', '5');
//       $commison_amount = ($package->price * $commission_percentage) / 100;
//       $total_amount = $package->price + $commison_amount;
      
      $total_amount = $package->price;
      $commison_amount = 0;
      if($package->resource_type == 'user') {
        $getCommisionEntry = Engine_Api::_()->getDbTable('commissions', 'sesmembersubscription')->getCommisionEntry(array('from' => $package->price));
        if($getCommisionEntry) {
          if($getCommisionEntry->commission_type == 1) { 
            $commison_amount = ($package->price * $getCommisionEntry->commission_value) / 100;
            $total_amount = $package->price + $commison_amount;
          } else if($getCommisionEntry->commission_type == 2) { 
            $total_amount = $package->price + $getCommisionEntry->commission_value;
            $commison_amount = $getCommisionEntry->commission_value;
          }
        }
      }

      $rpData = array(
        'TOKEN' => $params['token'],
        'PROFILEREFERENCE' => $order->order_id,
        'PROFILESTARTDATE' => $data['TIMESTAMP'],
        'DESC' => $desc,
        'BILLINGPERIOD' => ucfirst($package->recurrence_type),
        'BILLINGFREQUENCY' => $package->recurrence,
        'INITAMT' => 0,
        'AMT' => $total_amount, //$package->price,
        'CURRENCYCODE' => $this->getGateway()->getCurrency(),
      );

      $count = $package->getTotalBillingCycleCount();
      if( $count ) {
        $rpData['TOTALBILLINGCYCLES'] = $count;
      }

      // Create recurring payment profile
      try {
        $rdata = $this->getService()->createRecurringPaymentsProfile($rpData);
      } catch( Exception $e ) {
        // Cancel order and subscription?
        $order->onFailure();

        $orderSubscriber->onOrderFailure();
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      }

      // Let's log it
      $this->getGateway()->getLog()->log('CreateRecurringPaymentsProfile: '
          . print_r($rdata, true), Zend_Log::INFO);

      // Check returned profile id
      if( empty($rdata['PROFILEID']) ) {
        // Cancel order and subscription?
        $order->onFailure();
        $orderSubscriber->onOrderFailure();
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' .
            'transaction. Please try again later.');
      }
      $profileId = $rdata['PROFILEID'];

      // Update order with profile info and complete status?
      $order->state = 'complete';
      $order->gateway_order_id = $profileId;
      $order->save();

      // Get benefit setting
      $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi')->getBenefitStatus($user);

      // Check profile status
      if( $rdata['PROFILESTATUS'] == 'ActiveProfile' ||
          ($rdata['PROFILESTATUS'] == 'PendingProfile' && $giveBenefit) ) {
          
        // Enable now
        $orderSubscriber->gateway_id = $this->_gatewayInfo->gateway_id;
        $orderSubscriber->gateway_profile_id = $rdata['PROFILEID'];
        $orderSubscriber->onOrderComplete();
        
        $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
        $transaction->gateway_profile_id = $rdata['PROFILEID'];
        $transaction->save();
        
        if( in_array($transaction->state, array('initial', 'trial', 'pending', 'active')) ) {

//           // If the subscription is in initial or pending, set as active and
//           // cancel any other active subscriptions
//           if( in_array($transaction->state, array('initial', 'pending')) ) {
//             $this->setActive(true);
//             Engine_Api::_()->getDbtable('subscriptions', 'payment')
//               ->cancelAll($this->getUser(), 'User cancelled the subscription.', $this);
//           }
          
          // Update expiration to expiration + recurrence or to now + recurrence?
          //$package = $this->getPackage();
          $expiration = $package->getExpirationDate();
          if( $expiration ) {
            $transaction->state = 'okay';
            $transaction->expiration_date = date('Y-m-d H:i:s', $expiration);
            $transaction->save();
          }
        }

        // send notification
       // if( $orderSubscriber->didStatusChange() ) {
//           Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
//             'subscription_title' => $package->title,
//             'subscription_description' => $package->description,
//             'subscription_terms' => $package->getPackageDescription(),
//             'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
//                 Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
//           ));
       // }

        return 'active';

      } else if( $rdata['PROFILESTATUS'] == 'PendingProfile' ) {
        // Enable later
        $orderSubscriber->gateway_id = $this->_gatewayInfo->gateway_id;
        $orderSubscriber->gateway_profile_id = $rdata['PROFILEID'];
        $orderSubscriber->onPaymentPending();
        
        $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
        $transaction->gateway_profile_id = $rdata['PROFILEID'];
        $transaction->save();
        // send notification
       // if( $orderSubscriber->didStatusChange() ) {
//           Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_pending', array(
//             'subscription_title' => $package->title,
//             'subscription_description' => $package->description,
//             'subscription_terms' => $package->getPackageDescription(),
//             'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
//                 Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
//           ));
      //  }

        return 'pending';

      } else {
        // Cancel order and subscription?
        $order->onFailure();
        $orderSubscriber->onOrderFailure();
        // This is a sanity error and cannot produce information a user could use
        // to correct the problem.
        throw new Payment_Model_Exception('There was an error processing your ' . 'transaction. Please try again later.');
      }
    }
	}
	
  /**
   * Process return of subscription transaction
   *
   * @param Payment_Model_Order $order
   * @param array $params
   */
  public function onSubscriptionTransactionReturn(Payment_Model_Order $order, array $params = array()){
  
  }
  
	public function onOrderPaymentTransactionIpn(Payment_Model_Order $order, Engine_Payment_Ipn $ipn) {
		
    // Check that gateways match
    if( $order->gateway_id != $this->_gatewayInfo->gateway_id ) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
    
    // Get related info
    $user = $order->getUser();
    $orderSubscriber = $order->getSource();
    
    $packageTable = Engine_Api::_()->getDbTable('packages', 'sespaymentapi');
    $packageTableName = $packageTable->info('name');
    
    $packageId = Engine_Api::_()->getDbTable('packages', 'sespaymentapi')->getPackageId(array('resource_id' => $orderSubscriber->resource_id, 'resource_type' => $orderSubscriber->resource_type));
    $package = Engine_Api::_()->getItem('sespaymentapi_package', $packageId);
    
    // Get IPN data
    $rawData = $ipn->getRawData();
    // Get tx table
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi');
    
    // Chargeback --------------------------------------------------------------
    if( !empty($rawData['case_type']) && $rawData['case_type'] == 'chargeback' ) {
      $orderSubscriber->onOrderFailure(); // or should we use pending?
			//update ticket state
		//	Engine_Api::_()->getDbtable('orderTickets', 'sesevent')->updateTicketOrderState(array('order_id'=>$orderSubscriber->order_id,'state'=>'failed'));
    }
    
    // Transaction Type --------------------------------------------------------
    else if( !empty($rawData['txn_type']) ) {
      switch( $rawData['txn_type'] ) {
        // @todo see if the following types need to be processed:
        // — adjustment express_checkout new_case
        case 'express_checkout':
          // Only allowed for one-time
          if( $package->isOneTime() ) {
            switch( $rawData['payment_status'] ) {
              case 'Created': // Not sure about this one
              case 'Pending':
                // @todo this might be redundant
                // Get benefit setting
                $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')->getBenefitStatus($user);
                if( $giveBenefit ) {
                  $orderSubscriber->onOrderComplete();
									//update ticket state
									
									Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'complete'), array('order_id =?' => $orderSubscriber->order_id));
                } else {
                  $orderSubscriber->onOrderPending();
									//update ticket state
									Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'pending'), array('order_id =?' => $orderSubscriber->order_id));
                }
                break;
              case 'Completed':
              case 'Processed':
              case 'Canceled_Reversal': // Not sure about this one
                $orderSubscriber->onOrderComplete();
								//update ticket state
								Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'complete'), array('order_id =?' => $orderSubscriber->order_id));
                break;
              case 'Denied':
              case 'Failed':
              case 'Voided':
              case 'Reversed':
                $orderSubscriber->onOrderFailure();
								//update ticket state
								Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));
                break;
              case 'Refunded':
                $orderSubscriber->onOrderRefund();
								//update ticket state
								Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'refunded'), array('order_id =?' => $orderSubscriber->order_id));
                break;
              case 'Expired': // Not sure about this one
                break;
              default:
                throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
                    'payment status %1$s', $rawData['payment_status']));
                break;
            }
          }
          break;
          
          // Recurring payment was received
          case 'recurring_payment':
            if( !$package->isOneTime() ) {
              $orderSubscriber->onOrderComplete();
              // send notification
              /*if( $item->didStatusChange() ) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_recurrence', array(
                  'subscription_title' => $package->title,
                  'subscription_description' => $package->description,
                  'subscription_terms' => $package->getPackageDescription(),
                  'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                      Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
                ));
              }*/
            }
            break;

          // Profile was created
          case 'recurring_payment_profile_created':
            if( (!empty($rawData['initial_payment_status']) &&
                $rawData['initial_payment_status'] == 'Completed') ||
                (!empty($rawData['profile_status']) && 
                $rawData['profile_status'] == 'Active') ) {
              //$subscription->active = true;
              $orderSubscriber->onOrderComplete();
              // @todo add transaction row for the initial amount?
              // send notification
              /*if( $item->didStatusChange() ) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
                  'subscription_title' => $package->title,
                  'subscription_description' => $package->description,
                  'subscription_terms' => $package->getPackageDescription(),
                  'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                      Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
                ));
              }*/
            } else {
              throw new Engine_Payment_Plugin_Exception(sprintf('Unknown or missing ' .
                  'initial_payment_status %1$s', @$rawData['initial_payment_status']));
            }
            break;

          // Profile was cancelled
          case 'recurring_payment_profile_cancel':
            $orderSubscriber->onOrderCancel();
            // send notification
            /*if( $item->didStatusChange() ) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_cancelled', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }*/
            break;

          // Recurring payment expired
          case 'recurring_payment_expired':
            if( !$package->isOneTime() ) {
              $orderSubscriber->onOrderExpiration();
              // send notification
              /*if( $item->didStatusChange() ) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_expired', array(
                  'subscription_title' => $package->title,
                  'subscription_description' => $package->description,
                  'subscription_terms' => $package->getPackageDescription(),
                  'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                      Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
                ));
              }*/
            }
            break;

          // Recurring payment failed
          case 'recurring_payment_skipped':
          case 'recurring_payment_suspended_due_to_max_failed_payment':
          case 'recurring_payment_outstanding_payment_failed':
          case 'recurring_payment_outstanding_payment':
            $orderSubscriber->onOrderFailure();
            // send notification
            /*if( $item->didStatusChange() ) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_overdue', array(
                'subscription_title' => $package->title,
                'subscription_description' => $package->description,
                'subscription_terms' => $package->getPackageDescription(),
                'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                    Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
              ));
            }*/
            break;
          case 'recurring_payment_suspended':
            $orderSubscriber->onOrderFailure();
            break;
          
        // What is this?
        default:
          throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
              'type %1$s', $rawData['txn_type']));
          break;
      }
    }
    // Payment Status ----------------------------------------------------------
    else if( !empty($rawData['payment_status']) ) {
      switch( $rawData['payment_status'] ) {
        case 'Created': // Not sure about this one
        case 'Pending':
          // Get benefit setting
          $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')->getBenefitStatus($user);
          if( $giveBenefit ) {
            $orderSubscriber->onOrderComplete();
            //update ticket state
            Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'complete'), array('order_id =?' => $orderSubscriber->order_id));
          } else {
            $orderSubscriber->onOrderPending();
            //update ticket state
            Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'pending'), array('order_id =?' => $orderSubscriber->order_id));
          }
          break;
        case 'Completed':
        case 'Processed':
        case 'Canceled_Reversal': // Not sure about this one
          $orderSubscriber->onOrderComplete();
					//update ticket state
					Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'complete'), array('order_id =?' => $orderSubscriber->order_id));
          break;
        case 'Denied':
        case 'Failed':
        case 'Voided':
        case 'Reversed':
           $orderSubscriber->onOrderFailure();
					//update ticket state
					Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'failed'), array('order_id =?' => $orderSubscriber->order_id));

          break;
        case 'Refunded':
         $orderSubscriber->onOrderRefund();
					//update ticket state
					Engine_Api::_()->getDbtable('orders', 'sespaymentapi')->update(array('state' => 'refunded'), array('order_id =?' => $orderSubscriber->order_id));
					break;
        case 'Expired': // Not sure about this one
          break;
        default:
          throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
              'payment status %1$s', $rawData['payment_status']));
          break;
      }
    }
    // Unknown -----------------------------------------------------------------
    else {
      throw new Engine_Payment_Plugin_Exception(sprintf('Unknown IPN ' .
          'data structure'));
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
  public function cancelSubscription($transactionId, $note = null)
  {
    $profileId = null; 
    if( $transactionId instanceof Sespaymentapi_Model_Transaction ) {
      $package = $transactionId->getPackage();
      if( $package->isOneTime() ) {
        return $this;
      }
      $profileId = $transactionId->gateway_profile_id;
    }
    else if( is_string($transactionId) ) {
      $profileId = $transactionId;
    }
    else {
      // Should we throw?
      return $this;
    }
    try {
      $r = $this->getService()->cancelRecurringPaymentsProfile($profileId, $note);
    } catch( Exception $e ) {
      // throw?
    }
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
    // @todo make sure this is correct
    // I don't think this works
    if( $this->getGateway()->getTestMode() ) {
      // Note: it doesn't work in test mode
      return 'https://www.sandbox.paypal.com/vst/?id=' . $orderId;
    } else {
      return 'https://www.paypal.com/vst/?id=' . $orderId;
    }
  }
  /**
   * Generate href to a page detailing the transaction
   *
   * @param string $transactionId
   * @return string
   */
  public function getTransactionDetailLink($transactionId)
  {
    // @todo make sure this is correct
    if( $this->getGateway()->getTestMode() ) {
      // Note: it doesn't work in test mode
      return 'https://www.sandbox.paypal.com/vst/?id=' . $transactionId;
    } else {
      return 'https://www.paypal.com/vst/?id=' . $transactionId;
    }
  }
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
  public function onIpn(Engine_Payment_Ipn $ipn)
  {
    $rawData = $ipn->getRawData();
    $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
    
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi');
    
    // Find transactions -------------------------------------------------------
    $transactionId = null;
    $parentTransactionId = null;
    $transaction = null;
    $parentTransaction = null;
    // Fetch by txn_id
    if( !empty($rawData['txn_id']) ) {
      $transaction = $transactionsTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_transaction_id = ?' => $rawData['txn_id'],
      ));
      $parentTransaction = $transactionsTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_parent_transaction_id = ?' => $rawData['txn_id'],
      ));
    }
    // Fetch by parent_txn_id
    if( !empty($rawData['parent_txn_id']) ) {
      if( !$transaction ) {
        $parentTransaction = $transactionsTable->fetchRow(array(
          'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
          'gateway_parent_transaction_id = ?' => $rawData['parent_txn_id'],
        ));
      }
      if( !$parentTransaction ) {
        $parentTransaction = $transactionsTable->fetchRow(array(
          'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
          'gateway_transaction_id = ?' => $rawData['parent_txn_id'],
        ));
      }
    }
    
    // Fetch by transaction->gateway_parent_transaction_id
    if( $transaction && !$parentTransaction &&
        !empty($transaction->gateway_parent_transaction_id) ) {
      $parentTransaction = $transactionsTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_parent_transaction_id = ?' => $transaction->gateway_parent_transaction_id,
      ));
    }
    // Fetch by parentTransaction->gateway_transaction_id
    if( $parentTransaction && !$transaction &&
        !empty($parentTransaction->gateway_transaction_id) ) {
      $transaction = $transactionsTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_parent_transaction_id = ?' => $parentTransaction->gateway_transaction_id,
      ));
    }
    // Get transaction id
    if( $transaction ) {
      $transactionId = $transaction->gateway_transaction_id;
    } else if( !empty($rawData['txn_id']) ) {
      $transactionId = $rawData['txn_id'];
    }
    // Get parent transaction id
    if( $parentTransaction ) {
      $parentTransactionId = $parentTransaction->gateway_transaction_id;
    } else if( $transaction && !empty($transaction->gateway_parent_transaction_id) ) {
      $parentTransactionId = $transaction->gateway_parent_transaction_id;
    } else if( !empty($rawData['parent_txn_id']) ) {
      $parentTransactionId = $rawData['parent_txn_id'];
    }

    // Fetch order -------------------------------------------------------------
    $order = null;
    // Transaction IPN - get order by invoice
    if( !$order && !empty($rawData['invoice']) ) {
      $order = $ordersTable->find($rawData['invoice'])->current();
    }
    // Subscription IPN - get order by recurring_payment_id
    if( !$order && !empty($rawData['recurring_payment_id']) ) {
      // Get attached order
      $order = $ordersTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_order_id = ?' => $rawData['recurring_payment_id'],
      ));
    }
    // Subscription IPN - get order by rp_invoice_id
    //if( !$order && !empty($rawData['rp_invoice_id']) ) {
    //
    //}
    // Transaction IPN - get order by parent_txn_id
    if( !$order && $parentTransactionId ) {
      $order = $ordersTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_transaction_id = ?' => $parentTransactionId,
      ));
    }
    // Transaction IPN - get order by txn_id
    if( !$order && $transactionId ) {
      $order = $ordersTable->fetchRow(array(
        'gateway_id = ?' => $this->_gatewayInfo->gateway_id,
        'gateway_transaction_id = ?' => $transactionId,
      ));
    }
    // Transaction IPN - get order through transaction
    if( !$order && !empty($transaction->order_id) ) {
      $order = $ordersTable->find($parentTransaction->order_id)->current();
    }
    // Transaction IPN - get order through parent transaction
    if( !$order && !empty($parentTransaction->order_id) ) {
      $order = $ordersTable->find($parentTransaction->order_id)->current();
    }
    // Process generic IPN data ------------------------------------------------
    // Build transaction info
    if( !empty($rawData['txn_id']) ) {
      $transactionData = array(
        'gateway_id' => $this->_gatewayInfo->gateway_id,
      );
      // Get timestamp
      if( !empty($rawData['payment_date']) ) {
        $transactionData['timestamp'] = date('Y-m-d H:i:s', strtotime($rawData['payment_date']));
      } else {
        $transactionData['timestamp'] = new Zend_Db_Expr('NOW()');
      }
      // Get amount
      if( !empty($rawData['mc_gross']) ) {
        $transactionData['amount'] = $rawData['mc_gross'];
      }
      // Get currency
      if( !empty($rawData['mc_currency']) ) {
        $transactionData['currency'] = $rawData['mc_currency'];
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
      if( $parentTransactionId ) {
        $transactionData['gateway_parent_transaction_id'] = $parentTransactionId;
      }
      // Get payment_status
      switch( $rawData['payment_status'] ) {
        case 'Canceled_Reversal': // @todo make sure this works
        case 'Completed':
        case 'Created':
        case 'Processed':
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'okay';
					
          break;
        case 'Denied':
        case 'Expired':
        case 'Failed':
        case 'Voided':
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'failed';
          break;
        case 'Pending':
          $transactionData['type'] = 'payment';
          $transactionData['state'] = 'pending';
          break;
        case 'Refunded':
          $transactionData['type'] = 'refund';
          $transactionData['state'] = 'refunded';
          break;
        case 'Reversed':
          $transactionData['type'] = 'reversal';
          $transactionData['state'] = 'reversed';
          break;
        default:
          $transactionData = 'unknown';
          break;
      }
      // Insert new transaction
      if( !$transaction ) {
        $transactionsTable->insert($transactionData);
      }
      // Update transaction
      else {
        unset($transactionData['timestamp']);
        $transaction->setFromArray($transactionData);
        $transaction->save();
      }
      // Update parent transaction on refund?
      if( $parentTransaction && in_array($transactionData['type'], array('refund','reversal')) ) {
        $parentTransaction->state = $transactionData['state'];
        $parentTransaction->save();
      }
    }
    // Process specific IPN data -----------------------------------------------
    if( $order ) {
      $ipnProcessed = false;
      // Subscription IPN
      if( $order->source_type == 'sespaymentapi_userpayrequest' ) {
        $this->onOrderPaymentTransactionIpn($order, $ipn);
        $ipnProcessed = true;
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
    return new Sespaymentapi_Form_Admin_Gateway_PayPal();
  }
  public function processAdminGatewayForm(array $values)
  {
    return $values;
  }
}