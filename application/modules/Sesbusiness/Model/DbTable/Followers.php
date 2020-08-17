<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Followers.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Followers extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Follower";
  protected $_name = "sesbusiness_followers";

  public function isFollow($params = array()) {
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $status = $this->select()
            ->where('resource_type = ?', $params['resource_type'])
            ->where('resource_id = ?', $params['resource_id'])
            ->where('owner_id = ?', $viewer_id)
            ->query()
            ->fetchColumn();
    if ($status)
      return 1;
    else
      return 0;
  }

  public function getFollowers($resourceId) {

    $select = $this->select()
            ->from($this->info('name'), 'owner_id')
            ->where('resource_id = ?', $resourceId);
    return $this->fetchAll($select);
  }

  function getCategoryFollowers($resourceId = "") {
    $select = $this->select()
            ->from($this->info('name'), 'owner_id')
            ->where('resource_type = ?', 'sesbusiness_category')
            ->where('resource_id = ?', $resourceId);
    return $this->fetchAll($select);
  }

  public function getItemFollower($resource_type, $itemId) {
    $select = $this->select()->from($this->info('name'))->where('resource_type =?', $resource_type)->where('owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('resource_id =?', $itemId);
    return $this->fetchRow($select);
  }

}
