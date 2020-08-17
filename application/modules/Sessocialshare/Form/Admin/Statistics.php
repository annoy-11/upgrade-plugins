<?php

class Sessocialshare_Form_Admin_Statistics extends Engine_Form {

  public function init() {
  
    $this->addDecorator('FormElements')
        ->addDecorator('Form')
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
      
    $this->setAttribs(array('id' => 'sessocialshare_stats','class' => 'global_form_box'))->setMethod('GET');
    $this->addElement('Dummy', 'pageurlsearch', array(
      'content' => '<a id="pageurlsearcha" href="javascript:void(0);" onclick="showsearch()">Show Page URLs</a>',
    ));
    $this->addElement('Select', 'pageurl', array(
      
      'multiOptions' => array(
        '' => '',
      ),
      'value' => '',

    ));
    
    $this->addElement('Text', 'pageurl1', array(
//       'label' => 'Enter Page URL',
    ));		
    $this->addElement('Text', 'from_date', array(
        'placeholder' => 'yyyy-mm-dd',
				'label' => 'From Ex(yyyy-mm-dd)',
    ));
    
    $this->addElement('Text', 'to_date', array(
        'label' => 'To Date Ex(yyyy-mm-dd)',
				'placeholder' => 'yyyy-mm-dd',
    ));
   $this->addDisplayGroup(array('from_date', 'to_date'), 'date');

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Search',
      'type' => 'submit'
    ));

  }
}
