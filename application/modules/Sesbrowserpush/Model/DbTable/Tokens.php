<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tokens.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Model_DbTable_Tokens extends Engine_Db_Table {
  
  function getTokens($params = array()){
    
    $select = $this->select()->from($this->info('name'),'access_token');
    
    if(!empty($params['user_id']))
      $select->where('user_id =?',$params['user_id']);
    if(!empty($params['level'])){
      $user = Engine_Api::_()->getItemTable('user')->info('name');
      $select->setIntegrityCheck(false)
            ->join($user,$user.'.user_id = '.$this->info('name').'.user_id',null)
            ->where($user.'.level_id =?',$params['level'])
            ->where($this->info('name').'.user_id !=?','0');  
    }else if(!empty($params['network'])){
      $network = 'engine4_network_membership';
      $select->setIntegrityCheck(false)
            ->join($network,$network.'.user_id = '.$this->info('name').'.user_id',null)
            ->where($network.'.resource_id =?',$params['network'])
            ->where($this->info('name').'.user_id !=?','0')
            ->where($network.'.active =?',1)
             ->where($network.'.resource_approved =?',1)
              ->where($network.'.user_approved =?',1);  
    }else if(!empty($params['user_ids'])){
      $select->where('user_id IN('.$params['user_ids'].')');  
    }else if(!empty($params['not_user_ids'])){
        $select->where('user_id !=?',$params['not_user_ids']);
    }else if(!empty($params['browser']))
      $select->where('browser =?',$params['browser']);
    else if(!empty($params['token_id']))
      $select->where('token_id =?',$params['token_id']);
   else if(!empty($params['test_user']))
      $select->where('test_user !=?','0');
    $result = $this->fetchAll($select);
    if(count($result)){
      $tokenString = array();
      foreach($result->toArray() as $token)
        $tokenString[] = $token['access_token'];
       return ($tokenString);
    }else{
      return false;
    }
  }  
}
