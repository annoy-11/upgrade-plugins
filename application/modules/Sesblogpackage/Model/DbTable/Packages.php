<?php
class Sesblogpackage_Model_DbTable_Packages extends Engine_Db_Table
{
  protected $_rowClass = 'Sesblogpackage_Model_Package';
	
  public function getEnabledPackageCount()
  {
    return $this->select()
      ->from($this, new Zend_Db_Expr('COUNT(*)'))
      ->where('enabled = ?', 1)
			->where('`default` =?',0)
      ->query()
      ->fetchColumn()
      ;
  }
	
	public function getDefaultPackage(){
    return $this->select()
      ->from($this, 'package_id')
			->where('`default` =?',1)
      ->query()
      ->fetchColumn()
      ; 	
	}
	
	public function getPackage($params = array()){
		$tablename = $this->info('name');
		$select = $this->select()->from($tablename);
		if(empty($params['default']))
			$select->where('`default` =?',0);
		if(empty($params['enabled']))
			$select->where('enabled =?',1);
		if(isset($params['member_level']))
			$select->where('member_level LIKE "%,0,%" || member_level LIKE "%,'.$params['member_level'].',%" ');
		if(isset($params['show_upgrade']))
			$select->where('show_upgrade =?',1);
		if(isset($params['not_in_id']))
			$select->where('package_id !=?',$params['not_in_id']);
		if(isset($params['package_id']))
			$select->where('package_id =?',$params['package_id']);
		$select->order('order ASC');
		$select->where('enabled =?',1);
		return $this->fetchAll($select);	
	}
	
  public function getEnabledNonFreePackageCount()
  {
    return $this->select()
      ->from($this, new Zend_Db_Expr('COUNT(*)'))
      ->where('enabled = ?', 1)
      ->where('price > ?', 0)
			->where('`default` =?',0)
      ->query()
      ->fetchColumn()
      ;
  }
}