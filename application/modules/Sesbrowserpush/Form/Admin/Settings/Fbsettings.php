<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Fbsettings.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Form_Admin_Settings_Fbsettings extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $description = vsprintf('This page contains Firebase API key settings. Below, enter the required key and code to get started with this plugin. To generate the keys, <a href="%1$s" target="_blank">click here</a>.<br />To read the tutorial on how to get API Key, read the <a href="%1$s" target="_blank">KB Article</a>.', array('https://www.help.socialenginesolutions.com/faq/238/how-can-i-configure-firebase-api-key-for-web-mobile-push-notific', 'https://www.help.socialenginesolutions.com/faq/238/how-can-i-configure-firebase-api-key-for-web-mobile-push-notific'));

    $this
      ->setTitle('Firebase API Key Settings')
      ->setDescription($description);
    // Decorators
    $this->loadDefaultDecorators();
	  $this->getDecorator('Description')->setOption('escape', false);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

		$this->addElement('Textarea', "sesbrowserpush_serverkey", array(
		'label' => 'Server Key',
		'description' => 'Enter the Firebase project server key.',
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('sesbrowserpush.serverkey'),
		));
		$this->getElement('sesbrowserpush_serverkey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Textarea', "sesbrowserpush_snippet", array(
		'label' => 'Code Snippet',
		'description' => 'Enter the Firebase project server key.',
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('sesbrowserpush.snippet'),
		));
		$this->getElement('sesbrowserpush_snippet')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}
