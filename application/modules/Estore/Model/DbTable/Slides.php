<?php
class Estore_Model_DbTable_Slides extends Engine_Db_Table {

	protected $_rowClass = "Estore_Model_Slide";

  public function getSlides($id, $show_type = '',$status = false,$params = array()) {
    $tableName = $this->info('name');
    $select = $this->select()
            ->where('offer_id =?', $id);
    if(empty($show_type))
            $select->where('enabled = ?', 1);
	   $select->from($tableName);
		if(isset($params['order']) && $params['order'] == 'random'){
			$select ->order('RAND()')	;
		}else
			$select ->order('order ASC');

    if(!empty($params['limit']))
        $select->limit($params['limit']);

    return Zend_Paginator::factory($select);
  }

}
