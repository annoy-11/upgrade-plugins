<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Avatar.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Form_Admin_Signup_Avatar extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setAttrib('enctype', 'multipart/form-data');

    $step_table = Engine_Api::_()->getDbtable('signup', 'user');
    $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Sesavatar_Plugin_Signup_Avatar'));
    $count = $step_row->order;
    $title = $this->getView()->translate('Step %d: Add Your Photo (SES - Custom Avatar Plugin)', $count);
    $this->setTitle($title)->setDisableTranslator(true);


    // Element: enable
    $this->addElement('Radio', 'enable', array(
      'label' => 'User Photo Upload',
      'description' => 'Do you want your users to be able to upload a photo of ' .
        'themselves upon signup?',
      'multiOptions' => array(
        '1' => 'Yes, give users the option to upload a photo upon signup.',
        '0' => 'No, do not allow users to upload a photo upon signup.',
      ),
    ));

    // Element: require_photo
    $this->addElement('Radio', 'require_photo', array(
      'label' => 'Require User Photo',
      'description' => 'Do you want to require your users to upload a photo of ' .
        'themselves upon signup?',
      'multiOptions' => array(
        '1' => 'Yes, require users upload a photo upon signup.',
        '0' => 'No, do not require users upload a photo upon signup.',
      ),
    ));

    // Populate
    $this->populate(array(
      'enable' => $step_row->enable,
      'require_photo' => $settings->getSetting('sesavatar.signup.photo', 0),
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));
  }
}
