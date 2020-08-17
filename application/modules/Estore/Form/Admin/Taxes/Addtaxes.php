<?php
class Estore_Form_Admin_Taxes_Addtaxes extends Engine_Form {

  public function init() {

    $this->setTitle('Add Tax')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box global_form');

    $this->addElement('Text', 'title', array(
        'label' => 'Tax Title',
    ));

    $this->addElement('Select', 'type', array(
        'label' => 'Applicable Location',
        'multiOptions' => array('0'=>'Shipping Address','1'=>'Billing Address'),
    ));
      $this->addElement('Radio', 'status', array(
          'label' => 'Add Tax',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>1,
      ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Add Tax',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
