<?php

class Sesshoutbox_Form_Edit extends Engine_Form {

  public function init() {

    $this->setTitle('Edit Message')
      ->setDescription('')
      ->setAttrib('name', 'sesshoutbox_editmessage')
      ->setAttrib('class', 'sesshoutbox_formcheck global_form');

    $this->addElement('Text', 'body', array(
        'description' => "Edit Your Message",
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
  }
}
