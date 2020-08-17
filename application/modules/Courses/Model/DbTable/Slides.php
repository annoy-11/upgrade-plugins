<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Slides.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Slides extends Engine_Db_Table {

	protected $_rowClass = "Courses_Model_Slide";

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
