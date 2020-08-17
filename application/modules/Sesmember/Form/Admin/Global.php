<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')->setDescription('These settings affect all members in your community.');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmember_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmember.licensekey'),
    ));
    $this->getElement('sesmember_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesmember.pluginactivated')) {
      $this->addElement('Select', 'sesmember_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for members on your website?',
          'multiOptions' => array(
              '1' => 'Yes,enable location',
              '0' => 'No, do not enable location',
          ),
          'value' => $settings->getSetting('sesmember.enable.location', 1),
      ));
      $this->addElement('Select', 'sesmember_showsignup_location', array(
          'label' => 'Show Location Field On Singup Page',
          'description' => 'Do you want to show location field on signup page?',
          'multiOptions' => array(
              '1' => 'Yes,show location',
              '0' => 'No, do not show location',
          ),
          'value' => $settings->getSetting('sesmember.showsignup.location', 1),
      ));
      $this->addElement('Select', 'sesmember_user_approved', array(
          'label' => 'Member Auto Verified',
          'description' => 'Do you want to allow users to auto-verfied on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'show_type(this.value)',
          'value' => $settings->getSetting('sesmember.user.approved', 1),
      ));

      $this->addElement('Select', 'sesmember_approve_criteria', array(
          'label' => 'Auto Verified Type',
          'description' => 'On which based user will be auto verfied?',
          'multiOptions' => array(
              1 => 'Member Based on "Like"',
              0 => 'Member Based on "Profile View"'
          ),
          'onchange' => 'showCriteria(this.value)',
          'value' => $settings->getSetting('sesmember.approve.criteria', 1),
      ));

      $this->addElement('Text', "sesmember_like_count", array(
          'label' => 'Enter Like Count',
          'description' => "Enter the like count, after which member will be automatic verfied.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesmember.like.count', 10),
      ));

      $this->addElement('Text', "sesmember_view_count", array(
          'label' => 'Enter View Count',
          'description' => "Enter the view count, after which member will be automatic verfied.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesmember.view.count', 10),
      ));

      /* Follow Functionality Setting */
      $this->addElement('Select', 'sesmember_follow_active', array(
          'label' => 'Enable Follow Functionality',
          'description' => 'Do you want to enable follow functionality on your website?',
          'onchange' => 'showfollowtext(this.value)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesmember.follow.active', 1),
      ));

        $this->addElement('Select', 'sesmember_autofollow', array(
          'label' => 'Auto Follow / Approvals',
          'description' => 'Do you want to enable auto follow / approvals functionality on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesmember.autofollow', 1),
        ));

      $this->addElement('Text', "sesmember_follow_followtext", array(
          'label' => 'Follow Button Text',
          'description' => "Enter the text for Follow Button.",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesmember.follow.followtext', 'Follow'),
      ));
      $this->addElement('Text', "sesmember_follow_unfollowtext", array(
          'label' => 'Unfollow Button Text',
          'description' => "Enter the text Unfollow Button.",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesmember.follow.unfollowtext', 'Unfollow'),
      ));

      $this->addElement('Text', "sesmember_nearest_distance", array(
          'label' => 'Default distance for Nearest member page',
          'description' => 'Enter the default distance for nearest member for Nearest member page.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesmember_nearest_distance', '100'),
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
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
