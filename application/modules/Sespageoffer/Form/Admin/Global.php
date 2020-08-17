<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageoffer_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sespageoffer_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.licensekey'),
    ));
    $this->getElement('sespageoffer_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.pluginactivated')) {

        $this->addElement('Text', 'sespageoffer_offers_manifest', array(
            'label' => 'Plural "pageoffers" Text in URL',
            'description' => 'Enter the text which you want to show in place of "pageoffers" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.offers.manifest', 'pageoffers'),
        ));
        $this->addElement('Text', 'sespageoffer_offer_manifest', array(
            'label' => 'Singular "pageoffer" Text in URL',
            'description' => 'Enter the text which you want to show in place of "pageoffer" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.offer.manifest', 'pageoffer'),
        ));

        $this->addElement('Select', 'sespageoffer_allow_follow', array(
            'label' => 'Allow Follow for Offers',
            'description' => 'Do you want to allow users to follow offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.allow.follow', '1'),
        ));

        $this->addElement('Select', 'sespageoffer_enable_favourite', array(
            'label' => 'Allow Favourite for Offers',
            'description' => 'Do you want to allow users to favourite offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.enable.favourite', '1'),
        ));

        $this->addElement('Select', 'sespageoffer_enable_like', array(
            'label' => 'Allow Like for Offers',
            'description' => 'Do you want to allow users to like offers on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.enable.like', '1'),
        ));

        $this->addElement('Radio', "sespageoffer_allow_share", array(
            'label' => 'Allow to Share Offers',
            'description' => "Do you want to allow users to share Offers of your website inside on your website and outside on other social networking sites?",
            'multiOptions' => array(
                '2' => 'Yes, allow sharing on this site and on social networking sites both.',
                '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
                '0' => 'No, do not allow sharing of Offers.',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.allow.share', '1'),
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
