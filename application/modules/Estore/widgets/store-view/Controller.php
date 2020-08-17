<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_StoreViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('store_id', null);
    $store_id = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->store = $store = Engine_Api::_()->getItem('stores', $store_id);
    else
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();

    $sesprofilelock_enable_module = (array) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
    if (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock')) && in_array('estore', $sesprofilelock_enable_module) && $viewerId != $store->owner_id) {
      $cookieData = '';
      if ($store->enable_lock && !in_array($store->store_id, explode(',', $cookieData))) {
        $this->view->locked = true;
      } else {
        $this->view->locked = false;
      }
      $this->view->password = $store->store_password;
    } else
      $this->view->password = true;

      $storeTable = Engine_Api::_()->getDbtable('stores', 'estore');
      $owner = $store->getOwner();
      if( !$store->isOwner($viewer) ) {
          $storeTable->update(array(
              'view_count' => new Zend_Db_Expr('view_count + 1'),
          ), array(
              'store_id = ?' => $store->getIdentity(),
          ));
      }
    $this->view->main_photo_height = $main_photo_height = $this->_getParam('main_photo_height', 400);
    $this->view->main_photo_width = $main_photo_width = $this->_getParam('main_photo_width', 400);
    $this->view->cover_photo_height = $cover_photo_height = $this->_getParam('cover_photo_height', 400);
    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $params['tab_placement'] = isset($params['tab_placement']) ? isset($params['tab_placement']) : 'out';
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($store->category_id))
      $this->view->category = Engine_Api::_()->getDbTable('categories', 'estore')->find($store->category_id)->current();
    $this->view->storeTags = $store->tags()->getTagMaps();
    $this->view->canComment = $store->authorization()->isAllowed($viewer, 'comment');
  }

}
