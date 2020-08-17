<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Ecoupon
 * @package    Ecoupon
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Ecoupon_Widget_couponFaqsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->getElement()->removeDecorator('Title');
    $this->view->title = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.couponstitle', 'FAQs for Coupons');
    $this->view->body = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.couponsbody', '');
  }
}
