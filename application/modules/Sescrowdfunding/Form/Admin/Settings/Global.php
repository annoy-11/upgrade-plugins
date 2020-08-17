<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sescrowdfunding_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sescrowdfunding.licensekey'),
    ));
    $this->getElement('sescrowdfunding_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        if ($settings->getSetting('sescrowdfunding.pluginactivated')) {


            $this->addElement('Text', 'sescrowdfunding_crowdfundings_manifest', array(
                'label' => 'Plural Text for "crowdfundings" in URL',
                'description' => 'Enter the text which you want to show in place of "crowdfundings" in the URLs of this plugin.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sescrowdfunding.crowdfundings.manifest', 'crowdfundings'),
            ));
            $this->addElement('Text', 'sescrowdfunding_crowdfunding_manifest', array(
                'label' => 'Singular Text for "crowdfunding" in URL',
                'description' => 'Enter the text which you want to show in place of "crowdfunding" in the URLs of this plugin.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sescrowdfunding.crowdfunding.manifest', 'crowdfunding'),
            ));

            $this->addElement('Text', 'sescrowdfunding_text_singular', array(
                'label' => 'Singular Text for "Crowdfunding"',
                'description' => 'Enter the text which you want to show in place of "Crowdfunding" at various places in this plugin like activity feeds, etc.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sescrowdfunding.text.singular', 'crowdfunding'),
            ));
            $this->addElement('Text', 'sescrowdfunding_text_plural', array(
                'label' => 'Plural Text for "Crowdfunding"',
                'description' => 'Enter the text which you want to show in place of "Crowdfunding" at various places in this plugin like search form, navigation menu, etc.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sescrowdfunding.text.plural', 'crowdfundings'),
            ));
            

            $this->addElement('Radio', "sescrowdfunding_other_modulecrowdfundings", array(
                'label' => 'Crowdfundings Created in Content Visibility',
                'description' => "Choose the visibility of the crowdfundings created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create crowdfundings in a content or module, place the widget \"Content Profile Crowdfundings\" on the profile page of the desired content.)",
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => $settings->getSetting('sescrowdfunding.other.modulecrowdfundings', 1),
            ));

            $this->addElement('Radio', 'sescrowdfunding_start_date', array(
                'label' => 'Enable Custom Crowdfunding Publish Date',
                'description' => 'Do you want to allow users to choose a custom publish date for their crowdfundings. If you choose Yes, then crowdfundings on your website will display in activity feeds, various crowdfundings and widgets on their publish dates.',
                'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
                ),
                'value' => $settings->getSetting('sescrowdfunding.start.date', 1),
            ));

            $this->addElement('Radio', 'sescrowdfunding_enable_location', array(
                'label' => 'Enable Location',
                'description' => 'Do you want to enable location for crowdfundings on your website?',
                'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
                ),
                'onclick' => 'showLocation(this.value)',
                'value' => $settings->getSetting('sescrowdfunding.enable.location', 1),
            ));

            $this->addElement('Radio', 'sescrowdfunding_search_type', array(
                'label' => 'Proximity Search Unit',
                'description' => 'Choose the unit for proximity search of location of crowdfundings on your website.',
                'multiOptions' => array(
                1 => 'Miles',
                0 => 'Kilometres'
                ),
                'value' => $settings->getSetting('sescrowdfunding.search.type', 1),
            ));

            $this->addElement('Select', 'sescrowdfunding_taboptions', array(
                'label' => 'Menu Items Count in Main Navigation',
                'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
                'multiOptions' => array(
                0 => 0,
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                ),
                'value' => $settings->getSetting('sescrowdfunding.taboptions', 6),
            ));

            $this->addElement('Text', "sescrowdfunding_fillcolor", array(
                'label' => 'Donation Filled Percentage Bar Color',
                'description' => 'Choose the color of the percentage of donations made for various crowdfunding campaigns on your website.',
                'allowEmpty' => false,
                'required' => true,
                'class' => 'SEScolor',
                'value' => $settings->getSetting('sescrowdfunding.fillcolor', '20B34C'),
            ));
            $this->addElement('Text', "sescrowdfunding_outercolor", array(
                'label' => 'Donation Left Percentage Bar Color',
                'description' => 'Choose the color of the percentage of donations left for various crowdfunding campaigns on your website.',
                'allowEmpty' => false,
                'required' => true,
                'class' => 'SEScolor',
                'value' => $settings->getSetting('sescrowdfunding.outercolor', 'EEEEEE'),
            ));

            $this->addElement('Radio', "sescrowdfunding_enable_sharing", array(
                'label' => 'Allow to Share Crowdfunding',
                'description' => "Do you want to allow users to share Crowdfunding of your website inside on your website and outside on other social networking sites?",
                'multiOptions' => array(
                    '2' => 'Yes, allow sharing on this site and on social networking sites both.',
                    '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
                    '0' => 'No, do not allow sharing of Crowdfunding.',
                ),
                'value' => $settings->getSetting('sescrowdfunding.enable.sharing', 1),
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
