<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Recipients.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Model_DbTable_Recipients extends Engine_Db_Table
{
	public function getMessageSelect($params = array())
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if(isset($params['type']) && $params['type']==2)  // 2 means group messages
		{
			if(!isset($params['group_id'])){ return null;  }
			$messages_ids=Engine_Api::_()->emessages()->getuseroldmessagesid($params['group_id'],$viewer->getIdentity());
			$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
			$select = $table->select();
			$select = $select->where('type = (?)',2)->where('receiver_id = (?)', $params['group_id']);
			if(isset($params['starting_id']) && !empty($params['starting_id']))
			{
				$select = $select->where('messages_id > (?)',$params['starting_id']);
			}
			if(isset($params['end_id']) && !empty($params['end_id']))
			{
				$select = $select->where('messages_id <= (?)',$params['end_id']);
			}
			if(isset($messages_ids) && count($messages_ids)>0) {
				$select = $select->orwhere('messages_id in (?)', $messages_ids);
			}
			$select = $select->order('creation_date DESC');
			return $select;
		}
		else
		{
			$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
			$select = $table->select();
			$select = $select->where('type = (?)',1);
			$select = $select->where('sender_id = (?)', $params['user_id'])->where('receiver_id = (?)', $viewer->getIdentity())->where('receiver_status =1');
			$select = $select->orwhere('sender_id = (?)', $viewer->getIdentity())->where('receiver_id = (?)', $params['user_id'])->where('sender_status =1');
			$select = $select->order('creation_date DESC');
			return $select;
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

	public function autoupdate($reciver_id,$sender_id)
	{
		$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
		$select = $table->select();
		$select=$select->where('sender_id = (?)',$sender_id)->where('receiver_id = (?)',$reciver_id)->where('receiver_status =0');
		$select=$select->order( 'messages_id DESC' )->query()->fetchAll();
		return $select;
	}

	public function getShareMediaSelect($params = array())
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if(isset($params['type']) && $params['type']==2)  // 2 means group messages
		{
			$messages_ids=Engine_Api::_()->emessages()->getuseroldmessagesid($params['user_id'],$viewer->getIdentity());
			$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
			$select = $table->select();
			$select = $select->where('type = (?)',2)->where('receiver_id = (?)', $params['user_id'])->where('image_id IS NOT NULL');
			if(isset($params['starting_id']) && !empty($params['starting_id']))
			{
				$select = $select->where('messages_id > (?)',$params['starting_id'])->orwhere('messages_id in (?)', $messages_ids);
			}
			if(isset($params['end_id']) && !empty($params['end_id']))
			{
				$select = $select->where('messages_id < (?)',$params['end_id'])->orwhere('messages_id in (?)', $messages_ids);
			}
			$select = $select->order('creation_date DESC');
			return $select;
		}
		else
		{
			$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
			$select = $table->select();
			$select = $select->where('sender_id = (?)', $params['user_id'])->where('receiver_id = (?)', $viewer->getIdentity())->where('type = (?)',1)->where('image_id IS NOT NULL');
			$select = $select->orwhere('sender_id = (?)', $viewer->getIdentity())->where('receiver_id = (?)', $params['user_id'])->where('type = (?)',1)->where('image_id IS NOT NULL');
			$select = $select->order('creation_date DESC');
			return $select;
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





	public function getMessageForHeader($params = array())
	{
		  $viewer = Engine_Api::_()->user()->getViewer();
		  $list=Engine_Api::_()->emessages()->AllGroupByUser($viewer->getIdentity());
			$table = Engine_Api::_()->getDbtable('messagess', 'emessages');
			$select = $table->select();
			$select = $select->where('sender_id != (?)', $viewer->getIdentity())->where('receiver_status !=2')->where('status !=2')->where('receiver_id = (?)', $viewer->getIdentity())->where('type = 1');
			if(!empty($list)) {
				$select = $select->orwhere('type = 2 AND receiver_id in (?)', $list)->where('sender_id != (?)', $viewer->getIdentity());
			}
			$select = $select->order('messages_id DESC');
			return $select;
	}


	public function getNotificationMessagePaginator($params = array())
	{
		$paginator = Zend_Paginator::factory($this->getMessageForHeader($params));
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





}
