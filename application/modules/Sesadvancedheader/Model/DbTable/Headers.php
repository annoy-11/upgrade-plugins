<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Headers.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Model_DbTable_Headers extends Engine_Db_Table {

  public function getHeader($params = array()) {
  
    $select = $this->select();
    
    if(!empty($params['header_id']))
      $select->where('header_id =?',$params['header_id']);
      
    return $this->fetchAll($select);
  }
}