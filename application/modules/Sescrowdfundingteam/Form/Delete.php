<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Delete.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingteam_Form_Delete extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Delete This Entry')
      ->setDescription('Are you sure you want to delete this this entry?')
      ->setAttrib('name', 'sescrowdfundingteam_delete');
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
