<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Featureblocks.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Model_DbTable_Featureblocks extends Engine_Db_Table {

  protected $_rowClass = "Seslandingpage_Model_Featureblock";

  public function getFeatureBlocks($param = array()) {
  
    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName);
		if($param['params'] == 1) {
			return $this->fetchAll($select);
		} else {
    	return Zend_Paginator::factory($select);
		}
  }

}
