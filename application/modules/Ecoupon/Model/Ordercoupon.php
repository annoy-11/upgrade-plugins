<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Coupon.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Model_OrderCoupon extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_type = 'ecoupon_ordercoupon';
}
