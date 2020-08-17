<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_PageViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('page_id', null);
    $page_id = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->page = $page = Engine_Api::_()->getItem('sespage_page', $page_id);
    else
      $this->view->page = $page = Engine_Api::_()->core()->getSubject();

    $sesprofilelock_enable_module = (array) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
    if (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock')) && in_array('sespage', $sesprofilelock_enable_module) && $viewerId != $page->owner_id) {
      $cookieData = '';
      if ($page->enable_lock && !in_array($page->page_id, explode(',', $cookieData))) {
        $this->view->locked = true;
      } else {
        $this->view->locked = false;
      }
      $this->view->password = $page->page_password;
    } else
      $this->view->password = true;


    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($page->category_id))
      $this->view->category = Engine_Api::_()->getDbTable('categories', 'sespage')->find($page->category_id)->current();
    $this->view->pageTags = $page->tags()->getTagMaps();
    $this->view->canComment = $page->authorization()->isAllowed($viewer, 'comment');
  }

}
