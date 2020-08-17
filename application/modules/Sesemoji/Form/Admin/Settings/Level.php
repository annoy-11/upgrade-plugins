<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");


    if( !$this->isPublic() ) {

      $this->addElement('Radio', 'enableemojis', array(
        'label' => 'Enable Emojis for this member level?',
        'description' => 'Do you want to enable emojis for this member level? If set to no, some other settings will not apply.',
        'multiOptions' => array(
          1 => 'Yes, enable emojis.',
          0 => 'No, do not enable emojis.'
        ),
        'value' => 1,
      ));
      
      $getEmojis = Engine_Api::_()->getDbTable('emojis', 'sesemoji')->getEmojis(array('fetchAll' => 1, 'admin' => 1));
      if(count($getEmojis) > 0) {
        $allEmojisCategories = $allEmojisCategoriesIds = array();
        foreach($getEmojis as $getEmoji) {
          $allEmojisCategories[$getEmoji->emoji_id] = $getEmoji->title;
          $allEmojisCategoriesIds[] = $getEmoji->emoji_id;
        }
      }

      $this->addElement('MultiCheckbox', 'emojiscategories', array(
        'label' => 'Choose Emojis Category',
        'description' => 'Choose emoji categories, you want to show for this member level.',
        'multiOptions' => $allEmojisCategories,
        'value' => $allEmojisCategoriesIds,
      ));
      
    }
  }
}