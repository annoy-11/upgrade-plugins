<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crossposts.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Crossposts extends Engine_Db_Table {
 protected $_rowClass = "Estore_Model_Crosspost";
  public function getCrossposts($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('sender_store_id =?',$params['store_id']);
    if(!empty($params['receiver_approved'])){
      $select->orWhere('receiver_store_id = '.$params['store_id'].' AND receiver_approved =?',1);
    }else{
      $select->orWhere('receiver_store_id =?',$params['store_id']);
    }
   return $this->fetchAll($select);
  }
}
