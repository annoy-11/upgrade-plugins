<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: MessagesController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_MessagesController extends Core_Controller_Action_Standard
{
	public function indexAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if ($viewer->getIdentity() && Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', Engine_Api::_()->user()->getViewer()->level_id, 'auth')!="none") {
			$this->_helper->content->setEnabled();
		} else {
			return $this->_forward('requireauth', 'error', 'core');
			//throw new Exception('Page not found.');
		}
	}

	public function notificationlistappendAction()
	{
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$page = $this->_getParam('page', 1);
		$this->view->paginator = Engine_Api::_()->getDbTable('messagess', 'emessages')->getNotificationMessagePaginator(array('page' => $page));
	}


	public function addusesuggestAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if( !$viewer->getIdentity() ) {
			$data = null;
		} else {
			$data = array();
			$table = Engine_Api::_()->getItemTable('user');

			$usersAllowed = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', $viewer->level_id, 'auth');

			if( (bool)$this->_getParam('message') && $usersAllowed == "everyone" ) {
				$select = Engine_Api::_()->getDbtable('users', 'user')->select();
				$select->where('user_id <> ?', $viewer->user_id);
			}
			else {
				$select = Engine_Api::_()->user()->getViewer()->membership()->getMembersObjectSelect();
			}

			if( $this->_getParam('includeSelf', false) ) {
				$data[] = array(
					'type' => 'user',
					'id' => $viewer->getIdentity(),
					'guid' => $viewer->getGuid(),
					'label' => $viewer->getTitle() . ' (you)',
					'photo' => $this->view->itemPhoto($viewer, 'thumb.icon'),
					'url' => $viewer->getHref(),
				);
			}
			$blockedUserIds = !$viewer->isAdmin() ? $viewer->getAllBlockedUserIds() : array();
			if( $blockedUserIds ) {
				$select->where('user_id NOT IN(?)', (array) $blockedUserIds);
			}
			$not_seen_user_id=Engine_Api::_()->emessages()->alluseridfornotseen();
			if(isset($not_seen_user_id) && !empty($not_seen_user_id))
			{
				$select->where('user_id NOT IN(?)', (array)$not_seen_user_id);
			}
			if( 0 < ($limit = (int) $this->_getParam('limit', 10)) ) {
				$select->limit($limit);
			}

			if( null !== ($text = $this->_getParam('search', $this->_getParam('value'))) ) {
				$select->where('`'.$table->info('name').'`.`displayname` LIKE ?', '%'. $text .'%');
			}

			$ids = array();
			foreach( $select->getTable()->fetchAll($select) as $friend ) {
				$data[] = array(
					'type'  => 'user',
					'id'    => $friend->getIdentity(),
					'guid'  => $friend->getGuid(),
					'label' => $friend->getTitle(),
					'photo' => $this->view->itemPhoto($friend, 'thumb.icon'),
					'url'   => $friend->getHref(),
				);
				$ids[] = $friend->getIdentity();
				$friend_data[$friend->getIdentity()] = $friend->getTitle();
			}

			// first get friend lists created by the user
			$listTable = Engine_Api::_()->getItemTable('user_list');
			$lists = $listTable->fetchAll($listTable->select()->where('owner_id = ?', $viewer->getIdentity()));
			$listIds = array();
			foreach( $lists as $list ) {
				$listIds[] = $list->list_id;
				$listArray[$list->list_id] = $list->title;
			}

			// check if user has friend lists
			if( $listIds ) {
				// get list of friend list + friends in the list
				$listItemTable = Engine_Api::_()->getItemTable('user_list_item');
				$uName = Engine_Api::_()->getDbtable('users', 'user')->info('name');
				$iName  = $listItemTable->info('name');

				$listItemSelect = $listItemTable->select()
					->setIntegrityCheck(false)
					->from($iName, array($iName.'.listitem_id', $iName.'.list_id', $iName.'.child_id',$uName.'.displayname'))
					->joinLeft($uName, "$iName.child_id = $uName.user_id")
					//->group("$iName.child_id")
					->where('list_id IN(?)', $listIds);

				$listItems = $listItemTable->fetchAll($listItemSelect);

				$listsByUser = array();
				foreach( $listItems as $listItem ) {
					$listsByUser[$listItem->list_id][$listItem->user_id]= $listItem->displayname ;
				}

				foreach ($listArray as $key => $value){
					if (!empty($listsByUser[$key])){
						$data[] = array(
							'type' => 'list',
							'friends' => $listsByUser[$key],
							'label' => $value,
						);
					}
				}
			}
		}

		if( $this->_getParam('sendNow', true) ) {
			return $this->_helper->json($data);
		} else {
			$this->_helper->viewRenderer->setNoRender(true);
			$data = Zend_Json::encode($data);
			$this->getResponse()->setBody($data);
		}
	}


	public function suggestAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!$viewer->getIdentity()) {
			$data = null;
		} else {
			$data = array();
			$table = Engine_Api::_()->getItemTable('user');

			$usersAllowed = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', $viewer->level_id, 'auth');

			if ((bool)$this->_getParam('messages') && $usersAllowed == "everyone") {
				$select = Engine_Api::_()->getDbtable('users', 'user')->select();
				$select->where('user_id <> ?', $viewer->user_id);
			} else {
				$select = Engine_Api::_()->user()->getViewer()->membership()->getMembersObjectSelect();
			}

			if ($this->_getParam('includeSelf', false))
			{
				$data[] = array(
					'type' => 'user',
					'id' => $viewer->getIdentity(),
					'guid' => $viewer->getGuid(),
					'label' => $viewer->getTitle() . ' (you)',
					'photo' => $this->view->itemPhoto($viewer, 'thumb.icon'),
					'url' => $viewer->getHref(),
				);
			}
			$blockedUserIds = !$viewer->isAdmin() ? $viewer->getAllBlockedUserIds() : array();
			if ($blockedUserIds) {
				$select->where('user_id NOT IN(?)', (array)$blockedUserIds);
			}
			$not_seen_user_id=Engine_Api::_()->emessages()->alluseridfornotseen();
			if(isset($not_seen_user_id) && !empty($not_seen_user_id))
			{
				$select->where('user_id NOT IN(?)', (array)$not_seen_user_id);
			}
			$groupid = $this->_getParam('groupid');
			if (isset($groupid) && !empty($groupid) && !empty(Engine_Api::_()->emessages()->AllActiveUserByGroup($groupid)))
			{
				$alluserid = Engine_Api::_()->emessages()->AllActiveUserByGroup($groupid);
				$select = $select->where('engine4_users.user_id NOT IN(?)', $alluserid);
			}

			if (0 < ($limit = (int)$this->_getParam('limit', 10))) {
				$select->limit($limit);
			}
			if (null !== ($text = $this->_getParam('search', $this->_getParam('value')))) {
				$select->where('`' . $table->info('name') . '`.`username` LIKE ?', '%' . $text . '%');
			}

			$ids = array();
			foreach ($select->getTable()->fetchAll($select) as $friend) {
				$data[] = array(
					'type' => 'user',
					'id' => $friend->getIdentity(),
					'guid' => $friend->getGuid(),
					'label' => $friend->getTitle(),
					'photo' => $this->view->itemPhoto($friend, 'thumb.icon'),
					'url' => $friend->getHref(),
				);
				$ids[] = $friend->getIdentity();
				$friend_data[$friend->getIdentity()] = $friend->getTitle();
			}


			// first get friend lists created by the user
			$listTable = Engine_Api::_()->getItemTable('user_list');
			$lists = $listTable->fetchAll($listTable->select()->where('owner_id = ?', $viewer->getIdentity()));
			$listIds = array();
			foreach ($lists as $list) {
				$listIds[] = $list->list_id;
				$listArray[$list->list_id] = $list->title;
			}

			// check if user has friend lists
			if ($listIds) {
				// get list of friend list + friends in the list
				$listItemTable = Engine_Api::_()->getItemTable('user_list_item');
				$uName = Engine_Api::_()->getDbtable('users', 'user')->info('name');
				$iName = $listItemTable->info('name');

				$listItemSelect = $listItemTable->select()
					->setIntegrityCheck(false)
					->from($iName, array($iName . '.listitem_id', $iName . '.list_id', $iName . '.child_id', $uName . '.displayname'))
					->joinLeft($uName, "$iName.child_id = $uName.user_id")
					//->group("$iName.child_id")
					->where('list_id IN(?)', $listIds);

				$listItems = $listItemTable->fetchAll($listItemSelect);

				$listsByUser = array();
				foreach ($listItems as $listItem) {
					$listsByUser[$listItem->list_id][$listItem->user_id] = $listItem->displayname;
				}

				foreach ($listArray as $key => $value) {
					if (!empty($listsByUser[$key])) {
						$data[] = array(
							'type' => 'list',
							'friends' => $listsByUser[$key],
							'label' => $value,
						);
					}
				}
			}
		}

		if ($this->_getParam('sendNow', true)) {
			return $this->_helper->json($data);
		} else {
			$this->_helper->viewRenderer->setNoRender(true);
			$data = Zend_Json::encode($data);
			$this->getResponse()->setBody($data);
		}
	}


// All Code start here for chat
	public function getmessagesAction()
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$viewer = Engine_Api::_()->user()->getViewer();
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$returnarray = array();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['chatuser_id']) && !empty($_POST['chatuser_id']) && isset($_POST['page_id']) && !empty($_POST['page_id']) && isset($_POST['type']) && !empty($_POST['type']) && $viewer) {
			$group=Engine_Api::_()->getItem('emessages_userlist',$_POST['chatuser_id']);
			$searchtext=isset($_POST['searchtext']) && !empty($_POST['searchtext']) ? trim($_POST['searchtext']) : null;
			if (isset($_POST['type']) && $_POST['type'] == 2)
			{
				$returnarray['chat_id']=$_POST['chatuser_id'];
				$returnarray['content'] = Engine_Api::_()->emessages()->allMessage($group->group_id, $_POST['page_id'], $searchtext);
				$returnarray['status'] = 1;
				$returnarray['userstatus'] = Engine_Api::_()->emessages()->userexites($group->group_id, $viewer->getIdentity());
				echo json_encode($returnarray);
				exit();
			}

			$returnarray = array(); // For single user
			$get_user_id = Engine_Api::_()->getItem('emessages_userlist', $_POST['chatuser_id']);
			$data = Engine_Api::_()->getDbTable('userlists', 'emessages')->getMessagePaginator(array('page' => $_POST['page_id'], 'user_id' =>$get_user_id->user_id2,'searchtext'=>$searchtext));
			if (isset($data) && count($data) > 0)
			{
				foreach ($data as $key => $datas) {
				    if(isset($datas["message_id"]) && !empty($datas["message_id"]))
				    {
                    $text = isset($datas['body']) && !empty($datas['body']) ? "<span>" . $datas['body'] . "</span>" : '';
                    $images = Engine_Api::_()->emessages()->getattachment($datas["message_id"]);
					          $delete='';
                    if(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage')) {
	                    $delete = '<div id="transh_delete_' . $datas["message_id"] . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $datas["message_id"] . ')" class="sesbasic_text_light"><span>Delete</span></a></div>';
                    }
					$edit_option=Engine_Api::_()->emessages()->editmessage($datas["message_id"],1);
                    $db->update('engine4_emessages_recipients', array('inbox_read' => 1), array('user_id = ?' => $viewer->getIdentity(), 'inbox_message_id = ?' => $datas["message_id"]));
                    $db->update('engine4_messages_recipients', array('inbox_read' => 1,'inbox_updated'=>date('Y-m-d H:i:s')), array('user_id = ?' => $viewer->getIdentity(), 'inbox_message_id = ?' => $datas["message_id"]));

                    if (isset($datas['user_id']) && $datas['user_id'] != $viewer->getIdentity()) {
                    $status = $db->select()->from('engine4_messages_recipients', array('outbox_deleted'))->where('outbox_message_id = ?', $datas["message_id"])->where('user_id = ?', $viewer->getIdentity())->query()->fetch();
                    if ($status['outbox_deleted'] == 1)
                    {
                        continue;
                    }
                    $edit_delete_text='';
                    if(!empty($delete) || !empty($edit_option))
                    {
                        $edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">'. $edit_option .'' . $delete . '</div></div>';
                    }
	                        
                   	$user = Engine_Api::_()->getItem('user', $group->user_id1);
                    $returnarray[] = '<li class="msg-list-item msg-list-item-out" id="messages_li_' . $datas["message_id"] . '">
						          <div class="msg-list-item-photo">
						              ' .$view->htmlLink($user->getHref(),$view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle()))) . '
						          </div>
						          <div class="msg-list-item-details">
						            <div class="msg-list-item-cont">
						              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '' . $images . '</div>
						               '.$edit_delete_text.'
						            </div>
						            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($datas['date'], false) . '</div>
						          </div>
				          </li>';
                    } else if (isset($datas['user_id']) && $datas['user_id'] == $viewer->getIdentity()) {
                        $status = $db->select()->from('engine4_messages_recipients', array('outbox_deleted'))->where('outbox_message_id = ?', $datas["message_id"])->query()->fetch();

                        $user1 = Engine_Api::_()->getItem('user', $group->user_id2);
                        if ($status['outbox_deleted'] == 1) {
                            $images = '';
                            $text = "<span class='sesbasic_text_light'>" . $user1->getTitle() . " deleted this messages</span>";
                            $delete = '';
                        }
	                        $edit_delete_text='';
	                        if(!empty($delete) || !empty($edit_option))
	                        {
		                        $edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">'. $edit_option .'' . $delete . '</div></div>';
	                        }
                        $returnarray[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $datas["message_id"] . '">
				          <div class="msg-list-item-photo">
				             ' .$view->htmlLink($user1->getHref(), $view->htmlLink($user1->getHref(),$view->itemPhoto($user1, 'thumb.icon', $user1->getTitle()))) . '
				          </div>
				          <div class="msg-list-item-details">
				            <div class="msg-list-item-cont">
				              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '' . $images . '</div>
                      '.$edit_delete_text.'
				            </div>
				            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($datas['date'], false) . '</div>    
				          </div>
				        </li>';
                    }

                }
				}
			}

			$returnarray['content'] = implode(' ', array_reverse($returnarray));
			$returnarray['status'] = 1;
			$returnarray['userstatus'] = Engine_Api::_()->emessages()->checksingleuserblockornot($get_user_id->user_id2);
			$returnarray['chat_id']=$_POST['chatuser_id'];
			$returnarray['total_pages'] = $data->count();
			echo json_encode($returnarray);
			exit();
		}
		$returnarray['status'] = 2;
		echo json_encode($returnarray);
		exit();
	}

	public function setmessagesAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$returnarray = array();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && ((isset($_POST['messages']) && !empty($_POST['messages'])) || (isset($_POST['imageid']) && !empty($_POST['imageid']))) && isset($_POST['chatuser_id']) && isset($_POST['type']) && !empty($_POST['type']) && $viewer->getIdentity())
		{
	           if(empty(trim($_POST['messages'])) && (!isset($_GET['attachment']) || empty($_GET['attachment'])))
	           {
		           $returnarray['status']=2;
		           echo json_encode($returnarray);
		           exit();
	           }

						$checkuser_id = explode(',', $_POST['newuserid']);
						$returnarray['newuser_status']=0;
						if (!empty($_POST['newuserid']) && count($checkuser_id) > 1) // group create
            {
                $newgroup=Engine_Api::_()->emessages()->createGroup($viewer->getIdentity(), $_POST['newuserid']);
                if(!empty($newgroup))
                {
                    $_POST['chatuser_id']=$newgroup;
                    $_POST['type']=2;
                    $returnarray['newuser_status']=1;
                    $returnarray['newuser_id']="g.".$newgroup;
                }
            }
           else if (!empty($_POST['newuserid'])  && count($checkuser_id)==1)   // if user is single
						{
               $newuser=Engine_Api::_()->emessages()->singleusercreate($viewer->getIdentity(), $_POST['newuserid']);
               if(isset($newuser['userlist_id']) && !empty($newuser['userlist_id']))
               {
                   $_POST['chatuser_id']=$newuser['userlist_id'];
                   $_POST['type']=1;
                   $returnarray['newuser_status']=1;
                   $returnarray['newuser_id']=$newuser['userlist_id'];
               }
            }
			$group=Engine_Api::_()->getItem('emessages_userlist', $_POST['chatuser_id']);
			$messages = isset($_POST['messages']) && !empty($_POST['messages']) ? trim($_POST['messages']) : null;
			$messages = nl2br($messages);
			 $gif=0;
			$messagess_forsender='';
			$messagess_forreceiver = '';
			$message_create_id=0;
			$message_create_date='';
			if (!empty($messages) && filter_var($messages, FILTER_VALIDATE_URL) && @getimagesize($messages))
			{
				$gif=1;
				$messages = '<img  src="' . $messages . '" alt="">';
				$messagess_forsender = "GIF";
				$messagess_forreceiver = "GIF";
			}
			if (isset($messages) && !empty($messages))
			{
				$emoticonsTag = Engine_Api::_()->activity()->getEmoticons();
				foreach ($emoticonsTag as $key => $icon)
				{
					$vals = "<img src=\"" . $view->layout()->staticBaseUrl . "application/modules/Activity/externals/emoticons/images/$icon\" class=\"_emojiicon\" border=\"0\"/>";
					$messages = str_replace($key, $vals, $messages);
				}
			}
			if (isset($_POST['messages']) && !empty($_POST['messages']) && $gif==0)
			{
				$messagess_forsender = nl2br(trim($_POST['messages']));
				$messagess_forreceiver = nl2br(trim($_POST['messages']));
			}
			// for group
			if(isset($_POST['type']) && $_POST['type']==2)
			{
				$messages_create = Engine_Api::_()->getDbtable('messages', 'messages')->createRow();
				$messages_create->conversation_id=$group->group_id;
				$messages_create->user_id=$viewer->getIdentity();
				$messages_create->title="Un-title";
				$messages_create->body=$messages;
				$messages_create->date=date('Y-m-d H:i:s');
				$messages_create->attachment_type=null;
				$messages_create->attachment_id=0;
				$messages_create->save();
				$message_create_id=$messages_create->message_id;
				$message_create_date=$messages_create->date;
				$all_userid = Engine_Api::_()->emessages()->AllActiveUserByGroup($group->group_id);
				$file_id=array();
				if(isset($_GET['attachment']) && !empty($_GET['attachment']))
				{
					$messages_attachement=Engine_Api::_()->getDbtable('messageattachments', 'emessages')->createRow();
					$messages_attachement->conversation_id=$_POST['chatuser_id'];
					$messages_attachement->owner_id=$viewer->getIdentity();
					$messages_attachement->message_id=$message_create_id;
					$messages_attachement->created_date=date("Y-m-d H:i:s");
					if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='photo')
					{
			            $attachment=explode(" ",$_GET['attachment']['photo_id']);
			            foreach ($attachment as $at)
			            {
			             	if(!empty($at))
			              	{
				              $item=Engine_Api::_()->getItem('album_photo', $at);
				              $file_id[]=$item->file_id;
			              	}
			            }
						if(isset($attachment[0]) && !empty($attachment[0])) {
								$db->update('engine4_messages_messages', array('attachment_type' => "album_photo", 'attachment_id' => $attachment[0]), array('message_id = ?' => $message_create_id));
						}
	            		$messages_attachement->image_id=implode(',',$file_id);
					}else if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='video' && isset($_GET['attachment']['video_id']))
					{
						$item= Engine_Api::_()->getItem('video', $_GET['attachment']['video_id']);
						$messages_attachement->video_id=$item->file_id;
						$messages_attachement->code=$item->code;
						if(isset($_GET['attachment']['video_id']) && !empty($_GET['attachment']['video_id'])) {
							$db->update('engine4_messages_messages', array('attachment_type' => "video", 'attachment_id' => $_GET['attachment']['video_id']), array('message_id = ?' => $message_create_id));
						}
					}else if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='music' && isset($_GET['attachment']['song_id']))
					{
						$item=Engine_Api::_()->getItem('music_playlist_song', $_GET['attachment']['song_id']);
						$messages_attachement->audio_id=$item->file_id;
						$messages_attachement->audio_title=$item->title;
						if(isset($_GET['attachment']['song_id']) && !empty($_GET['attachment']['song_id'])) {
							$db->update('engine4_messages_messages', array('attachment_type' => "music_playlist_song", 'attachment_id' => $_GET['attachment']['song_id']), array('message_id = ?' => $message_create_id));
						}
					}
					$messages_attachement->save();
				}
				foreach ($all_userid as $userid)
				{
					if($userid > 0 && $userid != $viewer->getIdentity())
					{
						$user_status = Engine_Api::_()->getDbtable('recipients', 'emessages')->createRow();
						$user_status->user_id = $userid;
						$user_status->conversation_id = $group->group_id;
						$user_status->owner_id = $viewer->getIdentity();
						$user_status->message_id = $messages_create->message_id;
						$user_status->inbox_message_id = $messages_create->message_id;
						$user_status->inbox_updated = date("Y-m-d H:i:s");
						$user_status->inbox_read = 0;
						$user_status->inbox_deleted = 0;
						$user_status->outbox_message_id = null;
						$user_status->outbox_updated = null;
						$user_status->outbox_deleted = 0;
						$user_status->created_date = date("Y-m-d H:i:s");
						$user_status->save();
					}
				}
				$owner_status =  Engine_Api::_()->getDbtable('recipients', 'emessages')->createRow();
				$owner_status->user_id=$viewer->getIdentity();
				$owner_status->conversation_id=$group->group_id;
				$owner_status->owner_id=$viewer->getIdentity();
				$owner_status->message_id=$messages_create->message_id;
				$owner_status->inbox_message_id=null;
				$owner_status->inbox_updated=null;
				$owner_status->inbox_read=0;
				$owner_status->inbox_deleted=0;
				$owner_status->outbox_message_id=$messages_create->message_id;
				$owner_status->outbox_updated=date("Y-m-d H:i:s");
				$owner_status->outbox_deleted=0;
				$owner_status->created_date=date("Y-m-d H:i:s");
				$owner_status->save();
				$db->update('engine4_emessages_userlists', array('description' => $messagess_forsender,'modified_date' => date('Y-m-d H:i:s')), array('group_id = ?'=> $group->group_id));
			}else{
				// single users
				$conversations_create = Engine_Api::_()->getDbtable('conversations', 'messages')->createRow();
				$conversations_create->title="Un-title";
				$conversations_create->user_id=$viewer->getIdentity();
				$conversations_create->recipients=1;
				$conversations_create->modified=date('Y-m-d H:i:s');
				$conversations_create->locked=0;
				$conversations_create->recipients=1;
				$conversations_create->resource_type=null;
				$conversations_create->resource_id=0;
				if($conversations_create->save())
				{
					$messages_create = Engine_Api::_()->getDbtable('messages', 'messages')->createRow();
					$messages_create->conversation_id = $conversations_create->conversation_id;
					$messages_create->user_id = $viewer->getIdentity();
					$messages_create->title = "Un-title";
					$messages_create->body = $messages;
					$messages_create->date = date('Y-m-d H:i:s');
					$messages_create->attachment_type = null;
					$messages_create->attachment_id = 0;
					$messages_create->save();
					$message_create_id=$messages_create->message_id;
					$message_create_date=$messages_create->date;

					$recipients_create1 = Engine_Api::_()->getDbtable('recipients', 'messages')->createRow();
					$recipients_create1->conversation_id=$conversations_create->conversation_id;
					$recipients_create1->user_id=$viewer->getIdentity();
					$recipients_create1->inbox_message_id=null;
					$recipients_create1->inbox_updated=null;
					$recipients_create1->inbox_read=null;
					$recipients_create1->inbox_deleted=null;
					$recipients_create1->outbox_message_id=$messages_create->message_id;
					$recipients_create1->outbox_updated=date("Y-m-d H:i:s");
					$recipients_create1->outbox_deleted=0;
					$recipients_create1->save();

					$recipients_create2 = Engine_Api::_()->getDbtable('recipients', 'messages')->createRow();
					$recipients_create2->user_id=$group->user_id2;
					$recipients_create2->conversation_id=$conversations_create->conversation_id;
					$recipients_create2->inbox_message_id=$messages_create->message_id;
					$recipients_create2->inbox_updated=date("Y-m-d H:i:s");
					$recipients_create2->inbox_read=0;
					$recipients_create2->inbox_deleted=0;
					$recipients_create2->outbox_message_id=0;
					$recipients_create2->outbox_updated=null;
					$recipients_create2->outbox_deleted=0;
					$recipients_create2->save();
					$db->update('engine4_emessages_userlists', array('status'=>1,'description' => $messagess_forsender,'modified_date' => date('Y-m-d H:i:s')), array('user_id1 = ?'=>$viewer->getIdentity(),'user_id2 = ?'=>$group->user_id2));
					$db->update('engine4_emessages_userlists', array('status'=>1,'description' => $messagess_forreceiver,'modified_date' => date('Y-m-d H:i:s')), array('user_id2 = ?'=>$viewer->getIdentity(),'user_id1 = ?'=>$group->user_id2));

					$file_id=array();
					if(isset($_GET['attachment']) && !empty($_GET['attachment']))
					{
						$messages_attachement=Engine_Api::_()->getDbtable('messageattachments', 'emessages')->createRow();
						$messages_attachement->conversation_id=$_POST['chatuser_id'];
						$messages_attachement->owner_id=$viewer->getIdentity();
						$messages_attachement->message_id=$message_create_id;
						$messages_attachement->created_date=date("Y-m-d H:i:s");
						if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='photo')
						{
							$attachment=explode(" ",$_GET['attachment']['photo_id']);
							foreach ($attachment as $at)
							{
								if(!empty($at))
								{
									$item=Engine_Api::_()->getItem('album_photo', $at);
									$file_id[]=$item->file_id;
								}
							}
							if(isset($attachment[0]) && !empty($attachment[0])) {
								$db->update('engine4_messages_messages', array('attachment_type' => "album_photo", 'attachment_id' => $attachment[0]), array('message_id = ?' => $message_create_id));
							}
							$messages_attachement->image_id=implode(',',$file_id);
						}else if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='video' && isset($_GET['attachment']['video_id']))
						{
							$item= Engine_Api::_()->getItem('video', $_GET['attachment']['video_id']);
							$messages_attachement->video_id=$item->file_id;
							$messages_attachement->code=$item->code;
							if(isset($_GET['attachment']['video_id']) && !empty($_GET['attachment']['video_id'])) {
								$db->update('engine4_messages_messages', array('attachment_type' => "video", 'attachment_id' => $_GET['attachment']['video_id']), array('message_id = ?' => $message_create_id));
							}
						}else if(isset($_GET['attachment']['type']) && strtolower($_GET['attachment']['type'])=='music' && isset($_GET['attachment']['song_id']))
						{
							$item=Engine_Api::_()->getItem('music_playlist_song', $_GET['attachment']['song_id']);
							$messages_attachement->audio_id=$item->file_id;
							$messages_attachement->audio_title=$item->title;
							if(isset($_GET['attachment']['song_id']) && !empty($_GET['attachment']['song_id'])) {
								$db->update('engine4_messages_messages', array('attachment_type' => "music_playlist_song", 'attachment_id' => $_GET['attachment']['song_id']), array('message_id = ?' => $message_create_id));
							}
						}
						$messages_attachement->save();
					}
				}
			}
			$user = Engine_Api::_()->getItem('user', $viewer->getIdentity());
			$text = isset($messages) && !empty($messages) ? "<span>" .$messages. "</span>" : '';
			$images =Engine_Api::_()->emessages()->getattachment($message_create_id);
			$returnarray['status'] = 1;
			$delete='';
			if(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage')) {
				$delete='<div  id="transh_delete_' .$message_create_id . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $message_create_id . ')" class="sesbasic_text_light"><span>Delete</span></a></div>';
			}
			$edit_option=Engine_Api::_()->emessages()->editmessage($message_create_id,$_POST['type']);
			$edit_delete_text='';
			if(!empty($delete) || !empty($edit_option))
			{
				$edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">'. $edit_option .'' . $delete . '</div></div>';
			}
			$returnarray['content'] = '<li class="msg-list-item msg-list-item-out"  id="messages_li_' . $message_create_id . '">
							          <div class="msg-list-item-photo">
							          ' . $view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle())) . '
							          </div>
							          <div class="msg-list-item-details">
							            <div class="msg-list-item-cont">
							              <div class="msg-list-item-body" id="messagesdisplay_' . $message_create_id . '">' . $text . '' . $images . '</div>
							              '.$edit_delete_text.'
							            </div>
							            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($message_create_date, false) . '</div>
							          </div>
					          </li>';
			$returnarray['user_des'] =  $messagess_forsender;
			$returnarray['user_id'] = isset($_POST['chatuser_id']) ? trim($_POST['chatuser_id']) : 0;
			$returnarray['user_date'] = Engine_Api::_()->emessages()->TimeAgo($message_create_date, false);
			echo json_encode($returnarray);
			exit();
		}
		$returnarray['status'] = 0;
		echo json_encode($returnarray);
		exit();
	}

	public function setimagesAction()
	{
		$returnarray = array();
		if (!empty($_FILES['file']['name'])) {
			$file_ext = pathinfo($_FILES['file']['name']);
			$file_ext = $file_ext['extension'];
			$storage = Engine_Api::_()->getItemTable('storage_file');
			$storageObject = $storage->createFile($_FILES['file'], array(
				'parent_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
				'parent_type' => Engine_Api::_()->user()->getViewer()->getType(),
				'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
			));
			// Remove temporary file
			@unlink($file['tmp_name']);
			$file = Engine_Api::_()->getItemTable('storage_file')->getFile($storageObject->file_id, null);
			$returnarray['status'] = 1;
			$returnarray['id'] = $storageObject->file_id;
			$returnarray['image_path'] = $file->map();
			echo json_encode($returnarray);
			exit();
		}
		$returnarray['status'] = 0;
		echo json_encode($returnarray);
		exit();

	}


	public function autoupdateAction()
	{
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['selecteduserid']) && !empty($_POST['selecteduserid']) && isset($_POST['type']) && !empty($_POST['type'])) {
			$return = array();
			$returnarray = array();
			$returnarray['status'] = 0;
			$group = Engine_Api::_()->getItem('emessages_userlist', $_POST['selecteduserid']);
			if ($_POST['type'] == 2) {
				// if group
				$datas = $db->select()->from('engine4_emessages_recipients', array('message_id'))->where('user_id = ? ', $viewer->getIdentity())->where('conversation_id = ? ', $group->group_id)->where('inbox_read = 0 AND inbox_message_id is not null AND outbox_message_id is null')->order('message_id ASC')->query()->fetchAll();
				if(!empty($datas)) {
					foreach ($datas as $data) {
						if (isset($data) && !empty($data)) {
							$returnarray['status'] = 1;
							$message = $db->select()->from('engine4_messages_messages')->where('message_id =?', $data['message_id'])->query()->fetch();
							$user = Engine_Api::_()->getItem('user', $message['user_id']);
							$text = isset($message['body']) ? trim($message['body']) : '';
							$images = Engine_Api::_()->emessages()->getattachment($data["message_id"]);
							$delete = '';
							if (Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage')) {
								$delete = '<div id="transh_delete_' . $datas["message_id"] . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $datas["message_id"] . ')" class="sesbasic_text_light" ><span>Delete</span></a></div>';
							}
							$edit_option = Engine_Api::_()->emessages()->editmessage($data["message_id"], 2);

							$edit_delete_text='';
							if(!empty($delete) || !empty($edit_option))
							{
								$edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">' . $edit_option . '' . $delete . '</div></div>';
							}

							$return[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $data["message_id"] . '">
				          <div class="msg-list-item-photo">
				           ' .$view->htmlLink($user->getHref(),$view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle()))) . '
				          </div>
				          <div class="msg-list-item-details">
				            <div class="msg-list-item-cont">
				              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '' . $images . '</div>
				            '.$edit_delete_text.'
				            </div>
				            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($message['date'], false) . '</div>    
				          </div>
				        </li>';
							$db->update('engine4_emessages_recipients', array('inbox_read' => 1), array('conversation_id = ?' => $group->group_id, 'user_id = ?' => $viewer->getIdentity(), 'inbox_read = 0'));
							$db->update('engine4_messages_recipients', array('inbox_read' => 1), array('conversation_id = ?' => $group->group_id, 'user_id = ?' => $viewer->getIdentity(), 'inbox_read = 0'));
						}
					}
					$returnarray['content'] = implode('', array_reverse($return));
					$returnarray['user_date'] = Engine_Api::_()->emessages()->TimeAgo($group->modified_date, false);
					$returnarray['username'] = Engine_Api::_()->emessages()->groupname($group->group_id);
					$returnarray['user_des'] = Engine_Api::_()->emessages()->groupdescription($group->group_id);
					$returnarray['selecteduserid'] = $_POST['selecteduserid'];
					$returnarray['type'] = $_POST['type'];
					echo json_encode($returnarray);
					exit();
				}

			} else {
				// if single user
				$chat_id = $group->user_id2;
				$viewerid = $viewer->getIdentity();
				$user = Engine_Api::_()->getItem('user', $group->user_id2);
				$datas = $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_recipients.inbox_read = 0  AND engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC')->query()->fetchAll();
				if(!empty($datas)) {
					foreach ($datas as $data) {
						$returnarray['status'] = 1;
						$text = isset($data['body']) && !empty($data['body']) ? "<span>" . $data['body'] . "</span>" : '';
						$images = Engine_Api::_()->emessages()->getattachment($data["message_id"]);
						$delete = '';
						if (Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage')) {
							$delete = ' <div id="transh_delete_' . $data["message_id"] . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $data["message_id"] . ')" class="sesbasic_text_light"><span>Delete</span></a></div>';
						}
						$edit_option = Engine_Api::_()->emessages()->editmessage($data["message_id"], 1);
						$edit_delete_text='';
						if(!empty($delete) || !empty($edit_option))
						{
							$edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">' . $edit_option . '' . $delete . '</div></div>';
						}
						$return[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $data["message_id"] . '">
				          <div class="msg-list-item-photo">
				           ' . $view->itemPhoto($user, 'thumb.icon', $user->getTitle()) . '
				          </div>
				          <div class="msg-list-item-details">
				            <div class="msg-list-item-cont">
				              <div class="msg-list-item-body" id="messagesdisplay_' . $data["message_id"] . '">' . $text . '' . $images . '</div>
				              '.$edit_delete_text.'
				            </div>
				            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($data['inbox_updated'], false) . '</div>    
				          </div>
				        </li>';
						$db->update('engine4_messages_recipients', array('inbox_read' => 1), array('inbox_message_id = ?' => $data["message_id"], 'user_id = ?' => $viewer->getIdentity(), 'inbox_read = 0'));
					}
					$returnarray['username'] = $user->getTitle();
					$returnarray['user_des'] = isset($group->description) && !empty($group->description) ? strlen($group->description) > 30 ? substr($group->description, 0, 30) . " ..." : $group->description : '';
					$returnarray['user_date'] = isset($group->modified_date) && !empty($group->modified_date) ? Engine_Api::_()->emessages()->TimeAgo($group->modified_date, false) : '';
					$returnarray['selecteduserid'] = $_POST['selecteduserid'];
					$returnarray['type'] = $_POST['type'];
					$returnarray['content'] = implode(' ', array_reverse($return));
					echo json_encode($returnarray);
					exit();
				}
				echo json_encode($returnarray);
				exit();
			}
		}
			else {
			throw new Exception('Page not found.');
		}
	}


	public function autoupdatealluserAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		$returnarray = array();
		$status = 0;
		$c = 0;
		if ($viewer->getIdentity()) {
			$alluser = Engine_Api::_()->emessages()->getAllUser($viewer->getIdentity());
			if (count($alluser) > 0) {
				foreach ($alluser as $user)
				{
                   if($user['type']==1)
                    {
                        $chatuser_id=$user['user_id2'];
                        $viewerid = $viewer->getIdentity();
                     $newmessage=$db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_recipients.outbox_deleted = 0  AND engine4_messages_messages.user_id = $chatuser_id AND engine4_messages_recipients.user_id = $viewerid AND engine4_messages_recipients.inbox_read = 0 AND  engine4_messages_recipients.inbox_message_id is not null")->order('engine4_messages_messages.message_id DESC')->query()->fetch();
                       if(isset($newmessage['message_id']) && !empty($newmessage['message_id']) && isset($newmessage['inbox_updated']))
                       {
                           $status=1;
                           $returnarray[$c]['selecteduserid']=$user['userlist_id'];
                           $returnarray[$c]['message_id']=$newmessage['inbox_message_id'];
                           $returnarray[$c]['user_des']=$user['description'];
                           $returnarray[$c]['type']=1;
                           $returnarray[$c]['time']=Engine_Api::_()->emessages()->TimeAgo($newmessage['inbox_updated'],false);
                           $c++;
                       }
                    }
                   else if($user['type']==2)
                   {
                       $tablevalue=$db->select()->from('engine4_emessages_recipients', array('inbox_updated','inbox_message_id'))->where('inbox_read = 0 AND inbox_message_id is not null AND user_id = ?',$viewer->getIdentity())->where('conversation_id =?',$user['group_id'])->order('inbox_message_id DESC')->query()->fetch();
                       if(isset($tablevalue['inbox_message_id']) && !empty($tablevalue['inbox_message_id']) && isset($tablevalue['inbox_message_id']))
                       {
                           $status=1;
                           $returnarray[$c]['type']=2;
                           $returnarray[$c]['selecteduserid']=$user['userlist_id'];
                           $returnarray[$c]['message_id']=$tablevalue['inbox_message_id'];
                           $returnarray[$c]['user_des']= Engine_Api::_()->emessages()->returndescription(Engine_Api::_()->emessages()->groupdescription($user['group_id']));
                           $returnarray[$c]['time']=Engine_Api::_()->emessages()->TimeAgo($tablevalue['inbox_updated'],false);
                           $c++;
                       }

                   }
				}
			}
			$returnarray['status'] = $status;
			$returnarray['totallength'] = $c;
			echo json_encode($returnarray);
			exit();
		} else {
			throw new Exception('Page not found.');
		}
	}

	public function deletemessagesAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity()  && isset($_POST['message_id']) && !empty($_POST['message_id']) && isset($_POST['type']) && !empty($_POST['type']))
		{
			$returnarray = array();
			$returnarray['status'] = 0;
			$db = Engine_Db_Table::getDefaultAdapter();
			$messages = $db->select()->from('engine4_messages_messages')->where('message_id =?', $_POST['message_id'])->query()->fetch();
			if (isset($_POST['type']) && trim($_POST['type']) == 2)
			{
				if ($viewer->getIdentity() == $messages['user_id'])
				{
					$db->update('engine4_emessages_recipients', array('outbox_deleted' => 1), array('outbox_message_id = ?' =>$_POST['message_id']));
					$db->update('engine4_messages_recipients', array('outbox_deleted' => 1), array('outbox_message_id = ?' =>$_POST['message_id']));
					$returnarray['status'] = 1;
					echo json_encode($returnarray);
					exit();
				}
				else
					{
					$db->update('engine4_emessages_recipients', array('inbox_deleted' => 1), array('inbox_message_id = ?' =>$_POST['message_id']));
					$db->update('engine4_messages_recipients', array('inbox_deleted' => 1), array('inbox_message_id = ?' =>$_POST['message_id']));
						$returnarray['status'] = 1;
						echo json_encode($returnarray);
						exit();
					}
				}
			else if (isset($_POST['message_id']) &&  isset($_POST['type']) && trim($_POST['type']) == 1) {
				if ($viewer->getIdentity() == $messages['user_id']) {
					$db->update('engine4_messages_recipients', array('outbox_deleted' => 1), array('outbox_message_id = ?' =>$_POST['message_id']));
					$returnarray['status'] = 1;
					echo json_encode($returnarray);
					exit();
				} else {
					$db->update('engine4_messages_recipients',array('inbox_deleted' => 1), array('inbox_message_id = ?'=>$_POST['message_id']));
					$returnarray['status'] = 1;
					echo json_encode($returnarray);
					exit();
				}
			}
			echo json_encode($returnarray);
			exit();
		} else {
			throw new Exception('Page not found.');
		}
	}

	public function deletemessageslistAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['selecteduserid']) && !empty($_POST['selecteduserid']) && isset($_POST['type']) && !empty($_POST['type'])) {
			$db = Engine_Db_Table::getDefaultAdapter();
			$returnarray = array();
			$c = 0;
            $group=Engine_Api::_()->getItem('emessages_userlist', $_POST['selecteduserid']);
            $returnarray['status'] = 0;
			if ($_POST['type'] == 2)
			{

				$messages = $db->select()->from('engine4_emessages_recipients',array('owner_id','message_id'))->where('conversation_id =?',$group->group_id)->where('outbox_message_id is not null AND outbox_deleted = 1')->order('created_date DESC')->limit(20)->query()->fetchAll();
                foreach ($messages as $messagess)
                {
                    $returnarray['status'] = 1;
                    $user = Engine_Api::_()->getItem('user', $messagess['owner_id']);
                    $returnarray[$c]['messages_id'] = $messagess['message_id'];
                    $returnarray[$c]['messages'] = '<span class="sesbasic_text_light">' . $user->getTitle() . ' deleted this messages</span>';
                    ++$c;
                }

                $returnarray['totallength'] = $c;
                echo json_encode($returnarray);
                exit();
			}
			else
			{
                $chatuser_id=$group->user_id2;
                $viewerid=$viewer->getIdentity();
                $messages=$db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_recipients.outbox_deleted = 1  AND engine4_messages_messages.user_id = $chatuser_id AND engine4_messages_recipients.user_id = $viewerid  AND engine4_messages_recipients.outbox_message_id is not null")->order('engine4_messages_messages.message_id DESC')->query()->fetchAll();
                foreach ($messages as $messagess)
                {
                    $returnarray['status'] = 1;
                    $user = Engine_Api::_()->getItem('user', $chatuser_id);
                    $returnarray[$c]['messages_id'] = $messagess['message_id'];
                    $returnarray[$c]['messages'] = '<span class="sesbasic_text_light">' . $user->getTitle() . ' deleted this messages</span>';
                    ++$c;
                }

                $returnarray['totallength'] = $c;
                echo json_encode($returnarray);
                exit();
            }

		} else
		 {
			throw new Exception('Page not found.');
		}
	}


	public function createuserAction()
	{
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['createuser_id']) && !empty($_POST['createuser_id'])) {
			$db = Engine_Db_Table::getDefaultAdapter();
			$returnarray = array();
			$checkuser_id = explode(',', $_POST['createuser_id']);
			if (count($checkuser_id) == 1) {    // if user is single
				$returnarray['status'] = 1;
				$returnarray['user_id'] = trim($_POST['userlist_id']);
				$returnarray['type'] = 1;

				echo json_encode($returnarray);
				exit();

			} else {  //if user in group
				if (count($checkuser_id) > 0) {
					$group_id = Engine_Api::_()->emessages()->createGroup();
					if ($group_id != 0) {
						Engine_Api::_()->emessages()->AddUserInGroup($group_id, $viewer->getIdentity(), null);
						foreach ($checkuser_id as $key => $groupuser) {
							if (!empty($groupuser)) {
								Engine_Api::_()->emessages()->AddUserInGroup($group_id, $groupuser, null);
							}
						}
						$returnarray['status'] = 1;
						$returnarray['userlist'] = Engine_Api::_()->emessages()->groupHtmlCode($group_id);
						$returnarray['user_id'] = $group_id;
						$returnarray['type'] = 2;
						echo json_encode($returnarray);
						exit();
					}
				}
			}
		}
		throw new Exception('Page not found.');
	}

	// All Code start here for share media

	public function allsharemediaAction()
	{
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['chatuser_id']) && !empty($_POST['chatuser_id']) && isset($_POST['type']) && !empty($_POST['type'])) {
			$returnarray = array();
            $group = Engine_Api::_()->getItem('emessages_userlist', $_POST['chatuser_id']);
		//	$userstatus = Engine_Api::_()->emessages()->checksingleuserblockornot($_POST['chatuser_id']);
            $userstatus=1;
			if ($_POST['type'] == 1 && $userstatus == 1) {
				$user = Engine_Api::_()->getItem('user', $group->user_id2);
				$returnarray['username'] = $user->getTitle();
				$returnarray['profileimage'] = $view->itemPhoto($user, 'thumb.profile', $user->getTitle());
				$returnarray['buttontext'] = '<li class="viewprofile"><a href="' . $user->getHref() . '" class="sesbasic_text_hl"><i class="fa fa-eye"></i> <span>View Profile</span></a></li>
		          <li class="blockuser"><a href="' . $view->url(array('controller' => 'block', 'action' => 'add', 'user_id' => $_POST['chatuser_id']), 'user_extended', true) . '" class="sesbasic_text_hl opensmoothboxurl"><i class="fa fa-ban"></i> <span>Block</span></a></li>
		          <li class="deletechat"><a onclick="deleteAllChatForUser(' . $_POST['chatuser_id'] . ')" href="javascript:void(0);" class="sesbasic_text_hl"><i class="fa fa-trash"></i> <span>Delete Conversation</span></a></li>
		          <li class="deletechat"><a onclick="deleteAllChatWithUser(' . $_POST['chatuser_id'] . ')" href="javascript:void(0);" class="sesbasic_text_hl"><i class="fas fa-times"></i> <span>Chat Delete</span></a></li>';
				$returnarray['content'] = Engine_Api::_()->emessages()->getShareMedia($group->user_id2, 1, 1);
				$returnarray['status'] = 1;
				$returnarray['userstatus'] = $userstatus;
				echo json_encode($returnarray);
				exit();
			}
			else if ($_POST['type'] == 2)
			{
				$returnarray['username'] = Engine_Api::_()->emessages()->groupname($group->group_id);
				$returnarray['profileimage'] = '<img src="' . Engine_Api::_()->emessages()->groupimage($group->group_id) . '" alt="">';
				$allUsersthisgroup = Engine_Api::_()->emessages()->AllActiveUserByGroup($group->group_id);
				$allgroupmemberlist = '';
				$groupadmin_id = $group->group_admin;
				$exitornot = Engine_Api::_()->emessages()->userexites($group->group_id, $viewer->getIdentity());
				if ($exitornot == 1)
				{
					foreach ($allUsersthisgroup as $key => $allusers) {
						$user = Engine_Api::_()->getItem('user', $allusers);
						$role = '';
						$button_text = '';
						$addremoveadmin='';
						$user_admin=Engine_Api::_()->getItem('user', $groupadmin_id);
						if (Engine_Api::_()->emessages()->getGroupOwner($group->group_id,$allusers,$groupadmin_id)==1)
						{
							if(Engine_Api::_()->authorization()->getPermission($user_admin->level_id, 'emessages', 'online') && $groupadmin_id!=$allusers && Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'groupadmin'))
							{
								$addremoveadmin="<a href='javascript:void(0);' class='emessages_user_removeadmin' onclick='addremoveadmin(".$group->group_id.", ".$allusers.",0)' ><span>Remove Admin</span></a>";
							}
							$role = "Admin";
						}
						else if (Engine_Api::_()->emessages()->getGroupOwner($group->group_id,$allusers,$groupadmin_id)==0 && Engine_Api::_()->emessages()->getGroupOwner($group->group_id, $viewer->getIdentity(),$groupadmin_id)==1 && Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'groupadmin'))
						{
							$button_text = "<a onclick='removeUserFromGroup(" . $_POST['chatuser_id'] . "," . $allusers . ")' href='javascript:void(0);'><span>Remove</span></a>";
							if(Engine_Api::_()->authorization()->getPermission($user_admin->level_id, 'emessages', 'online') && $groupadmin_id!=$allusers)
							{
								$addremoveadmin="<a href='javascript:void(0);' class='emessages_user_addadmin' onclick='addremoveadmin(".$group->group_id.", ".$allusers.",1)' ><span>Make Admin</span></a>";
							}
						}
						$edit_delete_text='';
						if(!empty($button_text) || !empty($addremoveadmin))
						{
							$edit_delete_text = '<div class="_btns"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-v"></i></a><div class="_btnsoptions">' . $button_text . '  '.$addremoveadmin.'</div></div>';
						}
						$allgroupmemberlist .= '<li id="userlist_forsocialmedia_' . $allusers . '"><div class="_thumb">' . $view->itemPhoto($user, 'thumb.icon', $user->getTitle()) . '</div><div class="_info"><p class="_infoname">' . $user->getTitle() . '</p><p class="_role fsmall sesbasic_text_light">' . $role . '</p></div>'.$edit_delete_text.'</li>';
					}
				}
				if (Engine_Api::_()->emessages()->getGroupOwner($group->group_id,$viewer->getIdentity(),$groupadmin_id)==1)
				{
					if ($exitornot == 1)
					{
						$returnarray['buttontext'] =
							'<li class="addmemberforgroup">' . $view->htmlLink(array("route" => 'messages', "module" => 'emessages', "controller" => 'messages', "action" => 'addnewuseringroup', 'id' => $_POST['chatuser_id']), "<i class='fas fa-plus'></i><span>Add Member</span>", array('class'=>'sesbasic_text_hl')) . '</li>
              <li class="changegroupname">' . $view->htmlLink(array("route" => 'messages', "module" => 'emessages', "controller" => 'messages', "action" => 'changegroupname', 'id' => $_POST['chatuser_id']), "<i class='fas fa-pencil-alt'></i><span>Edit Group Info</span>", array('class'=>'sesbasic_text_hl')) . '</li>
		          <li class="blockuser"><a onclick="finalydeletegroup(' . $_POST['chatuser_id'] . ')" href="javascript:void(0);" class="sesbasic_text_hl"><i class="fas fa-trash"></i> <span>Delete Group</span></a></li>';
					}
					else
					{
						$returnarray['buttontext'] = '';
					}
				}
				else
				{
				if ($exitornot == 1)
					{
						$returnarray['buttontext'] = '<li class="viewprofile"><a href="javascript:void(0);" onclick="removeUserFromGroup(' . $_POST['chatuser_id'] . ',' . $viewer->getIdentity() . ')"  class="sesbasic_text_hl"><i class="fas fa-times"></i> <span>Exit from group</span></a></li>';
					}
				else
				{
						$returnarray['buttontext'] = '';
					}
				}
				$returnarray['userstatus'] = $exitornot;
				$returnarray['content'] = Engine_Api::_()->emessages()->getShareMedia($group->group_id, 1, 2);
				$returnarray['status'] = 1;
				$returnarray['allmemberlist'] = $allgroupmemberlist;
				echo json_encode($returnarray);
				exit();
			}
		}
		throw new Exception('Page not found.');
	}

	public function deleteallahatwithuserAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['chatuser_id']) && !empty($_POST['chatuser_id'])) {
			$group=Engine_Api::_()->getItem('emessages_userlist',$_POST['chatuser_id']);
			$group->status=0;
			$group->save();
			$chat_id=$group->user_id2;
			$viewerid = $viewer->getIdentity();
			$allmessageid= $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_messages.user_id = $viewerid AND engine4_messages_recipients.user_id = $chat_id ")->orwhere("engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC')->query()->fetchAll();
			foreach ($allmessageid as $message_id)
			{
				$db->update('engine4_messages_recipients',array('inbox_deleted' => 1,'inbox_updated'=>date("Y-m-d H:i:s")), array('inbox_message_id = ?'=>$message_id['message_id'],'user_id = ?'=>$viewer->getIdentity()));
				$db->update('engine4_messages_recipients',array('outbox_deleted'=> 1), array('outbox_message_id = ?'=>$message_id['message_id'],'user_id = ?'=>$viewer->getIdentity()));

			}
			$returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function sharemediaupdateAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['chatuser_id']) && !empty($_POST['chatuser_id']) && isset($_POST['type']) && !empty($_POST['type']) && isset($_POST['page_id']) && !empty($_POST['page_id'])) {
			$returnarray = array();
			if ($_POST['type'] == 1) {
				$returnarray['content'] = Engine_Api::_()->emessages()->getShareMedia($_POST['chatuser_id'], $_POST['page_id'], $_POST['type']);
				$returnarray['status'] = 1;
				echo json_encode($returnarray);
				exit();
			}
		}
		throw new Exception('Page not found.');
	}

	public function deleteuserfromgroupAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['conversation_id']) && !empty($_POST['conversation_id']) && isset($_POST['user_id']) && !empty($_POST['user_id']))
		{
            $group=Engine_Api::_()->getItem('emessages_userlist',$_POST['conversation_id']);
			$title = Engine_Api::_()->emessages()->groupname($group->group_id);
			$description = Engine_Api::_()->emessages()->groupdescription($group->group_id);
			$image = Engine_Api::_()->emessages()->groupimage($group->group_id);
			$db->update('engine4_emessages_groupusers', array('group_image' => $image, 'group_name' => $title, 'group_description' => $description, 'status' => 0, 'modified_date' => date('Y-m-d H:i:s')), array('group_id = ?' =>$group->group_id, 'user_id = ?' => $_POST['user_id']));
			$returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function deleteallchatforuserAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['chatuser_id']) && !empty($_POST['chatuser_id'])) {
            $group=Engine_Api::_()->getItem('emessages_userlist',$_POST['chatuser_id']);
            $chat_id=$group->user_id2;
            $viewerid = $viewer->getIdentity();
            $allmessageid= $db->select()->from('engine4_messages_messages')->joinUsing('engine4_messages_recipients', 'conversation_id')->where("engine4_messages_messages.user_id = $viewerid AND engine4_messages_recipients.user_id = $chat_id ")->orwhere("engine4_messages_messages.user_id = $chat_id AND engine4_messages_recipients.user_id = $viewerid ")->order('engine4_messages_messages.date DESC')->query()->fetchAll();
            foreach ($allmessageid as $message_id)
            {
                $db->update('engine4_messages_recipients',array('inbox_deleted' => 1,'inbox_updated'=>date("Y-m-d H:i:s")), array('inbox_message_id = ?'=>$message_id['message_id'],'user_id = ?'=>$viewer->getIdentity()));
                $db->update('engine4_messages_recipients',array('outbox_deleted'=> 1), array('outbox_message_id = ?'=>$message_id['message_id'],'user_id = ?'=>$viewer->getIdentity()));

            }
            $returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function addnewuseringroupAction()
	{
		$id = $this->_getParam('id');
		if (empty($id)) {
			throw new Exception('Page not found.');
		}
        $viewer = Engine_Api::_()->user()->getViewer();
        $group=Engine_Api::_()->getItem('emessages_userlist',$id);
        if($viewer->getIdentity()!=$group->group_admin)
        {
            throw new Exception('Page not found.');
        }
		$this->view->form = new Emessages_Form_Newmemberadd();
		$this->view->groupid = $group->group_id;
		$this->view->groupname = $form = Engine_Api::_()->emessages()->groupname($group->group_id);

	}


	public function changegroupnameAction()
	{
		$id = $this->_getParam('id');
		if (empty($id)) {
			throw new Exception('Page not found.');
		}
        $viewer = Engine_Api::_()->user()->getViewer();
        $group=Engine_Api::_()->getItem('emessages_userlist',$id);
        if($viewer->getIdentity()!=$group->group_admin)
        {
            throw new Exception('Page not found.');
        }
		$this->view->form = new Emessages_Form_Create();
		$this->view->groupid = $id;
		$this->view->groupname = $form = Engine_Api::_()->emessages()->groupname($group->group_id);

	}

	public function changegroupnameandimageAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['grouptitle']) && !empty($_POST['grouptitle']) && isset($_POST['groupid']) && !empty($_POST['groupid'])) {
			$db = Engine_Db_Table::getDefaultAdapter();
			if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
				$file_ext = pathinfo($_FILES['file']['name']);
				$file_ext = $file_ext['extension'];
				$storage = Engine_Api::_()->getItemTable('storage_file');
				$storageObject = $storage->createFile($_FILES['file'], array(
					'parent_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
					'parent_type' => Engine_Api::_()->user()->getViewer()->getType(),
					'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
				));
				// Remove temporary file
				@unlink($file['tmp_name']);
				$db->update('engine4_emessages_userlists', array('group_image' => $storageObject->file_id), array('userlist_id = ?' => trim($_POST['groupid'])));
			}
			$db->update('engine4_emessages_userlists', array('title' => trim($_POST['grouptitle'])), array('userlist_id = ?' => trim($_POST['groupid'])));
			echo json_encode(array('status' => 1));
			exit();

		}
	}

	public function editmessageAction()
	{
		$id = $this->_getParam('id');
		if (empty($id)) {
			throw new Exception('Page not found.');
		}
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		$message = $db->select()->from('engine4_messages_messages',array('body'))->where('message_id =?', $id)->where('user_id = ?',$viewer->getIdentity())->where('body is not null')->query()->fetch();
		if(!isset($message['body']) || empty(strip_tags($message['body'])))
		{
			throw new Exception('Page not found.');
		}
		$this->view->form = $form = new Emessages_Form_Editmessage();
		$this->view->message_id = $id;
		$this->view->message_text = strip_tags($message['body']);
		$form->populate(array(
			'message_id' => $id,
			'message_text' => strip_tags($message['body']),
		));

	}

	public function editmessagetextAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		$returnarray=array();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['message_id']) && !empty($_POST['message_id']) && isset($_POST['message_text']) && !empty($_POST['message_text'])) {
			$db->update('engine4_messages_messages', array('body' =>trim($_POST['message_text'])), array('message_id = ?' => $_POST['message_id'], 'user_id = ?' => $viewer->getIdentity()));
			$returnarray['status']=1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function adduseringroupAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['group_id']) && !empty($_POST['group_id'])) {
			$checkuser_id = explode(',', $_POST['user_id']);
			foreach ($checkuser_id as $key => $groupuser) {
				if (!empty($groupuser)) {
					Engine_Api::_()->emessages()->AddUserInGroup($_POST['group_id'], $groupuser);
				}
			}
			$returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function addremoveadminAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		$returnarray=array();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['group_id']) && !empty($_POST['group_id'])&& isset($_POST['type']))
		{
			$db->update('engine4_emessages_groupusers', array('group_admin' =>trim($_POST['type'])), array('user_id = ?' =>trim($_POST['user_id']), 'group_id = ?' =>trim($_POST['group_id'])));
			$returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

  public function getuserlistidAction()
  {
	  $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
	  $viewer = Engine_Api::_()->user()->getViewer();
	  $db = Engine_Db_Table::getDefaultAdapter();
	  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['user_id']) && !empty($_POST['user_id']))
	  {
		  $returnarray = array(); // For single user
		  $data = Engine_Api::_()->getDbTable('userlists', 'emessages')->getMessagePaginator(array('page' => $_POST['page_id'], 'user_id' =>$_POST['user_id']));
		  if (isset($data) && count($data) > 0)
		  {
			  foreach ($data as $key => $datas) {
				  if(isset($datas["message_id"]) && !empty($datas["message_id"]))
				  {
					  $text = isset($datas['body']) && !empty($datas['body']) ? "<span>" . $datas['body'] . "</span>" : '';
					  $images = Engine_Api::_()->emessages()->getattachment($datas["message_id"]);
					  $delete='';
					  if(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage')) {
						  $delete = '<div id="transh_delete_' . $datas["message_id"] . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $datas["message_id"] . ')" class="sesbasic_text_light" ><span>Delete</span></a></div>';
					  }
					  $edit_option=Engine_Api::_()->emessages()->editmessage($datas["message_id"],1);
					  $db->update('engine4_emessages_recipients', array('inbox_read' => 1), array('user_id = ?' => $viewer->getIdentity(), 'inbox_message_id = ?' => $datas["message_id"]));
					  $db->update('engine4_messages_recipients', array('inbox_read' => 1,'inbox_updated'=>date('Y-m-d H:i:s')), array('user_id = ?' => $viewer->getIdentity(), 'inbox_message_id = ?' => $datas["message_id"]));

					  if (isset($datas['user_id']) && $datas['user_id'] != $viewer->getIdentity()) {
						  $status = $db->select()->from('engine4_messages_recipients', array('inbox_deleted'))->where('inbox_message_id = ?', $datas["message_id"])->where('user_id = ?', $viewer->getIdentity())->query()->fetch();
						  if ($status['inbox_deleted'] == 1)
						  {
							  continue;
						  }

						  $edit_delete_text='';
						  if(!empty($delete) || !empty($edit_option))
						  {
							  $edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">'. $edit_option .'' . $delete . '</div></div>';
						  }
						  $user = Engine_Api::_()->getItem('user', $datas['user_id']);
						  $returnarray[] = '<li class="msg-list-item msg-list-item-out">
							          <div class="msg-list-item-photo">
							              ' . $view->itemPhoto($user, 'thumb.icon', $user->getTitle()) . '
							          </div>
							          <div class="msg-list-item-details">
							            <div class="msg-list-item-cont">
							              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '' . $images . '</div>
						              '.$edit_delete_text.'
							            </div>
							            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($datas['date'], false) . '</div>
							          </div>
					          </li>';
					  } else if (isset($datas['user_id']) && $datas['user_id'] == $viewer->getIdentity()) {
						  $status = $db->select()->from('engine4_messages_recipients', array('outbox_deleted'))->where('outbox_message_id = ?', $datas["message_id"])->query()->fetch();

						  $user = Engine_Api::_()->getItem('user', $datas['user_id']);
						  if ($status['outbox_deleted'] == 1) {
							  $images = '';
							  $text = "<span class='sesbasic_text_light'>" . $user->getTitle() . " deleted this messages</span>";
							  $delete = '';
						  }
						  $edit_delete_text='';
						  if(!empty($delete) || !empty($edit_option))
						  {
							  $edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">'. $edit_option .'' . $delete . '</div></div>';
						  }
						  $returnarray[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $datas["message_id"] . '">
				          <div class="msg-list-item-photo">
				             ' . $view->itemPhoto($user, 'thumb.icon', $user->getTitle()) . '
				          </div>
				          <div class="msg-list-item-details">
				            <div class="msg-list-item-cont">
				              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '' . $images . '</div>
                      '.$edit_delete_text.'
				            </div>
				            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($datas['date'], false) . '</div>    
				          </div>
				        </li>';
					  }

				  }
			  }
		  }
		  $returnarray['content'] = implode(' ', array_reverse($returnarray));
		  $returnarray['status'] = 1;
		  $returnarray['userstatus'] = Engine_Api::_()->emessages()->checksingleuserblockornot($_POST['user_id']);
		  $returnarray['chat_id']=$_POST['user_id'];
		  echo json_encode($returnarray);
		  exit();
	  }
  }

  public function getidforsearchAction()
  {
	  $viewer = Engine_Api::_()->user()->getViewer();
	  $db = Engine_Db_Table::getDefaultAdapter();
	  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['text']))
	  {
     $return_id=array();
     $count=0;
		  $messages=$db->select()->from('engine4_messages_messages',array('message_id','user_id'))->where('body  LIKE ? ', '%' .trim($_POST['text']). '%')->query()->fetchAll();
		  foreach ($messages as $message)
		  {
		  	$m_id=$message['message_id'];
			  $singleuser=$db->select()->from('engine4_messages_recipients')->where('user_id = ?',$viewer->getIdentity())->where("(inbox_message_id = $m_id AND inbox_deleted = 0) or (outbox_message_id = $m_id AND outbox_deleted = 0)")->query()->fetchColumn();
			  $group=$db->select()->from('engine4_emessages_recipients',array('conversation_id'))->where("(inbox_message_id = $m_id AND inbox_deleted = 0) or (outbox_message_id = $m_id AND outbox_deleted = 0)")->query()->fetch();
			  if($singleuser)
			  {
			  	   $u_id='';
            if($viewer->getIdentity()!=$singleuser['user_id'])
            {
	            $u_id=$singleuser['user_id'];
            }
            else
            {
	            $singleuser=$db->select()->from('engine4_messages_recipients',array('user_id'))->where('user_id != ?',$viewer->getIdentity())->where("(inbox_message_id = $m_id AND inbox_deleted = 0) or (outbox_message_id = $m_id AND outbox_deleted = 0)")->query()->fetch();
	            if(isset($singleuser['user_id']) && !empty($singleuser['user_id']))
	            {
		            $u_id=$singleuser['user_id'];
	            }
            }
            if(!empty($u_id))
            {
	            $userlist=$db->select()->from('engine4_emessages_userlists',array('userlist_id'))->where('user_id1 = ? ',$viewer->getIdentity())->where('user_id2 = ? ',$u_id)->query()->fetch();
	            if(isset($userlist['userlist_id']) && !empty($userlist['userlist_id']))
	            {
		            if(!in_array($userlist['userlist_id'], $return_id))
		            {
			            $return_id[]=$userlist['userlist_id'];
			            ++$count;
		            }
	            }

            }
			  }
			  if(isset($group['conversation_id']) && !empty($group['conversation_id']))
			  {
				  $userlist=$db->select()->from('engine4_emessages_userlists',array('userlist_id'))->where('group_id = ? ',$group['conversation_id'])->query()->fetch();
				  if(isset($userlist['userlist_id']) && !empty($userlist['userlist_id']))
				  {
				  	if(!in_array($userlist['userlist_id'], $return_id))
					  {
						  $return_id[]=$userlist['userlist_id'];
						  ++$count;
					  }

				  }
			  }
		  }
	  }
	     $return_id['length']=$count;
	    echo json_encode($return_id);
	    exit();
	  }

	public function deletethisgroupAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['group_id']) && !empty($_POST['group_id'])) {
			$db = Engine_Db_Table::getDefaultAdapter();
			$db->delete('engine4_emessages_userlists', array('userlist_id = ?' => $_POST['group_id'], 'type = ?' => 2));
			$db->delete('engine4_emessages_messagess', array('receiver_id = ?' => $_POST['group_id'], 'type = ?' => 2));
			$db->delete('engine4_emessages_groupuserlists', array('userlist_id = ?' => $_POST['group_id']));
			$db->delete('engine4_emessages_groupmessagesstatuss', array('group_id = ?' => $_POST['group_id']));
			$returnarray = array();
			$returnarray['status'] = 1;
			echo json_encode($returnarray);
			exit();
		}
		throw new Exception('Page not found.');
	}

	public function getimagesurlAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $viewer->getIdentity() && isset($_POST['images_id']) && !empty($_POST['images_id'])) {
			echo Engine_Api::_()->emessages()->getAllImage($_POST['images_id'], 3);
			exit();
		}
		throw new Exception('Page not found.');

	}

}
