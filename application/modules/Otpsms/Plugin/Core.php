<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Plugin_Core extends Zend_Controller_Plugin_Abstract {
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
    $params = $request->getParams();    
    if(Engine_Api::_()->otpsms()->isServiceEnable()){
      include_once APPLICATION_PATH . '/application/modules/Otpsms/Plugin/Signup/Account.php';
	  
      include_once APPLICATION_PATH . '/application/modules/Otpsms/Form/Login.php';
      if($params['module'] == 'user' && ($params['action'] == 'forgot') && ($params['controller'] == "auth")) {
        $request->setModuleName('otpsms');
        $request->setControllerName('index');
        $request->setActionName('forgot');
      }else if($params['module'] == 'user' && ($params['action'] == 'login') && ($params['controller'] == "auth")) {
        $request->setModuleName('otpsms');
        $request->setControllerName('index');
        $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
        if(!count($_POST)){
            $otpverification->unsetAll();
        }
        if(!empty($otpverification->step) && $otpverification->step == 2){
          $request->setActionName('otpcode');
        }else{
          $request->setActionName('login');
        }
		return;
      }
      if($params['module'] != "otpsms") {
          $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
          $otpverification->unsetAll();
      }
    }
  }
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
        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
      					 .'application/modules/Otpsms/externals/scripts/core.js');
    }
    function onUserFormLoginInitAfter($event){

    }
    function onQuicksignupFormSignupFieldsInitAfter($event){
      $this->onUserFormSignupAccountInitAfter($event);
    }
  function onUserFormSignupAccountInitAfter($event){
    if(!Engine_Api::_()->otpsms()->isServiceEnable()){
          return;
    }
    $form = $event->getPayload();
    if($form->getElement('email') !== null) {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null; 
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $defaultCountry = !empty($_SESSION['login_country']) ? $_SESSION['login_country'] : $settings->getSetting('otpsms.default.countries','US');
      $defaultPhoneNumber = !empty($_SESSION['login_phone_number']) ? $_SESSION['login_phone_number'] : "";
      $countries = Engine_Api::_()->otpsms()->getCountryCodes();
      $allowedCountries = $settings->getSetting('otpsms_allowed_countries');
      $countriesArray = array();
      $otpsms_signup_phonenumber  = $settings->getSetting('otpsms_signup_phonenumber',1);
      $otpsms_choose_phonenumber = $settings->getSetting('otpsms_choose_phonenumber',0);
      $otpsms_required_phonenumber = $settings->getSetting('otpsms_required_phonenumber',1);
      $orderOrginal = 2;
      $order = 1;
      $display = 'block';
      if($otpsms_choose_phonenumber){
        $emailField = $form->getElement($form->getEmailElementFieldName())->setAttrib('class','emailField');
        $emailFieldName = $form->getEmailElementFieldName();
        $display = "none";
          $form->addElement('Dummy','change_otp_type',array(
            'order'=>$order,
            'content'=>'<a href="javascript:;" data-rel="phone" class="opt_change_type">'.$view->translate("Create via Phone Number").'</a><a href="javascript:;" data-rel="email" style="display:none;" class="opt_change_type">'.$view->translate("Create via Email Address").'</a>
            <script type="application/javascript">
              sesJqueryObject(document).on("ready",function(e){
                var elementEmailName = sesJqueryObject(".emailField");  
                for(i=0;i<elementEmailName.length;i++){
                  var elem = sesJqueryObject(elementEmailName[i]).closest(".form-elements");
                  var value = elem.find("#otp_field_type").val();
                  if(value == "phone"){
                     elem.find("#change_otp_type-wrapper").find("#change_otp_type-element").find("a[data-rel=\'phone\']").trigger("click");
                  } 
                }
              });
            </script>'
            )
           );
          $orderOrginal = 3;
      }
      if($otpsms_signup_phonenumber){
        foreach ($countries as $code => $country) {
          $countryName = ucwords(strtolower($country["name"]));
          if($code == $defaultCountry)
            $defaultCountry = $country['code'];
          if(count($allowedCountries) && !in_array($code,$allowedCountries))
            continue;
          $countriesArray[$country["code"]] = "+".$country["code"];
        }
        if(!$otpsms_choose_phonenumber && $otpsms_required_phonenumber){
           $required = true;
           $allowEmpty = false;
           $requiredClass = ' required';
        }else{
           $required = false;
           $allowEmpty = true;
           $requiredClass = '';
        }
        $form->addElement('Select','country_code',array(
          'value'=>$defaultCountry,
          'label'=>'Country Code',
          'required'=>$required,
          'allowEmpty' => $allowEmpty,
          'multiOptions'=>$countriesArray,
          'order'=> ++$order,
        ));
        $form->addElement('Text','phone_number',array(
          'placeholder'=>'Phone Number',
          'label' => 'Phone Number',
          'order'=> ++$order,
          'required'=>$required,
          'allowEmpty' => $allowEmpty,
          'value' => $defaultPhoneNumber,
          'validators' => array(
            array('NotEmpty', empty($required) ? false : true),
            array('Regex', true, array('/^[1-9][0-9]{4,15}$/')),
            array('Db_NoRecordExists', true, array(Engine_Db_Table::getTablePrefix() . 'users', 'phone_number'))
          ),
        ));
        $form->addElement('Hidden','otp_field_type',array('order'=>87678,'value'=>!empty($_POST['otp_field_type']) ? $_POST['otp_field_type'] : "email"));
        $form->phone_number->getValidator('Db_NoRecordExists')->setMessage('Someone has already registered this phone number, please use another one.', 'recordFound');
        $form->phone_number->getDecorator('Description')->setOptions(array('placement' => 'APPEND', 'escape' => false));
        $form->phone_number->getValidator('Regex')->setMessage('Please enter a valid phone number.', 'regexNotMatch');
        $form->addDisplayGroup(array('phone_number', 'country_code'), 'otp_phone_number',array('order'=>$orderOrginal));
        $button_group = $form->getDisplayGroup('otp_phone_number');
        $button_group->setDescription('Phone Number');
        $button_group->setDecorators(array(
            'FormElements',
            array('Description', array('placement' => 'PREPEND', 'tag' => 'div', 'class' => 'form-label'.$requiredClass)),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' => 'otp_phone_number','style'=>'display:'.$display.';'))
        ));
      }
    }
  }
}
