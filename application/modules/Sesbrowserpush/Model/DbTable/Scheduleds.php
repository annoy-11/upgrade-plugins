<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Scheduleds.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Model_DbTable_Scheduleds extends Engine_Db_Table {
  protected $_rowClass = 'Sesbrowserpush_Model_Scheduled';
  function getScheduled($params = array()){    
    $select = $this->select();
    $select->order('scheduled_id DESC');
    if(empty($params['sent']))
      $select->where('sent =?',0);
    else
      $select->where('sent =?',1);
    $result = $this->fetchAll($select);
    return $result;
  }  
}