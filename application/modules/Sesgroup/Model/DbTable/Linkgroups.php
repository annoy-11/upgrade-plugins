<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Linkgroups.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Linkgroups extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Linkgroup";

  public function getLinkGroupsPaginator($params = array()) {
    return Zend_Paginator::factory($this->getLinkGroupSelect($params));
  }

  public function getLinkGroupSelect($params = array()) {
    $groupTable = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    $groupTableName = $groupTable->info('name');
    $linkgroupTableName = $this->info('name');
    $select = $groupTable->select()->setIntegrityCheck(false);
    $select->from($groupTableName);
    $select->join($linkgroupTableName, "$linkgroupTableName.link_group_id = $groupTableName.group_id", 'active')
            ->where($linkgroupTableName . '.group_id = ?', $params['group_id']);
    return $select;
  }

}
