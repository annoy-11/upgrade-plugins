<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembersubscription_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");


    if( !$this->isPublic() ) {

      $this->addElement('Radio', 'enablesubscription', array(
        'label' => 'Enable Member Profile Subscription',
        'description' => 'Do you want to let members to enable subscription for making their profile visible on your website?',
        'multiOptions' => array(
          1 => 'Yes, allow members.',
          0 => 'No, do not allow members.'
        ),
        'value' => 1,
      ));
      
      $this->addElement('Text', "maxsubescriptionvalue", array(
        'label' => 'Maximum Amount for Profile Subscription',
        'description' => "Enter the maximum amount for the profile subscription by members of this level. If members will try to add a value greater than this amount, then they will see a message to upgrade their membership.",
        'allowEmpty' => false,
        'required' => true,
        'value' => 10,
      ));
      
	    $this->addElement('Text', "sesmembersubscription_threshold_amount", array(
        'label' => 'Threshold Amount for Releasing Payment',
        'description' => "Enter the threshold amount which will be required before making request for releasing payment from admins.",
        'allowEmpty' => false,
        'required' => true,
        'value' => 100,
	    ));
      
    }
  }
}