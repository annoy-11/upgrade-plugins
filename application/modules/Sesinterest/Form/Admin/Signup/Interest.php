<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Interest.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Form_Admin_Signup_Interest extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    //$this->setAttrib('enctype', 'multipart/form-data');

    $step_table = Engine_Api::_()->getDbtable('signup', 'user');
    $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Sesinterest_Plugin_Signup_Interest'));
    $count = $step_row->order;
    $title = $this->getView()->translate('Step %d: Choose Interests (SES - Interest Plugin)', $count);
    $this->setTitle($title)->setDisableTranslator(true);

    // Element: enable
    $this->addElement('Radio', 'enable', array(
      'label' => 'Choose Interest',
      'description' => 'Do you want your users to be able to choose interests upon signup?',
      'multiOptions' => array(
        '1' => 'Yes, give users the option to choose interest upon signup.',
        '0' => 'No, do not allow users to choose interest upon signup.',
      ),
    ));


    // Element: require_photo
    $this->addElement('Radio', 'require_interests', array(
      'label' => 'Require Interest',
      'description' => 'Do you want to require your users to choose interest upon signup?',
      'multiOptions' => array(
        '1' => 'Yes, require users choose interests upon signup.',
        '0' => 'No, do not require users choose interests upon signup.',
      ),
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));

    // Populate
    $this->populate(array(
      'enable' => $step_row->enable,
      'require_interests' => $settings->getSetting('sesinterest.require.interests', 0),
    ));

//     $this->addElement('Button', 'submit', array(
//       'label' => 'Save Changes',
//       'type' => 'submit',
//       'ignore' => true,
//     ));
  }
}
