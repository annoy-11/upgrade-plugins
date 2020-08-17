<?php

class Sesmembersubscription_IndexController extends Core_Controller_Action_Standard {

  public function subscriberBenifitAction() {
    $user_id = $this->_getParam('user_id', false);
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->form = $form = new Sesmembersubscription_Form_SubscriberBenifit();
    if ($user_id && $user->subscriber_benifit) {
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Subscriber Benefits");
      $form->setDescription("Below, edit subscriber benefits for your profile.");
      $form->populate($user->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $table = Engine_Api::_()->getDbtable('users', 'user');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        $user->subscriber_benifit = $values['subscriber_benifit'];
				$user->save();
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('Subscriber Benefits is saved successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
  
  public function addVideoAction() {
    $user_id = $this->_getParam('user_id', false);
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->form = $form = new Sesmembersubscription_Form_Video();
    if ($user_id && $user->video_url) {
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Video Url");
      $form->setDescription("Below, edit your welcome video.");
      $form->populate($user->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $table = Engine_Api::_()->getDbtable('users', 'user');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        $user->video_url = $values['video_url'];
				$user->save();
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('Video URL is saved successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
  
  public function designationAction() {
    $user_id = $this->_getParam('user_id', false);
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->form = $form = new Sesmembersubscription_Form_Designation();
    if ($user_id) {
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Designation");
      $form->setDescription("Below, edit your designation.");
      $form->populate($user->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $table = Engine_Api::_()->getDbtable('users', 'user');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        $user->designation = $values['designation'];
				$user->save();
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('Designation is saved successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }


  public function indexAction() {
    
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $resource_id = $viewer->getIdentity(); // content id
    $resource_type = $viewer->getType(); // content type

    $result = Engine_Api::_()->getDbTable('packages', 'sespaymentapi')->getPackageId(array('resource_id' => $resource_id, 'resource_type' => $resource_type));

    // Make form
    $this->view->form = $form = new Sesmembersubscription_Form_Create();
    
    if($result) {
      $package = Engine_Api::_()->getItem('sespaymentapi_package', $result);
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
    
    //Custom Remove after testing
    $recurrence = array_merge(array('day' => "Day"), $multiOptions);
    
    $form->getElement('recurrence')
      ->setMultiOptions($recurrence)
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
    
    $maxsubescriptionvalue = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesmembersubscription', $viewer, 'maxsubescriptionvalue');
    if($maxsubescriptionvalue < $values['price']) {
      $error = $this->view->translate("Please enter amount less then %s, because admin has entered maximum value for your member level %s. If you want to enter more amount then you need to upgrade first your profile.", $maxsubescriptionvalue, $maxsubescriptionvalue);
      $form->getDecorator('errors')->setOption('escape', false);
      $form->addError($error);
      return;
    }


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
    

    $packageTable = Engine_Api::_()->getDbtable('packages', 'sespaymentapi');
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
      $values['resource_id'] = $resource_id;
      $values['resource_type'] = $resource_type;
      
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

  public function manageSubscribersAction() {
  
    //Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespaymentapi_settings');
    
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    
//     if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $event->isOwner($viewer)))
//       return;
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
}