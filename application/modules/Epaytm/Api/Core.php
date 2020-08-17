<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epaytm_Api_Core extends Core_Api_Abstract
{
  public function updateRenewal($transaction,$package)    
  {
    if(empty($transaction))
      return false;
    $subscriptionTable = Engine_Api::_()->getDbtable('subscriptions', 'epaytm');
    $subscriptionTable->insert(array(
      "user_id" => $transaction->owner_id,
      "package_id" => $transaction->package_id,
      "status" => $transaction->state,
      "active" => ($transaction->state = "active" ? 1 : 0),
      "creation_date" => $transaction->creation_date,
      "modified_date" => $transaction->modified_date,
      "expiration_date" => $package->getExpirationDate(),
      "gateway_id" => $transaction->gateway_id,
      "gateway_profile_id" => $transaction->gateway_profile_id,
      "order_id" => $transaction->order_id,
      "source_type" => $package->getType(),
      "source_id" => $package->getIdentity(),
    ));
  }
}

