<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Openhours.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Openhours extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Openhour"; 

  public function getGroupHours($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('group_id =?', $params['group_id']);
    return $this->fetchRow($select);
  }
  
  public function hoursStatus($params = array()){
    
  }
}
