<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesemailverification_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserUpdateBefore($event) {

    $user = $event->getPayload();
    $getUserEmail = Engine_Api::_()->sesemailverification()->getUserEmail($user->getIdentity());
    if($getUserEmail != $user->email) {
      $item = Engine_Api::_()->getItem('user', $user->user_id);

      Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->isRowExists($item->getIdentity());
    }
  }

  public function onUserCreateAfter($event) {

    $user = $event->getPayload();
    Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->isRowExists($user->getIdentity());
  }
}
