<?php

class Sesinviter_Form_Search extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('GET');

    $recipient_email = new Zend_Form_Element_Text('recipient_email');
    $recipient_email
      ->setLabel('Recipient Email')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'));


    $import_method = new Zend_Form_Element_Select('import_method');
    $import_method
      ->setLabel('Invitation Type')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
      ->addDecorator('HtmlTag', array('tag' => 'div'))
      ->setMultiOptions(array(
        '' =>'',
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'csv' => 'CSV',
        'referral' => 'Referral',
      ))
      ->setValue('');

    $date = new Zend_Form_Element_Text('creation_date');
    $date
    ->setLabel('Invitation Date: ex (2000-12-01)')
    ->clearDecorators()
    ->addDecorator('ViewHelper')
    ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
    ->addDecorator('HtmlTag', array('tag' => 'div'));


    $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
    $submit
      ->setLabel('Search')
      ->clearDecorators()
      ->addDecorator('ViewHelper')
      ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
      ->addDecorator('HtmlTag2', array('tag' => 'div'));

    $arrayItem = array();
    $arrayItem = !empty($recipient_email)?	array_merge($arrayItem,array($recipient_email)) : '';
    $arrayItem = !empty($import_method) ?	array_merge($arrayItem,array($import_method)) : $arrayItem;
    $arrayItem = !empty($date)?	array_merge($arrayItem,array($date)) : $arrayItem;
    $arrayItem = !empty($submit)?	array_merge($arrayItem,array($submit)) : '';
    $this->addElements($arrayItem);

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));
  }
}
