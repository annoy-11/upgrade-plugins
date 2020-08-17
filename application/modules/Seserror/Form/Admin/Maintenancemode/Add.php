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

class Seserror_Form_Admin_Maintenancemode_Add extends Engine_Form {

  public function init() {
  
    $this->addElement('Radio', 'seserror_maintenanceenable', array(
      'label' => 'Enable Design Template',
      'description' => "Do you want to enable the design template for the Maintenance Mode page on your website? If you choose 'Yes', then the design of Maintenance Mode page will come from this plugin, otherwise default SocialEngine design will come.",
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenanceenable', 0),
    ));
    
    $this->addElement('Text', 'seserror_maintenancetext1', array(
        'label' => 'Template Heading',
        'description' => 'Enter the heading for the design template. This will come in the H1 tag on Maintenance Mode page on your website.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancetext1', "Maintenance Mode"),
    ));
    
    $this->addElement('Text', 'seserror_maintenancetext2', array(
        'label' => 'Template Text 1',
        'description' => 'Enter the text 1 for the design template. This text will be smaller to the Heading.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancetext2', "This site is under construction, may be you see it soon"),
    ));
    
    $this->addElement('Text', 'seserror_maintenancetext3', array(
        'label' => 'Template Text 2',
        'description' => 'Enter the text 2 for the design template. This text will be smaller to the Text 1.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancetext3', "We apologize for the inconvenience, we''re doing our best to get things back to working order for you"),
    ));
    
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
  }

}