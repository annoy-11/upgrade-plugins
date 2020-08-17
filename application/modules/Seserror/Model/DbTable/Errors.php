<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Errors.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Seserror_Model_DbTable_Errors extends Engine_Db_Table {

  protected $_name = 'seserror_errors';
  protected $_rowClass = 'Seserror_Model_Error';

  public function getResults($params = array()) {

    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName, $params['column_name']);

    if (isset($params['error_id'])) {
      $select = $select->where('error_id = ?', $params['error_id']);
    }
    
    if (isset($params['error_type'])) {
      $select = $select->where('error_type = ?', $params['error_type']);
    }
    
    if (isset($params['module_name'])) {
      $select = $select->where('module_name = ?', $params['module_name']);
    }

    $select = $select->where('enabled = ?', 1);
    $select = $select->order('RAND() DESC'); 

    return $select->query()->fetchAll();
  }

}