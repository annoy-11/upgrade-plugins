<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Comment.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_Comment extends Core_Model_Comment {

    protected $_type = "core_comment";
    protected function _postInsert() {
        $commentedItem = $this->getResource();
        $poster = $this->getPoster();
        $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
        $owner = $commentedItem->getOwner();
        if( $owner->getType() == 'courses' || $owner->getIdentity() == $poster->getIdentity() ) {
            Engine_Hooks_Dispatcher::getInstance()->callEvent('onCoreCommentCreateAfter', $this);
        }
        parent::_postInsert();
    }
}
