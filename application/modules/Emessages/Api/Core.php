<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Emessages_Api_Core extends Core_Api_Abstract
{

	// edit message
	public function editmessage($message_id,$type) // fixed
	{
    $return_text='';
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Db_Table::getDefaultAdapter();
		if(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'editmessage'))
		{
			$message = $db->select()->from('engine4_messages_messages',array('body'))->where('message_id =?', $message_id)->where('user_id = ?',$viewer->getIdentity())->where('body is not null')->query()->fetch();
       if(isset($message['body']) && !empty(strip_tags($message['body'])))
       {
       	if($type==1)
        {
	        $message_status = $db->select()->from('engine4_messages_recipients',array('outbox_deleted'))->where('outbox_message_id =?', $message_id)->where('user_id = ?',$viewer->getIdentity())->query()->fetch();
        }
       	else if($type==2)
       	{
	        $message_status = $db->select()->from('engine4_emessages_recipients',array('outbox_deleted'))->where('outbox_message_id =?', $message_id)->where('user_id = ?',$viewer->getIdentity())->query()->fetch();
        }
       	if(isset($message_status['outbox_deleted']) && $message_status['outbox_deleted']==0)
        {
	        $return_text= '<div>' .$view->htmlLink(array("route" => 'messages', "module" => 'emessages', "controller" => 'messages', "action" => 'editmessage', 'id' => $message_id), "<span>Edit</span>",array('class'=>'edit_message sessmoothbox')) .'</div>' ;        }
       }
		}
		return $return_text;
	}


	// user setting for last seen status
	public	function lastseenstatus($user_id) // fixed
	{
		$return_value=1;
		$viewer = Engine_Api::_()->user()->getViewer();
		$user_message=Engine_Api::_()->getItem('emessages_usersetting',$user_id);
		if(isset($user_message->otherlastseen))
		{
			$return_value=$user_message->otherlastseen;
		}
		return $return_value;
	}

	// user setting for online status
public function onlinestatus($user_id)  // fixed
	{
		$return_value=1;
		$user_message=Engine_Api::_()->getItem('emessages_usersetting',$user_id);
		if(isset($user_message->onlinestatus))
		{
			$return_value=$user_message->onlinestatus;
		}
		return $return_value;
	}

	// All user id for not seen
	public	function alluseridfornotseen()  // fixed
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$users_id=$db->select()->from('engine4_emessages_usersettings',array('user_id'))->where('receivemessage = 0')->query()->fetchAll();
		$return_array=array();
		foreach ($users_id as $user_id)
		{
			$return_array[]=$user_id['user_id'];
		}
		return $return_array;
	}

	// last user login
	public	function userlastlogin($user_id)  // fixed
	{
		$lastlogin='';
		$user = Engine_Api::_()->getItem('user', $user_id);
		$db = Engine_Db_Table::getDefaultAdapter();
		$online_user = $db->select('*')
			->from('engine4_user_online')
			->where('user_id =?', $user_id)
			->where('DATE_FORMAT(active,"%Y-%m-%d") =?', date("Y-m-d"))
			->query()
			->fetchColumn();
			if(Engine_Api::_()->emessages()->lastseenstatus($user_id))
			{
				if($online_user){
					$lastlogin='- Active Now';
				}
				else{
					if(isset($user->lastlogin_date))
					{
						$lastlogin="- ".Engine_Api::_()->emessages()->TimeAgo($user->lastlogin_date, false);
					}
					else
					{
						$lastlogin='';
					}

				}
			}
		return $lastlogin;
	}


	// online user
	public	function onlineclass($user_id) // fixed
	{
		$return_class='';
		$db = Engine_Db_Table::getDefaultAdapter();
		if(Engine_Api::_()->emessages()->onlinestatus($user_id))
		{
			$online_user = $db->select('*')
				->from('engine4_user_online')
				->where('user_id =?', $user_id)
				->where('DATE_FORMAT(active,"%Y-%m-%d") =?', date("Y-m-d"))
				->query()
				->fetchColumn();
			if($online_user){
				$return_class='<i class="emessages_online_icon"></i>';
			}
		}
		return $return_class;
	}



	// Time display all plugin
	public 	function TimeAgo($datetime, $full = false)  // fixed
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public	function updatestatus($group_id) //This will update all groups status in first time  // Fixed
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$conversation=$db->select()->from('engine4_messages_messages',array('message_id','user_id','date'))->where('conversation_id =?',$group_id)->query()->fetchAll();
		if(!empty($conversation))
		{
			foreach ($conversation as $cons)
			{
				$userid=Engine_Api::_()->emessages()->AllActiveUserByGroup($group_id);
				foreach ($userid as $usid)
				{
					$group_status=Engine_Api::_()->getDbtable('recipients', 'emessages')->createRow();
					$group_status->user_id=$usid;
					$group_status->conversation_id=$group_id;
					$group_status->owner_id=$cons['user_id'];
					$group_status->created_date=$cons['date'];
					$group_status->message_id=$cons['message_id'];
					if($usid==$cons['user_id'])
					{
						$group_status->inbox_message_id=null;
						$group_status->inbox_updated=null;
						$group_status->inbox_read=1;
						$group_status->inbox_deleted=0;
						$group_status->outbox_message_id=$cons['message_id'];
						$group_status->outbox_updated=$cons['date'];
						$group_status->outbox_deleted=0;
					}
					else
					{
						$group_status->inbox_message_id=$cons['message_id'];
						$group_status->inbox_updated=$cons['date'];
						$group_status->inbox_read=1;
						$group_status->inbox_deleted=0;
						$group_status->outbox_message_id=null;
						$group_status->outbox_updated=null;
						$group_status->outbox_deleted=0;
					}
					$group_status->save();
				}
			}
		}
	}

	public	function getAllImage($messagesid,$type)// type 1->image, 2->count, 3-> popup images  // Fixed
	{
		$returnImage='';
		$count=0;
		$allimage=explode(',',$messagesid);
		if($type==3 && isset($allimage) && count($allimage)>0)
		{
			$return_array=array();
			foreach ($allimage as $image)
			{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($image, null);
				if($file && !empty($file->map()))
				{
					$return_array[]=$file->map();
				}
			}
			return json_encode($return_array);
		}
		if(isset($allimage) && count($allimage)>0)
		{
			foreach ($allimage as $key=>$image)
			{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($image, null);
				if($file && !empty($file->map()))
				{
					if($count>3) { break; }
					++$count;
					$updatespan='';
					if($count==4 && count($allimage)>5){ $totalcount=count($allimage)-5; $updatespan='<span onclick="displayimages(\''.$messagesid.'\',\''.$key.'\')" class="photo_more"><b>+'.$totalcount.'</b></span>';  }
          $returnImage.='<div class="_thumb"><img onclick="displayimages(\''.$messagesid.'\',\''.$key.'\')" src="'.$file->map().'">'.$updatespan.'</div>';
				}
			}
		}
		return $type==1 ? $returnImage : $count;
	}


	// All user create
  public function getAllUser($viewerid)   // fixed
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		return $db->select()->from('engine4_emessages_userlists')->where("user_id1 = $viewerid AND status=1 ")->orwhere('group_id in (?)', Engine_Api::_()->emessages()->AllGroupByUser($viewerid))->order('modified_date DESC')->query()->fetchAll();
	}


	// Group create
public function createGroup($group_admin,$group_user) // fixed
	{
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $checkuser_id = explode(',',$group_user);
        if(count($checkuser_id)>1)
        {
            $conversation_create = Engine_Api::_()->getDbtable('conversations', 'messages')->createRow();
            $conversation_create->title="Un-title";
            $conversation_create->user_id=$group_admin;
            $conversation_create->recipients=count($checkuser_id);
            $conversation_create->modified=date("Y-m-d H:i:s");
            $conversation_create->resource_type=null;
            $conversation_create->resource_id=0;
            $conversation_create->save();

            $group = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
          //  $group->user_id1 = null;
           // $group->user_id2 = null;
            $group->group_id = $conversation_create->conversation_id;
            $group->title = null;
            $group->description = null;
            $group->group_image = null;
            $group->status = 1;
            $group->type = 2;
            $group->created_date = date('Y-m-d H:i:s');
            $group->modified_date = null;
            $group->group_admin=$group_admin;
            $group->save();
            foreach ($checkuser_id as $g_u_u)
            {
                if(!empty($g_u_u))
                {
                    $group_users = Engine_Api::_()->getDbtable('groupusers', 'emessages')->createRow();
                    $group_users->userlist_id = $group->userlist_id;
                    $group_users->group_id = $conversation_create->conversation_id;
                    $group_users->user_id = $g_u_u;
                    $group_users->created_date = date('Y-m-d H:i:s');
                    $group_users->modified_date = null;
                    $group_users->status = 1;
                    $group_users->save();
                }
            }
            $group_users = Engine_Api::_()->getDbtable('groupusers', 'emessages')->createRow();
            $group_users->userlist_id = $group->userlist_id;
            $group_users->group_id = $conversation_create->conversation_id;
            $group_users->user_id = $group_admin;
            $group_users->created_date = date('Y-m-d H:i:s');
            $group_users->modified_date = null;
            $group_users->status = 1;
            $group_users->save();
            return $group->userlist_id;
        }

	}

	// all user in group
  public function AddUserInGroup($group_id,$user_id)  // fixed
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$returnid=0;
		$db = Engine_Db_Table::getDefaultAdapter();
		$u = $db->select()->from('engine4_emessages_groupusers')->where('group_id =?',$group_id)->where('user_id =?',$user_id)->query()->fetchColumn();
		if(!$u)
		{
      $userlist_id = $db->select()->from('engine4_emessages_userlists',array('userlist_id'))->where('group_id =?',$group_id)->query()->fetch();
      $addingroup = Engine_Api::_()->getDbtable('groupusers', 'emessages')->createRow();
			$addingroup->userlist_id = $userlist_id['userlist_id'];
			$addingroup->group_id = $group_id;
			$addingroup->user_id = $user_id;
		//	$addingroup->title = null;
			$addingroup->status = 1;
			$addingroup->created_date = date("Y-m-d H:i:s");
			$addingroup->modified_date = null;
			$addingroup->status = 1;
			$addingroup->group_name = null;
			$addingroup->group_description = null;
			$addingroup->group_image = null;
			$addingroup->save();
			if ($addingroup->save())
			{
				$returnid = $addingroup->groupuser_id;
			}
		}
		else
		{
			$db->update('engine4_emessages_groupusers', array('status' => 1), array('group_id = ?' => $group_id, 'user_id = ?' => $user_id));
		}
		return $returnid;
	}


	// All converstations by user
	public	function AllConversationByUser($user_id)  // fixed
	{
		$return_array=array();
		if(isset($user_id) && !empty($user_id)) {
			$db = Engine_Db_Table::getDefaultAdapter();
			$cn = $db->select()->from('engine4_messages_recipients', 'conversation_id')->joinUsing('engine4_messages_conversations', 'conversation_id')->where('engine4_messages_conversations.recipients = 1')->where('engine4_messages_recipients.user_id = ?', $user_id)->group('engine4_messages_recipients.conversation_id')->query()->fetchAll();
			foreach ($cn as $cns)
			{
				$return_array[] = $cns['conversation_id'];
			}
		}
		return $return_array;
	}

	// all user id according user setting
	public	function AllUsersByUser($user_id) // fixed
	{
		$return_array=array();
		$return_array[]=$user_id;
		if(isset($user_id) && !empty($user_id)) {
			$db = Engine_Db_Table::getDefaultAdapter();
			$cn = $db->select()->from('engine4_emessages_userlists',array('user_id2'))->where('user_id1 = ?', $user_id)->query()->fetchAll();
			foreach ($cn as $cns)
			{
				$return_array[] = $cns['user_id2'];
			}
		}
		return $return_array;
	}


// We get all group for this user
public function AllGroupByUser($user_id)  // Fixed
	{
		$return_array=array();
		$return_array[]=0;
		 $alluser_id=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('group_id'))->where('user_id =?',$user_id)->query()->fetchAll();
		 foreach ($alluser_id as $ai)
		 {
		 	if(isset($ai['group_id']) && !empty($ai['group_id'])) {
			  $return_array[] = $ai['group_id'];
		  }
		 }
		 return $return_array;
	}

	public	function AllActiveUserByGroup($group_id) // We get all active user in group // fixed
	{
		$return_array=array();
		$alluser_id=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('user_id'))->where('group_id =?',$group_id)->where('status = ?',1)->query()->fetchAll();
		foreach ($alluser_id as $ai)
		{
			if(isset($ai['user_id']) && !empty($ai['user_id'])) {
				$return_array[] = $ai['user_id'];
			}
		}
		return $return_array;
	}

// Display here user exit or not
public function userexites($group_id,$userid)   // fixed
	{
		$alluser_id=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('status'))->where('group_id =?',$group_id)->where('user_id = ?',$userid)->query()->fetch();
		if(!isset($alluser_id['status']))
		{
			return -1;
		}
		return $alluser_id['status'];
	}

	// Display here group name
	public	function groupname($group_id)   // fixed
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$exitornot=Engine_Api::_()->emessages()->userexites($group_id,$viewer->getIdentity());
		if($exitornot==-1)
		{
			return "No Name";
		}
		else if($exitornot==0 || $exitornot==2)
		{
			$groupbyuser=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('group_name'))->where('user_id =?',$viewer->getIdentity())->where('group_id =?',$group_id)->query()->fetch();
			return isset($groupbyuser['group_name']) ? $groupbyuser['group_name'] : '';
		}
		else
		{
			$group=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_userlists',array('title'))->where('group_id =?',$group_id)->query()->fetch();
			if(isset($group['title']) && !empty($group['title']))
			{
				return	strlen($group['title'])>15 ? substr($group['title'], 0, 15)." ..." :  $group['title'];
			}
			$userid=Engine_Api::_()->emessages()->AllActiveUserByGroup($group_id);
			$returnvalue='';
			foreach ($userid as $key=>$user)
			{
				$username = Engine_Api::_()->getItem('user',$user);
				$returnvalue.=$username->getTitle().', ';
				if($key>1 && count($userid)>3)
				{
					$returnvalue=substr($returnvalue, 0, -2);
					$returnvalue.='...';
					return $returnvalue;
				}
			}
			$returnvalue=substr($returnvalue, 0, -1);
			return $returnvalue;
		}
	}
	// Display here group discription
public function groupdescription($group_id)    // fixed
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$exitornot=Engine_Api::_()->emessages()->userexites($group_id,$viewer->getIdentity());
		if($exitornot==-1)
		{
			return " ";
		}
		else if($exitornot==0 || $exitornot==2)
		{
			$groupbyuser=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('group_description'))->where('user_id =?',$viewer->getIdentity())->where('group_id =?',$group_id)->query()->fetch();
			return isset($groupbyuser['group_description']) ? $groupbyuser['group_description'] : '';
		}
		else
		{
			$group=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_userlists',array('description'))->where('group_id =?',$group_id)->query()->fetch();
			if(isset($group['description']) && !empty($group['description']))
			{
				return	(strlen($group['description']) > 30) ? substr($group['description'], 0, 30)." ..." :  $group['description'];
			}
			return '';
		}
	}

	// return here group Image
public function groupimage($group_id)       // fixed
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$exitornot=Engine_Api::_()->emessages()->userexites($group_id,$viewer->getIdentity());
		if($exitornot==-1)
		{
			return './application/modules/Emessages/externals/images/group.png';
		}
		else if($exitornot==0 || $exitornot==2)
		{
			$groupbyuser=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('group_image'))->where('user_id =?',$viewer->getIdentity())->where('group_id =?',$group_id)->query()->fetch();
			return isset($groupbyuser['group_image']) ? $groupbyuser['group_image']  : './application/modules/Emessages/externals/images/group.png';
		}
		else
		{
			$group=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_userlists',array('group_image'))->where('group_id =?',$group_id)->query()->fetch();
			if(isset($group['group_image']) && !empty($group['group_image']))
			{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($group['group_image'], null);
				return	$file->map();
			}
			return "./application/modules/Emessages/externals/images/group.png";
		}
	}



// Get User html code
public	function groupHtmlCode($userlist_id,$group_id)    // fixed
	{
		$group=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_userlists')->where('userlist_id =?',$userlist_id)->query()->fetch();
		$datetime=isset($group['modified_date']) && !empty($group['modified_date']) ? Engine_Api::_()->emessages()->TimeAgo($group['modified_date'],false) : '';
		$return_html='<li class="listofusers sesbasic_clearfix" type="2" username="'.Engine_Api::_()->emessages()->groupname($group_id).'" id="chatuser_id_'.$userlist_id.'" onclick="changeusername(\''.Engine_Api::_()->emessages()->groupname($group_id).'\');displayusermessages('.$userlist_id.',1,2);">
          <div class="item-photo"><img class="thumb-icon" src="'. Engine_Api::_()->emessages()->groupimage($group_id).'" alt=""></div>
          <div class="item-content">
            <div class="item-title clearfix">
              <span class="time sesbasic_text_light fsmall" id="userdate_'.$userlist_id.'">'.$datetime.'</span>
              <h6>'.Engine_Api::_()->emessages()->groupname($group_id).'</h6>
            </div>
            <p class="messages-body fsmall" id="userdescription_'.$userlist_id.'">'. Engine_Api::_()->emessages()->returndescription(Engine_Api::_()->emessages()->groupdescription($group_id)).'</p>
          </div>
        </li>';
		return $return_html;
	}




	// message attachment we get
	public	function getattachment($messages_id,$types = 2)  // fixed
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$attachment=$db->select()->from('engine4_emessages_messageattachments')->where('message_id = ?', $messages_id)->query()->fetch();
		if(isset($attachment['image_id']) && !empty($attachment['image_id']))
		{
        return isset($attachment['image_id']) && !empty($attachment['image_id']) ? "<div class='msg-list-item-body-attachment photo-" . Engine_Api::_()->emessages()->getAllImage($attachment['image_id'], $types) . "'>" . Engine_Api::_()->emessages()->getAllImage($attachment['image_id'], 1) . "</div>" : null;
		}
		else if(((isset($attachment['video_id'])) || (isset($attachment['code']) && !empty($attachment['code']))) && $types!=3)
		{
			if(isset($attachment['code']) && !empty($attachment['code']))
			{
				return '<div class="_video">' .$attachment['code']. '</div>';
			}
			else
			{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($attachment['video_id'], null);
				if($file && !empty($file->map())) {
					return '<div class="_video">'. '<video controls><source src="'.$file->map().'"></video></div>';
				}
			}

		}
		else if(isset($attachment['audio_id']) && !empty($attachment['audio_id'])  && $types!=3)
		{
			$file = Engine_Api::_()->getItemTable('storage_file')->getFile($attachment['audio_id'], null);
			if($file && !empty($file->map())) {
				return '<audio controls><source src="'.$file->map().'">' . $attachment['audio_title'] . '</audio>';
			}
		}
		else
		{
			if(!isset($attachment['message_id']))
			{
				$attachment_update=$db->select()->from('engine4_messages_messages')->where('message_id = ?', $messages_id)->where('attachment_id !=0')->query()->fetch();
				if(isset($attachment_update['attachment_type']) && !empty($attachment_update['attachment_type']) && isset($attachment_update['attachment_id']) && !empty($attachment_update['attachment_id']))
				{
					$messages_attachement=Engine_Api::_()->getDbtable('messageattachments', 'emessages')->createRow();
					$messages_attachement->conversation_id=$attachment_update['conversation_id'];
					$messages_attachement->owner_id=$attachment_update['user_id'];
					$messages_attachement->message_id=$messages_id;
					$messages_attachement->created_date=$attachment_update['date'];
					if(isset($attachment_update['attachment_type']) && strtolower($attachment_update['attachment_type'])=='album_photo' && isset($attachment_update['attachment_id']) && !empty($attachment_update['attachment_id']))
					{
						$attachment=explode(" ",$attachment_update['attachment_id']);
						foreach ($attachment as $at)
						{
							if(!empty($at))
							{
								$item=Engine_Api::_()->getItem('album_photo', $at);
								$file_id[]=$item->file_id;
							}
						}
						$messages_attachement->image_id=implode(',',$file_id);
					}

					else if(isset($attachment_update['attachment_type']) && strtolower($attachment_update['attachment_type'])=='video' && isset($attachment_update['attachment_id']) && !empty($attachment_update['attachment_id']))
					{
						$item= Engine_Api::_()->getItem('video', $attachment_update['attachment_id']);
						$messages_attachement->video_id=$item->file_id;
						$messages_attachement->code=$item->code;
					}

					else if(isset($attachment_update['attachment_type']) && strtolower($attachment_update['attachment_type'])=='music_playlist_song' && isset($attachment_update['attachment_id']) && !empty($attachment_update['attachment_id']))
					{
						$item=Engine_Api::_()->getItem('music_playlist_song', $attachment_update['attachment_id']);
						$messages_attachement->audio_id=$item->file_id;
						$messages_attachement->audio_title=$item->title;
					}
					if($messages_attachement->save())
					{
						return Engine_Api::_()->emessages()->getattachment($messages_id);
					}
				}
			}
		}
	}

// All messages for group only login user
 public function  allMessage($group_id,$page_id,$searchtext)  //fixed
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$returnarray=array();
		if($viewer->getIdentity())
		{
			$check_status=$db->select()->from('engine4_emessages_recipients')->where('conversation_id = ?', $group_id)->query()->fetchColumn();
			if(!$check_status)
			{
				Engine_Api::_()->emessages()->updatestatus($group_id);
			}
    	$db->update('engine4_emessages_recipients', array('inbox_read'=>1,'inbox_updated'=>date('Y-m-d H:i:s')), array('conversation_id = ?' => $group_id, 'user_id = ?' => $viewer->getIdentity(), 'inbox_read = 0'));
    	$db->update('engine4_messages_recipients', array('inbox_read'=>1,'inbox_updated'=>date('Y-m-d H:i:s')), array('conversation_id = ?' => $group_id, 'user_id = ?' => $viewer->getIdentity(), 'inbox_read = 0'));

			$data = Engine_Api::_()->getDbTable('userlists', 'emessages')->getMessagePaginator(array('page' =>$page_id,'type'=>2,'group_id' =>$group_id,'searchtext'=>$searchtext));
			foreach ($data as $datas)
			{
				$owner_status=$db->select()->from('engine4_emessages_recipients',array('outbox_deleted'))->where('conversation_id = ?', $group_id)->where('outbox_message_id = ?',$datas['message_id'])->query()->fetch();
				$text = isset($datas['body']) && !empty($datas['body']) ? "<span>" . $datas['body'] . "</span>" : '';
				$images = Engine_Api::_()->emessages()->getattachment($datas["message_id"]);
				$delete='';
				if(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'emessages', 'deletemessage'))
				{
					$delete = '<div id="transh_delete_' . $datas["message_id"] . '"><a href="javascript:void(0);" onclick="deleteMessage(' . $datas["message_id"] . ')" class="sesbasic_text_light" ><span>Delete</span></a></div>';
				}
				$edit_option=Engine_Api::_()->emessages()->editmessage($datas["message_id"],2);
				if (isset($datas['owner_id']) && $datas['owner_id'] == $viewer->getIdentity() && $datas['outbox_deleted']== 0)
				{
					$edit_delete_text='';
          if(!empty($delete) || !empty($edit_option))
          {
	          $edit_delete_text = ' <div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">' . $edit_option . '' . $delete . '</div></div>';
          }
					$user = Engine_Api::_()->getItem('user', $datas['owner_id']);
					$returnarray[] = '<li class="msg-list-item msg-list-item-out" id="messages_li_' . $datas["message_id"] . '">
							          <div class="msg-list-item-photo">
							            '.$view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle())).'
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
			else	if (isset($datas['owner_id']) && !empty($datas['owner_id']) && $datas['owner_id'] != $viewer->getIdentity() && isset($owner_status['outbox_deleted']) && $owner_status['outbox_deleted']==0 && $datas['inbox_deleted'] == 0)
			{
				$edit_delete_text='';
				if(!empty($delete))
				{
					$edit_delete_text = '<div class="msg-list-item-option"><a href="javascript:void(0);" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a><div class="msg-list-item-option-btns">' . $delete . '</div></div>';
				}
					$user = Engine_Api::_()->getItem('user', $datas['owner_id']);
				    $returnarray[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $datas["message_id"] . '">
				          <div class="msg-list-item-photo">
				            '.$view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle())).'
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
			else if(isset($datas['owner_id']) && $datas['owner_id'] != $viewer->getIdentity() &&  $datas['inbox_deleted'] == 0 &&  isset($owner_status['outbox_deleted']) && $owner_status['outbox_deleted']!=0)
			{
				$user = Engine_Api::_()->getItem('user', $datas['owner_id']);
				$text = "<span class='sesbasic_text_light'>" . $user->getTitle() . " deleted this messages</span>";
				$returnarray[] = '<li class="msg-list-item msg-list-item-in" id="messages_li_' . $datas["message_id"] . '">
				          <div class="msg-list-item-photo">
				            ' .$view->htmlLink($user->getHref(),$view->itemPhoto($user, 'thumb.icon', $user->getTitle())) . '
				          </div>
				          <div class="msg-list-item-details">
				            <div class="msg-list-item-cont">
				              <div class="msg-list-item-body" id="messagesdisplay_' . $datas["message_id"] . '">' . $text . '</div>
				            </div>
				            <div class="time sesbasic_text_light fsmall">' . Engine_Api::_()->emessages()->TimeAgo($datas['date'], false) . '</div>    
				          </div>
				        </li>';
			}
			}
		}
   return implode(' ',array_reverse($returnarray));
	}


 // here we get all share media
 public function getShareMedia($group_or_user_id, $page_id,$type) // fixed
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$sharemedia = Engine_Api::_()->getDbTable('userlists', 'emessages')->getShareMediaPaginator(array('page' => $page_id, 'user_id' => $group_or_user_id, 'type' => $type));
		$returnimage='';
		foreach ($sharemedia as $share)
		{
		    if(isset($share['message_id']) && !empty($share['message_id']))
            {
                $returnimage.= Engine_Api::_()->emessages()->getattachment($share['message_id'],3)  ;
            }
		}
		return $returnimage;

	}

// All image for share media
  public function getAllImageForShareMedia($messagesid)   // not fixed
	{
		$returnImage='';
		$allimage=explode(',',$messagesid);
		if(isset($allimage) && count($allimage)>0)
		{
			foreach ($allimage as $image)
			{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($image, null);
				if($file && !empty($file->map()))
				{
					$returnImage.='<li><span><a href="javascript:void(0);"><img onclick="sharemediapopup(\''.$file->map().'\')" class="totalimagesupload" src="'.$file->map().'"></a></span></li>';
				}
			}
		}
		return $returnImage;
	}

   // here we got user block or not
	public function checksingleuserblockornot($userid) // fixed
	{
		$view = Engine_Api::_()->user()->getViewer();
		$user = Engine_Api::_()->getItem('user', $userid);
		$viewer = Engine_Api::_()->getItem('user', $view->getIdentity());
		if(!$viewer->isBlockedBy($user) && !$user->isBlockedBy($viewer))
		{
          return 1;
		}
		return 0;

	}


	public function singleusercreate($user_id1,$user_id2) // single user create //fixed  // user_id1 is viewerid
    {
        $db = Engine_Db_Table::getDefaultAdapter();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $user = Engine_Api::_()->getItem('user', $user_id2);
        $userdetails1 = $db->select()->from('engine4_emessages_userlists')->where('user_id1 =?', $user_id1)->where('user_id2 =?', $user_id2)->query()->fetchColumn();
        $returnarray = array();
        if (!$userdetails1)
        {
            $users1 = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
            $users1->user_id1 = $user_id1;
            $users1->user_id2 = $user_id2;
            $users1->group_id = null;
            $users1->title = null;
            $users1->description = null;
            $users1->group_image = null;
            $users1->status = 1;
            $users1->type = 1;
            $users1->created_date = date('Y-m-d H:i:s');
            $users1->modified_date = null;
            $users1->save();
        }
        $userdetails2 = $db->select()->from('engine4_emessages_userlists')->where('user_id1 =?',$user_id2)->where('user_id2 =?', $user_id1)->query()->fetchColumn();
        if (!$userdetails2)
        {
            $users2 = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
            $users2->user_id1 = $user_id2;
            $users2->user_id2 = $user_id1;
            $users2->group_id = null;
            $users2->title = null;
            $users2->description = null;
            $users2->group_image = null;
            $users2->status = 1;
            $users2->type = 1;
            $users2->created_date = date('Y-m-d H:i:s');
            $users2->modified_date = null;
            $users2->save();
        }
        $userdetails = $db->select()->from('engine4_emessages_userlists')->where('user_id1 =?', $user_id1)->where('user_id2 =?', $user_id2)->query()->fetch();
        $returnarray['userlist_text'] = '<li class="listofusers clearfix" type="1" username="' . $user->getTitle() . '" id="chatuser_id_' . $userdetails['userlist_id'] . '" onclick="changeusername(\'' . $user->getTitle() . '\');displayusermessages(' . $userdetails['userlist_id'] . ',1,1)">
          <div class="item-photo">
          ' . $view->itemPhoto($user, 'thumb.icon', $user->getTitle()) . '          
          </div>
          <div class="item-content">
            <div class="item-title clearfix">
              <span class="time sesbasic_text_light fsmall" id="userdate_' . $userdetails['userlist_id'] . '"></span>
              <h6>' . $user->getTitle() . '</h6>
            </div>
            <p class="messages-body fsmall" id="userdescription_' . $userdetails['userlist_id'] . '"></p>
          </div>
        </li>';
        $returnarray['userlist_id']= $userdetails['userlist_id'];
       return $returnarray;
    }

    // here you get owner permision
	public function getGroupOwner($group_id,$user_id,$group_owner)  // fixed
	{
		if($user_id == $group_owner){ return true; }
		$group=Engine_Db_Table::getDefaultAdapter()->select()->from('engine4_emessages_groupusers',array('group_admin'))->where('group_id =?',$group_id)->where('user_id =?',$user_id)->where('status = 1')->query()->fetch();
		if(isset($group['group_admin']) && $group['group_admin']==1)
		{
			return 1;
		}
		return 0;
	}
	public  function returndescription($text)
	{

		$emoticonsTag = Engine_Api::_()->activity()->getEmoticons();
		$text = nl2br($text);
		return Engine_Api::_()->core()->smileyToEmoticons($text);
	}
}
