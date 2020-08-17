<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_Widget_CouponViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
     $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('coupon_id', null);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->coupon = $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $id);
    else
      $this->view->coupon = $coupon = Engine_Api::_()->core()->getSubject();
    $couponTable = Engine_Api::_()->getDbtable('coupons', 'ecoupon');
    $owner = $coupon->getOwner();
    if( !$coupon->isOwner($viewer) ) {
        $couponTable->update(array(
            'view_count' => new Zend_Db_Expr('view_count + 1'),
        ), array(
            'coupon_id = ?' => $coupon->getIdentity(),
        ));
    }
    $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $params = Engine_Api::_()->ecoupon()->getWidgetParams($widgetId);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

  }
}
