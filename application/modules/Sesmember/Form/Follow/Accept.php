<?php

class Sesmember_Form_Follow_Accept extends User_Form_Friends
{
  public function init()
  {
    $this->setTitle('Accept Follow Request')
      ->setDescription('Would you like to confirm this member follow request?')
      ->setAttrib('class', 'global_form_popup')
      ->setAction($_SERVER['REQUEST_URI'])
      ;

    parent::init();

    $this->addElement('Button', 'submit', array(
      'label' => 'Accept Follow Request',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
