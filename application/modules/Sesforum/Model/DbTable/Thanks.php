<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Thanks.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Thanks extends Engine_Db_Table {

  protected $_rowClass = "Sesforum_Model_Thank";

  public function isThank($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()

                    ->where('poster_id = ?', $viewer_id);
    if(!empty($params['post_id'])) {
        $select->where('post_id = ?', $params['post_id']);
    }
    if(!empty($params['resource_id'])) {
        $select->where('resource_id = ?', $params['resource_id']);
    }
    $select =  $select->query()
               ->fetchColumn();
		return $select;
  }

  public function getAllUserThanks($user_id , $post_id = null ) {
    $select = $this->select()
                    ->from($this->info('name'),'thank_id');

    if(!empty($post_id)) {
        $select->where('post_id = ?', $post_id);
    }
     if(!empty($user_id)) {
        $select->where('resource_id = ?', $user_id);
    }
    $results = $this->fetchAll($select);
    return count($results);
  }
}
