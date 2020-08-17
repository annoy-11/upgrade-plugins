<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesdemouser_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesdemouser.licensekey'),
    ));
    $this->getElement('sesdemouser_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesdemouser.pluginactivated')) {
	    $this->addElement('Text', "sesdemouser_headingText", array(
	        'label' => 'Heading Text of Test Users Box',
	        'description' => 'Enter the text for the heading of test user slider box.',
	        'allowEmpty' => false,
	        'required' => true,
	        'value' => $settings->getSetting('sesdemouser.headingText', "Site Tour with Test Users"),
	    ));

	    $this->addElement('Text', "sesdemouser_innerText", array(
	        'label' => 'Description Text of Test Users Box',
	        'description' => 'Enter the text for the description of test user slider box.',
	        'allowEmpty' => false,
	        'required' => true,
	        'value' => $settings->getSetting('sesdemouser.innerText', 'Choose a test user to login and take a site tour.'),
	    ));


	    $this->addElement('Radio', "sesdemouser_showside", array(
	        'label' => 'Test Users Box Placement',
	        'description' => 'Choose the placement of the test user slider box.',
	        'allowEmpty' => false,
	        'required' => true,
	        'multiOptions' => array(
	            'left' => 'In Left Side of Screen',
	            'right' => 'In Right Side of Screen',
	        ),
	        'value' => $settings->getSetting('sesdemouser.showside', 'left'),
	    ));

	    $this->addElement('Radio', "sesdemouser_designshow", array(
	        'label' => 'Choose View Type',
	        'description' => 'Choose the view type for displaying test users in the box.',
	        'allowEmpty' => false,
	        'required' => true,
	        'multiOptions' => array(
	            'listView' => 'List View',
	            'gridView' => 'Grid View',
	        ),
	        'value' => $settings->getSetting('sesdemouser.designshow', 'gridView'),
	    ));


		//New File System Code
		$banner_options = array('' => '');
		$files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
		foreach( $files as $file ) {
		  $banner_options[$file->storage_path] = $file->name;
		}

	    $this->addElement('Select', 'sesdemouser_defaultimage', array(
	        'label' => 'Upload Icon for Box',
	        'description' => 'Choose an icon to be uploaded for opening and closing the test user slider box. [Note: You can add a new icon from the "File & Media Manager" section from here: File & Media Manager. Leave the field blank if you do not want to change test user box icon.]',
	        'multiOptions' => $banner_options,
	        'escape' => false,
	        'value' => $settings->getSetting('sesdemouser.defaultimage', ''),
	    ));

	    $this->addElement('Text', "sesdemouser_limit", array(
	        'label' => 'Maximum test Users Shown',
	        'description' => 'Enter the maximum number of test users to be shown in the test user slider box.',
	        'allowEmpty' => false,
	        'required' => true,
	        'value' => $settings->getSetting('sesdemouser.limit',6),
	    ));

	    // Add submit button
	    $this->addElement('Button', 'submit', array(
	        'label' => 'Save Changes',
	        'type' => 'submit',
	        'ignore' => true
	    ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
