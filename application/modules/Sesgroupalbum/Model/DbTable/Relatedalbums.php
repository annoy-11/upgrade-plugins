<?php

class Sesgroupalbum_Model_DbTable_Relatedalbums extends Engine_Db_Table
{
	protected $_name = 'sesgroupalbum_relatedalbums';
  protected $_rowClass = 'Sesgroupalbum_Model_Relatedalbum';
  
	public function getitem($params = array()){
		$itemTable = Engine_Api::_()->getItemTable('sesgroupalbum_album');
		$itemTableName = $itemTable->info('name');
		$select = $this->select()
							->from($this->info('name'),array('*'))
							->where('resource_id = ?' ,$params['album_id'])
							->setIntegrityCheck(false);		
		$select->joinLeft($itemTableName, $itemTableName . ".album_id =  ".$this->info('name') . '.album_id');
		$select->where($itemTableName.'.album_id != ?','');
		return Zend_Paginator::factory($select);
	}
}