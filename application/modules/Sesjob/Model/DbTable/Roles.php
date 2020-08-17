<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for sesjobs
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getJobAdmins($params = array()) {

    $select = $this->select()->where('job_id =?', $params['job_id']);
    return Zend_Paginator::factory($select);
  }

  public function isJobAdmin($jobId = null, $jobAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $jobAdminId)
    ->where('job_id =?', $jobId)->query()->fetchColumn();
  }
}
