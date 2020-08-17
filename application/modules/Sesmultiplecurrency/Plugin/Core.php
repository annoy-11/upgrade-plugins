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


class Sesmultiplecurrency_Plugin_Core extends Zend_Controller_Plugin_Abstract {
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefault($event) {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
    $checkPaymentExtentionsEnable = Engine_Api::_()->sesmultiplecurrency()->checkSesPaymentExtentionsEnable();
		$getCurrentCurrency = Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
    if($checkPaymentExtentionsEnable && Engine_Api::_()->sesmultiplecurrency()->multiCurrencyActive()) {
      $fullySupportedCurrencies = Engine_Api::_()->sesmultiplecurrency()->getSupportedCurrency();
      $currencyData = '<li class="sesmultiplecurrency_mini_menu_currency_chooser"><a href="javascript:;" id="sesmultiplecurrency_btn_currency"><span>'.Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency().'</span><i class="fa fa-caret-down"></i></a><div class="sesmultiplecurrency_mini_menu_currency_chooser_dropdown" id="sesmultiplecurrency_currency_change" style="display:none;"><ul id="sesmultiplecurrency_currency_change_data">';
      $defaultCurrency = Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      foreach ($fullySupportedCurrencies as $key => $values) {
        if(!$settings->getSetting('sesmultiplecurrency.'.$key.'active','0') && $key != $defaultCurrency)
          continue;
				if($getCurrentCurrency == $key)
					$active ='selected';
				else
					$active ='';
        $currencyData .= '<li class="'.$active.'"><a href="javascript:;" data-rel="'.$key.'">'.$key.'</a></li>';
      }
      $currencyData .= '</ul></div></li>';
      $script = 'sesJqueryObject(document).ready(function(e){
                  if(!sesJqueryObject(".sesariana_currencydropdown").length)
                  sesJqueryObject("#core_menu_mini_menu").find("ul").first().append(\''.$currencyData.'\');
                  else{
                  sesJqueryObject(".sesariana_currencydropdown").html(\''.$currencyData.'\');
                  if(!sesJqueryObject(".sesariana_currencydropdown").children().length)
                    sesJqueryObject(".sesariana_currencydropdown").parent().remove();
                  }
                })';
      $view->headScript()->appendScript($script);
    } else{
      $script = 'sesJqueryObject(document).ready(function(e){
            sesJqueryObject(".sesariana_currencydropdown").parent().remove();
      })';
      $view->headScript()->appendScript($script);
    }
  }
}
