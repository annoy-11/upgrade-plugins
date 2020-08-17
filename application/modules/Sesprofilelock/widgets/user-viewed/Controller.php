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
class Sesprofilelock_Widget_UserViewedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $subject_id = Engine_Api::_()->core()->getSubject('user')->getIdentity();

    if ($viewer_id != $subject_id) {
      return $this->setNoRender();
    }

    $this->view->statistics = $this->_getParam('statistics', array('viewCount', 'lastSeen'));

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('uservieweds', 'sesprofilelock')->getViewedUsers(array('subject_id' => $subject_id));
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.blockedviewmembers')) {
      return $this->setNoRender();
    }
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 4));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0) {
      return $this->setNoRender();
    }
  }

}