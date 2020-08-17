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

class Epaytm_Plugin_Core extends Zend_Controller_Plugin_Abstract
{
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    if(isset($_GET['gateway_id'])) {
      $gateway = Engine_Api::_()->getItem('payment_gateway', $_GET['gateway_id']);
    }   
    if(empty($gateway))
      return false;
    if($module == "payment" && $controller == "subscription" && $action == "process" && $gateway->plugin == 'Epaytm_Plugin_Gateway_Paytm'){ 
        $request->setModuleName('epaytm');
        $request->setControllerName('subscription');
        $request->setActionName('process');
    }
  }
  public function onUserCreateBefore($event)
  {
    $payload = $event->getPayload();
    if( !($payload instanceof User_Model_User) ) {
      return;
    }
    // Check if the user should be enabled?
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
    if( !$subscriptionsTable->check($payload) ) {
      $payload->enabled = false;
      // We don't want to save here
    }
  }
  public function onUserUpdateBefore($event)
  {
    $payload = $event->getPayload();
    if( !($payload instanceof User_Model_User) ) {
      return;
    }
    // Actually, let's ignore if they've logged in before
    if( !empty($payload->lastlogin_date) ) {
      return;
    }
    // Check if the user should be enabled?
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
    if( !$subscriptionsTable->check($payload) ) {
      $payload->enabled = false;
      // We don't want to save here
    }
  }
  public function onAuthorizationLevelDeleteBefore($event)
  {
    $payload = $event->getPayload();
    if( $payload instanceof Authorization_Model_Level ) {
      $packagesTable = Engine_Api::_()->getDbtable('packages', 'payment');
      $packagesTable->update(array(
        'level_id' => 0,
      ), array(
        'level_id = ?' => $payload->getIdentity(),
      ));
    }
  }
}
