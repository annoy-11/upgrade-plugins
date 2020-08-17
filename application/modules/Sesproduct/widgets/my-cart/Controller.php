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
class Sesproduct_Widget_MyCartController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    //get all cart data
    $this->view->socialSharingActive = 1;
    $this->view->likeButtonActive = 1;
    $this->view->favouriteButtonActive = 1;
    $cartData = Engine_Api::_()->sesproduct()->cartTotalPrice();
    $this->view->productsArray = $cartData['productsArray'];
    $this->view->totalPrice = round($cartData['totalPrice'],2);
  }

}
