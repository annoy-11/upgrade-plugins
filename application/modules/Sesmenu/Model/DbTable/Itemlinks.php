<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Itemlinks.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Model_DbTable_Itemlinks extends Engine_Db_Table {

  protected $_rowClass = "Sesmenu_Model_Itemlink";

  public function getInfo($params = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $socialTable = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu');
    $select = $socialTable->select()->order('order DESC');
	    if (isset($params['item_id']) && !empty($params['item_id'])) {
      $select = $select->where('item_id = ?', $params['item_id']);
    }
    if (isset($params['itemlink_id']) && !empty($params['itemlink_id'])) {
      $select = $select->where('itemlink_id = ?', $params['itemlink_id']);
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
                    ->where('itemlink_id =?', $params['itemlink_id'])
                    ->query()
                    ->fetchColumn();
  }

  public function order($categoryType = 'itemlink_id', $categoryTypeId) {

    $currentOrder = $this->select()
            ->from($this, 'itemlink_id')
            ->order('order DESC');
    if ($categoryType != 'itemlink_id')
      $currentOrder = $currentOrder->where($categoryType . ' = ?', $categoryTypeId);
    else
      $currentOrder = $currentOrder->where('sublink = ?', 0);
    return $currentOrder->query()->fetchAll(Zend_Db::FETCH_COLUMN);
  }
}
