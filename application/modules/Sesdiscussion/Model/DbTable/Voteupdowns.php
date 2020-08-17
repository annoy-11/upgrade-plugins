<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Voteupdowns.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Model_DbTable_Voteupdowns extends Engine_Db_Table
{
  protected $_rowClass = 'Sesdiscussion_Model_Voteupdown';
  
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