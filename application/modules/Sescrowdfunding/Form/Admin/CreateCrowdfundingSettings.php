<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateCrowdfundingsetting.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Admin_CreateCrowdfundingSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Crowdfunding Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Crowdfunding on your website. The settings enabled or disabled will effect Crowdfunding Directory creation crowdfunding, popup and Edit crowdfundings.');


    $this->addElement('Select', 'sescrowdfunding_redirect', array(
        'label' => 'Redirection After Crowdfunding Creation',
        'description' => 'Choose from below where you want to redirect users after a Crowdfunding is successfully created.',
        'multiOptions' => array(
            '0' => 'On Crowdfunding Dashboard',
            '1' => 'On Crowdfunding Profile (view crowdfunding)',
        ),
        'value' => $settings->getSetting('sescrowdfunding.redirect', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Crowdfunding is created? [Note: This setting will only work if you have placed Advanced Share widget on Crowdfunding View or Crowdfunding Dashboard, wherever user is redirected just after Crowdfunding creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sescrowdfunding.autoopenpopup', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_category_enable', array(
        'label' => 'Make Crowdfunding Categories Mandatory',
        'description' => 'Do you want to make category field mandatory when users create or edit their crowdfundings?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sescrowdfunding.category.enable', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_description_mandatory', array(
        'label' => 'Make Crowdfunding Description Mandatory',
        'description' => 'Do you want to make description field mandatory when users create or edit their crowdfundings?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sescrowdfunding.description.mandatory', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_photo_mandatory', array(
        'label' => 'Make Crowdfunding Main Photo Mandatory',
        'description' => 'Do you want to make main photo field mandatory when users create or edit their crowdfundings?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sescrowdfunding.photo.mandatory', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_crowdfundingtags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Crowdfunding on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sescrowdfunding.crowdfundingtags', 1),
    ));

    $this->addElement('Select', 'sescrowdfunding_global_search', array(
        'label' => 'Enable “People can search for this Crowdfunding” Field',
        'description' => 'Do you want to enable “People can search for this Crowdfunding” field while creating and editing Crowdfunding on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sescrowdfunding.global.search', 1),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
