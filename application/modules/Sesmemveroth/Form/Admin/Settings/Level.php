<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
        ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    if( !$this->isPublic() ) {

      $this->addElement('Dummy', 'veryothermember', array(
        'label' => 'Settings for Verifying Other Members',
      ));

      // Element: create
      $this->addElement('Radio', 'allow', array(
        'label' => 'Allow Verification of Members?',
        'description' => 'Do you want to allow members of this level to verify other members of your website?',
        'multiOptions' => array(
          1 => 'Yes, allow to verify other members.',
          0 => 'No, do not allow to verify other members.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'autoapprove', array(
        'label' => 'Auto Approve Verifications?',
        'description' => 'Do you want to auto approve the verifications for the members verified by members of this level?',
        'multiOptions' => array(
          1 => 'Yes, auto-approve verifications.',
          0 => 'No, enable admin approval. (If you choose this option, then you will receive notification and email whenever new verification is made by members of this level. To manage mail settings <a href="admin/mail/templates" target="_blank">click here</a>.)',
        ),
        'escape' => false,
        'value' => 1,
      ));

      // Element: delete
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Verifications?',
        'description' => 'Do you want to let members of this level to edit verifications made by them?',
        'multiOptions' => array(
          1 => 'Yes, allow editing of verifications.',
          0 => 'No, do not allow editing of verifications.',
        ),
        'value' => 1,
      ));

      // Element: comment
      $this->addElement('Radio', 'cancel', array(
        'label' => 'Allow Cancellation of Verifications?',
        'description' => 'Do you want to let members of this level to cancel verifications made by them?',
        'multiOptions' => array(
          1 => 'Yes, allow to cancel verifications.',
          0 => 'No, do not allow to cancel verifications.',
        ),
        'value' => 1,
      ));

      $this->addElement('Dummy', 'gettingberified', array(
        'label' => 'Settings for Getting Verified',
      ));

      // Element: comment
      $this->addElement('Radio', 'enbeveriftion', array(
        'label' => 'Enable Members Verification?',
        'description' => 'Do you want to enable members of this level to be verified by other members of your website?',
        'multiOptions' => array(
          1 => 'Yes, allow to be verified by other members.',
          0 => 'No, do not allow to be verified by other members.',
        ),
        'value' => 1,
      ));

      // Element: max
      $this->addElement('Text', 'vifitionlmt', array(
        'label' => 'Minimum Verification Limit',
        'description' => 'Enter the minimum verification limit which members of this level need to be displayed as Verified Members on your website.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));
    }
  }
}
