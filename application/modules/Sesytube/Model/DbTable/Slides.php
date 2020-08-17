<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slides.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Model_DbTable_Slides extends Engine_Db_Table {

	protected $_rowClass = "Sesytube_Model_Slide";

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
