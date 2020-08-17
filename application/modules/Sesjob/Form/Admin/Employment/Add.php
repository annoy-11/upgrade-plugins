<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Admin_Employment_Add extends Engine_Form
{
  protected $_field;

  public function init()
  {
    $this
      ->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $label = new Zend_Form_Element_Text('label');
    $label->setLabel('Employment Name')
      ->addValidator('NotEmpty')
      ->setRequired(true)
      ->setAttrib('class', 'text');

    $id = new Zend_Form_Element_Hidden('id');
    $this->addElements(array($label, $id));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Employment',
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

  public function setField($employment)
  {
    $this->_field = $employment;

    // Set up elements
    //$this->removeElement('type');
    $this->label->setValue($employment->employment_name);
    $this->id->setValue($employment->employment_id);
    $this->submit->setLabel('Edit Employment');

    // @todo add the rest of the parameters
  }
}
