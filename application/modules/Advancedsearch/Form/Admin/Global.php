<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Advancedsearch_Form_Admin_Global extends Engine_Form {
  public function init() {
      $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "advancedsearch_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('advancedsearch.licensekey'),
    ));
    $this->getElement('advancedsearch_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('advancedsearch.pluginactivated')) {


        $this->addElement('Radio','advancedsearch_visibility',array(
            'label' => 'Search Box Visibility',
            'description' => 'Do you want the Advanced Search Box to be visible to non-logged-in users?',
            'allowEmpty'=>false,
            'required' => true,
            'value' => $settings->getSetting('advancedsearch_visibility',1),
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        ));

        $this->addElement('Text','advancedsearch_max',array(
            'label' => 'Maximum Results Limit in Advanced Search Box',
            'description' => 'Enter the maximum limit for auto-suggest search results that come in the global search field of mini-menu. [Note: Recommended value of this limit is 5]',
            'allowEmpty'=>false,
            'required' => true,
            'value' => $settings->getSetting('advancedsearch_max',5),
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
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
