<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesprofilelock_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesprofilelock.licensekey'),
    ));
    $this->getElement('sesprofilelock_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    if ($settings->getSetting('sesprofilelock.pluginactivated')) {

     $isSesvideoEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo');
     $isSesalbumEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum');
     $isSeslivestreamEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslivestream');

     if($isSesvideoEnabled || $isSesalbumEnabled || $isSeslivestreamEnabled) {
      if($isSesvideoEnabled)
        $options['sesvideo'] = 'SES - Advanced Videos & Channels';
     if($isSesalbumEnabled)
        $options['sesalbum'] = 'SES - Advanced Photos & Albums';
     if($isSeslivestreamEnabled)
        $options['seslivestream'] = 'SES - Video & Audio Live Streaming';

      $this->addElement('MultiCheckbox', 'sesprofilelock_enable_modules', array(
	    'label' => 'Check the module you want to enable lock',
	    'description' => '',
	    'multiOptions' => $options,
	    'value' => $settings->getSetting('sesprofilelock.enable.modules', array()),
	));
      }

				$this->addElement('Select', 'sesprofilelock_enable_lock', array(
          'label' => 'Enable "Lock Screen" Feature',
          'description' => 'Do you want to enable "Lock Screen" feature on your website? [Note: When you choose "Yes", then site member can Lock Screen by clicking on "Lock Screen" link by choosing below options.]',
					'onchange'=>'showelem(this.value)',
          'multiOptions' => array(
              '1' => 'Yes',
							'0' => 'No',
          ),
          'value' => $settings->getSetting('sesprofilelock.enable.lock', 1),
      ));

      $this->addElement('MultiCheckbox', 'sesprofilelock_lockedlink', array(
          'label' => 'Display "Lock Screen" Link',
          'description' => 'Choose from below where do you want to display "Lock Screen" link on your website?',
          'multiOptions' => array(
              'sesprofilelock_mini_admin' => 'In Mini Menu',
              'sesprofilelock_main_admin' => 'In Main Menu',
							'sesprofilelock_footer_admin' => 'In Footer',
          ),
          'value' => $settings->getSetting('sesprofilelock.lockedlink', 'mini_menu'),
      ));

      $member_levels = array();
      $public_level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel();
      foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $row) {
        if ($public_level->level_id != $row->level_id) {
          $member_count = $row->getMembershipCount();
          if (null !== ($translate = $this->getTranslator())) {
            $title = $translate->translate($row->title);
          } else {
            $title = $row->title;
          }
          $member_levels[$row->level_id] = $title;
        }
      }

      $sesproflelock_levels = $settings->getSetting('sesproflelock.levels', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
      $sesproflelock_levelsvalue = unserialize($sesproflelock_levels);

      $this->addElement('Multiselect', 'sesproflelock_levels', array(
          'label' => 'Member Levels',
          'description' => 'Select member level you want to show "Lock Screen" link in mini menu? Hold down the CTRL key to select or de-select specific Member Levels.',
          'required' => true,
          'allowEmpty' => false,
          'multiOptions' => $member_levels,
          'value' => $sesproflelock_levelsvalue,
      ));


      $lockpopup_information = array('site_title' => 'Website Title', 'member_title' => 'Member\'s Name', 'email' => 'Member\'s Email id', 'locked_text' => 'Text: "Locked"', 'signout_link' => 'Text: "Not Member\'s Name, logout?"');
      $sesproflelock_popupinfo = $settings->getSetting('sesprofilelock.popupinfo', 'a:5:{i:0;s:10:"site_title";i:1;s:12:"member_title";i:2;s:5:"email";i:3;s:11:"locked_text";i:4;s:12:"signout_link";}');
      $sesproflelock_popupinfovalue = unserialize($sesproflelock_popupinfo);

      $this->addElement('MultiCheckbox', 'sesprofilelock_popupinfo', array(
          'label' => 'Information for Locked Screen',
          'description' => 'Choose from below the information to be shown when the user screen is locked.',
          'multiOptions' => $lockpopup_information,
          'value' => $sesproflelock_popupinfovalue,
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
