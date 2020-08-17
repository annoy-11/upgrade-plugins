<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Postattributions.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Postattributions extends Engine_Db_Table {

  public function getBusinessPostAttribution($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id =?', $params['business_id'])
            ->where('user_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
   $res = $this->fetchRow($select);
   //1 => as business
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
