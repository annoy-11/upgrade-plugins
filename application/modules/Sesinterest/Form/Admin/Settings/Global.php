<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Form_Admin_Settings_Global extends Engine_Form {

    public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
        $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
        $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

        $this->addElement('Text', "sesinterest_licensekey", array(
            'label' => 'Enter License key',
            'description' => $descriptionLicense,
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesinterest.licensekey'),
        ));
        $this->getElement('sesinterest_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        
        if ($settings->getSetting('sesinterest.pluginactivated')) {

            $this->addElement('Radio', 'sesinterest_userdriven', array(
                'label' => 'Allow Users to Enter Interest',
                'description' => 'Do you want to allow users to enter interests on your website?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.userdriven', 0),
            ));

            $this->addElement('Text', 'sesinterest_minchoint', array(
                'label' => 'Minimum Number of Interest',
                'description' => 'Enter the minimum number of interest that you want user choose upon signup (0 means not to choose any interests) on your website.',
                'allowEmpty' => true,
                'required' => false,
                'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.minchoint', 3),
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
