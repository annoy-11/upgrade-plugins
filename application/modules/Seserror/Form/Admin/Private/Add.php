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

class Seserror_Form_Admin_Private_Add extends Engine_Form {

  public function init() {
  
    $this->addElement('Radio', 'seserror_privateenable', array(
      'label' => 'Enable Design Template',
      'description' => "Do you want to enable the design template for the Private Page on your website? If you choose 'Yes', then the design of Private Page will come from this plugin, otherwise default SocialEngine design will come.",
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'onclick' => "hideoption(this.value)",
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privateenable', 1),
    ));
    
    $this->addElement('Text', 'seserror_privatepagetext1', array(
        'label' => 'Template Heading',
        'allowEmpty' => false,
        'required' => true,
        'description' => 'Enter the heading for the design template. This will come in the H1 tag on Private pages on your website.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privatepagetext1', "Private Page"),
    ));
    
    $this->addElement('Text', 'seserror_privatepagetext2', array(
        'label' => 'Template Text 1',
        'description' => 'Enter the text 1 for the design template. This text will be smaller to the Heading.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privatepagetext2', "Don''t Try To Make Over Smart"),
    ));
    
    $this->addElement('Text', 'seserror_privatepagetext3', array(
        'label' => 'Template Text 2',
        'description' => 'Enter the text 2 for the design template. This text will be smaller to the Text 1.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privatepagetext3', "This Is A Private Page Go To Another Page And Search Other Thing"),
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
  }
}