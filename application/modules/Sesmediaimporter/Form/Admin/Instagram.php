<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Instagram.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_Form_Admin_Instagram extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Instagram Integration')
            ->setDescription("SESMEDIAIMPORTER_ADMIN_SETTINGS_INSTAGRAM_DESCRIPTION");
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$description = $this->getTranslator()->translate('SESMEDIAIMPORTER_ADMIN_SETTINGS_INSTAGRAM_DESCRIPTION');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if( $settings->getSetting('user.support.links', 0) == 1 ) {
    $moreinfo = $this->getTranslator()->translate(
          '<br>More Info: <a href="https://www.socialenginesolutions.com/guidelines-social-photo-media-importer-instagram-api-key/
" target="_blank"> KB Article</a>');
    } else {
    $moreinfo = $this->getTranslator()->translate(
          '');
    }
    $description = vsprintf($description.$moreinfo, array(
        'https://www.instagram.com/developer/',
    ));
    $this->setDescription($description);


    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $this->addElement('Text', "sesmediaimporter_instagram_clientid", array(
        'label' => 'Instagram Client ID',
        'value' => $settings->getSetting('sesmediaimporter_instagram_clientid',''),
        'required'=>true,
        'allowEmpty'=>false,
    ));
    $this->addElement('Text', "sesmediaimporter_instagram_clientsecret", array(
        'label' => 'Instagram Client Secret',
        'value' => $settings->getSetting('sesmediaimporter_instagram_clientsecret',''),
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
