<?php

class Sesmembersubscription_Form_Admin_Add extends Engine_Form
{
  protected $_field;

  public function init()
  {
  
    $this
      ->setTitle('Add New Commission Value')
      ->setDescription('Below add a new commission value which will be charged from the members who enable subscription on their profiles.')
      ->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $this->addElement('Text', 'from', array(
      'label' => 'Enter the starting amount (From Amount) of the subscription price.',
      'validators' => array(
        array('Int', true),
        new Engine_Validate_AtLeast(0),
      ),
    ));

    $this->addElement('Text', 'to', array(
      'label' => 'Enter the end amount (To Amount) of the subscription price.',
      'validators' => array(
        array('Int', true),
        new Engine_Validate_AtLeast(0),
      ),
    ));
    
    $this->addElement('Radio', 'commission_type', array(
      'label' => "Choose Commission Type",
      'multiOptions' => array(
        1 => 'Percentage (%)',
        2 => 'Fixed amount.'
      ),
      'value' => 1,
    ));
    
    
    $this->addElement('Text', 'commission_value', array(
      'label' => 'Enter Commission Value.',
      'validators' => array(
        array('Int', true),
        new Engine_Validate_AtLeast(0),
      ),
    ));
    
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add',
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

  public function setField($commisson)
  {
    $this->_field = $commisson;

    $this->from->setValue($commisson->from);
    $this->to->setValue($commisson->to);
    $this->commission_type->setValue($commisson->commission_type);
    $this->commission_value->setValue($commisson->commission_value);
    $this->submit->setLabel('Edit Commission');

    // @todo add the rest of the parameters
  }
}