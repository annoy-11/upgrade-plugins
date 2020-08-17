<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_BrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->createButton = $this->_getParam('createButton', 1);
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_main');
    if(count($this->view->navigation) == 1)
      $this->view->navigation = null;
    
    $eblog_browseblogs = Zend_Registry::isRegistered('eblog_browseblogs') ? Zend_Registry::get('eblog_browseblogs') : null;
    if (empty($eblog_browseblogs))
      return $this->setNoRender();
      
    $this->view->createBlog = Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'create');
      
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.taboptions', 6);
  }
}
