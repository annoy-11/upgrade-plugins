<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Membership.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Membership extends Core_Model_DbTable_Membership {

  protected $_type = 'sesgroup_group';

  // Configuration

  /**
   * Does membership require approval of the resource?
   *
   * @param Core_Model_Item_Abstract $resource
   * @return bool
   */
  public function isResourceApprovalRequired(Core_Model_Item_Abstract $resource) {
    return $resource->approval;
  }

  public function getRequestInfo($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('resource_id =?', $params['resource_id'])
            ->where('user_id =?', $params['user_id']);
    return $this->fetchRow($select);
  }

  public function getFriendGroup($params = array(), $query = '') {
    return $this->select()
                    ->from($this->info('name'), new Zend_Db_Expr('COUNT(user_id)'))
                    ->where('user_id IN(?)', $query)
                    ->where('resource_id =?', $params['group_id'])
                    ->where('resource_approved =?', 1)
                    ->where('user_approved =?', 1)
                    ->where('active =?', 1)
                    ->query()
                    ->fetchColumn();
  }

  public function groupMembers($groupId = '') {
    $table = Engine_Api::_()->getDbTable('users', 'user');
    $subtable = Engine_Api::_()->getDbTable('membership', 'sesgroup');
    $tableName = $table->info('name');
    $subtableName = $subtable->info('name');
    $select = $table->select()
            ->from($tableName, array('user_id', 'photo_id','displayname'))
            ->setIntegrityCheck(false)
            ->join($subtableName, '`' . $subtableName . '`.`user_id` = `' . $tableName . '`.`user_id`', array('resource_approved', 'user_approved', 'active'))
            ->where('`' . $subtableName . '`.`resource_id` = ?', $groupId)
            ->where('resource_approved =?', 1)
            ->where('user_approved =?', 1)
            ->where($subtableName . '.active =?', 1)
            ->order('RAND()');
    return $table->fetchAll($select);
  }

}
