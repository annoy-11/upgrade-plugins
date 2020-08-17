<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: General.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Form_Admin_General extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmediaimporter_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmediaimporter.licensekey'),
    ));
    $this->getElement('sesmediaimporter_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

	if ($settings->getSetting('sesmediaimporter.pluginactivated')) {

      $this->addElement('Text', "sesmediaimporter_albumshowcount", array(
        'label' => 'Album Count',
        'description' => 'Enter the number of albums to be shown when a user is connected to a service. More albums can be viewed by clicking on “View More” button.',
        'value' => $settings->getSetting('sesmediaimporter_albumshowcount',8),
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
      ));

      $this->addElement('Text', "sesmediaimporter_photoshowcount", array(
        'label' => 'Photo Count',
        'description' => 'Enter the number of photos to be shown when a user is connected to a service or clicks on any album. More photos can be viewed by clicking on "View More" button.',
        'value' => $settings->getSetting('sesmediaimporter_photoshowcount',8),
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
      ));

      $this->addElement('Radio', "sesmediaimporter_facebook_enable", array(
        'label' => 'Enable Facebook',
        'description' => 'Do you want to enable importing of photos from Facebook?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.facebook.enable',0),
      ));

      $this->addElement('Radio', "sesmediaimporter_instagram_enable", array(
        'label' => 'Enable Instagram',
        'description' => 'Do you want to enable importing of photos from Instagram?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.instagram.enable',0),
      ));

      $this->addElement('Radio', "sesmediaimporter_flickr_enable", array(
        'label' => 'Enable Flickr',
        'description' => 'Do you want to enable importing of photos from Flickr?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.flickr.enable',0),
      ));

      $this->addElement('Radio', "sesmediaimporter_google_enable", array(
        'label' => 'Enable Google',
        'description' => 'Do you want to enable importing of photos from Google?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.google.enable',0),
      ));

      $this->addElement('Radio', "sesmediaimporter_500px_enable", array(
        'label' => 'Enable 500px',
        'description' => 'Do you want to enable importing of photos from 500px?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.500px.enable',0),
      ));

      $this->addElement('Radio', "sesmediaimporter_zip_enable", array(
        'label' => 'Enable Zip Upload',
        'description' => 'Do you want to enable uploading of photos from Zipped Folder?',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesmediaimporter.zip.enable',0),
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
