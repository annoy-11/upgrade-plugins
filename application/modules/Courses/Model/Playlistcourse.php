<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Playlistcourse.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Playlistcourse extends Core_Model_Item_Abstract {

  public function getParent($recurseType = NULL) {
    return Engine_Api::_()->getItem('courses_wishlist', $this->wishlist_id);
  }

}
