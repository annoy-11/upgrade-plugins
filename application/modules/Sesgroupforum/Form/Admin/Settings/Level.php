<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription('These settings are applied on a per
member level basis. Start by selecting the member level you want to modify,
then adjust the settings for that level below.');

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Forums?',
      'description' => 'Do you want to let users view Forums? If set to no, some other settings on this page may not apply.',
      'value' => 1,
      'multiOptions' => array(
        2 => 'Yes, allow viewing of forums, even private ones.',
        1 => 'Yes, allow viewing of forums.',
        0 => 'No, do not allow forums to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if($this->isPublic() ) {
        $this->addElement('Radio', 'post', array(
        'label' => 'Allow Creation of Topics',
        'description' => 'Do you want to allow users to show create topics option in forums?',
        'value' => 1,
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
    }
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: topic_create
      $this->addElement('Radio', 'topic_create', array(
        'label' => 'Allow Creation of Topics?',
        'description' => 'Do you want to allow users to create topics in Forums?',
        'multiOptions' => array(
          2 => 'Yes, allow creation of topics in forums, even private ones.',
          1 => 'Yes, allow creation of topics.',
          0 => 'No, do not allow topics to be created.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->topic_create->options[2]);
      }

      // Element: topic_edit
      $this->addElement('Radio', 'topic_edit', array(
        'label' => 'Allow Editing of Topics?',
        'description' => 'Do you want to allow users to edit topics in Forums?',
        'multiOptions' => array(
          2 => 'Yes, allow editing of topics in forums, including other members\' topics.',
          1 => 'Yes, allow editing of topics.',
          0 => 'No, do not allow topics to be edited.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->topic_edit->options[2]);
      }

      // Element: topic_edit
      $this->addElement('Radio', 'topic_delete', array(
        'label' => 'Allow Deletion of Topics?',
        'description' => 'Do you want to allow users to delete topics in Forums?',
        'multiOptions' => array(
          2 => 'Yes, allow deletion of topics in forums, including other members\' topics.',
          1 => 'Yes, allow deletion of topics.',
          0 => 'No, do not allow topics to be deleted.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->topic_delete->options[2]);
      }

      // Element: post_create
      $this->addElement('Radio', 'post_create', array(
        'label' => 'Allow Posting?',
        'description' => 'Do you want to allow users to post to the Forums? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow posting to forums, even private ones.',
          1 => 'Yes, allow posting to forums.',
          0 => 'No, do not allow forum posts.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->post_create->options[2]);
      }

      // Element: post_edit
      $this->addElement('Radio', 'post_edit', array(
        'label' => 'Allow Editing of Posts?',
        'description' => 'Do you want to allow users to edit posts in topics?',
        'multiOptions' => array(
          2 => 'Yes, allow editing of posts, including other members\' posts.',
          1 => 'Yes, allow editing of posts.',
          0 => 'No, do not allow forum posts to be edited.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->post_edit->options[2]);
      }

      // Element: post_edit
      $this->addElement('Radio', 'post_delete', array(
        'label' => 'Allow Deletion of Posts?',
        'description' => 'Do you want to allow users to delete posts in topics?',
        'multiOptions' => array(
          2 => 'Yes, allow deletion of posts, including other members\' posts.',
          1 => 'Yes, allow deletion of posts.',
          0 => 'No, do not allow forum posts to be deleted.'
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->post_delete->options[2]);
      }



      // Element: commentHtml
      $this->addElement('Text', 'commentHtml', array(
        'label' => 'Allow HTML in posts?',
        'description' => 'If you have disabled HTML in posts but want to allow specific tags, you can enter them below (separated by commas). If you have enabled HTML in posts, this setting will have no effect.  Example: b, img, a, embed, font',
      ));
    }

  }
}
