<?php
class Estore_Model_Like extends Core_Model_Like
{  
  protected $_type = "core_like";
  protected function _postInsert()
  {
    $likedItem = $this->getResource();
    $poster = $this->getPoster();
    $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
    $owner = $likedItem->getOwner();
    if( $owner->getType() == 'stores' || $owner->getIdentity() == $poster->getIdentity() ) {
      Engine_Hooks_Dispatcher::getInstance()
        ->callEvent('onCoreLikeCreateAfter', $this);
    }
    parent::_postInsert();
  }
}
