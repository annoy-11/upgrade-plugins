<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcements.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Announcements extends Engine_Db_Table {

  protected $_rowClass = 'Sescrowdfunding_Model_Announcement';

  public function getCrowdfundingAnnouncementPaginator($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('crowdfunding_id =?', $params['crowdfunding_id']);
    return Zend_Paginator::factory($this->getCrowdfundingAnnouncementSelect($params));
  }

  public function getCrowdfundingAnnouncementSelect($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('crowdfunding_id =?', $params['crowdfunding_id']);
    return $select;
  }

}
