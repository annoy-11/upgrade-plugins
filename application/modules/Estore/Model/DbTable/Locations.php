<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locations.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Locations extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Location";

  public function getStoreLocationPaginator($params = array()) {
    return Zend_Paginator::factory($this->getStoreLocationSelect($params));
  }

  public function getStoreLocationSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('store_id =?', $params['store_id']);
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
