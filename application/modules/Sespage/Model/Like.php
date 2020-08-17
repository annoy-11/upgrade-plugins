<?php
class Sespage_Model_Like extends Core_Model_Like
{  
  protected $_type = "core_like";
  protected function _postInsert()
  {
    $likedItem = $this->getResource();
    $poster = $this->getPoster();
    $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
    $owner = $likedItem->getOwner();
    if( $owner->getType() == 'sespage_page' || $owner->getIdentity() == $poster->getIdentity() ) {
      Engine_Hooks_Dispatcher::getInstance()
        ->callEvent('onCoreLikeCreateAfter', $this);
    }
    if($poster->getType() != "user")
      return;
    parent::_postInsert();
  }
}
