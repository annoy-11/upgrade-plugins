<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Linkstores.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Linkstores extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Linkstore";

  public function getLinkStoresPaginator($params = array()) {
    return Zend_Paginator::factory($this->getLinkStoreSelect($params));
  }

  public function getLinkStoreSelect($params = array()) {
    $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
    $storeTableName = $storeTable->info('name');
    $linkstoreTableName = $this->info('name');
    $select = $storeTable->select()->setIntegrityCheck(false);
    $select->from($storeTableName);
    $select->join($linkstoreTableName, "$linkstoreTableName.link_store_id = $storeTableName.store_id", 'active')
            ->where($linkstoreTableName . '.store_id = ?', $params['store_id']);
    return $select;
  }

}
