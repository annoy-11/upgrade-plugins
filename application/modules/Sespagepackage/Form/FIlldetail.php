<?php

class Sespagepackage_Form_Filldetail extends Engine_Form {

  public function init() {
    $this
            ->setTitle('')
            ->setDescription('');
    $this->addElement('Textarea', 'message', array(
        'label' => 'Message',
        'description' => '',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('File', 'payment_file', array(
        'label' => 'Attach File',
        'placeholder' => "",
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Send Message',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        )
    ));
		
  }

}
