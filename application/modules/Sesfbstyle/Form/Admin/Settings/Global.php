<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesfbstyleApi = Engine_Api::_()->sesfbstyle();
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesfbstyle_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesfbstyle.licensekey'),
    ));
    $this->getElement('sesfbstyle_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if (!$settings->getSetting('sesfbstyle.changelanding', 0)) {
      $this->addElement('Radio', 'sesfbstyle_changelanding', array(
          'label' => 'Set Landing Page',
          'description' => 'Do you want to set the Default Landing Page of this theme as Landing page of your website?  [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name "LP backup from SES - Professional FB Clone".]  ',
          'onclick' => 'confirmChangeLandingPage(this.value)',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesfbstyle.changelanding', 0),
      ));
    }

		if ($settings->getSetting('sesfbstyle.pluginactivated')) {
		   $this->addElement('Select','sesfbstyletheme_fixleftright',array(
        'label' => 'Enable Fixed Sidebar Layout',
        'description' => 'Do you want to enable the fixed layout for right and left column sidebar of your website? If you choose "Yes", then when users scroll down on your website then both the sidebar will be fixed at the end of the widgets in both the columns.',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value'=>$settings->getSetting('sesfbstyletheme.fixleftright',0),
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
          'label' => 'Activate Your Theme',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
