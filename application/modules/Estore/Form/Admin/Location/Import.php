<?php

class Estore_Form_Admin_Location_Import extends Engine_Form {

  public function init() {

    $this
            ->setTitle('Import Locations')
            ->setDescription("Add a CSV file to import locations corresponding to the entries in it, then click on ‘Submit’ button.")
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('File', 'filename', array(
        'label' => 'Import File',
        'required' => true,
    ));
    $this->filename->getDecorator('Description')->setOption('placement', 'append');

    $this->addElement('Radio', 'seprator', array(
            'label' => 'File Columns Separator',
            'description' => 'Select a separator from below which you are using for the columns of the CSV file.',
            'multiOptions' => array(
                    0 => "Comma (',')",
                    1 => "Pipe ('|')",
            ),
            'value' => 1,
    ));


    $this->addElement('Button', 'submit', array(
        'label' => 'Submit',
        'type' => 'submit',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    // Cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => "javascript:parent.Smoothbox.close()",
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    // DisplayGroup: buttons
    $this->addDisplayGroup(array(
        'submit',
        'cancel',
            ), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper'
        ),
    ));
  }

}
