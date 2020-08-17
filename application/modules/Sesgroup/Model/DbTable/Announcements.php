<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcements.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Model_DbTable_Announcements extends Engine_Db_Table {

  protected $_rowClass = 'Sesgroup_Model_Announcement';

  public function getGroupAnnouncementPaginator($params = array()) {
    return Zend_Paginator::factory($this->getGroupAnnouncementSelect($params));
  }

  public function getGroupAnnouncementSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('group_id =?', $params['group_id']);
    return $select;
  }

}
