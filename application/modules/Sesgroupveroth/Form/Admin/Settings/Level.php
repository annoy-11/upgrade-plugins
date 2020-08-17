<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupveroth_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
        ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    if( !$this->isPublic() ) {

      $this->addElement('Dummy', 'veryothermember', array(
        'label' => 'Settings for Verifying Groups',
      ));

      // Element: create
      $this->addElement('Radio', 'allow', array(
        'label' => 'Allow Verification of Groups?',
        'description' => 'Do you want to allow members of this level to verify Groups of your website?',
        'multiOptions' => array(
          1 => 'Yes, allow to verify Groups.',
          0 => 'No, do not allow to verify Groups.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'autoapprove', array(
        'label' => 'Auto Approve Verifications?',
        'description' => 'Do you want to auto approve the verifications for the Groups by members of this level?',
        'multiOptions' => array(
          1 => 'Yes, auto-approve verifications.',
          0 => 'No, enable admin approval. (If you choose this option, then you will receive notification and email whenever new verification for the Group is made by members of this level. To manage mail settings <a href="admin/mail/templates" target="_blank">click here</a>.)',
        ),
        'escape' => false,
        'value' => 1,
      ));

      // Element: delete
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Verifications?',
        'description' => 'Do you want to let members of this level to edit Group verifications made by them?',
        'multiOptions' => array(
          1 => 'Yes, allow editing of Group verifications.',
          0 => 'No, do not allow editing of Group verifications.',
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
        'label' => 'Enable Group Verification?',
        'description' => 'Do you want to enable Groups created by the members of this level to be verified by the same member level of your website?',
        'multiOptions' => array(
          1 => 'Yes, allow to be verified by the members.',
          0 => 'No, do not allow to be verified by the members.',
        ),
        'value' => 1,
      ));

      // Element: max
      $this->addElement('Text', 'vifitionlmt', array(
        'label' => 'Minimum Verification Limit',
        'description' => 'Enter the minimum verification limit which members of this level need to be displayed as Verified Groups on your website.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));
    }
  }
}
