<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Postattributions.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Postattributions extends Engine_Db_Table {

  public function getClassroomPostAttribution($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('classroom_id =?', $params['classroom_id'])
            ->where('user_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
   $res = $this->fetchRow($select);
   //1 => as classroom
   //0 => as user
   if(!empty($params['return'])){
      return $res;
   }
   if($res){
      return $res->type;
   }else{
      return 1;
   }
  }

  public function hoursStatus($params = array()){

  }
}
