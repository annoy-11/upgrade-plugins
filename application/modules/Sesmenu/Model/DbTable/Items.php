<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Items.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmenu_Model_DbTable_Items extends Engine_Db_Table {

  protected $_rowClass = "Sesmenu_Model_Item";

  public function getDashboard($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName);
	if (isset($param['menu_id'])) {
		$select->where("menu_id = ?",$param['menu_id']);
	}
    if (isset($param['fetchAll'])) {
        $select->where('enabled =?', 1);
        return $this->fetchAll($select);
    }
    return Zend_Paginator::factory($select);
  }
}
