<?php

class Sesblogpackage_Form_Confirm extends Engine_Form {

  public function init() {
		$this
      ->setTitle('Confirm Package Change')
      ->setDescription('Are you sure to change your Blog package.Once you confirm it will not be changed.');
    $this->addElement('Button', 'submit', array(
		   'label' =>'Change Package',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
