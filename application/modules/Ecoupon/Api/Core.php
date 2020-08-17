<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Api_Core extends Core_Api_Abstract {

  function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '') {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
      $defaultParams['precision'] = $precisionValue;
      if (!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])) {
        return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate);
      } else {
        $givenSymbol = $settings->getSetting('payment.currency', 'USD');
        return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $givenSymbol, $defaultParams);
      }
  }
  public function getCurrentCurrency(){
          $settings = Engine_Api::_()->getApi('settings', 'core');
      if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
      }else{
      return $settings->getSetting('payment.currency', 'USD');
      }
  }
  public function getWidgetParams($widgetId) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $params = $db->select()
              ->from('engine4_core_content', 'params')
              ->where('`content_id` = ?', $widgetId)
              ->query()
              ->fetchColumn();
      return json_decode($params, true);
  }
  public function getLikeStatus($item_id = '', $resource_type = '') {
    if ($item_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $item_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
  public function setAppliedCouponDetails($code) {
      if(!isset($_SESSION[$code]) || empty($_SESSION[$code]))
        return 0;
      $params = $_SESSION[$code]['params'];
      $viewer = Engine_Api::_()->user()->getViewer();
      $ordercoupons = Engine_Api::_()->getDbtable('ordercoupons', 'ecoupon');
      $data = $_SESSION[$code];
        unset($data['coupon_detail']);
      $ordercoupons->insert(array(
        'user_id' => $viewer->getIdentity(),
        'coupon_id' => $_SESSION[$code]['coupon_detail']->coupon_id,
        'resource_type'=> $params['resource_type'],
        'resource_id'=> $params['resource_id'],
        'is_package'=> $params['is_package'],
        'package_type'=> isset($params['package_type']) ? $params['package_type'] : '',
        'package_id'=> isset($params['package_id']) ? $params['package_id'] : 0,
        'discount_amount'=> $_SESSION[$code]['discount_amount'],
        'params'=> json_encode($data),
        'creation_date' => new Zend_Db_Expr('NOW()')
      ));
      $ordercouponId =  $ordercoupons->getAdapter()->lastInsertId();
      if($_SESSION[$code]['coupon_detail']->count_per_coupon > 0){
        $_SESSION[$code]['coupon_detail']->count_per_coupon--;
        $_SESSION[$code]['coupon_detail']->save();
      }
      return $ordercouponId;
  }
  public function applyCoupon(array $params = array('coupon_code'=>'','item_amount'=> 0,'resource_type'=>'all','resource_id'=>0,'buyer_id'=>0)){
    $coupon_detail = Engine_Api::_()->getDbtable('coupons', 'ecoupon')->getCouponDetails($params);
    $isCouponExist = @count($coupon_detail);
    $error_msg = '';
    $status = 1;
    $item_amount = $params['item_amount'];
    $discount_amount = 0;
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if(!empty($isCouponExist)) {
      if (empty($isCouponExist) || empty($coupon_detail->is_approved) || empty($coupon_detail->enabled) || $coupon_detail->count_per_coupon <= 0) {
        $error_msg = $view->translate("Please enter a different coupon code as %s is either invalid or expired", $params['coupon_code']);
        $status = 0;
      } 
      if((time() < strtotime($coupon_detail->discount_start_time)) || ($coupon_detail->discount_type == 1 && $coupon_detail->discount_end_time < time())) {
        $error_msg = $view->translate("Sorry you have entered expired coupon code.");
        $status = 0;
      }
      if(!empty($coupon_detail->count_per_buyer)){
        $uses_count = Engine_Api::_()->getDbtable('ordercoupons', 'ecoupon')->getOrderCouponCount(array('coupon_id'=>$coupon_detail->coupon_id));
        if($uses_count >= $coupon_detail->count_per_buyer){
          $error_msg = $view->translate("Sorry you can cannot apply this coupon more than %s", $params['coupon_code']);
          $status = 0;
        }
        
      } 
      if($coupon_detail->minimum_purchase_amount > $item_amount){
        $error_msg = $view->translate("Coupon is not valid on Your order amount please checkout amout for this coupon is %s ", $coupon_detail->minimum_purchase_amount);
        $status = 0;
      }
      if($status) {
        if ($coupon_detail->discount_type) {
          $discount_amount = $coupon_detail->fixed_discount_value;
        } else {
          $discount_amount = ($item_amount * $coupon_detail->percentage_discount_value) / 100;
        }
        $itemDiscountedAmount = $item_amount - $discount_amount;
        if(isset($params['buyer_id']) && !empty($params['buyer_id'])) {
          $ordercoupons = Engine_Api::_()->getDbtable('ordercoupons', 'ecoupon');
          $ordercoupons->insert(array(
            'user_id' => $params['buyer_id'],
            'coupon_id' => $coupon_detail->coupon_id,
            'resource_type'=> $params['resource_type'],
            'resource_id'=> $params['resource_id'],
            'is_package'=> 0,
            'creation_date' => new Zend_Db_Expr('NOW()')
          ));
        }
      }
    } else {
      $error_msg = $view->translate("Coupon is not valid");
      $status = 0;
    }
    return array('status'=>$status,'error_msg'=>$error_msg,'coupon_detail'=>$coupon_detail,'params'=>$params,'discount_amount'=>@round($discount_amount,2),'item_discounted_amount'=>@round($itemDiscountedAmount,2),'item_actual_amount'=>@round($item_amount,2));
  }  
  public function getItemTitle($itemType) {
    $table = Engine_Api::_()->getItemTable('ecoupon_type');
    $itemTableName = $table->info('name');
    return $table->select()
                    ->from($itemTableName,array('title'))
                    ->where("(`{$itemTableName}`.`item_type` LIKE ?)", "%{$itemType}%")
                    ->query()
                    ->fetchColumn();
  }
}
