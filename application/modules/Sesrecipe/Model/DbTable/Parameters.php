<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Parameters.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesrecipe_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Sesrecipe_Model_Parameter';
	protected $_name  = 'sesrecipe_parameters';
	function getParameterResult($params = array()){
		if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
    $select = $this->select()
            ->from($this->info('name'), $columnName);
    if (isset($params['category_id']))
      $select = $select->where('category_id = ?', $params['category_id']);   
      return $select->query()->fetchAll();
	}
	
}