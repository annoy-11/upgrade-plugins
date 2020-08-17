<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Voteupdowns.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Model_DbTable_Voteupdowns extends Engine_Db_Table
{
  protected $_rowClass = 'Sesqa_Model_Voteupdown';
  
  public function isVote($params = array()){
      $select = $this->select()
                     ->where('resource_id =?',$params['resource_id'])
                     ->where('resource_type =?',$params['resource_type'])
                     ->where('user_type =?',$params['user_type'])
                     ->where('user_id =?',$params['user_id'])
                     ->limit(1);
     return $this->fetchRow($select);
  }
  
}