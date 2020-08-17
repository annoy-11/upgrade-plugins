<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Api_Core extends Core_Api_Abstract
{
    function updateUser(
      Payment_Model_Order $order, array $params = array(),$gateway_profile_id){
       // Get related info
      $user = $order->getUser();
      $subscription = $order->getSource();
      $package = $subscription->getPackage();
      
      // Check subscription state
      if( $subscription->status == 'active')  {
        return 'active';
      } else if( $subscription->status == 'pending' ) {
        return 'pending';
      }
  
      // Check for cancel state - the user cancelled the transaction
      if( $params['state'] == 'cancel' ) {
        // Cancel order and subscription?
        $order->onCancel();
        $subscription->onPaymentFailure();
        // Error
        throw new Payment_Model_Exception('Your payment has been cancelled and ' .
            'not been charged. If this is not correct, please try again later.');
      }
        // Update order with profile info and complete status?
        $order->state = 'complete';
        $order->save();
        $gateway_profile_id = $gateway_profile_id;
        // Get benefit setting
        //$giveBenefit = Engine_Api::_()->getDbtable('transactions', 'payment')
          //  ->getBenefitStatus($user);
        // Insert transaction
        $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
        $transactionsTable->insert(array(
          'user_id' => $order->user_id,
          'gateway_id' => $order->gateway_id,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'order_id' => $order->order_id,
          'type' => 'payment',
          'state' => 'okay',
          'gateway_transaction_id' => $gateway_profile_id,
          'amount' => $package->price, // @todo use this or gross (-fee)?
          'currency' => Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD'),
        ));
        //$subscription->gateway_id = $order->gateway_id;
        //if(!$subscription->gateway_profile_id)
        // $subscription->gateway_profile_id = $gateway_profile_id;
        $subscription->save();
        //if($giveBenefit){
          // Enable now
          $status = $this->onPaymentSuccess($subscription,$package,$user);
          // send notification
          if($status) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'payment_subscription_active', array(
              'subscription_title' => $package->title,
              'subscription_description' => $package->description,
              'subscription_terms' => $package->getPackageDescription(),
              'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
                  Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
            ));
          }
          return 'active';          
        //}
      }
      
    function onPaymentSuccess($subscription,$package,$user){
        $status = false;
        
        if( in_array($subscription->status, array('initial', 'trial', 'pending', 'active')) ) {

        // If the subscription is in initial or pending, set as active and
        // cancel any other active subscriptions
        if( in_array($subscription->status, array('initial', 'pending')) ) {
          $this->setActive(true,null,$subscription);
          Engine_Api::_()->getDbtable('subscriptions', 'payment')
            ->cancelAll($subscription->getUser(), 'User cancelled the subscription.', $subscription);
        }
        // Update expiration to expiration + recurrence or to now + recurrence?
        $package = $subscription->getPackage();
        $expiration = $package->type;
        if( $expiration ) {
          $date = date('Y-m-d H:i:s',strtotime($subscription->creation_date.' + '.$package->recurring_length.' days'));
          $subscription->expiration_date = $date;
        }
        
        // Change status
        if( $subscription->status != 'active' ) {
          $subscription->status = 'active';
          $status = true;
        }
        // Update user if active
        if( $subscription->active ) {
          $subscription->upgradeUser();
        }
      }
      $subscription->save();
      // Check if the member should be enabled
      $user = $subscription->getUser();
      $user->enabled = true; //This will get set correctly in the update hook
      $user->save();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("UPDATE engine4_users SET enabled = 1 WHERE user_id =".$user->getIdentity());
      return $status;
    }
  public function onPaymentFailure($subscription,$package,$user)
  {
    $status = false;
    if( in_array($subscription->status, array('initial', 'trial', 'pending', 'active', 'overdue')) ) {
      // Change status
      if( $subscription->status != 'overdue' ) {
        $subscription->status = 'overdue';
        $status = true;
      }

      // Downgrade and log out user if active
      if( $subscription->active ) {
        // Downgrade user
        $subscription->downgradeUser();

        // Remove active sessions?
        Engine_Api::_()->getDbtable('session', 'core')->removeSessionByAuthId($user->getIdentity());
      }
    }
    $subscription->save();

    // Check if the member should be enabled
    $user = $subscription->getUser();
    $user->enabled = true; // This will get set correctly in the update hook
    $user->save();
    
    return $status;
  }
   public function setActive($flag = true, $deactivateOthers = null,$subscription)
  {
    if( (true === $flag && null === $deactivateOthers) ||
        $deactivateOthers === true ) {
      $table = Engine_Api::_()->getDbTable('subscriptions','payment');
      $select = $table->select()
        ->where('user_id = ?', $subscription->user_id)
        ->where('active = ?', true);
      foreach( $table->fetchAll($select) as $otherSubscription ) {
        $this->setActive(false,null,$subscription);
      }
    }
    $subscription->save();
    return $subscription;
  }
}