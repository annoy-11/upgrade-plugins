<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinviter_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    if ($settings->getSetting('sesinviter.pluginactivated')) {

      $this->addElement('Radio', 'sesinviter_affiliateforsingup', array(
          'label' => 'Enable Signup Invitation Referrals',
          'description' => 'Do you want to enable referrals when members send invites for joining your website. If you choose Yes, then members of your website will be able to send affiliate links.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesinviter.affiliateforsingup', 1)
      ));

      $this->addElement('MultiCheckbox', 'sesinviter_socialmediaoptions', array(
        'label' => 'Enable Invite Social Media Options',
        'description' => 'Enable Invite Social Media Options',
        'multiOptions' => array(
          'facebook' => 'Facebook',
          'twitter' => 'Twitter',
          'gmail' => 'Gmail',
          'hotmail' => 'Hotmail',
          'yahoo' => 'Yahoo',
          //'csv' => 'CSV',
          //'emailinvite' => 'Direct Email (Using SocialEngine Invite)',
        ),
        'value' => unserialize($settings->getSetting('sesinviter.socialmediaoptions', '')),
      ));

	    $this->addElement('Text', 'sesinviter_facebooktitle', array(
        'label' => 'Facebook Title',
        'description' => 'Enter title for facebook.',
        'filters' => array(
        new Engine_Filter_Censor(),
        ),
        'value' => $settings->getSetting('sesinviter.facebooktitle', 'Share this site with your friends'),
		  ));

	    $this->addElement('Text', 'sesinviter_facebookmessage', array(
        'label' => 'Facebook Message',
        'description' => 'Enter message for facebook.',
        'filters' => array(
        new Engine_Filter_Censor(),
        ),
        'value' => $settings->getSetting('sesinviter.facebookmessage', 'This page is amazing, check it out!'),
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
