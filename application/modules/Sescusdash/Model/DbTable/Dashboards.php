<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sescusdash_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Sescusdash_Model_Dashboard";

  public function getDashboard($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName);
    if (isset($param['fetchAll'])) {
        $select->where('enabled =?', 1);
        return $this->fetchAll($select);
    }
    return Zend_Paginator::factory($select);
  }
}
