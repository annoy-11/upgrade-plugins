<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Variation.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Dashboard_Variation extends Engine_Form
{
  public function init()
  {
    $this->setMethod('POST')
      ->setAttrib('class', 'global_form')
     ->setTitle('Create Variation')
    ->setDescription('Create a new product variation based on your product\'s select-box type attributes.');


    $this->addElement('Radio','status',array(
       'label'=>'Status',
       'order'=>999,
       'multiOptions' => array('1'=>'Enabled','0'=>'Disabled'),
        'value'=>1
    ));
      $this->addElement('Text', "quatity", array(
          'label' => "Quantity",
          'value' => '1',
          'allowEmpty'=>false,
          'required'=>true,
          'order'=>1000,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
    // Add submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Variation',
      'type' => 'submit',
        'order'=>1001,
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    // Add cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
       'order'=>1002,
      'onclick' => 'parent.Smoothbox.close();',
      'prependText' => ' or ',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons',array('order'=>1003));
  }
}