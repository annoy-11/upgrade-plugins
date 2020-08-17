<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Global.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');
    
    $einstaclone_adminmenu = Zend_Registry::isRegistered('einstaclone_adminmenu') ? Zend_Registry::get('einstaclone_adminmenu') : null;
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "einstaclone_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('einstaclone.licensekey'),
    ));
    $this->getElement('einstaclone_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (!$settings->getSetting('einstaclone.changelanding', 0)) {
      $this->addElement('Radio', 'einstaclone_changelanding', array(
          'label' => 'Set Landing Page',
          'description' => 'Do you want to set the Default Landing Page of this theme as Landing page of your website?  [This is a one time setting, so if you choose \'Yes\' and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name "LP backup from SES - Insta Clone".]',
          'onclick' => 'confirmChangeLandingPage(this.value, "1")',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('einstaclone.changelanding', 0),
      ));
    }

    if (!$settings->getSetting('einstaclone.changememberprofile', 0)) {
      $this->addElement('Radio', 'einstaclone_changememberprofile', array(
        'label' => 'Set Member Profile Page',
        'description' => 'Do you want to set Member Profile page of your webiste as that of the Instagram? If you choose Yes, then your page will look like the demo page as in <a href="https://socialnetworking.solutions/themes/instaclonetheme/images/8.png" target="_blank">here</a> and you will not be able to undo the change. A backup page of your current Member Profile Page will be created as "Member Profile Page Backup for InstaClone Theme".',
        'onclick' => 'confirmChangeLandingPage(this.value, "3")',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('einstaclone.changememberprofile', 0),
      ));
      $this->getElement('einstaclone_changememberprofile')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    }
    
    if (!$settings->getSetting('einstaclone.changememberhome', 0)) {
      $this->addElement('Radio', 'einstaclone_changememberhome', array(
          'label' => 'Set Member Home Page',
          'description' => 'Do you want to set Member Home page of your webiste as that of the Instagram? If you choose Yes, then your page will look like the demo page as in <a href="https://socialnetworking.solutions/themes/instaclonetheme/images/7.png" target="_blank">here</a> and you will not be able to undo the change. A backup page of your current Member Home Page will be created as "Member Home Page Backup for InstaClone Theme".',
          'escape' => false,
          'onclick' => 'confirmChangeLandingPage(this.value, "2")',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('einstaclone.changememberhome', 0),
      ));
      $this->getElement('einstaclone_changememberhome')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    }

    if ($settings->getSetting('einstaclone.pluginactivated')) {
      if($einstaclone_adminmenu) {
        $this->addElement('Select', "einstaclone_header_fixed_layout", array(
            'label' => 'Header Fixed?',
            'description' => 'Do you want Header fixed on your website?',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions' => array(
                '1' => 'Yes',
                '2' => "No",
            ),
            'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_header_fixed_layout'),
        ));
      }
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
