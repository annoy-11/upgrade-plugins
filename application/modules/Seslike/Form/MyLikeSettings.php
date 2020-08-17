<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MyLikeSettings.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Form_MyLikeSettings extends Engine_Form {

  public function init() {

    $this->setTitle('My Profile Like Settings')->setDescription('Do you want site member like your profile?');

    $isUserSettingExist = Engine_Api::_()->getDbTable('mylikesettings', 'seslike')->isUserSettingExist(Engine_Api::_()->user()->getViewer()->getIdentity());

    if(empty($isUserSettingExist)) {
        $isUserSettingExist = '0';
    } else {
        $isUserSettingExist = $isUserSettingExist;
    }

    $this->addElement('Radio','mylikesetting',array(
        'multiOptions' => array (
            1 => 'Yes' ,
            0 => 'No'
        ),
        'value' => $isUserSettingExist ,
    ));
    $this->addElement('Button','submit',array (
        'label' => 'Save',
        'type' => 'submit',
    ));
  }
}
