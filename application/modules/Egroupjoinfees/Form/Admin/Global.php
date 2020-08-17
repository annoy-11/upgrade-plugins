<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Form_Admin_Global extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Contests Joining Fees & Payments System Global Settings')
            ->setDescription("Here, you can enable / disable fees on joining contests on your website. Another settings will affect the joining of contests for fees globally.");
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "egroupjoinfees_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('egroupjoinfees.licensekey'),
    ));
    $this->getElement('egroupjoinfees_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('egroupjoinfees.pluginactivated')) {

      $this->addElement('Select', 'egroupjoinfees_allow_entryfees', array(
	        'label' => 'Enable Contest Joining Fees',
          'description'=>'Do you want to allow contest owners to take payment from the members who Join their contests?',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value'=>$settings->getSetting('egroupjoinfees.allow.entryfees',1),
	    ));

      $commission = '<a href="admin/egroupjoinfees/settings/level">Click here</a> to set commission which you will receive when users pay fees for the joining paid contests on your website.';
      $this->addElement('Text', 'commision', array(
	        'label' => 'Admin Commission',
          'description' => sprintf('%s',$commission),
	    ));
      $this->getElement('commision')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


      //entry payment page title and description
       $this->addElement('Text', 'commision', array(
	        'label' => 'Commission',
          'description' => sprintf('%s',$commission),
	    ));
      $this->getElement('commision')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

       $this->addElement('Text', 'egroupjoinfees_entry_popupTitle', array(
	        'label' => 'Contest Joining Payment Popup - Title',
          'description' => 'Enter the title of the contest joining payment popup.',
          'value'=>$settings->getSetting('egroupjoinfees.entry.popupTitle','Join Contest'),
	    ));
      $this->getElement('egroupjoinfees_entry_popupTitle')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

       $this->addElement('Textarea', 'egroupjoinfees_entry_popupdescription', array(
	        'label' => 'Contest Joining Payment Popup - Description',
          'description' => 'Enter the description of the contest joining payment popup.',
          'value'=>$settings->getSetting('egroupjoinfees.entry.popupdescription','This is a Paid contest, so you will have to make the payment as mentioned by the contest owner. Click on "Make Payment" button below to proceed with the submission of your entry to this contest.'),
	    ));
      $this->getElement('egroupjoinfees_entry_popupdescription')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
	    //Add submit button
	    $this->addElement('Button', 'submit', array(
	        'label' => 'Save Changes',
	        'type' => 'submit',
	        'ignore' => true
	    ));
	  } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
