<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Notifications.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Notifications extends Engine_Db_Table {

  protected $_rowClass = 'Sesgroup_Model_Notification';
	public function getNotifications($params = array())
  {
    if(empty($params['user_id'])){
      $user_id = Engine_Api::_()->user()->getViewer();
      if(!$user_id->getIdentity())
        return array();
      $params['user_id'] = $user_id->getIdentity();
    }
    $select = $this->select();
    if(!empty($params['type']) && !empty($params['role'])){
        $select->where('type ="'.$params['type'].'" OR type = "'.$params['role'].'"');
    }else if(!empty($params['type'])){
        $select->where('type ="'.$params['type'].'"');  
    }else if(!empty($params['role'])){
        $select->where('role ="'.$params['role'].'"');  
    }
    
    $select->where('group_id =?',$params['group_id'])
           ->where('user_id =?',$params['user_id']);
    $notifications = $this->fetchAll($select);
    if(!empty($params['getAll'])){
      return $notifications;  
    }
    if(count($notifications)){ 
      //site notification = site_notification
      //email notification = email_notification
      //both = both
      //off = turn_off
      $type = "";
      $role = "";
      foreach($notifications as $notification){ 
        if($notification->type == "notification_type")
          $type = $notification->value;
        else
          $role = $notification->type;
      }
      if($type == "turn_off"){
          return false;
      } else if($type == $params['notification_type'] || $type == "both"){
          if($role == $params['role'])
            return true;
      }
    } else {
      return false;  
    }
    return false;
  }
  
}
