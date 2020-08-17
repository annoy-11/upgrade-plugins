<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Plugin_Core extends Zend_Controller_Plugin_Abstract{
  function onSesgroupParticipantCreateAfter($event){
//      $payload = $event->getPayload();
//      $group = Engine_Api::_()->getItem('sesgroup_group',$payload->group_id);
//      if($group && $group->entry_fees > 0){
//        $getPaidOrder = Engine_Api::_()->egroupjoinfees()->isUserHasPaidOrder();
//        if($getPaidOrder){
//         $getPaidOrder->entry_id = $payload->getIdentity();
//         $getPaidOrder->save();  
//        }
//      }
  }
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
//    if (substr($request->getPathInfo(), 1, 5) == "admin")
//       return;
//     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
//     $module = $request->getModuleName(); 
// 		$controller = $request->getControllerName();
// 		$action = $request->getActionName();
//     if (($module == "sesgroup") && $controller == "member" && $action == "request") {
//       $front = Zend_Controller_Front::getInstance();
//       $getParams =  $front->getRequest()->getParams();
//       $enableEntryFees = Engine_Api::_()->getApi('settings', 'core')->getSetting('egroupjoinfees.allow.entryfees', 1);
//       if(!empty( $getParams['group_id']) && $enableEntryFees){
//         $group = Engine_Api::_()->getItem('sesgroup_group',$getParams['group_id']);
//         if($group && $group->entry_fees > 0){
//           //get payment status of user
//          // $isPaymentDone = Engine_Api::_()->egroupjoinfees()->isUserHasPaidOrder();       
//           $request->setModuleName('egroupjoinfees');
//           $request->setControllerName('index');
//           $request->setActionName('join-group');
//           $request->setParams(array('group_id' => $getParams['group_id']));
//           
//         }
//       }
//     }
  }
}
