<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Followers.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Model_DbTable_Followers extends Engine_Db_Table {

  protected $_rowClass = "Sesdiscussion_Model_Follower";
  protected $_name = "sesdiscussion_followers";

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
            ->where('resource_type = ?', 'sesdiscussion_category')
            ->where('resource_id = ?', $resourceId);
    return $this->fetchAll($select);
  }

  public function getItemFollower($resource_type, $itemId) {
    $select = $this->select()->from($this->info('name'))->where('resource_type =?', $resource_type)->where('owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('resource_id =?', $itemId);
    return $this->fetchRow($select);
  }

}
