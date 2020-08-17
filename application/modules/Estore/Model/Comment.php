<?php
class Estore_Model_Comment extends Core_Model_Comment {

    protected $_type = "core_comment";
    protected function _postInsert() {
        $commentedItem = $this->getResource();
        $poster = $this->getPoster();
        $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
        $owner = $commentedItem->getOwner();
        if( $owner->getType() == 'stores' || $owner->getIdentity() == $poster->getIdentity() ) {
            Engine_Hooks_Dispatcher::getInstance()->callEvent('onCoreCommentCreateAfter', $this);
        }
        parent::_postInsert();
    }
}
