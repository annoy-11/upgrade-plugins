<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
      ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of FAQs?',
      'description' => 'Do you want to let members view FAQs? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow viewing of all FAQs, even private ones.',
        1 => 'Yes, allow viewing of FAQs.',
        0 => 'No, do not allow FAQs to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( $this->isModerator() ) {
      unset($this->view->options[2]);
    }
      
    // Element: rating
    $this->addElement('Radio', 'askquestion', array(
      'label' => 'Allow Ask Question?',
      'description' => 'Do you want to let members of this level ask question?',
      'multiOptions' => array(
        1 => 'Yes, allow members to ask question.',
        0 => 'No, do not allow members to ask question.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( $this->isModerator() ) {
      unset($this->helpful->options[2]);
    }
    
    if( !$this->isPublic() ) {

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on FAQs?',
        'description' => 'Do you want to let members of this level comment on FAQs?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all FAQs.',
          1 => 'Yes, allow members to comment on FAQs.',
          0 => 'No, do not allow members to comment on FAQs.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( $this->isModerator() ) {
        unset($this->comment->options[2]);
      }

      // Element: rating
      $this->addElement('Radio', 'rating', array(
        'label' => 'Allow Rating on FAQs?',
        'description' => 'Do you want to let members of this level to rate FAQs?',
        'multiOptions' => array(
          1 => 'Yes, allow members to rating on FAQs.',
          0 => 'No, do not allow members to rating on FAQs.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( $this->isModerator() ) {
        unset($this->rating->options[2]);
      }
      
      // Element: rating
      $this->addElement('Radio', 'helpful', array(
        'label' => 'Allow to Select FAQs as Helpful?',
        'description' => 'Do you want to let members of this level select FAQs as helpful?',
        'multiOptions' => array(
          1 => 'Yes, allow members to helpful on FAQs.',
          0 => 'No, do not allow members to helpful on FAQs.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->helpful->options[2]);
      }

    }
  }
}