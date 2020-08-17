<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Sections.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Sections extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Section';
  public function getSections($params = array()){
    $tableName = $this->info('name');
    $select = $this->select()->from($tableName,'*');
    
    if(!empty($params['estore_id']))
      $select->where('estore_id =?',$params['estore_id']);
      
    $select->order('order DESC');
    return $this->fetchAll($select);
  }
}