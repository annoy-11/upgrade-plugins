<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecentlogin_Api_Core extends Core_Api_Abstract {

    public function checkUser($password, $user_id) {

        $table = Engine_Api::_()->getDbTable('users','user');
        return Engine_Api::_()->getDbTable('users','user')->select()
                        ->from($table, array('user_id'))
                        ->where('user_id =?', $user_id)
                        ->where('password =?', $password)
                        ->query()
                        ->fetchColumn();
    }

    public function getNotificationsPaginator(User_Model_User $user) {
        $enabledNotificationTypes = array();
        foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $type) {
        $enabledNotificationTypes[] = $type->type;
        }

        $select = Engine_Api::_()->getDbtable('notifications', 'activity')->select()
                ->where('user_id = ?', $user->getIdentity())
                ->where('type IN(?)', $enabledNotificationTypes)
                ->where('type != ?', 'message_new')
                ->where('type != ?', 'friend_request')
                ->order('date DESC');

        return Engine_Api::_()->getDbTable('notifications', 'activity')->fetchAll($select);
    }
}
