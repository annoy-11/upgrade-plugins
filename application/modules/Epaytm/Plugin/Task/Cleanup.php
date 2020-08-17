<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Cleanup.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Payment_Plugin_Task_Cleanup extends Core_Plugin_Task_Abstract
{
  public function execute()
  {
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
    // Get subscriptions that have expired or have finished their trial period
    // (trial is not yet implemented)
    $select = $subscriptionsTable->select()
      ->where('expiration_date <= ?', new Zend_Db_Expr('NOW()'))
      ->where('status = ?', 'active')
      //->where('status IN(?)', array('active', 'trial'))
      ->order('subscription_id ASC')
      ->limit(10)
      ;

    foreach( $subscriptionsTable->fetchAll($select) as $subscription ) {
      $package = $subscription->getPackage();
      // Check if the package has an expiration date
      $expiration = $package->getExpirationDate();
      if( !$expiration || !$package->hasDuration()) {
        continue;
      }
      // It's expired
      // @todo send an email
      $subscription->onExpiration();
      if ($subscription->didStatusChange()) {
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($subscription->getUser(), 'payment_subscription_expired', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
            Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
        ));
      }
    }

    
    // Get subscriptions that are old and are pending payment
    $select = $subscriptionsTable->select()
      ->where('status IN(?)', array('initial', 'pending'))
      ->where('expiration_date <= ?', new Zend_Db_Expr('DATE_SUB(NOW(), INTERVAL 2 DAY)'))
      ->order('subscription_id ASC')
      ->limit(10)
      ;

    foreach($subscriptionsTable->fetchAll($select) as $subscription ) {
      $subscription->onCancel();
      if ($subscription->didStatusChange()) {
        $package = $subscription->getPackage();
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($subscription->getUser(), 'payment_subscription_cancelled', array(
            'subscription_title' => $package->title,
            'subscription_description' => $package->description,
            'subscription_terms' => $package->getPackageDescription(),
            'object_link' => 'http://' . $_SERVER['HTTP_HOST'] .
            Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
        ));
      }
    }
  }
}


