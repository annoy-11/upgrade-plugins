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

class Sesproduct_Widget_CustomOfferController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->design = $design = $this->_getParam('design', 'design1');
    $this->view->offer_id = $offer_id = $this->_getParam('offer_id', 0);
    $this->view->heading = $heading = $this->_getParam('heading', '');
    $this->view->show_timer = $show_timer = $this->_getParam('show_timer', 'yes');
    $this->view->itemCount = $itemCount = $this->_getParam('itemCount', 3);
    $this->view->button_title = $button_title = $this->_getParam('button_title', '');
    $this->view->width = $width = $this->_getParam('width', 3);
    $this->view->height = $height = $this->_getParam('height', '');
    // Get Products
     $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'estore')->getSlides($offer_id,'',true,array('limit'=>$itemCount));
  }
}
