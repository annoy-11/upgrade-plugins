<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboardlinks.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Model_DbTable_Dashboardlinks extends Engine_Db_Table {

  protected $_rowClass = "Sespagethm_Model_Dashboardlink";

  public function getInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('dashboardlinks', 'sespagethm');
    $select = $socialTable->select()->order('order DESC');

    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }

    if (isset($params['sublink'])) {
      $select = $select->where('sublink = ?', $params['sublink']);
    }

    return $socialTable->fetchAll($select);
  }

  public function getDashboardName($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('name'))
                    ->where('enabled = ?', 1)
                    ->where('dashboardlink_id =?', $params['dashboardlink_id'])
                    ->query()
                    ->fetchColumn();
  }

  public function order($categoryType = 'dashboardlink_id', $categoryTypeId) {

    $currentOrder = $this->select()
            ->from($this, 'dashboardlink_id')
            ->order('order DESC');
    if ($categoryType != 'dashboardlink_id')
      $currentOrder = $currentOrder->where($categoryType . ' = ?', $categoryTypeId);
    else
      $currentOrder = $currentOrder->where('sublink = ?', 0);
    return $currentOrder->query()->fetchAll(Zend_Db::FETCH_COLUMN);
  }
}
