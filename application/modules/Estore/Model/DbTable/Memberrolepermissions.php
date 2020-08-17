<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberrolepermissions.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Memberrolepermissions extends Engine_Db_Table {
  public function getLevels($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('memberrole_id =?',$params['memberrole_id']);
    return $this->fetchAll($select);
  }
}
