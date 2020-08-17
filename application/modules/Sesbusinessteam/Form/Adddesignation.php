<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Adddesignation.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessteam_Form_Adddesignation extends Engine_Form {

  public function init() {

    $this->setMethod('POST')
        ->setAttrib('name', 'sesbusinessteam_adddesignation')
        ->setAttrib('class', 'sesbusinessteam_formcheck global_form');

    $this->addElement('Text', "designation", array(
        'label' => 'Enter designation for business team members on your website.',
        'allowEmpty' => false,
        'placeholder' => 'Enter Designation',
        'required' => true,
    ));

    $this->addElement('Button', 'submit', array(
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'Cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'javascript:sessmoothboxclose();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
