<?php

class Sesgroupalbum_Form_Photo_Delete extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Delete Photo')
            ->setDescription('Are you sure you want to delete this photo?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI'])
            ->setAttrib('class', 'global_form_popup')
    ;

    $this->addElement('Button', 'execute', array(
        'label' => 'Delete Photo',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));

    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        ),
    ));

    $this->addDisplayGroup(array(
        'execute',
        'cancel'
            ), 'buttons');
  }

}
