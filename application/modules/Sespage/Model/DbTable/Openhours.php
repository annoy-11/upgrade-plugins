<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Openhours.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Openhours extends Engine_Db_Table {

  protected $_rowClass = "Sespage_Model_Openhour"; 

  public function getPageHours($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id']);
    return $this->fetchRow($select);
  }
  
  public function hoursStatus($params = array()){
    
  }
}
