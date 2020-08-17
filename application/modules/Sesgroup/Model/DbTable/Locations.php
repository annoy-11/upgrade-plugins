<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locations.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Locations extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Location";

  public function getGroupLocationPaginator($params = array()) {
    return Zend_Paginator::factory($this->getGroupLocationSelect($params));
  }

  public function getGroupLocationSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('group_id =?', $params['group_id']);
    if(isset($params['content']) && !empty($params['content'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }

  function getLocationData($params=array()) {
    $lName = $this->info('name');
    $select = $this->select()
            ->from($lName)
            ->where('location_id =?', $params['location_id']);
    $row = $this->fetchRow($select);
    return $row;
  }

}
