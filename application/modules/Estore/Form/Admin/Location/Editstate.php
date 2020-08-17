<?php

class Estore_Form_Admin_Location_Editstate extends Engine_Form {

  public function init() {

    $this->setTitle('Edit State');
    
    $this->addElement('Text', 'country', array(
        'label' => 'Country',
        'attribs' => array('disabled' => 'disabled'),
    ));

    $this->addElement('Text', 'name', array(
        'label' => 'State',
        'allowEmpty' => false,
        'required' => true,
        'validators' => array(
            array('NotEmpty', true),
            array('StringLength', true, array(1, 128)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }
}