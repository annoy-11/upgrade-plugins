<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Welcome.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Form_Admin_Welcome extends Engine_Form {

  public function init() {

    $api_settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Welcome Page Settings')
            ->setDescription('Here, you can manage the settings which will affect the Welcome Page to wish Christmas and New Year to your users.');

    $this->addElement('Radio', 'seschristmas_welcome', array(
        'label' => 'Redirect to Welcome Page',
        'description' => 'Do you want the users of your website to the Welcome Page when they open your website? (Note: Users will be redirected to the Welcome Page only when users enter the base URL of your website. If they open some other URL like www.yourwebsiteurl.com/albums, then they will not be redirected to the Welcome Page and that particular page will open.)',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => 'showwelcome(this.value)',
        'value' => $api_settings->getSetting('seschristmas.welcome', 1),
    ));

    $this->addElement('Text', 'seschristmas_urlmanifest', array(
        'label' => '"welcome" Text in URL',
        'allowEmpty' => false,
        'required' => true,
        'description' => 'Enter the text which you want to show in place of “welcome” in the URL of Welcome Page of this plugin.',
        'value' => $api_settings->getSetting('seschristmas.urlmanifest', "welcome"),
    ));

    $this->addElement('Radio', 'seschristmas_welcomepageshow', array(
        'label' => 'Users to Show Welcome Page',
        'description' => 'Choose from below who all users should be able to see the Welcome Page on your website when they enter the base URL of your website.',
        'multiOptions' => array(
            2 => 'Logged-in members only',
            1 => 'Non-logged in users only',
            0 => 'Both logged-in and non-logged in users'
        ),
        'value' => $api_settings->getSetting('seschristmas.welcomepageshow', 0),
    ));

    $this->addElement('Text', 'seschristmas_pagename', array(
        'label' => 'Welcome Page Title',
        'allowEmpty' => false,
        'required' => true,
        'description' => 'Enter the text for the Title of the Welcome Page.',
        'value' => $api_settings->getSetting('seschristmas.pagename', "Welcome Page"),
    ));

    $this->addElement('Radio', 'seschristmas_welcomecountdown', array(
        'label' => 'Christmas / New Year Countdown',
        'description' => 'Choose from below for which occasion you want to show the countdown on the Welcome Page.',
        'multiOptions' => array(
            1 => 'Merry Christmas',
            0 => 'New Year'
        ),
        'value' => $api_settings->getSetting('seschristmas.welcomecountdown', 1),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}