<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Subscriptions.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Model_DbTable_Subscriptions extends Engine_Db_Table {

  public function sendNotifications(Seslisting_Model_Listing $seslisting) {

    if( !empty($seslisting->draft) || $seslisting->owner_type != 'user' ) {
      return $this;
    }

    // Get seslisting owner
    $owner = $seslisting->getOwner('user');

    // Get notification table
    $notificationTable = Engine_Api::_()->getDbtable('notifications', 'activity');

    // Get all subscribers
    $identities = $this->select()
      ->from($this, 'subscriber_user_id')
      ->where('user_id = ?', $seslisting->owner_id)
      ->query()
      ->fetchAll(Zend_Db::FETCH_COLUMN);

    if( empty($identities) || count($identities) <= 0 ) {
      return $this;
    }

    $users = Engine_Api::_()->getItemMulti('user', $identities);

    if( empty($users) || count($users) <= 0 ) {
      return $this;
    }

    // Send notifications
    foreach( $users as $user ) {
      $notificationTable->addNotification($user, $owner, $seslisting, 'seslisting_subscribed_new');
    }

    return $this;
  }

  public function checkSubscription(User_Model_User $user, User_Model_User $subscriber) {

    return (bool) $this->select()
        ->from($this, new Zend_Db_Expr('TRUE'))
        ->where('user_id = ?', $user->getIdentity())
        ->where('subscriber_user_id = ?', $subscriber->getIdentity())
        ->query()
        ->fetchColumn();
  }

  public function createSubscription(User_Model_User $user, User_Model_User $subscriber) {

    // Ignore if already subscribed
    if( $this->checkSubscription($user, $subscriber) ) {
      return $this;
    }

    // Create
    $this->insert(array(
      'user_id' => $user->getIdentity(),
      'subscriber_user_id' => $subscriber->getIdentity(),
    ));

    return $this;
  }

  public function removeSubscription(User_Model_User $user, User_Model_User $subscriber) {

    // Ignore if already not subscribed
    if( !$this->checkSubscription($user, $subscriber) ) {
      return $this;
    }

    // Delete
    $this->delete(array(
      'user_id = ?' => $user->getIdentity(),
      'subscriber_user_id = ?' => $subscriber->getIdentity(),
    ));

    return $this;
  }
}
