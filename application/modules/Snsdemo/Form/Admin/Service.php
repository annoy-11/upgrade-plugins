<?php

class Snsdemo_Form_Admin_Service extends Engine_Form
{
  protected $_field;

  public function init() {

    $this
      ->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $this->addElement('Text', 'service_name', array(
      'label' => 'Service Name',
    ));
    $this->addElement('Text', 'servicelink', array(
      'label' => 'Service Link',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Service',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');


  }
}
