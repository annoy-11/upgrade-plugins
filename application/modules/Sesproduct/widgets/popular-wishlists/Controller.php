<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_PopularWishlistsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $this->view->width = $this->_getParam('width', 100);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $showOptionsType = $this->_getParam('showOptionsType', 'all');

    $this->view->information = $this->_getParam('information', array('featured', 'viewCount', 'title', 'postedby'));

    $params = array();
    if ($showOptionsType == 'recommanded') {
      $params['widgteName'] = 'Recommanded Wishlist';
    }
    if ($showOptionsType == 'other') {
      $wishlist_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('wishlist_id');
      if ($wishlist_id)
        $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
      else
        return $this->setNoRender();
        $params['owner_id'] = $wishlist->owner_id;
        $params['widgteName'] = 'Other Wishlist';
        $params['wishlist_id'] = $wishlist->wishlist_id;
    }
    $params['is_private'] = true;
    $params['popularity'] = $this->_getParam('popularity', 'creation_date');
    $params['limit'] = $this->_getParam('limit', 3);
    $this->view->results = Engine_Api::_()->getDbtable('wishlists', 'sesproduct')->getWishlistPaginator($params);
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }

}
