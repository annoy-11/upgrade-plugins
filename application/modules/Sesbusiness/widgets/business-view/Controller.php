<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_BusinessViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('business_id', null);
    $business_id = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->business = $business = Engine_Api::_()->getItem('businesses', $business_id);
    else
      $this->view->business = $business = Engine_Api::_()->core()->getSubject();

    $sesprofilelock_enable_module = (array) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
    if (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock')) && in_array('sesbusiness', $sesprofilelock_enable_module) && $viewerId != $business->owner_id) {
      $cookieData = '';
      if ($business->enable_lock && !in_array($business->business_id, explode(',', $cookieData))) {
        $this->view->locked = true;
      } else {
        $this->view->locked = false;
      }
      $this->view->password = $business->business_password;
    } else
      $this->view->password = true;

      $businessTable = Engine_Api::_()->getDbtable('businesses', 'sesbusiness');
      $owner = $business->getOwner();
      if( !$business->isOwner($viewer) ) {
          $businessTable->update(array(
              'view_count' => new Zend_Db_Expr('view_count + 1'),
          ), array(
              'business_id = ?' => $business->getIdentity(),
          ));
      }
    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($business->category_id))
      $this->view->category = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->find($business->category_id)->current();
    $this->view->businessTags = $business->tags()->getTagMaps();
    $this->view->canComment = $business->authorization()->isAllowed($viewer, 'comment');
  }

}
