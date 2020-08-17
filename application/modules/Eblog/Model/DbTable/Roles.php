<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for eblogs
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getBlogAdmins($params = array()) {

    $select = $this->select()->where('blog_id =?', $params['blog_id']);
    return Zend_Paginator::factory($select);
  }

  public function getAllBlogAdmins($params = array()) {
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()->where('blog_id =?', $params['blog_id'])->where('resource_approved =?', 1)->where('user_id <> ?', $viewer_id);
    return $this->fetchAll($select);
  }

  public function isBlogAdmin($blogId = null, $blogAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $blogAdminId)
    ->where('blog_id =?', $blogId)->query()->fetchColumn();
  }
}
