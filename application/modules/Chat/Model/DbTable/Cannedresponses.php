<?php

class Chat_Model_DbTable_Cannedresponses extends Engine_Db_Table
{
    function getCannedReplies($params = array()){
        $select = $this->select();
        if(!empty($params['room_id'])){
            $select->where('room_id =?',$params['room_id']);
        }
        if(!empty($params['active'])){
            $select->where('active =?',$params['active']);
        }

        return $this->fetchAll($select);
    }

}