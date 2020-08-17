<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Orderaddresses.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Orderaddresses extends Engine_Db_Table {
   protected $_rowClass = "Courses_Model_Orderaddress";
   protected $_name = 'courses_order_addresses';
    function getAddress($params = array()){
        $select = $this->select();
        if(!empty($params['user_id'])){
          $select->where('user_id =?',$params['user_id']);
        }
        if(!empty($params['order_id'])){
          $select->where('order_id =?',$params['order_id']);
        }
        if(!empty($params['view'])){
          return $this->fetchRow($select);
        }
        return $this->fetchAll($select);
    }
}
