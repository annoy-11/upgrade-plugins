<?php

class Sessubscribeuser_IndexController extends Core_Controller_Action_Standard {


  public function ordersAction() {
  
    $this->view->user_id = $user_id = $this->_getParam('user_id', null);
    $this->view->user = $user = $user = Engine_Api::_()->getItem('user', $user_id);
    
    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $sessubscribeuserTable = Engine_Api::_()->getDbTable('orders', 'sessubscribeuser');
    $sessubscribeuserTableName = $sessubscribeuserTable->info('name');

    $select = $sessubscribeuserTable->select()
            ->setIntegrityCheck(false)
            ->from($sessubscribeuserTableName)
            ->joinLeft($userTableName, "$sessubscribeuserTableName.subject_id = $userTableName.user_id", 'displayname')
            ->where($sessubscribeuserTableName . '.subject_id = ?', $user_id)
            ->where($sessubscribeuserTableName . '.state = ?', 'complete')
            ->order('order_id DESC');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    
  }
  
  //get user account details
  public function accountDetailsAction() {
    
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_edit');
    
    $viewer = Engine_Api::_()->user()->getViewer();

    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'sessubscribeuser')->getUserGateway(array('user_id' => $viewer->getIdentity(),'enabled'=>true));
    
		$settings = Engine_Api::_()->getApi('settings', 'core');
    $userGatewayEnable = 'paypal';
		$this->view->form = $form = new Sessubscribeuser_Form_PayPal();
		$gatewayTitle = 'Paypal';
		$gatewayClass= 'Sessubscribeuser_Plugin_Gateway_PayPal';
		
    if (count($userGateway)) {
      $form->populate($userGateway->toArray());
      if (is_array($userGateway['config'])) {
        $form->populate($userGateway['config']);
      }
    }
    
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Process
    $values = $form->getValues();
    $enabled = (bool) $values['enabled'];
    unset($values['enabled']);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'sessubscribeuser');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->subject_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->save();
      } else {
        $gatewayObject = Engine_Api::_()->getItem("sessubscribeuser_usergateway", $userGateway['usergateway_id']);
      }
      $db->commit();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Validate gateway config
    if ($enabled) {
      $gatewayObjectObj = $gatewayObject->getGateway();
      try {
        $gatewayObjectObj->setConfig($values);
        $response = $gatewayObjectObj->test();
      } catch (Exception $e) {
        $enabled = false;
        $form->populate(array('enabled' => false));
        $form->addError(sprintf('Gateway login failed. Please double check ' .
                        'your connection information. The gateway has been disabled. ' .
                        'The message was: [%2$d] %1$s', $e->getMessage(), $e->getCode()));
      }
    } else {
      $form->addError('Gateway is currently disabled.');
    }
    // Process
    $message = null;
    try {
      $values = $gatewayObject->getPlugin()->processAdminGatewayForm($values);
    } catch (Exception $e) {
      $message = $e->getMessage();
      $values = null;
    }
    if (null !== $values) {
      $gatewayObject->setFromArray(array(
          'enabled' => $enabled,
          'config' => $values,
      ));
			//echo "asdf<pre>";var_dump($gatewayObject);die;
      $gatewayObject->save();
      $form->addNotice('Changes saved.');
    } else {
      $form->addError($message);
    }
  }
  
  public function indexAction() {
    
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_edit');
    
    $sessubscribeuser = Engine_Api::_()->getDbtable('packages', 'sessubscribeuser');
    $result = $sessubscribeuser->select()
      ->from($sessubscribeuser->info('name'), new Zend_Db_Expr('package_id'))
      ->where('user_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
      ->query()
      ->fetchColumn();

    // Make form
    $this->view->form = $form = new Sessubscribeuser_Form_Create();
    
    if($result) {
      $package = Engine_Api::_()->getItem('sessubscribeuser_package', $result);
      $values = $package->toArray();
      
    $values['recurrence'] = array($values['recurrence'], $values['recurrence_type']);
    $values['duration'] = array($values['duration'], $values['duration_type']);
    //$values['trial_duration'] = array($values['trial_duration'], $values['trial_duration_type']);
    
    //unset($values['recurrence']);
   // unset($values['recurrence_type']);
    //unset($values['duration']);
 //   unset($values['duration_type']);
    //unset($values['trial_duration']);
    //unset($values['trial_duration_type']);

    $otherValues = array(
      'price' => $values['price'],
      'recurrence' => $values['recurrence'],
      'duration' => $values['duration'],
    );
      
      
      $form->populate($values);
    }

    // Get supported billing cycles
    $gateways = array();
    $supportedBillingCycles = array();
    $partiallySupportedBillingCycles = array();
    $fullySupportedBillingCycles = null;
    $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    foreach( $gatewaysTable->fetchAll(/*array('enabled = ?' => 1)*/) as $gateway ) {
      $gateways[$gateway->gateway_id] = $gateway;
      $supportedBillingCycles[$gateway->gateway_id] = $gateway->getGateway()->getSupportedBillingCycles();
      $partiallySupportedBillingCycles = array_merge($partiallySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
      if( null === $fullySupportedBillingCycles ) {
        $fullySupportedBillingCycles = $supportedBillingCycles[$gateway->gateway_id];
      } else {
        $fullySupportedBillingCycles = array_intersect($fullySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
      }
    }
    $partiallySupportedBillingCycles = array_diff($partiallySupportedBillingCycles, $fullySupportedBillingCycles);

    $multiOptions = /* array(
      'Fully Supported' =>*/ array_combine(array_map('strtolower', $fullySupportedBillingCycles), $fullySupportedBillingCycles)/*,
      'Partially Supported' => array_combine(array_map('strtolower', $partiallySupportedBillingCycles), $partiallySupportedBillingCycles),
    )*/;
    $form->getElement('recurrence')
      ->setMultiOptions($multiOptions)
      //->setDescription('-')
      ;
    $form->getElement('recurrence')->options/*['Fully Supported']*/['forever'] = 'One-time';

    $form->getElement('duration')
      ->setMultiOptions($multiOptions)
      //->setDescription('-')
      ;
    $form->getElement('duration')->options/*['Fully Supported']*/['forever'] = 'Forever';

    /*
    $form->getElement('trial_duration')
      ->setMultiOptions($multiOptions)
      //->setDescription('-')
      ;
    $form->getElement('trial_duration')->options['Fully Supported']['forever'] = 'None';
    //$form->getElement('trial_duration')->setValue('0 forever');
     * 
     */

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }


    // Process
    $values = $form->getValues();

    $tmp = $values['recurrence'];
    unset($values['recurrence']);
    if( empty($tmp) || !is_array($tmp) ) {
      $tmp = array(null, null);
    }
    $values['recurrence'] = (int) $tmp[0];
    $values['recurrence_type'] = $tmp[1];

    $tmp = $values['duration'];
    unset($values['duration']);
    if( empty($tmp) || !is_array($tmp) ) {
      $tmp = array(null, null);
    }
    $values['duration'] = (int) $tmp[0];
    $values['duration_type'] = $tmp[1];

    /*
    $tmp = $values['trial_duration'];
    unset($values['trial_duration']);
    if( empty($tmp) || !is_array($tmp) ) {
      $tmp = array(null, null);
    }
    $values['trial_duration'] = (int) $tmp[0];
    $values['trial_duration_type'] = $tmp[1];
     * 
     */
    
    if( !empty($values['default']) && (float) $values['price'] > 0 ) {
      return $form->addError('Only a free plan may be the default plan.');
    }
    

    $packageTable = Engine_Api::_()->getDbtable('packages', 'sessubscribeuser');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();

    try {
      
//       // Update default
//       if( !empty($values['default']) ) {
//         $packageTable->update(array(
//           'default' => 0,
//         ), array(
//           '`default` = ?' => 1,
//         ));
//       }
      $values['user_id'] = Engine_Api::_()->user()->getViewer()->getIdentity();
      // Create package
      if(empty($result)) {
        $package = $packageTable->createRow();
      }
      $package->setFromArray($values);
      $package->save();

      // Create package in gateways?
//       if( !$package->isFree() ) {
//         $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
//         foreach( $gatewaysTable->fetchAll(array('enabled = ?' => 1)) as $gateway ) {
//           $gatewayPlugin = $gateway->getGateway();
//           // Check billing cycle support
//           if( !$package->isOneTime() ) {
//             $sbc = $gateway->getGateway()->getSupportedBillingCycles();
//             if( !in_array($package->recurrence_type, array_map('strtolower', $sbc)) ) {
//               continue;
//             }
//           }
//           if( method_exists($gatewayPlugin, 'createProduct') ) {
//             $gatewayPlugin->createProduct($package->getGatewayParams());
//           }
//         }
//       }

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  
  
  
  
  
  }
}
