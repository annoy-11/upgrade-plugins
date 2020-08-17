<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: 500px.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Form_Admin_500px extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('500px App Settings')
            ->setDescription('SESMEDIAIMPORTER_ADMIN_SETTINGS_500PX_DESCRIPTION');
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
    $description = $this->getTranslator()->translate('SESMEDIAIMPORTER_ADMIN_SETTINGS_500PX_DESCRIPTION');
    $settings = Engine_Api::_()->getApi('settings', 'core');
	if( $settings->getSetting('user.support.links', 0) == 1 ) {
	$moreinfo = $this->getTranslator()->translate( 
        '<br>More Info: <a href="https://www.socialenginesolutions.com/guidelines-social-photo-media-importer-500px-api-key/" target="_blank"> KB Article</a>');
	} else {
	$moreinfo = $this->getTranslator()->translate( 
        '');
	}
	$description = vsprintf($description.$moreinfo, array(
      'https://500px.com/settings/applications',
    ));
    $this->setDescription($description);


    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    
    $this->addElement('Text', "sesmediaimporter_500px_consumerkey", array(
        'label' => '500px Consumer Key',
        'value' => $settings->getSetting('sesmediaimporter_500px_consumerkey',''),
        'required'=>true,
        'allowEmpty'=>false,
    ));
    $this->addElement('Text', "sesmediaimporter_500px_consumersecret", array(
        'label' => '500px Consumer Secret',
        'value' => $settings->getSetting('sesmediaimporter_500px_consumersecret',''),
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