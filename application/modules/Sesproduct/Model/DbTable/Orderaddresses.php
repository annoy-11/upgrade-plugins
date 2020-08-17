<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orderaddresses.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Orderaddresses extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Orderaddress";
   protected $_name = 'sesproduct_order_addresses';
    function getAddress($params = array()){
        $select = $this->select();
        if(!empty($params['user_id'])){
            $select->where('user_id =?',$params['user_id']);
        }
        if(!empty($params['type'])){
            $select->where('type =?',$params['type']);
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
