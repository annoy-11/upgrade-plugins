<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Message.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Api_Message extends Core_Api_Abstract
{

  public function getMessagesUnreadCount(Core_Model_Item_Abstract $user) {

    $recipients_table = Engine_Api::_()->getDbtable('recipients', 'messages');
    $recipients_table_name = $recipients_table->info('name');

    $select = $recipients_table->select()
            ->from($recipients_table_name, new Zend_Db_Expr('COUNT(conversation_id) AS unread'))
            ->where('inbox_deleted = ?', 0)
            ->where('user_id = ?', $user->getIdentity())
            ->where('socialtube_read = ?', 0)
            ->where('inbox_read = ?', 0);
    $results = $recipients_table->fetchRow($select);
    return $results->unread;
  }

  public function setUnreadMessage(Core_Model_Item_Abstract $user) {

    Engine_Api::_()->getDbtable('recipients', 'messages')->update(array('socialtube_read' => 1), array('`user_id` = ?' => $user->getIdentity(), 'socialtube_read = ?' => 0, 'inbox_read = ?' => 0));
  }

  public function setUnreadNotification(Core_Model_Item_Abstract $user) {
  
    Engine_Api::_()->getDbtable('notifications', 'activity')->update(array('view_notification' => 1), array('user_id = ?' => $user->getIdentity(), 'socialtube_read = ?' => 0, 'view_notification = ?' => 0));
  }

  public function setUnreadFriendRequest(Core_Model_Item_Abstract $user) {

    Engine_Api::_()->getDbtable('notifications', 'activity')->update(array('view_notification' => 1), array('user_id = ?' => $user->getIdentity(), 'socialtube_read = ?' => 0, 'mitigated = ?' => 0, 'view_notification = ?' => 0));
  }

}