<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Login.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Form_Login extends Engine_Form_Email{
  protected $_mode;

  public function setMode($mode)
  {
    $this->_mode = $mode;
    return $this;
  }

  public function getMode()
  {
    if( null === $this->_mode ) {
      $this->_mode = 'page';
    }
    return $this->_mode;
  }

  public function init()
  {
    $tabindex = rand(100, 9999);
    $this->_emailAntispamEnabled = (Engine_Api::_()->getApi('settings', 'core')
          ->getSetting('core.spam.email.antispam.login', 1) == 1);

    // Used to redirect users to the correct page after login with Facebook
    $_SESSION['redirectURL'] = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

    $description = Zend_Registry::get('Zend_Translate')->_("If you already have an account, please enter your details below. If you don't have one yet, please <a href='%s'>sign up</a> first.");
    $description= sprintf($description, Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_signup', true));

    // Init form
    $this->setTitle('Member Sign In');
    $this->setDescription($description);
    $this->setAttrib('id', 'user_form_login');
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $email = Zend_Registry::get('Zend_Translate')->_('Email Address');
    // Init email
    $emailElement = $this->addEmailElement(array(
      'label' => $email,
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        'EmailAddress'
      ),

      // Fancy stuff
      'tabindex' => $tabindex++,
      'autofocus' => 'autofocus',
      'inputType' => 'email',
      'class' => 'text',
    ));

    $emailElement->getValidator('EmailAddress')->getHostnameValidator()->setValidateTld(false);

    $password = Zend_Registry::get('Zend_Translate')->_('Password');
    // Init password
    $this->addElement('Password', 'password', array(
			 'placeholder' => $password,
      'label' => $password,
      'required' => true,
      'allowEmpty' => false,
      'tabindex' => $tabindex++,
      'filters' => array(
        'StringTrim',
      ),
    ));

    $this->addElement('Hidden', 'return_url', array(
      'value'=> Zend_Controller_Front::getInstance()->getRouter()->assemble(array()),
    ));

    $settings = Engine_Api::_()->getApi('settings', 'core');
    if( $settings->core_spam_login ) {
      $this->addElement('captcha', 'captcha', Engine_Api::_()->core()->getCaptchaOptions(array(
        'tabindex' => $tabindex++,
        'size' => ($this->getMode() == 'column') ? 'compact' : 'normal',
      )));
    }

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Sign In',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => $tabindex++,
    ));

    // Init remember me
    $this->addElement('Checkbox', 'remember', array(
      'label' => 'Remember Me',
      'tabindex' => $tabindex++,
    ));

    $content = Zend_Registry::get('Zend_Translate')->_("<span><a href='%s'>Forgot Password?</a></span>");
    $content= sprintf($content, Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth', 'action' => 'forgot'), 'default', true));


    // Init forgot password link
    $this->addElement('Dummy', 'forgot', array(
      'content' => $content,
    ));

		$this->addDisplayGroup(array('remember', 'forgot'), 'buttons');

		// Init facebook login link
    if( 'none' != $settings->getSetting('core_facebook_enable', 'none')
        && $settings->core_facebook_secret ) {
      $this->addElement('Dummy', 'facebook', array(
        'content' => User_Model_DbTable_Facebook::loginButton(),
      ));
    }

    // Init twitter login link
    if( 'none' != $settings->getSetting('core_twitter_enable', 'none')
        && $settings->core_twitter_secret ) {
      $this->addElement('Dummy', 'twitter', array(
        'content' => User_Model_DbTable_Twitter::loginButton(),
      ));
    }

    // Init janrain login link
    if( 'none' != $settings->getSetting('core_janrain_enable', 'none')
        && $settings->core_janrain_key ) {
      $mode = $this->getMode();
      $this->addElement('Dummy', 'janrain', array(
        'content' => User_Model_DbTable_Janrain::loginButton($mode),
      ));
    }

    // Set default action
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login'));
  }
}

class User_Form_Login extends Otpsms_Form_Login{
  public function init()
  {
    parent::init();
    $form = $this;
    if($form->getElement('email') !== null) {
      $elem = $form->getElement($form->getEmailElementFieldName());
      $elem->setLabel("Email or Phone");
      $elem->setAttrib("placeholder","Email or Phone");
      $elem->setAttrib("inputType","text");
      $form->setAttrib("class","otpsms_login_form global_form sesbasic_login_form");
      $elem->removeValidator('EmailAddress');
      $elem->setValidators(array(
        array('NotEmpty', true),
      ));
      //get settings
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $otpsms_login_options = $settings->getSetting('otpsms_login_options',0);
      if($otpsms_login_options == 1){
          $emailElementName = $form->getEmailElementFieldName();
          // show login with otp button
          $form->addElement('Button', 'login_via_otp', array(
            'label' => 'Sign In with OTP',
            'onClick' => 'sendotpCode();',
            'order' => 2,
            'decorators' => array(array('ViewScript', array(
              'viewScript' => 'application/modules/Otpsms/views/scripts/_otpLogin.tpl',
              'class' => 'form element',
              'emailFieldName' => $emailElementName
            )))
          ));
					// Show Password
					$this->addElement('dummy', 'showhidepassword', array(
						'order'=>1,
						'decorators' => array(array('ViewScript', array(
							'viewScript' => 'application/modules/Sesbasic/views/scripts/showhidepassword.tpl',
						))),
					));
          $form->addDisplayGroup(array(
            'password',
						'showhidepassword',
            'login_via_otp'
            ), 'password_buttons', array(
            'order' => 1,
          ));
      }
    }
  }
}
class Sesbasic_Form_Login extends User_Form_Login{
     public function init()
  {
    parent::init();

  }
}
