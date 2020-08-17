<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Applications.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Applications extends Engine_Db_Table {

  protected $_rowClass = 'Sesjob_Model_Application';

  public function getApplications($params = array()) {

    $tbale = $this->info('name');
    $select = $this->select();

    if(isset($params['job_id'])) {
        $select->where('job_id = ?', $params['job_id']);
    }

    return $this->fetchAll($select);

  }

  public function isApplied($params = array()) {

    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName, 'application_id')
            ->where('owner_id = ?', $params['owner_id'])
            ->where('job_id = ?', $params['job_id'])
            ->limit(1);

    return $select->query()->fetchColumn();
  }

}
