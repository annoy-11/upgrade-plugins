<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contents.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Model_DbTable_Contents extends Engine_Db_Table {
	
	protected $_rowClass = "Sestour_Model_Content";

  public function getContents($id, $show_type = '') {
  
    $tableName = $this->info('name');
    $select = $this->select()
                  ->from($tableName)
                  ->where('tour_id =?', $id);

    if(empty($show_type))
      $select->where('enabled =?', 1);
      
    $select->order('content_id ASC');
    if(!empty($show_type)) {
      return Zend_Paginator::factory($select);
    } else {
      return $this->fetchAll($select);
    }
  }
}