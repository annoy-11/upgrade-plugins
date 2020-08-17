<?php

class Edocument_Form_Email extends Engine_Form {

  public function init() {

    $this->setTitle('Email Document')->setDescription('Please fill the form given below.');

    $this->addElement('Text', 'to', array(
      'label' => 'To',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'allowEmpty' => false,
        'required' => true
    ));

    $this->addElement('Textarea', 'message', array(
        'label' => 'Message ',
        'required' => true,
        'allowEmpty' => false,
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Submit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
          'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'onClick' => 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper',
      ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'sitepage_buttons', array('decorators' => array('FormElements', 'DivDivDivWrapper')));
  }
}
