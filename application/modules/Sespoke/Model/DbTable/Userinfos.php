<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userinfos.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Model_DbTable_Userinfos extends Engine_Db_Table {

  protected $_rowClass = 'Sespoke_Model_Userinfo';

  public function isUser($params = array()) {
    return $this->select()->from($this->info('name'), 'userinfo_id')
                    ->where('user_id = ?', $params['user_id'])
                    ->query()
                    ->fetchColumn();
  }

  public function getResults($params = array()) {

    $select = $this->select();

    if (isset($params['action']) && $params['action'] != 'widget') {
      $select->where($params['count'] . " <> ?", 0)
              ->order($params['count'] . " DESC");
    }

    if (isset($params['action']) && $params['action'] == 'widget')
      $select->where("user_id = ?", $params['user_id']);

    if (isset($params['limit']))
      $select->limit($params['limit']);

    return $select->query()->fetchAll();
  }

}
