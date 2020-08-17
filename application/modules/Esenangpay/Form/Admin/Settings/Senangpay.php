<?php
class Esenangpay_Form_Admin_Settings_Senangpay extends Engine_Form
{

  public function init()
  {
    $this->setTitle('Payment Gateway: SenangPay');

    $description = $this->getTranslator()->translate('ESENANG_FORM_ADMIN_GATEWAY_SENANG_DESCRIPTION');
    $description = vsprintf($description, array(
      'https://senangpay.my/register/',
      'http://guide.senangpay.my/callback-url ',
      'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
        'module' => 'sesadvpmnt',
        'controller' => 'ipn',
        'action' => 'stripe'
      ), 'default', true),
    ));
    $this->setDescription($description);

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $this->setTitle('Manage Your SenangPay Account');

    $this->addElement('Text', "esenangpay_merchant_id", array(
      'label' => 'Merchant ID',
      'required' => true,
      'allowEmpty' => false,
      'description' => 'Merchant ID as displayed in senangPay Dashboard.',
    ));

    $this->addElement('Text', "esenangpay_secret_key", array(
      'label' => 'Secret Key',
      'required' => true,
      'allowEmpty' => false,
      'description' => 'Secret key as displayed in senangPay Dashboard..',
    ));

    $this->addElement('Select', 'esenangpay_order_status_id', array(
      'label' => 'Order Status',
      'multiOptions' => array(
        7 => "Canceled",
        9 => "Canceled Reversal",
        13 => "Chargeback",
        5 => "Complete",
        8 => "Denied",
        14 => "Expired",
        10 => "Failed",
        1 => "Pending",
        15 => "Processed",
        2 => "Processing",
        11 => "Refunded",
        12 => "Reversed",
        3 => "Shipped",
        16 => "Voided",
      ),
      'description' => 'Order Status to be set after the payment was done.',
    ));

    $this->addElement('Radio', "enabled", array(
      'label' => 'Enable?',
      'multiOptions' => array('1' => 'Yes', '0' => 'No'),
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}
