<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboardlinks.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescusdash_Model_DbTable_Dashboardlinks extends Engine_Db_Table {

  protected $_rowClass = "Sescusdash_Model_Dashboardlink";

  public function getInfo($params = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $socialTable = Engine_Api::_()->getDbTable('dashboardlinks', 'sescusdash');
    $select = $socialTable->select()->order('order DESC');
    if (isset($params['dashboard_id']) && !empty($params['dashboard_id'])) {
      $select = $select->where('dashboard_id = ?', $params['dashboard_id']);
    }
    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }

    if (isset($params['sublink'])) {
      $select = $select->where('sublink = ?', $params['sublink']);
    }

    if(@$params['admin'] == 0) {

        if($viewer->getIdentity() && $viewer->level_id)
            $select = $select->where("FIND_IN_SET($viewer->level_id, `privacy`) OR privacy is null or privacy = ''");
        else
            $select = $select->where("privacy IS NULL || privacy = ''");
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
