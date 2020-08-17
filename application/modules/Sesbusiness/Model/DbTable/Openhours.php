<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Openhours.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Openhours extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Openhour";

  public function getBusinessHours($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id =?', $params['business_id']);
    return $this->fetchRow($select);
  }

  public function hoursStatus($params = array()){

  }
}
