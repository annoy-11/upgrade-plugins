<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crossposts.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Crossposts extends Engine_Db_Table {
 protected $_rowClass = "Sesgroup_Model_Crosspost";
  public function getCrossposts($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('sender_group_id =?',$params['group_id']);
    if(!empty($params['receiver_approved'])){
      $select->orWhere('receiver_group_id = '.$params['group_id'].' AND receiver_approved =?',1);
    }else{
      $select->orWhere('receiver_group_id =?',$params['group_id']);  
    }
   return $this->fetchAll($select);
  } 
}
