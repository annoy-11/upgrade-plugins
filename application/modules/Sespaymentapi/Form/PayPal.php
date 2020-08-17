<?php

class Sespaymentapi_Form_PayPal extends Engine_Form {

  public function init() {
  
    parent::init();

    $this->setTitle('Payment Gateway Settings: PayPal');
    
    $description = $this->getTranslator()->translate('SESMEMBERSUBSCRIPTION_FORM_ADMIN_GATEWAY_PAYPAL_DESCRIPTION');
    $description = vsprintf($description, array(
      'https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-api-signature',
      'https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-ipn-notify',
      'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
          'module' => 'payment',
          'controller' => 'ipn',
          'action' => 'PayPal'
        ), 'default', true),
    ));
    $this->setDescription($description);

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    // Elements
    $this->addElement('Text', 'username', array(
      'label' => 'API Username',
      'filters' => array(
       new Zend_Filter_StringTrim(),
      ),
    ));
    
    $this->addElement('Text', 'password', array(
      'label' => 'API Password',
      'filters' => array(
       new Zend_Filter_StringTrim(),
      ),
    ));
    
    $this->addElement('Text', 'signature', array(
      'label' => 'API Signature',
      'filters' => array(
       new Zend_Filter_StringTrim(),
      ),
    ));
    
		 // Element: enabled
    $this->addElement('Radio', 'enabled', array(
      'label' => 'Enabled?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => 0,
      'order' => 10000,
    ));
    
		// Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
     // 'decorators' => array('ViewHelper'),
      'order' => 10001,
      'ignore' => true,
    ));
    
  }
  

  public function isValid($values)
  {
    $enabled = (bool) $values['enabled'];
    if( $enabled && ( empty($values['username']) || empty($values['password']) || empty($values['signature'])) ) {
      $this->addError('Please enter the correct API details before enabling this gateway.');
      return false;
    }
    return parent::isValid($values);
  }
}