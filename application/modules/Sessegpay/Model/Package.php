<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Package.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessegpay_Model_Package extends Payment_Model_Package{

 public function getPackageDescription()
  {
    $translate = Zend_Registry::get('Zend_Translate');
    $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD');
    $view = Zend_Registry::get('Zend_View');
    $priceStr = $view->locale()->toCurrency($this->price, $currency);
    
    // Plan is free
    if( $this->price == 0 ) {
      $str = $translate->translate('Free');
    }else if($this->type == 1){
       return  $view->locale()->toCurrency($this->initial_price, $currency) .' for '.$this->initial_length.' days then '.$view->locale()->toCurrency($this->recurring_price, $currency).' every '.$this->recurring_length.' days' ;
    }
    // Plan is recurring
    else if( $this->recurrence > 0 && $this->recurrence_type != 'forever' ) {

      // Make full string
      if( $this->recurrence == 1 ) { // (Week|Month|Year)ly
        if( $this->recurrence_type == 'day' ) {
          $typeStr = $translate->translate('daily');
        } else {
          $typeStr = $translate->translate($this->recurrence_type . 'ly');
        }
        $str = sprintf($translate->translate('%1$s %2$s'), $priceStr, $typeStr);
      } else { // per x (Week|Month|Year)s
        $typeStr = $translate->translate(array($this->recurrence_type, $this->recurrence_type . 's', $this->recurrence));
        $str = sprintf($translate->translate('%1$s per %2$s %3$s'), $priceStr,
          $this->recurrence, $typeStr); // @todo currency
      }
    }

    // Plan is one-time
    else {
      $str = sprintf($translate->translate('One-time fee of %1$s'), $priceStr);
    }

    // Add duration, if not forever
    if( $this->duration > 0 && $this->duration_type != 'forever' ) {
      $typeStr = $translate->translate(array($this->duration_type, $this->duration_type . 's', $this->duration));
      $str = sprintf($translate->translate('%1$s for %2$s %3$s'), $str, $this->duration, $typeStr);
    }

    return $str;
  }
}