<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Google.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Form_Admin_Google extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Google App Settings')
            ->setDescription('SESMEDIAIMPORTER_ADMIN_SETTINGS_GOOGLE_DESCRIPTION');
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
    $description = $this->getTranslator()->translate('SESMEDIAIMPORTER_ADMIN_SETTINGS_GOOGLE_DESCRIPTION');
    $settings = Engine_Api::_()->getApi('settings', 'core');
	if( $settings->getSetting('user.support.links', 0) == 1 ) {
	$moreinfo = $this->getTranslator()->translate( 
        '<br>More Info: <a href="https://www.socialenginesolutions.com/guidelines-social-photo-media-importer-google-api-key/
" target="_blank"> KB Article</a>');
	} else {
	$moreinfo = $this->getTranslator()->translate( 
        '');
	}
	$description = vsprintf($description.$moreinfo, array(
      'https://developers.google.com/places/web-service/get-api-key',
    ));
    $this->setDescription($description);


    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    $this->addElement('Text', "sesmediaimporter_google_clientid", array(
        'label' => 'Google Client ID',
        'value' => $settings->getSetting('sesmediaimporter_google_clientid',''),
        'required'=>true,
        'allowEmpty'=>false,
    ));
    $this->addElement('Text', "sesmediaimporter_google_clientsecret", array(
        'label' => 'Google Client Secret',
        'value' => $settings->getSetting('sesmediaimporter_google_clientsecret',''),
        'required'=>true,
        'allowEmpty'=>false,
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
  }
}