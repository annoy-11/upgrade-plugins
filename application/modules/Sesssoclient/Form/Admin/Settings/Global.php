<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesssoclient_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesssoclient_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesssoclient.licensekey'),
    ));
    $this->getElement('sesssoclient_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesssoclient.pluginactivated')) {

        $this->addElement('Text', "sesssoclient_client_secret", array(
            'label' => 'Client Secret',
            'description' => 'Enter the Client Secret. You will have to enter this in Server site while adding this site as Client site.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesssoclient.client.secret'),
        ));
        $this->getElement('sesssoclient_client_secret')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "sesssoclient_client_token", array(
            'label' => 'Client Token',
            'description' => 'Enter the Client Token. You will have to enter this in Server site while adding this site as Client site.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesssoclient.client.token'),
        ));
        $this->getElement('sesssoclient_client_token')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

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
