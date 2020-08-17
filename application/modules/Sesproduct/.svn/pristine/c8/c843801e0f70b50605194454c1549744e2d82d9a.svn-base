<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Metas.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Metas extends Engine_Db_Table {

  protected $_name = 'sesproduct_fields_meta';
  protected $_rowClass = 'Sesproduct_Model_Meta';

	public function getMetaData($options_id = null){
		if(!$options_id)
			return null;
		$tableName = $this->info('name');
		$mapTableName = Engine_Api::_()->getDbTable('maps','sesproduct')->info('name');
		$select = $this->select()->from($tableName)
							->setIntegrityCheck(false)
							->join($mapTableName, $mapTableName . '.child_id = ' . $tableName . '.field_id', null)
							->order($mapTableName.'.order')
							->where($mapTableName.'.option_id =?',$options_id);
		return $this->fetchAll($select);
	}

  public function profileFieldId() {
    return $this->select()
                    ->from($this->info('name'), array('field_id'))
                    ->where('alias = ?', 'profile_type')
                    ->where('type = ?', 'profile_type')
                    ->query()
                    ->fetchColumn();
  }

	public function reviewProfileFieldId() {
	  $table = Engine_Api::_()->fields()->getTable('sesproductreview', 'metas');
		return $table->select()
		->from($table->info('name'), array('field_id'))
		->where('alias = ?', 'profile_type')
		->where('type = ?', 'profile_type')
		->query()
		->fetchColumn();
	}

}
