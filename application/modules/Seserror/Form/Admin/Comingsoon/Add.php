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

class Seserror_Form_Admin_Comingsoon_Add extends Engine_Form {

  public function init() {
  
    
    $this->addElement('Radio', 'seserror_comingsoonenable', array(
      'label' => 'Enable Coming Soon',
      'description' => 'Do you want to enable the Coming Soon functionality on your website? If you choose Yes, then you will see Coming Soon page whenever you try to open your website.',
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoonenable', 0),
    ));
    
   
    $seserror_comingsoondate = new Engine_Form_Element_CalendarDateTime('seserror_comingsoondate');
    $seserror_comingsoondate->setLabel("End Date for Coming Soon Page");
    $seserror_comingsoondate->setDescription("Choose an end date on which the coming soon page will automatically end. After the selected date, your website will be visible to all.");
    //$seserror_comingsoondate->setAllowEmpty(false);
    //$seserror_comingsoondate->setRequired(true);
    $this->addElement($seserror_comingsoondate);
    
    
    $this->addElement('Radio', 'seserror_comingsooncontactenable', array(
      'label' => 'Enable Contact Us',
      'description' => 'Do you want to enable users to contact you via the Contact Us option on the coming soon page?',
      'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
      ),
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsooncontactenable', 1),
    ));

    $this->addElement('Text', 'seserror_comingsoontext1', array(
      'label' => 'Template Heading',
      'description' => 'Enter the heading for the design template. This will come in the H1 tag on Coming Soon page on your website.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoontext1', "Coming Soon !"),
    ));
    
    $this->addElement('Text', 'seserror_comingsoontext2', array(
      'label' => 'Template Text 1',
      'description' => 'Enter the text 1 for the design template. This text will be smaller to the Heading.',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoontext2', "This Page Going Overthrow Your Mind"),
    ));
    
    $this->addElement('Text', 'seserror_comingsoontext3', array(
      'label' => 'Template Text 2',
      'description' => 'Enter the text 2 for the design template. This text will be smaller to the Text 1.',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoontext3', "We Have Been Spending Long Hours In Order To Launch Our New Website. We Will Offer Freebies, A Brand New Blog And Featured Content Of Our Latest Work. Join Our Mailing List Or Follow Us On Facebook Or Twitter To Stay Up To Date."),
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