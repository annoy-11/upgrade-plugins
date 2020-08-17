<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow to View Weather?',
        'description' => 'Do you want to let users to view Weather? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Weather, even private ones.',
            1 => 'Yes, allow members to view their own Weather.',
            0 => 'No, do not allow Weather to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }
  }
}
