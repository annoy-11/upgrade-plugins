<?php

class Sesmembersubscription_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();

    if ($module == "user") {
      if ($controller == "profile" && $action == "index" && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespaymentapi')) {
        $requestParams = $request->getParams();
        $viewer = Engine_Api::_()->user()->getViewer();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        if (null !== $id) {
          $subject = Engine_Api::_()->user()->getUser($id);
        }
        
        $getPackageId = Engine_Api::_()->getDbTable('packages', 'sespaymentapi')->getPackageId(array('resource_id' => $subject->getIdentity(), 'resource_type' => $subject->getType()));
        
        $transaction = Engine_Api::_()->getDbTable('transactions','sespaymentapi')->getItemTransaction(array('user_id' => $viewer->getIdentity(), 'resource_id' => $subject->getIdentity()));
        
        if(!$transaction && $getPackageId && $viewer->getIdentity() != $subject->getIdentity()) {
          $request->setModuleName('sesmembersubscription');
          $request->setControllerName('profile');
          $request->setActionName('index');
        }
      }
    }
  }
}