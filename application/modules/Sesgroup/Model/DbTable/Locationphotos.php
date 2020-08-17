<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locationphotos.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Locationphotos extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Locationphoto";

  function getLocationPhotos($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('group_id=?', $params['group_id'])
            ->where('location_id=?', $params['location_id']);
    return $photos = $this->fetchAll($select);
  }

}
