<?php

class Sespaymentapi_Api_Core extends Core_Api_Abstract {

  //return price with symbol and change rate param for payment history.
  public function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '') {
		$settings = Engine_Api::_()->getApi('settings', 'core');
    $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
    $defaultParams['precision'] = $precisionValue;
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate);
    }else{
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
  public function defaultCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
    }else{
      $settings = Engine_Api::_()->getApi('settings', 'core');
      return $settings->getSetting('payment.currency', 'USD');
    }
  }
}