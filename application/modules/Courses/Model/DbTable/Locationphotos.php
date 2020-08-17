<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Locationsphotos.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Locationphotos extends Engine_Db_Table {

  protected $_rowClass = "Courses_Model_Locationphoto";

  function getLocationPhotos($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('course_id=?', $params['course_id'])
            ->where('location_id=?', $params['location_id']);
    return $photos = $this->fetchAll($select);
  }

}
