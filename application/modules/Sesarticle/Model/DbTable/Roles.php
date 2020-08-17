<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for sesarticles
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getArticleAdmins($params = array()) {
  
    $select = $this->select()->where('article_id =?', $params['article_id']);
    return Zend_Paginator::factory($select);
  }
  
  public function isArticleAdmin($articleId = null, $articleAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $articleAdminId)
    ->where('article_id =?', $articleId)->query()->fetchColumn();
  }
}