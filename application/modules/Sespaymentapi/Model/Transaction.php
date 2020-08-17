<?php

class Sespaymentapi_Model_Transaction extends Core_Model_Item_Abstract
{
  protected $_searchTriggers = false;

  protected $_modifiedTriggers = false;
  
  protected $_statusChanged;
  
  public function cancel()
  {
    // Try to cancel recurring payments in the gateway
    if( !empty($this->gateway_id) && !empty($this->gateway_profile_id) ) {
      try {
        $gateway = Engine_Api::_()->getItem('sespaymentapi_gateway', $this->gateway_id);
        if( $gateway ) {
          $gatewayPlugin = $gateway->getPlugin();
          if( method_exists($gatewayPlugin, 'cancelSubscription') ) {
            $gatewayPlugin->cancelSubscription($this->gateway_profile_id);
          }
        }
      } catch( Exception $e ) {
        // Silence?
      }
    }
    // Cancel this row
    $this->state = 'cancelled'; // Need to do this to prevent clearing the user's session
    $this->save();
    //$this->onCancel();
    return $this;
  }
  
//   public function onCancel()
//   {
//     $this->_statusChanged = false;
//     if( in_array($this->status, array('initial', 'trial', 'pending', 'active', 'overdue', 'cancelled')) ) {
//       // Change status
//       if( $this->status != 'cancelled' ) {
//         $this->status = 'cancelled';
//         $this->_statusChanged = true;
//       }
// 
//       // Downgrade and log out user if active
//       if( $this->active ) {
//         // Downgrade user
//         //$this->downgradeUser();
// 
//         // Remove active sessions?
//         Engine_Api::_()->getDbtable('session', 'core')->removeSessionByAuthId($this->user_id);
//       }
//     }
//     $this->save();
// 
//     // Check if the member should be enabled
// //     $user = $this->getUser();
// //     $user->enabled = true; // This will get set correctly in the update hook
// //     $user->save();
//     
//     return $this;
//   }

}