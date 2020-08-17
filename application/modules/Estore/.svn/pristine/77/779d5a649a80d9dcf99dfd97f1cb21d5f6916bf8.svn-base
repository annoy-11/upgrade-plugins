<?php
class Estore_Form_Admin_Taxes_Search extends Engine_Form {

  public function init()
  {

      $this->setTitle('Add Tax')
          ->setMethod('get')
          ->setAttrib('class', 'global_form_box global_form');
      $this
          ->clearDecorators()
          ->addDecorator('FormElements')
          ->addDecorator('Form')
          ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
          ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
      $this->addElement('Text', 'title', array(
          'label' => 'Tax Title',
      ));
      if (Zend_Controller_Front::getInstance()->getRequest()->getParam('type')){
          $this->addElement('Text', 'store', array(
              'label' => 'Store Name',
          ));
      }
      $this->addElement('Select', 'type', array(
        'label' => 'Applicable Location',
        'multiOptions' => array(''=>'','0'=>'Shipping Address','1'=>'Billing Address'),
    ));
      $this->addElement('Select', 'status', array(
          'label' => 'Status',
          'multiOptions' => array(''=>'','1'=>'Yes','0'=>'No'),
      ));
   

     $submit = new Zend_Form_Element_Button('submit', array('type' => 'submit'));
    $submit
      ->setLabel('Search')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
      ->addDecorator('HtmlTag2', array('tag' => 'div'));
      $this->addElement($submit);
  }


}