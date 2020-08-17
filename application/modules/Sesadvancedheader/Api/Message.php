<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Message.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Api_Message extends Core_Api_Abstract {

  public function getMessagesUnreadCount(Core_Model_Item_Abstract $user) {

    $recipients_table = Engine_Api::_()->getDbtable('recipients', 'messages');
    $recipients_table_name = $recipients_table->info('name');

    $tableread = Engine_Api::_()->getDbTable('notificationreads','sesbasic');
    $tablereadname = $tableread->info('name');

    $select = $recipients_table->select()
            ->from($recipients_table_name, new Zend_Db_Expr('COUNT(conversation_id) AS unread'))
            ->where('inbox_deleted = ?', 0)
            ->where($recipients_table_name.'.user_id = ?', $user->getIdentity());
    $tableread = Engine_Api::_()->getDbTable('notificationreads','sesbasic');
    $select->setIntegrityCheck(false);
    $tablereadname = $tableread->info('name');
    $select->joinLeft($tablereadname,$tablereadname.".`user_id` =".$recipients_table_name.".`user_id` AND ".$tablereadname.".`type` = 'message_read'",null);
    $select->where('CASE WHEN '.$tablereadname.'.notificationread_id IS NOT NULL THEN '.$recipients_table_name.'.conversation_id > '.$tablereadname.'.item_id ELSE TRUE END');
    $results = $recipients_table->fetchRow($select);
    return $results->unread;
  }

  public function getUserLastMessage(Core_Model_Item_Abstract $user){
    $recipients_table = Engine_Api::_()->getDbtable('recipients', 'messages');
    $recipients_table_name = $recipients_table->info('name');
    $select = $recipients_table->select()
            ->from($recipients_table_name, 'conversation_id')
            ->where('inbox_deleted = ?', 0)
            ->where($recipients_table_name.'.user_id = ?', $user->getIdentity())
            ->order('conversation_id DESC');
    $results = $recipients_table->fetchRow($select);
    return $results;
  }

  public function setUnreadMessage(Core_Model_Item_Abstract $user) {
    $userLastNotification = Engine_Api::_()->getApi('message', 'sesadvancedheader')->getUserLastMessage($user);
    if($userLastNotification){
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("INSERT INTO engine4_sesbasic_notificationreads (item_id, type, user_id) VALUES(".$userLastNotification->conversation_id.", 'message_read', ".$user->getIdentity().") ON DUPLICATE KEY UPDATE item_id=".$userLastNotification->conversation_id);
    }
  }

  public function setUnreadNotification(Core_Model_Item_Abstract $user) {
    $userLastNotification = Engine_Api::_()->getDbTable('notifications','sesbasic')->getUserLastNotification($user);
    if($userLastNotification){
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("INSERT INTO engine4_sesbasic_notificationreads (item_id, type, user_id) VALUES(".$userLastNotification->notification_id.", 'notification_read', ".$user->getIdentity().") ON DUPLICATE KEY UPDATE item_id=".$userLastNotification->notification_id);
    }
  }

  public function setUnreadFriendRequest(Core_Model_Item_Abstract $user) {
    $userLastNotification = Engine_Api::_()->getDbTable('notifications','sesbasic')->getUserLastNotification($user,"friend");
    if($userLastNotification){
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("INSERT INTO engine4_sesbasic_notificationreads (item_id, type, user_id) VALUES(".$userLastNotification->notification_id.", 'friendreq_read', ".$user->getIdentity().") ON DUPLICATE KEY UPDATE item_id=".$userLastNotification->notification_id);
    }
  }
}
