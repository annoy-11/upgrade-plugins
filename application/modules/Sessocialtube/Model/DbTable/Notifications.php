<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Notifications.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Model_DbTable_Notifications extends Engine_Db_Table {

  protected $_rowClass = 'Activity_Model_Notification';
  protected $_serializedColumns = array('params');
  
  public function getNotificationsPaginator(User_Model_User $user) {

    $enable_type = array();

    foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $type) {
      $enable_type[] = $type->type;
    }

    $select = Engine_Api::_()->getDbtable('notifications', 'activity')->select()
            ->where('user_id = ?', $user->getIdentity())
            ->where('type IN(?)', $enable_type)
            ->where('type != ?', 'friend_request')
            ->where('type != ?', 'message_new')
            ->order('date DESC');

    return Zend_Paginator::factory($select);
  }
  
  public function hasNotifications(User_Model_User $user, $param = null) {

    $notificationsTable = Engine_Api::_()->getDbtable('notifications', 'activity');
    $notificationsTableName = $notificationsTable->info('name');

    $select = new Zend_Db_Select($notificationsTable->getAdapter());
    $select->from($notificationsTableName, 'COUNT(notification_id) AS notification_count')
            ->where('user_id = ?', $user->getIdentity())
            ->where('socialtube_read = ?', 0)
            ->where('view_notification = ?', 0);

    if ($param == 'friend') {
      $select->where('type = ?', 'friend_request')
              ->where('mitigated 	 = ?', 0);
    } else {
      $select->where('type != ?', 'message_new')
              ->where('type != ?', 'friend_request');
    }

    $results = $notificationsTable->getAdapter()->fetchRow($select);
    return (int) @$results['notification_count'];
  }



  public function getFriendrequestPaginator(User_Model_User $user) {

    $enable_type = array();
    foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $type) {
      $enable_type[] = $type->type;
    }

    $select = Engine_Api::_()->getDbtable('notifications', 'activity')->select()
            ->where('user_id = ?', $user->getIdentity())
            ->where('type IN(?)', $enable_type)
            ->where('type = ?', 'friend_request')
            ->where('mitigated = ?', 0)
            ->order('date DESC');
    return Zend_Paginator::factory($select);
  }

}
