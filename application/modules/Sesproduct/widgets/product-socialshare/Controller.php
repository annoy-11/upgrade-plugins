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

class Sesproduct_Widget_ProductSocialshareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('product_id', null);
    $this->view->design_type = $this->_getParam('socialshare_design', 1);
    $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->sesproduct = Engine_Api::_()->getItem('sesproduct', $product_id);
    else
    $this->view->sesproduct = Engine_Api::_()->core()->getSubject();
  }

}
