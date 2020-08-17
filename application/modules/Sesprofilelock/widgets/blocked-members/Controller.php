<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Widget_BlockedMembersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $usersBlocksTable = Engine_Api::_()->getDbtable('block', 'user');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.blockedviewmembers')) {
      return $this->setNoRender();
    }
    $sesprofilelock_widget = Zend_Registry::isRegistered('sesprofilelock_widget') ? Zend_Registry::get('sesprofilelock_widget') : null;
    if(empty($sesprofilelock_widget))
      return $this->setNoRender();
    $select = $usersBlocksTable->select()->where('user_id =?', $viewer_id);
    $this->view->results = $usersBlocksTable->fetchAll($select);
    $count = count($this->view->results);
    if ($count <= 0) {
      return $this->setNoRender();
    }
  }

}
