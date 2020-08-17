<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Form_Admin_Level_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    if (!$this->isPublic()) {

      $this->addElement('Radio', 'rating_album', array(
          'label' => 'Allow Rating on Music Albums?',
          'description' => 'Do you want to let members rate Music Albums?',
          'multiOptions' => array(
              1 => 'Yes, allow rating on music albums.',
              0 => 'No, do not allow rating on music albums.'
          ),
          'value' => 1,
      ));


      $this->addElement('Radio', 'rating_albumsong', array(
          'label' => 'Allow Rating on Songs?',
          'description' => 'Do you want to let members rate Songs?',
          'multiOptions' => array(
              1 => 'Yes, allow rating on songs.',
              0 => 'No, do not allow rating on songs.'
          ),
          'value' => 1,
      ));
      
      $this->addElement('Radio', 'addfavourite_album', array(
          'label' => 'Allow Adding Music Albums to Favorite?',
          'description' => 'Do you want to let members add music albums to their favorite list.',
          'multiOptions' => array(
              1 => 'Yes, allow adding of music albums to favorite lists.',
              0 => 'No, do not allow adding music albums to favorite lists.'
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'addfavourite_albumsong', array(
          'label' => 'Allow Adding Songs to Favourite?',
          'description' => 'Do you want to let members add songs to their favorite list.',
          'multiOptions' => array(
              1 => 'Yes, allow adding of songs to favorite lists.',
              0 => 'No, do not allow adding songs to favorite lists.'
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'download_albumsong', array(
          'label' => 'Allow Downloading of Songs?',
          'description' => 'Do you want to let members download Songs?',
          'multiOptions' => array(
              1 => 'Yes, allow downloading of songs.',
              0 => 'No, do not allow downloading of songs.'
          ),
          'value' => 1,
      ));

      //Element: max
      $this->addElement('Text', 'addalbum_max', array(
          'label' => 'Maximum Allowed Music Albums',
          'description' => 'Enter the maximum number of music albums a member can create. The field must contain an integer, use zero for unlimited.',
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(0),
          ),
      ));
    }
  }

}