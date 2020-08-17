<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DeleteEducation.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class SesprofileField_Form_Profile_DeleteEducation extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Delete This Entry')
      ->setDescription('Are you sure you want to delete this this entry?')
      ->setAttrib('name', 'sesprofilefield_profile_delete');
      //->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      //->setMethod('POST');
    
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Delete',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'javascript:sessmoothboxclose();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}