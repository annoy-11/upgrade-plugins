<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crossposts.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Crossposts extends Engine_Db_Table {
 protected $_rowClass = "Sespage_Model_Crosspost";
  public function getCrossposts($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('sender_page_id =?',$params['page_id']);
    if(!empty($params['receiver_approved'])){
      $select->orWhere('receiver_page_id = '.$params['page_id'].' AND receiver_approved =?',1);
    }else{
      $select->orWhere('receiver_page_id =?',$params['page_id']);  
    }
   return $this->fetchAll($select);
  } 
}
