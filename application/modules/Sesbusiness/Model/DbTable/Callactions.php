<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Callactions.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Callactions extends Engine_Db_Table {

  public function getCallactions($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id =?', $params['business_id']);
   return $this->fetchRow($select);
  }
}
