<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Verification.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Form_Verification extends Engine_Form {

  public function init() {

    $this->setTitle('Verify This Member')
      ->setDescription('Are you sure you want to verify this member?')
      ->setAttrib('class', 'global_form_popup')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('POST');

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.enablecomment', 1)) {

      $this->addElement('Textarea', 'description', array(
        'label' => 'Comment',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
          new Engine_Filter_Censor(),
          'StripTags',
          new Engine_Filter_StringLength(array('max' => '5000'))
        ),
      ));
    }

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Verify',
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
