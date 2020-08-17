<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Customheaers.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Model_DbTable_Customheaders extends Engine_Db_Table {
	
	protected $_rowClass = "Sesadvancedheader_Model_Customheader";
  
  public function getHeaderKey($params = array()) {
  
    $select = $this->select();
    if(!empty($params['header_id']))
      $select->where('header_id =?',$params['header_id']);
      
    if(!empty($params['column_key']))
      $select->where('column_key =?',$params['column_key']);
      
    if(!empty($params['customheader_id']))
      $select->where('customheader_id =?',$params['customheader_id']);
      
    if(!empty($params['is_custom']))
      $select->where('is_custom =?',$params['is_custom']);
      
    return $this->fetchAll($select);
  }
}