<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesvideoimporter_Form_Admin_Global extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "sesvideoimporter_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('sesvideoimporter.licensekey'),
		));
		$this->getElement('sesvideoimporter_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
		if ($settings->getSetting('sesvideoimporter.pluginactivated')) {
		
		$this->addElement('Text', "sesvideoimporter_sleeptime", array(
			'label' => 'Importing Sleep Time',
			'description' => 'Enter "Sleep Time" when you start import videos.',
			'allowEmpty' => false,
			'required' => true,
			'value' => $settings->getSetting('sesvideoimporter.sleeptime',2),
			'validators' => array(
					array('Int', true),
					array('GreaterThan', true, array(1)),
			)
		));
		
		$this->addElement('Select', "videoimporter_youtube_safe_search", array(
			'label' => 'Youtube Search Criterias',
			'description' => 'The safeSearch parameter indicates whether the search results should include restricted content as well as standard content.',
			'multiOptions'=>array('moderate'=>'YouTube will filter content that is restricted in your locale.',
			'none'=>'YouTube will not filter the search result set.',
			'strict'=>'YouTube will try to exclude all restricted content from the search result set.'),
			'value' => $settings->getSetting('videoimporter.youtube.safe.search','none'),
		));
		
		$this->addElement('Text', "videoimporter_youtube_defaultsearchtext", array(
			'label' => 'Default Search Text',
			'description' => 'Enter default text for search box.',
			'allowEmpty' => false,
			'required' => true,
			'value' => $settings->getSetting('videoimporter.youtube.defaultsearchtext','pop music'),
		));
		
		$this->addElement('Text', "videoimporter_default_recordCount", array(
			'label' => 'Count for Search',
			'description' => 'Enter number of count that you want to on YouTube Search Page.',
			'allowEmpty' => false,
			'required' => true,
			'value' => $settings->getSetting('videoimporter.default.recordCount',50),
			'validators' => array(
					array('Int', true),
					array('GreaterThan', true, array(0)),
			)
		));
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
	  } else {
			if (APPLICATION_ENV == 'production') {
				$this->addElement('Checkbox', 'system_mode', array(
					'label' => 'Please make sure that you change the mode of your website from "Production Mode" to "Development Mode" before activating the plugin and again to "Production Mode" after successfully activating the plugin to reflect CSS changes from this plugin on user side.',
					'description' => 'System Mode',
					'value' => 0,
				));
			}
			
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
