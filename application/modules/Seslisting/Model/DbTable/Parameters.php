<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Parameters.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Seslisting_Model_Parameter';
	protected $_name  = 'seslisting_parameters';
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
