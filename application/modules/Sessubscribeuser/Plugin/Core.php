<?php

class Sessubscribeuser_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      return;
    }

    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    
    if ($module == "user" && $controller == 'profile' && $action == 'index') {
      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');

      if (null !== $id) {
        $subject = Engine_Api::_()->user()->getUser($id);
      }
      $subject_id = $subject->getIdentity();
      
      $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      
      $packageTable = Engine_Api::_()->getDbTable('packages', 'sessubscribeuser');
      $packageTableName = $packageTable->info('name');
      
      $package = $packageTable->select()
								->from($packageTable->info('name'), 'price')
								->where('user_id =?', $subject_id)
								->query()
								->fetchColumn();

      if (!empty($package) && $viewer_id != $subject_id) {
        
        $transaction = Engine_Api::_()->getDbTable('transactions','sessubscribeuser')->getItemTransaction(array('user_id' => $viewer_id,'subject_id' => $subject_id, 'noCondition' => 1));

        if(empty($transaction)) {

          //if((strtotime($transaction->expiration_date) <= time())){
            $request->setModuleName('sessubscribeuser');
            $request->setControllerName('profile');
            $request->setActionName('index');
            $request->setParam('module', 'sessubscribeuser');
            $request->setParam('controller', 'profile');
            $request->setParam('action', 'index');
          
          //}
        }
      }
    }
  }
}