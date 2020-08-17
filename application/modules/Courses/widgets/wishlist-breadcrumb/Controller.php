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

class Courses_Widget_WishlistBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $wishlist_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('wishlist_id');
   if ($wishlist_id)
       $wishlist = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
//     if (!$wishlist)
//       return $this->setNoRender();
     $this->view->subject = $wishlist;
  }

}
