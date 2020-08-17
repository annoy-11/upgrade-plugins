<?php

class Sesmembersubscription_Form_Create extends Engine_Form {

  public function init() {
  
    $this->setTitle('Profile Subscription Settings')
      ->setDescription('Here, you can enable subscription to make your profile visible to other users. Enter the subscription amount in the Fees field below. If you do not wish to enable subscription, then leave then enter 0.00 in the Fees field.');
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'sespaymentapi')->getUserGateway(array('user_id' => $viewer->getIdentity()));
    
    
    if(!count($userGateway)) {
      $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'default', true) . 'payment-settings/index';
      $this->addElement('Dummy', 'paymentdetailserror', array(
        'description' => "<div class='tip'><span>It seems you have not completed your payment details. Please fill your payment details from here: <a href='".$actual_link."'>".$actual_link."</a> to request for a refund. This is the account in which the refund will come.</span></div>.",
      ));
      $this->paymentdetailserror->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }

//     // Element: level_id
//     $multiOptions = array('' => '');
//     foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
//       if( $level->type == 'public' || $level->type == 'admin' || $level->type == 'moderator' ) {
//         continue;
//       }
//       $multiOptions[$level->getIdentity()] = $level->getTitle();
//     }
//     $this->addElement('Select', 'level_id', array(
//       'label' => 'Member Level',
//       //'required' => true,
//       //'allowEmpty' => false,
//       'description' => 'The member will be placed into this level upon ' .
//           'subscribing to this plan. If left empty, the default level at the ' .
//           'time a subscription is chosen will be used.',
//       'multiOptions' => $multiOptions,
//     ));

    /*
    // Element: downgrade_level_id
    $this->addElement('Select', 'downgrade_level_id', array(
      'label' => 'Downgrade Member Level',
      'multiOptions' => $multiOptions,
    ));
    */
    
    // Element: price
    $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency');
    $this->addElement('Text', 'price', array(
      'label' => 'Subscription Fees',
      'description' => 'Enter the subscription fees amount. This will be charged once for one-time plans, and each billing cycle for recurring plans. Setting this to zero will disable the subscription and all authorized users will be able to view your profile.',
      'required' => true,
      'allowEmpty' => false,
      'validators' => array(
        array('Float', true),
        new Engine_Validate_AtLeast(0),
      ),
      'value' => '0.00',
    ));

    // Element: recurrence
    $this->addElement('Duration', 'recurrence', array(
      'label' => 'Billing Cycle',
      'description' => 'How often should members in this plan be billed?',
      'required' => true,
      'allowEmpty' => false,
      //'validators' => array(
        //array('Int', true),
        //array('GreaterThan', true, array(0)),
      //),
      'value' => array(1, 'month'),
    ));
    //unset($this->getElement('recurrence')->options['day']);
    //$this->getElement('recurrence')->options['forever'] = 'One-time';
    
    // Element: duration
    $this->addElement('Duration', 'duration', array(
      'label' => 'Billing Duration',
      'description' => 'When should this plan expire? For one-time ' .
        'plans, the plan will expire after the period of time set here. For ' .
        'recurring plans, the user will be billed at the above billing cycle ' .
        'for the period of time specified here.',
      'required' => true,
      'allowEmpty' => false,
      //'validators' => array(
      //  array('Int', true),
      //  array('GreaterThan', true, array(0)),
      //),
      'value' => array('0', 'forever'),
    ));
    //unset($this->getElement('duration')->options['day']);
    
    // Element: trial_duration
    /*
    $this->addElement('Duration', 'trial_duration', array(
      'label' => 'Trial Duration',
      'description' => 'NOT YET IMPLEMENTED. Please note that the way ' .
          'payment gateways implement this varies. PayPal implements this ' .
          'exactly, however 2Checkout uses a negative startup fee. For ' .
          '2Checkout, you must use a multiple of your billing ' .
          'cycle.',
      'validators' => array(
        array('Int', true),
        new Engine_Validate_AtLeast(0),
      ),
      'value' => array('0', 'forever'),
    ));
     * 
     */
    
    // Element: enabled
//     $this->addElement('Radio', 'enabled', array(
//       'label' => 'Enabled?',
//       'description' => 'Can members choose this plan? Please note that disabling this plan will grandfather in existing plan members until they pick a new plan.',
//       'multiOptions' => array(
//         '1' => 'Yes, members may select this plan.',
//         '0' => 'No, members may not select this plan.',
//       ),
//       'value' => 1,
//     ));

    $this->addElement('Textarea', 'message', array(
      'label' => 'Message for Subscription Profile',
      'description' => "Enter the message which will be shown to all the users when they try to view your profile when this profile subscription is enabled.",
      'required' => true,
      'allowEmpty' => false,
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembersubscription.message', "This member is enabled subscription for their profile. So, if you want to view his profile, you can subscribe this member."),
    ));
    
    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));

//     // Element: cancel
//     $this->addElement('Cancel', 'cancel', array(
//       'label' => 'cancel',
//       'prependText' => ' or ',
//       'ignore' => true,
//       'link' => true,
//       'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index', 'package_id' => null)),
//       'decorators' => array('ViewHelper'),
//     ));
// 
//     // DisplayGroup: buttons
//     $this->addDisplayGroup(array('execute', 'cancel'), 'buttons', array(
//       'decorators' => array(
//         'FormElements',
//         'DivDivDivWrapper',
//       )
//     ));
  }
}