<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmultiplecurrency_Api_Core extends Core_Api_Abstract {
  public function checkSesPaymentExtentionsEnable() {
    $moduleTable = Engine_Api::_()->getDbtable('modules', 'core');
    return $moduleTable->select()->from($moduleTable->info('name'), new Zend_Db_Expr('COUNT(*)'))->where('name In ("seseventticket","sesadvancedactivity", "sesvideosell", "sescrowdfunding","sescontestpackage","sescontestjoinfees","sesblogpackage", "seslisting","sesproduct","ecourse")')->where('enabled =?', 1)->query()->fetchColumn();
  }
  public function multiCurrencyActive() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $fullySupportedCurrencies = $this->getSupportedCurrency();
    foreach ($fullySupportedCurrencies as $key => $values) {
      if ($settings->getSetting('sesmultiplecurrency.' . $key . 'active', 0)) {
        //currency found  return true and exit.
        return true;
      }
    }
    return false;
  }

  public function isMultiCurrencyAvailable() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $fullySupportedCurrencies = $this->getSupportedCurrency();
    foreach ($fullySupportedCurrencies as $key => $values) {
      if ($settings->getSetting('sesmultiplecurrency.' . $key)) {
        $fullySupportedCurrenciesExists[$key] = $values;
        //currency found  return true and exit.
        return true;
      }
    }
    return false;
  }

  public function updateCurrencyValues() {
    $isMultiCurrencyAvailable = $this->multiCurrencyActive();
    if (!$isMultiCurrencyAvailable)
      return;
    $getDefaultCurrency = $this->defaultCurrency();
    if (!$getDefaultCurrency)
      return;
    $fullySupportedCurrencies = $this->getSupportedCurrency();
    //End chnage currency work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    foreach ($fullySupportedCurrencies as $key => $value) {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $getPriceActual = $settings->getSetting('sesmultiplecurrency.' . $key);
      if ($getDefaultCurrency == $key)
        continue;
      $currency = strtolower($getDefaultCurrency . $key);
      $from_Currency = urlencode($getDefaultCurrency);
      $to_Currency = urlencode($key);
      //$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20csv%20where%20url%3D%22http%3A%2F%2Ffinance.yahoo.com%2Fd%2Fquotes.csv%3Fe%3D.csv%26f%3Dnl1d1t1%26s%3D' . $currency . '%3DX%22%3B&format=json';
      //$url = "https://finance.google.com/finance/converter?a=1&from=$from_Currency&to=$to_Currency";

      $url = "http://free.currencyconverterapi.com/api/v5/convert?q=".$from_Currency.'_'.$to_Currency.'&compact=y';
      $get = file_get_contents($url);

      //$get = explode("<span class=bld>",$get);
      //$get = explode("</span>",$get[1]);
      //$converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);

        $data = json_decode($get,true);

      if ((!empty($data[$from_Currency.'_'.$to_Currency]['val']))) {
        $settings->setSetting('sesmultiplecurrency.' . $key, $data[$from_Currency.'_'.$to_Currency]['val']);
      } else
        continue;
    }
  }

  public function getSupportedCurrency() {
    // Populate currency options
    $supportedCurrencyIndex = array();
    $fullySupportedCurrencies = array();
    $supportedCurrencies = array();
    $gateways = array();
    $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    foreach( $gatewaysTable->fetchAll(/*array('enabled = ?' => 1)*/) as $gateway ) {
      $gateways[$gateway->gateway_id] = $gateway->title;
      $gatewayObject = $gateway->getGateway();
      $currencies = $gatewayObject->getSupportedCurrencies();
      if( empty($currencies) ) {
        continue;
      }
      $supportedCurrencyIndex[$gateway->title] = $currencies;
      if( empty($fullySupportedCurrencies) ) {
        $fullySupportedCurrencies = $currencies;
      } else {
        $fullySupportedCurrencies = array_intersect($fullySupportedCurrencies, $currencies);
      }
      $supportedCurrencies = array_merge($supportedCurrencies, $currencies);
    }
    $supportedCurrencies = array_diff($supportedCurrencies, $fullySupportedCurrencies);
    
    $translationList = Zend_Locale::getTranslationList('nametocurrency', Zend_Registry::get('Locale'));
    $fullySupportedCurrencies = array_intersect_key($translationList, array_flip($fullySupportedCurrencies));
    $supportedCurrencies = array_intersect_key($translationList, array_flip($supportedCurrencies));
    return array_merge($supportedCurrencies, $fullySupportedCurrencies);
  }

  public function getCurrencySymbolValue($price, $currency = '', $change_rate = '') {
    $currentCurrency = empty($_COOKIE['sesmultiplecurrency_currencyId']) ? $currency : $_COOKIE['sesmultiplecurrency_currencyId'];
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($currentCurrency != '') {
      $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currentCurrency);
      if ($currencyValue != '' && $change_rate == '') {
        return $currencyValue * $price;
      } else if ($change_rate != '') {
        return $change_rate * $price;
      }
    }
    return '';
  }

  //return price with symbol and change rate param for payment history.
  public function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '',$returnPrice = "") {
    //if (empty($price) || $price == 0)
    //return 0;
    $price = (float) $price;
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
    $defaultParams['precision'] = $precisionValue;
    if ($givenSymbol == '') {
      $defaultCurrency = $settings->getSetting('sesmultiplecurrency.defaultcurrency', 'USD');
      if (isset($_COOKIE['sesmultiplecurrency_currencyId']) && !empty($_COOKIE['sesmultiplecurrency_currencyId']) && $_COOKIE['sesmultiplecurrency_currencyId'] != $defaultCurrency) {
        $changePrice = $this->getCurrencySymbolValue($price, '', $change_rate);
        $currency = $_COOKIE['sesmultiplecurrency_currencyId'];
        if ($changePrice != '')
          $price = $changePrice;
      } else
        $currency = $defaultCurrency;
    }else if ($change_rate != '') {
      $changePrice = $this->getCurrencySymbolValue($price, '', $change_rate);
      if ($changePrice != '')
        $price = $changePrice;
      $currency = $givenSymbol;
    } else
      $currency = $givenSymbol;
      if($returnPrice)
        return $price;
      //check this function todo
    $priceStr = Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $currency, $defaultParams);
    return $priceStr;
  }

  public function getCurrentCurrency() {
    return empty($_COOKIE['sesmultiplecurrency_currencyId']) ? Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmultiplecurrency.defaultcurrency', 'USD') : $_COOKIE['sesmultiplecurrency_currencyId'];
  }

  public function defaultCurrency() {
    return Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmultiplecurrency.defaultcurrency', 'USD');
  }

}
