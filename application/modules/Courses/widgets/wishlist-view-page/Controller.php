<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Widget_WishlistViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $wishlist_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('wishlist_id');
   if(!$wishlist_id)
    $this->setNoRender();
    $this->view->wishlist = $wishlist = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
    //Get viewer/subject
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $show_criterias = $this->_getParam('informationWishlist', array('wishlistOwner','editButton', 'deleteButton','viewCountWishlist', 'postedby', 'wishlistPhoto','favouriteButtonWishlist','descriptionWishlist','favouriteCountWishlist','featuredLabelWishlist','sponsoredLabelWishlist','likeButtonWishlist','socialSharingWishlist','likeCountWishlist','reportWishlist'));

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

  }

}
