<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessoffer_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesbusinessoffer_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.licensekey'),
    ));
    $this->getElement('sesbusinessoffer_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.pluginactivated')) {

        $this->addElement('Text', 'sesbusinessoffer_offers_manifest', array(
            'label' => 'Plural "businessoffers" Text in URL',
            'description' => 'Enter the text which you want to show in place of "businessoffers" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.offers.manifest', 'businessoffers'),
        ));
        $this->addElement('Text', 'sesbusinessoffer_offer_manifest', array(
            'label' => 'Singular "businessoffer" Text in URL',
            'description' => 'Enter the text which you want to show in place of "businessoffer" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.offer.manifest', 'businessoffer'),
        ));

        $this->addElement('Select', 'sesbusinessoffer_allow_follow', array(
            'label' => 'Allow Follow for Offers',
            'description' => 'Do you want to allow users to follow offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.allow.follow', '1'),
        ));

        $this->addElement('Select', 'sesbusinessoffer_enable_favourite', array(
            'label' => 'Allow Favourite for Offers',
            'description' => 'Do you want to allow users to favourite offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.enable.favourite', '1'),
        ));

        $this->addElement('Select', 'sesbusinessoffer_enable_like', array(
            'label' => 'Allow Like for Offers',
            'description' => 'Do you want to allow users to like offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.enable.like', '1'),
        ));

        $this->addElement('Radio', "sesbusinessoffer_allow_share", array(
            'label' => 'Allow to Share Offers',
            'description' => "Do you want to allow users to share Offers of your website inside on your website and outside on other social networking sites?",
            'multiOptions' => array(
                '2' => 'Yes, allow sharing on this site and on social networking sites both.',
                '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
                '0' => 'No, do not allow sharing of Offers.',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.allow.share', '1'),
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
