<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcements.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Model_DbTable_Announcements extends Engine_Db_Table {

  protected $_rowClass = 'Sesbusiness_Model_Announcement';

  public function getBusinessAnnouncementPaginator($params = array()) {
    return Zend_Paginator::factory($this->getBusinessAnnouncementSelect($params));
  }

  public function getBusinessAnnouncementSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id =?', $params['business_id']);
    return $select;
  }

}
