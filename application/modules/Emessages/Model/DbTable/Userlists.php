<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Userlists.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Model_DbTable_Userlists extends Engine_Db_Table
{

	public function getMessageSelect($params = array())
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if(isset($params['type']) && $params['type']==2)  // 2 means group messages
		{
			if(isset($params['group_id']) && !empty($params['group_id']))
			{
				if(isset($params['searchtext']) && !empty($params['searchtext']))
				{
					return $db->select()->from('engine4_emessages_recipients')->joinUsing('engine4_messages_messages', 'message_id')->where('engine4_messages_messages. body  LIKE ? ', '%' .trim($params['searchtext']). '%')->where('engine4_emessages_recipients.user_id = ? ', $viewer->getIdentity())->where('engine4_emessages_recipients.conversation_id = ? ',$params['group_id'])->where('(engine4_emessages_recipients.inbox_message_id is not null AND engine4_emessages_recipients.inbox_deleted!=1) or (engine4_emessages_recipients.outbox_message_id is not null AND engine4_emessages_recipients.outbox_deleted!=1)')->order('engine4_emessages_recipients.message_id DESC');

				}
				return $db->select()->from('engine4_emessages_recipients')->joinUsing('engine4_messages_messages', 'message_id')->where('engine4_emessages_recipients.user_id = ? ', $viewer->getIdentity())->where('engine4_emessages_recipients.conversation_id = ? ',$params['group_id'])->where('(engine4_emessages_recipients.inbox_message_id is not null AND engine4_emessages_recipients.inbox_deleted!=1) or (engine4_emessages_recipients.outbox_message_id is not null AND engine4_emessages_recipients.outbox_deleted!=1)')->order('engine4_emessages_recipients.message_id DESC');
			}
			else
			{
				return null;
			}
		}
		else
		{
			if(isset($params['user_id']) && !empty($params['user_id']))
			{
				$chat_id=$params['user_id'];
				$viewerid = $viewer->getIdentity();
				if(isset($params['searchtext']) && !empty($params['searchtext']))
				{
					return   $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where('engine4_messages_messages. body  LIKE ? ', '%' .trim($params['searchtext']). '%')->where("engine4_messages_recipients.outbox_deleted = 0  AND engine4_messages_messages.user_id = $viewerid AND engine4_messages_recipients.user_id = $chat_id ")->orwhere("engine4_messages_recipients.inbox_deleted = 0  AND engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC');

				}
				return   $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_recipients.outbox_deleted = 0  AND engine4_messages_messages.user_id = $viewerid AND engine4_messages_recipients.user_id = $chat_id ")->orwhere("engine4_messages_recipients.inbox_deleted = 0  AND engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC');

			}
			else
			{
				return null;
			}
		}
	}

	public function getMessagePaginator($params = array())
	{
		$paginator = Zend_Paginator::factory($this->getMessageSelect($params));
		if( !empty($params['page']) )
		{
			$paginator->setCurrentPageNumber($params['page']);
		}
		if( !empty($params['limit']) )
		{
			$paginator->setItemCountPerPage($params['limit']);
		}

		if( empty($params['limit']) )
		{
			$page = 10;
			$paginator->setItemCountPerPage($page);
		}

		return $paginator;
	}


	public function getAllUser($param = array()) {
		$viewer = Engine_Api::_()->user()->getViewer();
		$tableName = $this->info('name');
		$select = $this->select()->from($tableName);
		$select->where('`user_id` = ?', $viewer->getIdentity());
		if(!empty(Engine_Api::_()->emessages()->AllGroupByUser($viewer->getIdentity())))
		{
			$select = $select->orwhere('userlist_id In (?)', Engine_Api::_()->emessages()->AllGroupByUser($viewer->getIdentity()));
		}
		$select->order('modified_date DESC')->query();
		return $this->fetchAll($select);
	}

    public function getShareMediaSelect($params = array())
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $db = Engine_Db_Table::getDefaultAdapter();
        if(isset($params['type']) && $params['type']==2)  // 2 means group message
        {
            $select = $db->select()->from('engine4_emessages_recipients')->joinUsing('engine4_emessages_messageattachments', 'message_id');
            $select = $select->where('user_id = (?)',$viewer->getIdentity())->where('engine4_emessages_recipients.conversation_id = (?)',$params['user_id'])->where('engine4_emessages_recipients.inbox_deleted!=1 AND engine4_emessages_recipients.outbox_deleted!=1');
            $select = $select->order('engine4_emessages_recipients.created_date DESC');
            return $select;
        }
        else
        {

            $chat_id=$params['user_id'];
            $viewerid = $viewer->getIdentity();
            return   $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->joinUsing('engine4_emessages_messageattachments', 'message_id')->where("engine4_messages_recipients.outbox_deleted = 0  AND engine4_messages_messages.user_id = $viewerid AND engine4_messages_recipients.user_id = $chat_id ")->orwhere("engine4_messages_recipients.inbox_deleted = 0  AND engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC');
        }
    }

    public function getShareMediaPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getShareMediaSelect($params));
        if( !empty($params['page']) )
        {
            $paginator->setCurrentPageNumber($params['page']);
        }
        if( !empty($params['limit']) )
        {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if( empty($params['limit']) )
        {
            $page = 20;
            $paginator->setItemCountPerPage($page);
        }
        return $paginator;
    }

}
