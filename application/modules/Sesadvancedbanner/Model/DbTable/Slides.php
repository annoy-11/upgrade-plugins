<?php
class Sesadvancedbanner_Model_DbTable_Slides extends Engine_Db_Table {

	protected $_rowClass = "Sesadvancedbanner_Model_Slide";


  public function getWidgetSlides($id, $show_type = '',$status = false,$params = array()) {
    $tableName = $this->info('name');
    $select = $this->select()
            ->where('banner_id =?', $id);
    if(empty($show_type))
            $select->where('enabled =?', 1);
	   $select->from($tableName);
		if(isset($params['order']) && $params['order'] == 'random'){
			$select ->order('RAND()')	;
		}else
			$select ->order('order ASC');
	  if($status)
			$select = $select->where('status = 1');
    return $this->fetchAll($select);
  }

  public function getSlides($id, $show_type = '',$status = false,$params = array()) {
    $tableName = $this->info('name');
    $select = $this->select()
            ->where('banner_id =?', $id);
    if(empty($show_type))
            $select->where('enabled =?', 1);
	   $select->from($tableName);
		if(isset($params['order']) && $params['order'] == 'random'){
			$select ->order('RAND()')	;
		}else
			$select ->order('order ASC');
	  if($status)
			$select = $select->where('status = 1');
    return Zend_Paginator::factory($select);
  }

}
