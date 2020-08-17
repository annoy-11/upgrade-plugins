<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addresses.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Addresses extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Address";
   protected $_type = 'sesproduct_addresses';
    function getAddress($params = array()){
        $select = $this->select()->where('user_id =?',$params['user_id']);
        if(!empty($params['type']) || $params['type'] == 0){
            $select->where('type =?',$params['type']);
        }
        if(!empty($params['view'])){
            return $this->fetchRow($select);
        }
        return $this->fetchAll($select);
    }
}
