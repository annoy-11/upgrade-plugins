<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Document.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Form_Admin_Document extends Engine_Form {

  protected $_field;

  public function init() {

    $this->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $label = new Zend_Form_Element_Text('label');
    $label->setLabel('Document Type')
      ->addValidator('NotEmpty')
      ->setRequired(true)
      ->setAttrib('class', 'text');


    $id = new Zend_Form_Element_Hidden('id');


    $this->addElements(array(
      //$type,
      $label,
      $id
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add This Type',
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

  public function setField($document)
  {
    $this->_field = $document;

    // Set up elements
    //$this->removeElement('type');
    $this->label->setValue($document->document_name);
    $this->id->setValue($document->documenttype_id);
    $this->submit->setLabel('Edit This Type');

    // @todo add the rest of the parameters
  }
}
