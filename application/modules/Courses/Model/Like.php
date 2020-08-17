<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Like.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_Like extends Core_Model_Like
{
  protected $_type = "core_like";
  protected function _postInsert()
  {
    $likedItem = $this->getResource();
    $poster = $this->getPoster();
    $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
    $owner = $likedItem->getOwner();
    if( $owner->getType() == 'courses' || $owner->getIdentity() == $poster->getIdentity() ) {
      Engine_Hooks_Dispatcher::getInstance()
        ->callEvent('onCoreLikeCreateAfter', $this);
    }
    parent::_postInsert();
  }
}
