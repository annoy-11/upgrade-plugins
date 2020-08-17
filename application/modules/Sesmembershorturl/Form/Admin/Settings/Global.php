<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    if ($settings->getSetting('sesmembershorturl.pluginactivated')) {

      $this->addElement('Radio', 'sesmembershorturl_enablecustomurl', array(
        'label' => 'How to Short / Custom URL?',
        'description' => 'Choose from below how do you want to enable Short URLs & Custom Slug URLs on your website.',
        'multiOptions' => array(
          1 => 'Globally',
          0 => 'Member Level Based'
        ),
        'onclick' => "showHide(this.value);",
        'value' => $settings->getSetting('sesmembershorturl.enablecustomurl', 1),
      ));

      $this->addElement('Radio', 'sesmembershorturl_enableglobalurl', array(
        'label' => 'Enable Short / Custom URL',
        'description' => 'Do you want to enable Short URLs or Custom URLs on your website? If you choose Custom URLs, then you can enter the custom slug URL in setting below.',
        'multiOptions' => array(
          0 => 'Short URL',
          1 => 'Custom URL'
        ),
        'onclick' => "customURL(this.value);",
        'value' => $settings->getSetting('sesmembershorturl.enableglobalurl', 0),
      ));

      $this->addElement('Text', 'sesmembershorturl_customurltext', array(
        'label' => 'Custom URL for "profile"',
        'description' => 'Enter the custom URL which you want to be replaced with the “profile” word in the member profiles URLs on your website. (For example: if you have Coach member level, then you can enable member profile URLs as www.yourwebsite.com/COACH/username for the coaches on your website. This will look more personalized and meaningful to another users was well.)',
        'value' => $settings->getSetting('sesmembershorturl.customurltext', 'profile'),
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
