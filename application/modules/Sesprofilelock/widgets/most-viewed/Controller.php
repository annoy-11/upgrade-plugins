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
class Sesprofilelock_Widget_MostViewedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->statistics = $this->_getParam('statistics', array('viewCount', 'memberCount'));
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.blockedviewmembers')) {
      return $this->setNoRender();
    }
    $sesprofilelock_widget = Zend_Registry::isRegistered('sesprofilelock_widget') ? Zend_Registry::get('sesprofilelock_widget') : null;
    if(empty($sesprofilelock_widget))
      return $this->setNoRender();
    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->sesprofilelock()->getUsers();
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 3));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0) {
      return $this->setNoRender();
    }
  }

}
