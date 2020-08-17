<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
        ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    if( !$this->isPublic() ) {
      $this->addElement('Radio', 'enablecustomurl', array(
        'label' => 'Enable Custom & Short URLs',
        'description' => 'Do you want to enable the custom & short URLs for the member profiles on your website for this members of this level? If you choose Yes, then you can choose to set the custom URL which will replace PROFILE with your desired work in URL like: www.yourwebsite.com/PROFILE/username, or set the member profiles to short URLs like: www.yourwebsite.com/username.',
        'multiOptions' => array(
          2 => 'Yes, enable Short member profile URL.',
          1 => 'Yes, enable Custom member profile URL.',
          0 => 'No, do not enable custom or short URL.'
        ),
        'value' => 2,
      ));
      
      $this->addElement('Text', 'customurltext', array(
        'label' => 'Custom URL for "profile"',
        'description' => 'Enter the custom URL which you want to be replaced with the “profile” word in the member profiles URLs on your website. (For example: if you have Coach member level, then you can enable member profile URLs as www.yourwebsite.com/COACH/username for the coaches on your website. This will look more personalized and meaningful to another users was well.)',
        'value' => '',
      ));
    }
  }
}