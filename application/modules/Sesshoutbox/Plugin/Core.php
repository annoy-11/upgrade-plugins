<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesshoutbox_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserDeleteBefore($event) {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {

      $contentsTable = Engine_Api::_()->getDbtable('contents', 'sesshoutbox');
      $select = $contentsTable->select()->where('poster_id = ?', $payload->getIdentity());
      foreach ($contentsTable->fetchAll($select) as $contents) {
        $contentsTable->delete(array('content_id =?' => $contents['content_id']));
      }
    }
  }
}
