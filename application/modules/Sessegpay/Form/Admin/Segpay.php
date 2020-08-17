<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Segpay.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessegpay_Form_Admin_Segpay extends Payment_Form_Admin_Gateway_Abstract
{
  public function init()
  {
    parent::init();

    $this->setTitle('Payment Gateway: SegPay');
    
    $description = $this->getTranslator()->translate('');
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

    $this->addElement('Text', 'userid', array(
        'label' => 'Username',
        'description' => 'Your username to access SegPay Reporting Services (SRS).',
        'allowEmpty' => false,
	    	'required' => true,
    ));
    
    $this->addElement('Text', 'useraccesskey', array(
        'label' => 'User Access Key',
        'description' => ' Your unique key to access SegPay Reporting Services (SRS).',
        'allowEmpty' => false,
	    	'required' => true,
    ));    
  }

  public function isValid($values)
  {
    $enabled = (bool) $values['enabled'];
    if( $enabled && ( empty($values['useraccesskey']) || empty($values['userid'])) ) {
      $this->addError('Please enter the correct API details before enabling this gateway.');
      return false;
    }
    return parent::isValid($values);
  }
}
