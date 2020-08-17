<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Renewal.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epaytm_Plugin_Task_Renewal extends Core_Plugin_Task_Abstract
{
  public function execute()
  {
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'epaytm');
    // Get subscriptions that have expired or have finished their trial period
    // (trial is not yet implemented)
    $select = $subscriptionsTable->select()
      ->where('expiration_date <= ?', new Zend_Db_Expr('NOW()'))
      ->where('status = ?', 'active')
      //->where('status IN(?)', array('active', 'trial'))
      ->order('subscription_id ASC')
      ->limit(10)
      ;
    foreach($subscriptionsTable->fetchAll($select) as $subscription ) {
      $package = $subscription->getPackage();
      // Check if the package has an expiration date
      $expiration = $package->getExpirationDate();
      if(!$expiration || !$package->hasDuration()) {
        continue;
      }
      $gateway = $subscription->getGateway();
      $gatewayPlugin = $gateway->getPlugin();
      $gatewayPlugin->onIpnTransaction($subscription);
    }
  }
}


