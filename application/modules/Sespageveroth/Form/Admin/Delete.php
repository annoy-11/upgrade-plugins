<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Delete.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageveroth_Form_Admin_Delete extends Engine_Form
{
  public function init()
  {
    $this->setAttrib('class', 'global_form_popup')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('POST');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
