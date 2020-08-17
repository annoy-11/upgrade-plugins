<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Memberroles extends Engine_Db_Table {
  protected $_rowClass = 'Sesgroup_Model_Memberrole';
  protected $_searchTriggers = false;
  public function getLevels($params = array()) {
    $select = $this->select()
            ->from($this->info('name'));
    if(!empty($params['status']))
      $select->where('active =?',1);
    return $this->fetchAll($select);
  }
}
