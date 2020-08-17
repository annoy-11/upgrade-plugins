<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slides.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Model_DbTable_Slides extends Engine_Db_Table {

	protected $_rowClass = "Sesariana_Model_Slide";

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
