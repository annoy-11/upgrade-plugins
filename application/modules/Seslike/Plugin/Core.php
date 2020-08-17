<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserCreateAfter($event) {

    $user = $event->getPayload();
    $user_id = $user->user_id;

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslike.userlike', 0)) {

        $table = Engine_Api::_()->getDbTable('mylikesettings', 'seslike');
        $isUserSettingExist = $table->isUserExist($user_id);
        if (empty($isUserSettingExist)) {
            $row = $table->createRow() ;
            $row->user_id = $user_id ;
            $row->mylikesetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslike.bydefaultuserlike', 0);
            $row->save() ;
        }
    }
  }
}
