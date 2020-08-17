<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Form_Admin_Manage_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    $this->setTitle('Member Level Settings')->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Reviews?',
        'description' => 'Do you want to let members to view reviews for the pages?',
        'multiOptions' => array(
            1 => 'Yes, allow viewing  of reviews.',
            0 => 'No, do not allow reviewes to be viewed.',
        ),
        'value' => 1,
    ));
    if (!$this->isPublic()) {
      $this->addElement('Radio', 'create', array(
          'label' => 'Allow Write a Reviews',
          'description' => 'Do you want to let members to write reviews for the Pages?',
          'multiOptions' => array(
              1 => 'Yes, allow members to write a reviews.',
              0 => 'No, do not allow members to write a reviews.'
          ),
          'value' => 1,
      ));
      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Reviews?',
          'description' => 'Do you want to let members to edit  reviews?',
          'multiOptions' => array(
              1 => "Yes, allow  members to edit their own reviews.",
              0 => "No, do not allow reviews to be edited.",
          ),
          'value' => 1,
      ));
      //Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Reviews?',
          'description' => 'Do you want to let members to delete reviews? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              1 => 'Yes, allow members to delete their own reviews.',
              0 => 'No, do not allow members to delete their reviews.',
          ),
          'value' => 1,
      ));
      //Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Reviews?',
          'description' => 'Do you want to let members to comment on Reviews?',
          'multiOptions' => array(
              1 => 'Yes, allow members to comment on reviews.',
              0 => 'No, do not allow commenting on reviews.',
          ),
          'value' => 1,
      ));
    }
  }

}