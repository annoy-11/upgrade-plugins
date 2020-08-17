<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcements.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Model_DbTable_Announcements extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Announcement';

  public function getStoreAnnouncementPaginator($params = array()) {
    return Zend_Paginator::factory($this->getStoreAnnouncementSelect($params));
  }

  public function getStoreAnnouncementSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('store_id =?', $params['store_id']);
    return $select;
  }

}
