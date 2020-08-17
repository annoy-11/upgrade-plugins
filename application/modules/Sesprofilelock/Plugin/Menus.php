<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Plugin_Menus {

  public function canLocked() {

    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    $level_id = $viewer->level_id;

    if (empty($viewer->password)) {
      return false;
    }
    $enable_lock = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.lock');
    if(empty($enable_lock))
      return false;
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }

    $sesproflelock_levels = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproflelock.levels');
    $sesproflelock_levelsvalue = unserialize($sesproflelock_levels);
    if (isset($sesproflelock_levelsvalue) && in_array($level_id, $sesproflelock_levelsvalue)) {
      return true;
    } else {
      return false;
    }

    return true;
  }

  public function onMenuInitialize_SesprofilelockIndexProfilelock($row) {
   
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    if ($viewer->getIdentity() != $subject->getIdentity()) {
      return false;
    } else {
      return true;
    }
  }

}
