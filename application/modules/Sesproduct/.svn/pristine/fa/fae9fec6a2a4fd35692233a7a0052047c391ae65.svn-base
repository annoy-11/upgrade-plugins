<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Option.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Dashboard_Option extends Engine_Form
{
  public function init()
  {
    $this->setMethod('POST')
      ->setAttrib('class', 'global_form')
     ->setTitle('Enter Price For Configurations');

    // Add label
    $this->addElement('Text', 'label', array(
      'label' => 'Choice Label',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Radio','type',array(
        'label' => 'Choose Increment / decrement price for this attribute',
        'multiOptions'=>array('0'=>'Decrement','1'=>'Increment')
    ));
    $translate = Zend_Registry::get('Zend_Translate');
      $locale = Zend_Registry::get('Locale');
      $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());
      $this->addElement('Text','price',array(
          'label' => $translate->translate('Price (In '.$currencyName.')'),
          'value'=>0,
      ));
    // Add submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Choice',
      'type' => 'submit',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    // Add cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'onclick' => 'parent.Smoothbox.close();',
      'prependText' => ' or ',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}