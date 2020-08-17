<?php
class Seswordpressblog_Model_DbTable_Categories extends Engine_Db_Table {
	protected $_rowClass = 'Seswordpressblog_Model_Category';
	public function getCategory()
	{
		$setCategory=array();
		// $stmt = $this->select()
  //           ->from($this, array('category_name'))
  //           ->query()
  //           ->fetchAll();
  //       foreach ($stmt as $key => $value) {
  //       	$setCategory[$key] = $value['category_name'];
  //       }
  //       print_r($setCategory);
          $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $results = $db->query("SELECT title FROM engine4_sesblog_categories")->fetchAll();
        return $results;
	}
}
?>