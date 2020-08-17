<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Openhours.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Openhours extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Openhour";

  public function getStoreHours($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('store_id =?', $params['store_id']);
    return $this->fetchRow($select);
  }

  public function hoursStatus($params = array()){

  }
}
