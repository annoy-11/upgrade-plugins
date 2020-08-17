<?php

class Snsdemo_Form_Admin_Theme extends Engine_Form
{
  protected $_field;

  public function init() {

    $this
      ->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $this->addElement('Text', 'theme_name', array(
      'label' => 'Theme Name',
    ));
    $this->addElement('Text', 'demolink', array(
      'label' => 'Theme Demo Link',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Theme',
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
