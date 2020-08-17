<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Parameters.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesarticle_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Sesarticle_Model_Parameter';
	protected $_name  = 'sesarticle_parameters';
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