<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Form_Admin_Edit extends Engine_Form
{
  public function init()
  {
    
    $this
      ->setTitle('Edit Module')
      ->setDescription('')
      ->setAttribs(array(
        'id' => '',
        'class' => '',
      ))
      ->setMethod('POST');

   

    $this->addElement('Text','title',array(
      'label'=>'Title',
      'allowEmpty'=>false,
      'required'=>true,
    ));

      $this->addElement('File', 'photo', array(
          'label' => 'Upload Icon',
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');


    $this->addElement('Button', 'submit', array(
        'label' => 'Send Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    
    
    
    
    
  }
}