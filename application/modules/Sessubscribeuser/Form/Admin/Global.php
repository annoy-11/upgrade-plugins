<?php

class Sessubscribeuser_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');


    $this->addElement('Text', 'sessubscribeuser_commison', array(
      'label' => 'Enter Commison in Percentage',
      'description' => 'Enter Commison in Percentage',
      'required' => true,
      'allowEmpty' => false,
      'validators' => array(
        array('int', true),
        new Engine_Validate_AtLeast(0),
      ),
      'value' => '5',
    )); 
            
            
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
