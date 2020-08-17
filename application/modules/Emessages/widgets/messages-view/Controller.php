<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Widget_MessagesViewController extends Engine_Content_Widget_Abstract{

  public function indexAction()
  {
	 //  Engine_Api::_()->emessages()->oninstall();
	  $viewer = Engine_Api::_()->user()->getViewer();
	  $db = Engine_Db_Table::getDefaultAdapter();
	  // For Group
	  $request = Zend_Controller_Front::getInstance()->getRequest();
	  $this->view->id = $id = $request->getParam("id");
	  $conversation=$db->select()->from('engine4_messages_conversations',array('conversation_id as conversation_conversation_id'))->joinUsing('engine4_messages_recipients','conversation_id')->where('engine4_messages_conversations.recipients > 1')->where('engine4_messages_recipients.outbox_deleted = 0')->where('engine4_messages_conversations.user_id = ?',$viewer->getIdentity())->where('engine4_messages_conversations.conversation_id not in (?)', Engine_Api::_()->emessages()->AllGroupByUser($viewer->getIdentity()))->group('engine4_messages_recipients.conversation_id')->order('engine4_messages_conversations.conversation_id DESC')->query()->fetchAll();
	  if(!empty($conversation))
	  {
		  foreach ($conversation as $conversations)
		  {
			  $con = $db->select()->from('engine4_emessages_userlists', array('group_id'))->where('group_id = ?', $conversations['conversation_id'])->where('type = 2')->query()->fetchColumn();
			  if (empty($con)) {
				  $group = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
				  $group->user_id1 = null;
				  $group->user_id2 = null;
				  $group->group_id = $conversations['conversation_id'];
				  $group->title = null;
				  $group->description = null;
				  $group->group_image = null;
				  $group->status = 1;
				  $group->type = 2;
				  $group->created_date = date('Y-m-d H:i:s');
				  $group->modified_date = null;
				  if ($group->save())
				  {
					  $group_update_users = $db->select()->from('engine4_messages_recipients', array('user_id', 'inbox_message_id', 'inbox_deleted', 'outbox_message_id','inbox_updated','outbox_updated'))->where('conversation_id = ?', $conversations['conversation_id'])->query()->fetchAll();
					  foreach ($group_update_users as $g_u_u)
					  {
						  $group_users = Engine_Api::_()->getDbtable('groupusers', 'emessages')->createRow();
						  $group_users->userlist_id = $group->userlist_id;
						  $group_users->group_id = $conversations['conversation_id'];
						  $group_users->user_id = $g_u_u['user_id'];
						  $group_users->created_date = date('Y-m-d H:i:s');
						  $group_users->modified_date = null;
						  $group_users->status = 1;
						  $group_users->save();
						  if (isset($g_u_u['outbox_message_id']) && $g_u_u['outbox_message_id'] != 0)
						  {
							  $db->update('engine4_emessages_userlists', array('group_admin' => $g_u_u['user_id']), array('userlist_id = ?' => $group->userlist_id));
						  }
					  }
				  }
			  }
		  }
	  }
	  // For single users
    $user_conversation=Engine_Api::_()->emessages()->AllConversationByUser($viewer->getIdentity());
	  if(!empty($user_conversation))
	  {
		  $single_user_update = $db->select()->from('engine4_messages_recipients', array('user_id'))->where('conversation_id in (?)', $user_conversation)->where('user_id not in (?)', Engine_Api::_()->emessages()->AllUsersByUser($viewer->getIdentity()))->group('user_id')->query()->fetchAll();
		  if (!empty($single_user_update))
		  {
			  foreach ($single_user_update as $conversation_single_users)
			  {
				  if (empty($con)) {
					  $group1 = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
					  $group1->user_id1 = $viewer->getIdentity();
					  $group1->user_id2 = $conversation_single_users['user_id'];
					  $group1->group_id = null;
					  $group1->title = null;
					  $group1->description = null;
					  $group1->group_image = null;
					  $group1->status = 1;
					  $group1->type = 1;
					  $group1->created_date = date('Y-m-d H:i:s');
					  $group1->modified_date = null;
					  $group1->save();
					  $group2 = Engine_Api::_()->getDbtable('userlists', 'emessages')->createRow();
					  $group2->user_id2 = $viewer->getIdentity();
					  $group2->user_id1 = $conversation_single_users['user_id'];
					  $group2->group_id = null;
					  $group2->title = null;
					  $group2->description = null;
					  $group2->group_image = null;
					  $group2->status = 1;
					  $group2->type = 1;
					  $group2->created_date = date('Y-m-d H:i:s');
					  $group2->modified_date = null;
					  $group2->save();
				  }
			  }
		  }
	  }

	  	$this->view->type = isset($_GET['type']) ?? 0;
		if(!isset($_GET['type']) && $id){
		  	$rName = Engine_Api::_()->getDbtable('recipients', 'messages')->info('name');
	        $cTable = Engine_Api::_()->getDbtable('conversations', 'messages');
	        $cName = $cTable->info('name');
	        $enabledModules = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();

		    $mselect = $cTable->select()->setIntegrityCheck(false)
	        ->from($cName)
	        ->joinRight($rName, "`{$rName}`.`conversation_id` = `{$cName}`.`conversation_id`", array("user_id as recipient_id"))
	        ->where("`{$cName}`.`conversation_id` = ".$id)
	        ->where("`{$cName}`.`user_id` != `{$rName}`.`user_id`")
	        ->where("`{$cName}`.`resource_type` IS NULL or `{$cName}`.`resource_type` ='' or `{$cName}`.`resource_type` IN (?)", $enabledModules); 
	        $conversationDetails = $cTable->fetchRow($mselect);
	       	$userlistId = $db->select()->from('engine4_emessages_userlists', array('userlist_id'))->where('user_id1 = ?', $conversationDetails->recipient_id)->where('user_id2 = ?',$conversationDetails->user_id)->where('type = 1')->query()->fetchColumn();
	       	if(!empty($userlistId)){
	       		$this->view->id = $userlistId;
	       	}
	    } 

	  $composePartials = array();
	  $prohibitedPartials = array('_composeTwitter.tpl', '_composeFacebook.tpl');
	  $album_flag=0;
	  foreach( Zend_Registry::get('Engine_Manifest') as $data ) {
		  if( empty($data['composer']) ) {
			  continue;
		  }
		  foreach( $data['composer'] as $type => $config ) {
		  if(strtolower($type) == "photo" || strtolower($type) == "video" || strtolower($type) == "music" || strtolower($type) == "album")
		  {
			  // is the current user has "create" privileges for the current plugin
			  if (isset($config['auth'], $config['auth'][0], $config['auth'][1]))
			  {
				  $isAllowed = Engine_Api::_()
					  ->authorization()
					  ->isAllowed($config['auth'][0], null, $config['auth'][1]);

				  if (!empty($config['auth']) && !$isAllowed)
				  {
					  continue;
				  }
			  }
			  if (!in_array($config['script'][0], $prohibitedPartials)) {
				  $composePartials[] = $config['script'];
			  }
		     }
		  }
	  }

	  $this->view->composePartials = $composePartials;

	  if($viewer->getIdentity()==0)
	  {
		  return $this->setNoRender();
	  }
	  $this->view->allusers=$users=Engine_Api::_()->emessages()->getAllUser($viewer->getIdentity());
	  $composePartials = array();
	  foreach( Zend_Registry::get('Engine_Manifest') as $data )
	  {
		  if( empty($data['composer']) ) {
			  continue;
		  }
		  foreach( $data['composer'] as $type => $config ) {
			  if( !empty($config['auth']) && !Engine_Api::_()->authorization()->isAllowed($config['auth'][0], null, $config['auth'][1]) ) {
				  continue;
			  }
			  $composePartials[] = $config['script'];
		  }
	   }
	   
	}

}
