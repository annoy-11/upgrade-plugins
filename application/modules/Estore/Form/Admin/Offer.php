<?php

class Estore_Form_Admin_Offer extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Custom Offer');
    $this->setMethod('post');

    $this->addElement('Text', 'offer_name', array(
        'label' => 'Enter the name of the Custom Offer. You will have to choose this offer in the widget to display it to your users.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $param = Zend_Controller_Front::getInstance()->getRequest()->getParam('param');
    $this->setMethod('post')->setAttrib('class', 'global_form_box');

    $start = new Engine_Form_Element_CalendarDateTime('offer_startdate');
    $start->setLabel("Offer Start Date");
    $start->setAllowEmpty(false);
    $start->setRequired(true);
    $this->addElement($start);

    $end = new Engine_Form_Element_CalendarDateTime('offer_enddate');
    $end->setLabel("Offer End Date");
    $end->setRequired(true);
    $end->setAllowEmpty(false);
    $this->addElement($end);

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
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
