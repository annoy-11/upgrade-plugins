<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Memberroles extends Engine_Db_Table {
  protected $_rowClass = 'Estore_Model_Memberrole';
  protected $_searchTriggers = false;
  public function getLevels($params = array()) {
    $select = $this->select()
            ->from($this->info('name'));
    if(!empty($params['status']))
      $select->where('active =?',1);
    return $this->fetchAll($select);
  }
}
