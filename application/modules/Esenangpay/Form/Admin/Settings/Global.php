<?php

class Esenangpay_Form_Admin_Settings_Global extends Engine_Form
{

  public function init()
  {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');

    $this->addElement('Select', 'esenangpay_request_method', array(
      'label' => 'Default Method Type',
      'description' => 'Choose default method type during payment transaction.',
      'multiOptions' =>  array('POST' => 'Post', 'GET' => 'Get'),
      'value' => $settings->getSetting('esenangpay.request.method', 'POST'),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}
