<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userrviews.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Userviews extends Engine_Db_Table {

  protected $_rowClass = "Sesmember_Model_Userview";
  protected $_name = "sesmember_userviews";

  function whoViewedMe($params) {
    $tablename = $this->info('name');
    $table = Engine_Api::_()->getItemTable('user');
    $memberTableName = $table->info('name');
    $select = $table->select()->from($memberTableName)->setIntegrityCheck(false);
    if (isset($params['view_by_me'])) {
      $select->joinLeft($tablename, "`{$tablename}`.`resource_id` = `{$memberTableName}`.`user_id`", null);
      $select->where($tablename . '.user_id =?', $params['resources_id']);
    } else {
      $select->joinLeft($tablename, "`{$tablename}`.`user_id` = `{$memberTableName}`.`user_id`", null);
      $select->where($tablename . '.resource_id =?', $params['resources_id']);
    }
    $select->where($tablename . '.user_id IS NOT NULL');
    if (isset($params['limit'])) {
      $select->limit($params['limit']);
    }
    $select->order('view_id DESC');
    if (isset($params['paginator']))
      return Zend_Paginator::factory($select);
    else
      return $table->fetchAll($select);
  }

}
