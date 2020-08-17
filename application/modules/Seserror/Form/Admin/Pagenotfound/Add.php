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

class Seserror_Form_Admin_Pagenotfound_Add extends Engine_Form {

  public function init() {

  
    $this->addElement('Radio', 'seserror_pagenotfound301redirect', array(
      'label' => 'Enable 404 Redirect to Homepage',
      'description' => "Do you want to enable the redirection of Page Not Found (404 Error) pages to homepage of your website using 301 redirect? (We recommend you to choose “Yes” because when Google see the page not found or 404 error it counts them and hurts the rank of your site. Note: This setting will only work for the links which are opened directly. When a user will click on the link of a Page Not Found page, then he will not be redirected to home page, instead see the Page Not Found message on the page.)",
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfound301redirect', 0),
    ));
    
    
    $this->addElement('Radio', 'seserror_pagenotfoundenable', array(
      'label' => 'Enable Design Template',
      'description' => "Do you want to enable the design template for the Page Not Found page on your website? If you choose 'Yes', then the design of Page Not Found page will come from this plugin, otherwise default SocialEngine design will come.",
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'onclick' => "hideoption(this.value)",
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundenable', 1),
    ));
    
    $this->addElement('Text', 'seserror_pagenotfoundenabletext1', array(
        'label' => 'Template Heading',
        'description' => 'Enter the heading for the design template. This will come in the H1 tag on Page Not Found pages on your website.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundenabletext1', "OOPS!"),
    ));
    
    $this->addElement('Text', 'seserror_pagenotfoundenabletext2', array(
        'label' => 'Template Text 1',
        'description' => 'Enter the text 1 for the design template. This text will be smaller to the Heading.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundenabletext2', 'Error 404 :Page Not Found'),
    ));
    
    $this->addElement('Text', 'seserror_pagenotfoundenabletext3', array(
        'label' => 'Template Text 2',
        'description' => 'Enter the text 2 for the design template. This text will be smaller to the Text 1.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundenabletext3', 'Rather search for something else?'),
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