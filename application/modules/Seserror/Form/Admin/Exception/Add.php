<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Form_Admin_Exception_Add extends Engine_Form {

  public function init() {

    $this->addElement('Radio', 'seserror_exceptionenable', array(
      'label' => 'Enable Design Template',
      'description' => "Do you want to enable the design template for the Exception Mode page on your website? If you choose 'Yes', then the design of Exception Mode page will come from this plugin, otherwise default SocialEngine design will come.",
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionenable', 0),
    ));

    $this->addElement('Text', 'seserror_exceptiontext1', array(
        'label' => 'Template Heading',
        'description' => 'Enter the heading for the design template. This will come in the H1 tag on Exception Mode page on your website.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptiontext1', "We\'re sorry!"),
    ));

    $this->addElement('Text', 'seserror_exceptiontext2', array(
        'label' => 'Template Text 1',
        'description' => 'Enter the text 1 for the design template. This text will be smaller to the Heading.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptiontext2', "We\'re sorry!"),
    ));

    $this->addElement('Text', 'seserror_exceptiontext3', array(
        'label' => 'Template Text 2',
        'description' => 'Enter the text 2 for the design template. This text will be smaller to the Text 1.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptiontext3', "We are currently experiencing some technical issues. Please try again later."),
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
  }

}
