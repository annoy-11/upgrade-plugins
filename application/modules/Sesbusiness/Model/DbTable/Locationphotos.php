<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locationphotos.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Locationphotos extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Locationphoto";

  function getLocationPhotos($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('business_id=?', $params['business_id'])
            ->where('location_id=?', $params['location_id']);
    return $photos = $this->fetchAll($select);
  }

}
