<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locations.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Locations extends Engine_Db_Table {

  protected $_rowClass = "Sespage_Model_Location";

  public function getPageLocationPaginator($params = array()) {
    return Zend_Paginator::factory($this->getPageLocationSelect($params));
  }

  public function getPageLocationSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id']);
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
