<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tours.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Model_DbTable_Tours extends Engine_Db_Table {

  protected $_rowClass = "Sestour_Model_Tour";

  public function getTour($param = array()) {
  
    $tableName = $this->info('name');
    
    $select = $this->select()->from($tableName);
    
    if (isset($param['fetchAll'])) {
      $select->where('enabled =?', 1);
      return $this->fetchAll($select);
    }
    $select->order('tour_id DESC');
    return Zend_Paginator::factory($select);
  }
}