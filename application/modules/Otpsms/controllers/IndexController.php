<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_IndexController extends Core_Controller_Action_Standard
{
  public function forgotAction(){
    $this->_helper->content
        ->setContentName("user_auth_forgot")
        ->setEnabled();
        
    // no logged in users
    if( Engine_Api::_()->user()->getViewer()->getIdentity() ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'home'), 'user_general', true);
    }

    // Make form
    $this->view->form = $form = new Otpsms_Form_Forgot();
    
    // Check request
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    $email = $_POST['email'];
    $valid = true;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
    }
    if(!$valid){
      if(is_numeric($email)){
         $valid = true;
      }  
    }
    if(!$valid){
      $form->addError("Email Address / Phone number is not valid, Please provide a valid Email or phone number.");  
      return;
    }
    // Check data
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Check for existing user
    $user = Engine_Api::_()->getDbtable('users', 'user')
      ->fetchRow(array('email = ?' => $form->getValue('email')));
    if( !$user || !$user->getIdentity() ) {
      $user = Engine_Api::_()->getDbtable('users', 'user')
      ->fetchRow(array('phone_number = ?' => $form->getValue('email')));
      if( !$user || !$user->getIdentity() ) {
        $form->addError('A user account with that email was not found.');
		  return;
      }
      
    }


    // Check to make sure they're enabled
    if( !$user->enabled ) {
      $form->addError('That user account has not yet been verified or disabled by an admin.');
      return;
    }

    // Ok now we can do the fun stuff
    $forgotTable = Engine_Api::_()->getDbtable('forgot', 'user');
    //$db = $forgotTable->getAdapter();
    //$db->beginTransaction();
    try
    {
      // Delete any existing reset password codes
      $forgotTable->delete(array(
        'user_id = ?' => $user->getIdentity(),
      ));
      if(!empty($user->phone_number)){
        $code = Engine_Api::_()->otpsms()->generateCode();
        //send code to mobile
        $this->view->number = "+".$user->country_code.$user->phone_number;
        Engine_Api::_()->otpsms()->sendMessage("+".$user->country_code.$user->phone_number, $code,"forgot_template");
        $this->view->codesend = true;
      }
      $this->view->user_id = $user->getIdentity();
      $this->view->formCode = new Otpsms_Form_Signup_Otpsms();
      // Create a new reset password code
      //$code = base_convert(md5($user->salt . $user->email . $user->user_id . uniqid(time(), true)), 16, 36);
      $forgotTable->insert(array(
        'user_id' => $user->getIdentity(),
        'code' => $code,
        'creation_date' => date('Y-m-d H:i:s'),
      ));
      
      // Send user an email
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'core_lostpassword', array(
        'host' => $_SERVER['HTTP_HOST'],
        'email' => $user->email,
        'date' => time(),
        'recipient_title' => $user->getTitle(),
        'recipient_link' => $user->getHref(),
        'recipient_photo' => $user->getPhotoUrl('thumb.icon'),
        'object_link' => $this->_helper->url->url(array('action' => 'reset', 'code' => $code, 'uid' => $user->getIdentity())),
        'queue' => false,
      ));

      //$db->commit();
    }

    catch( Exception $e )
    {
      //$db->rollBack();
      throw $e;
    }  
  }
  function verifyForgotAction(){
    $code = $this->_getParam('value','');
    $user_id = $this->_getParam('user_id','');
    $forgotTable = Engine_Api::_()->getDbtable('forgot', 'user');
    $forgotSelect = $forgotTable->select()
      ->where('user_id = ?', $user_id)
      ->where('code = ?', $code);
      
    $forgotRow = $forgotTable->fetchRow($forgotSelect);
    if( !$forgotRow || (int) $forgotRow->user_id !== (int) $user_id ) {
       echo json_encode(array('error'=>1,'message'=>$this->view->translate('Invalid code')));die;
    }
      echo json_encode(array('error'=>0,'url'=>$this->_helper->url->url(array('module'=>'user','controller'=>'auth','action' => 'reset', 'code' => $code, 'uid' => $user_id))));die;
  }
  public function verifyCodeAction()
  {
      $otpsmsSession = new Zend_Session_Namespace('Otpsms_Verification');
      //generate code
      $code = Engine_Api::_()->otpsms()->generateCode();
      $number = $this->_getParam('number','');  
      if($number){
        $phone_number = $number;
        $user = Engine_Api::_()->getItem('user',$this->_getParam('user_id'));
        $forgotTable = Engine_Api::_()->getDbtable('forgot', 'user');
        //delete previous forgot password entry
        $forgotTable->delete(array(
         'user_id = ?' => $user->getIdentity(),
        ));
        $forgotTable->insert(array(
          'user_id' => $user->getIdentity(),
          'code' => $code,
          'creation_date' => date('Y-m-d H:i:s'),
        ));
      }else{
        $otpsmsSession->code = $code;
        $otpsmsSession->creation_time = time();
        $phone_number = $otpsmsSession->phone_number;
      }
      //send code to mobile
      $type = $this->_getParam('type','signup_template');
      Engine_Api::_()->otpsms()->sendMessage($phone_number, $code,$type);
      echo json_encode(array('message'=>$this->view->translate('Code Send Successfully.')));die;
  }
  public function phoneNumberAction(){
    // Check viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer || !$viewer->getIdentity())
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    
    $otpsmsverification = new Zend_Session_Namespace('Otpsms_Verification');
    $this->view->user = $subject = Engine_Api::_()->user()->getViewer();
    Engine_Api::_()->core()->setSubject($subject);
    if(!count($_POST)){
      $otpsmsverification->unsetAll();
      $otpsmsverification->step = 1;
    }
    
    if($otpsmsverification->step == 1){
      $this->view->form = $form = new Otpsms_Form_Phonenumber();
      $form->phone_number->setValue($subject->phone_number);
      if($subject->country_code)
        $form->country_code->setValue($subject->country_code);
      else
        $form->removeElement('remove');
      $form->enable->setValue($subject->enable_verification);      
      if(!$this->getRequest()->isPost())
        return;
      // Check data
      if(!$form->isValid($this->getRequest()->getPost()))
        return;



      if(!empty($_POST['remove'])){
        $subject->phone_number = "";
        $subject->country_code = "";
        $subject->enable_verification = 0;
        $subject->save();  
        $form->reset();
        $form->removeElement('remove');
        $form->addNotice("Phone Number removed successfully.");
        $otpsmsverification->unsetAll();
        $otpsmsverification->step = 1;
        return;
      }
      $values = $form->getValues();
        //check phone number already exists
        $table = Engine_Api::_()->getDbTable('users','user');
        $select = $table->select()->where('phone_number =?',$values['phone_number'])->where('user_id !=?',$this->view->viewer()->getIdentity());
        $res = $table->fetchAll($select);
        if(count($res)){
            $form->addError('Phone Number already exists.');
            return;
        }
      //save values in session      
      $otpsmsverification->phone_number = "+".$values['country_code'].$values['phone_number'];
        $otpsmsverification->phone_number_code = $values['phone_number'];
      $otpsmsverification->country_code = $values['country_code'];
      $otpsmsverification->enable_verification = $values['enable'];
      $otpsmsverification->step = 2;
    }
    
    if($otpsmsverification->step == 2){
      $this->view->form = $form = new Otpsms_Form_Signup_Otpsms();
      $inputcode = $this->_getParam("code");
      if( empty($otpsmsverification->code)){
        //generate code
        $code = Engine_Api::_()->otpsms()->generateCode();
        $otpsmsverification->code = $code;
        $otpsmsverification->creation_time = time();
        //send code to mobile
        if($subject->phone_number)
          $this->view->type = $type = "edit_number_template";
        else
          $this->view->type =  $type = "add_number_template";
        Engine_Api::_()->otpsms()->sendMessage("+".$otpsmsverification->country_code.$otpsmsverification->phone_number_code , $code ,$type);
      }
      if(empty($_POST['code']))
        return;
      if($form->isValid($this->getRequest()->getPost())){
        $code = $otpsmsverification->code;
        $expiretime = Engine_Api::_()->getApi('settings', 'core')->getSetting("otpsms.duration",600);
        $codeexpirytime = time() - $expiretime;
        if($code != $inputcode){
          $form->addError("The OTP code you entered is invalid. Please enter the correct OTP code.");
        }else if($otpsmsverification->creation_time < $codeexpirytime){
          $form->addError("The OTP code you entered has expired. Please click on'RESEND' button to get new OTP code.");
        }else{
          //save phone number
          $subject->phone_number = $otpsmsverification->phone_number_code;
          $subject->country_code = $otpsmsverification->country_code;
          $subject->enable_verification = $otpsmsverification->enable_verification;
          $subject->save();
          $otpsmsverification->unsetAll();
          header("Location:".$_SERVER['REQUEST_URI']);
        }
      }      
    }
    // Set up require's
    $this->_helper->requireUser();
    $this->_helper->requireSubject();
    $this->_helper->requireAuth()->setAuthParams(
      $subject, null, 'edit'
    );    
     $this->_helper->content
      ->setEnabled();
  }
  function loginOtpAction(){
    $email = $this->_getParam('emailField');
    $password = $this->_getParam('password');
    $valid = true;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
    }
    if(!$valid){
      if(is_numeric($email)){
         $valid = true; 
      }  
    }
    if(!$valid){
      echo json_encode(array("error" => 1,'message'=>"Email Address / Phone number is not valid, Please provide a valid Email or phone number."));die;  
      return;
    }
    
    // Get ip address
    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    // Check for existing user
    $user = Engine_Api::_()->getDbtable('users', 'user')
      ->fetchRow(array('email = ?' => $email));
    if( !$user || !$user->getIdentity() ) {
      $user = Engine_Api::_()->getDbtable('users', 'user')
      ->fetchRow(array('phone_number = ?' => $email));
      if( !$user || !$user->getIdentity() ) {
        
      // Register login
      Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
        'email' => $email,
        'ip' => $ipExpr,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'state' => 'no-member',
      ));
        echo json_encode(array("error" => 1,'message'=>Zend_Registry::get('Zend_Translate')->_('No record of a member with that email was found.')));die;
      }
    }    
    $translate = Zend_Registry::get('Zend_Translate');
    // Check if user is verified and enabled
    if( !$user->enabled ) {
      if( !$user->verified ) {
        $this->view->status = false;
        $translate = Zend_Registry::get('Zend_Translate');
        $error = $translate->translate('This account still requires either email verification.');
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'disabled',
        ));
        
        echo json_encode(array("error" => 1,'message'=>$error));die;
      }else if(!$user->approved){
        $this->view->status = false;
        
        
        $error = $translate->translate('This account still requires admin approval.');
        
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'disabled',
        ));
        
        echo json_encode(array("error" => 1,'message'=>$error));die;
      }  
    }
    
    if( empty($user->phone_number) ) {
      $error = $translate->translate('No Phone Number is registered with your account please enter password to login.');
      echo json_encode(array("error" => 1,'message'=>$error));die;
    }
    
    // Register login
    Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
      'user_id' => $user->getIdentity(),
      'email' => $email,
      'ip' => $ipExpr,
      'timestamp' => new Zend_Db_Expr('NOW()'),
      'state' => 'OtpVerificationSend',
    ));
    
    $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
    $otpverification->unsetAll();
    $otpverification->user_id = $user->getIdentity();
    $otpverification->email = $email;
    $otpverification->password = $password;
    $otpverification->return_url = $this->_getparam('return_url');
    $otpverification->remember = $this->_getparam('remember',0);
    
    //validate opt limit set by admin
    $codes = Engine_Api::_()->getDbTable('codes','otpsms');
    $response = $codes->generateCode($user,$type = "login");
    if(!empty($response['error'])){
      echo json_encode(array('error'=>1,'message'=>$response['message']));die;  
    }
    $code = $response['code'];
    //send code to mobile
    Engine_Api::_()->otpsms()->sendMessage("+".$user->country_code.$user->phone_number, $code,"login_template");    
    
    $formOTP = new Otpsms_Form_Signup_Otpsms();
    $formOTP->setAttrib('class','otpsms_login_verify global_form');
    $formOTP->setAttrib('id', 'otpsms_login_verify');
    $formOTP->setAction($this->view->url(array('module'=>'otpsms','action'=>'verify-login','controller'=>'index'),'default',true));
    $formOTP->getElement('resend')->setAttrib('onClick','resendLoginData(this)');
    $formOTP->email_data->setValue($user->getIdentity());
    //send for to reponse
    echo json_encode(array('form'=>$formOTP->render($this->view),'error'=>0));die;
  }
  function verifyLoginAction(){
     $code = $this->_getParam('code','');
     $user_id = $this->_getParam('user_id','');
     //fetch from table
     $codes = Engine_Api::_()->getDbTable('codes','otpsms');
     $select = $codes->select()->where('user_id =?',$user_id)->where('code =?',$code)->where('type =?','login');
     $codeData = $codes->fetchRow($select);     
     if( !$codeData ) {
       echo json_encode(array('error'=>1,'message'=>$this->view->translate("OTP entered is not valid.")));die;
     }     
     $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
     $otpverification->code = $code;
     $expire = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.duration', 600);
     $time = time() - $expire;
     if( strtotime($codeData->modified_date) < $time ) {
       echo json_encode(array('error'=>1,'message'=>$this->view->translate("The OTP code you entered has expired. Please click on'RESEND' button to get new OTP code.")));die;
     }
     echo json_encode(array('error'=>0,'url'=>$this->view->url(array('module'=>'otpsms','action'=>'logged-userin','controller'=>'index'),'default',true)));die;
  } 
  
  function loggedUserinAction(){
    $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
    $email = $otpverification->email;
    $password = $otpverification->password;
    $return_url = $otpverification->return_url;
    $remember = $otpverification->remember;
    $code = $otpverification->code;
    $user_id = $otpverification->user_id;
    $otpverification->unsetAll();
    if(!$code)
      $this->_helper->redirector->gotoRoute(array(), 'default', true);
    
    $codes = Engine_Api::_()->getDbTable('codes','otpsms');
    $select = $codes->select()->where('user_id =?',$user_id)->where('code =?',$code)->where('type =?','login');
    $codeData = $codes->fetchRow($select);   
    if(!$codeData)
      $this->_helper->redirector->gotoRoute(array(), 'default', true);
    $user = Engine_Api::_()->getItem('user',$user_id);
    $email = $user->email;
	
    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $form = new User_Form_Login();
    // Handle subscriptions
    if( Engine_Api::_()->hasModuleBootstrap('payment') ) {
      // Check for the user's plan
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
      if( !$subscriptionsTable->check($user) ) {
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'unpaid',
        ));
        // Redirect to subscription page
        $subscriptionSession = new Zend_Session_Namespace('Payment_Subscription');
        $subscriptionSession->unsetAll();
        $subscriptionSession->user_id = $user->getIdentity();
        return $this->_helper->redirector->gotoRoute(array('module' => 'payment',
          'controller' => 'subscription', 'action' => 'index'), 'default', true);
      }
    }
    
    // Run pre login hook
    $event = Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserLoginBefore', $user);
    foreach( (array) $event->getResponses() as $response ) {
      if( is_array($response) ) {
        if( !empty($response['error']) && !empty($response['message']) ) {
          $form->addError($response['message']);
        } else if( !empty($response['redirect']) ) {
          $this->_helper->redirector->gotoUrl($response['redirect'], array('prependBase' => false));
        } else {
          continue;
        }
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'third-party',
        ));

        // Return
        return;
      }
    }

    // Version 3 Import compatibility
    if( empty($user->password) ) {
      $compat = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.compatibility.password');
      $migration = null;
      try {
        $migration = Engine_Db_Table::getDefaultAdapter()->select()
          ->from('engine4_user_migration')
          ->where('user_id = ?', $user->getIdentity())
          ->limit(1)
          ->query()
          ->fetch();
      } catch( Exception $e ) {
        $migration = null;
        $compat = null;
      }
      if( !$migration ) {
        $compat = null;
      }
      
      if( $compat == 'import-version-3' ) {

        // Version 3 authentication
        $cryptedPassword = self::_version3PasswordCrypt($migration['user_password_method'], $migration['user_code'], $password);
        if( $cryptedPassword === $migration['user_password'] ) {
          // Regenerate the user password using the given password
          $user->salt = (string) rand(1000000, 9999999);
          $user->password = $password;
          $user->save();
          Engine_Api::_()->user()->getAuth()->getStorage()->write($user->getIdentity());
          // @todo should we delete the old migration row?
        } else {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid credentials');
          $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid credentials supplied'));
          return;
        }
        // End Version 3 authentication

      } else {
        $form->addError('There appears to be a problem logging in. Please reset your password with the Forgot Password link.');

        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'v3-migration',
        ));
        
        return;
      }
    }else{
      	//Engine_Api::_()->user()->setViewer();
		Engine_Api::_()->user()->getAuth()->getStorage()->write($user->getIdentity());
      /*$authResult = Engine_Api::_()->user()->authenticate($email, $password);
      $authCode = $authResult->getCode();
      Engine_Api::_()->user()->setViewer();

      if( $authCode != Zend_Auth_Result::SUCCESS ) {
        $this->view->status = false;
        $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid credentials');
        $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid credentials supplied'));
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'bad-password',
        ));

        return;
      }*/
      
    }
    // -- Success! --
    // Register login
    $loginTable = Engine_Api::_()->getDbtable('logins', 'user');
    $loginTable->insert(array(
      'user_id' => $user->getIdentity(),
      'email' => $email,
      'ip' => $ipExpr,
      'timestamp' => new Zend_Db_Expr('NOW()'),
      'state' => 'success',
      'active' => true,
    ));
    $_SESSION['login_id'] = $login_id = $loginTable->getAdapter()->lastInsertId();
    
    // Remember
    if( $remember ) {
      $lifetime = 1209600; // Two weeks
      Zend_Session::getSaveHandler()->setLifetime($lifetime, true);
      Zend_Session::rememberMe($lifetime);
    }

    // Increment sign-in count
    Engine_Api::_()->getDbtable('statistics', 'core')
        ->increment('user.logins');

    // Test activity @todo remove
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() ) {
      $viewer->lastlogin_date = date("Y-m-d H:i:s");
      if( 'cli' !== PHP_SAPI ) {
        $viewer->lastlogin_ip = $ipExpr;
      }
      $viewer->save();
      Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($viewer, $viewer, 'login');
    }

    // Assign sid to view for json context
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Login successful');
    $this->view->sid = Zend_Session::getId();
    $this->view->sname = Zend_Session::getOptions('name');
    
    // Run post login hook
    $event = Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserLoginAfter', $viewer);
    
    // Do redirection only if normal context
    if( null === $this->_helper->contextSwitch->getCurrentContext() ) {
      // Redirect by form
      $uri = $form->getValue('return_url');
      if( $uri ) {
        if( substr($uri, 0, 3) == '64-' ) {
          $uri = base64_decode(substr($uri, 3));
        }
        return $this->_redirect($uri, array('prependBase' => false));
      }

      // Redirect by session
      $session = new Zend_Session_Namespace('Redirect');
      if( isset($session->uri) ) {
        $uri  = $session->uri;
        $opts = $session->options;
        $session->unsetAll();
        return $this->_redirect($uri, $opts);
      } else if( isset($session->route) ) {
        $session->unsetAll();
        return $this->_helper->redirector->gotoRoute($session->params, $session->route, $session->reset);
      }

      // Redirect by hook
      foreach( (array) $event->getResponses() as $response ) {
        if( is_array($response) ) {
          if( !empty($response['error']) && !empty($response['message']) ) {
            return $form->addError($response['message']);
          } else if( !empty($response['redirect']) ) {
            return $this->_helper->redirector->gotoUrl($response['redirect'], array('prependBase' => false));
          }
        }
      }

      // Redirect to edit profile if user has no profile type
      /*$aliasedFields = $viewer->fields()->getFieldsObjectsByAlias();
      $profileType = isset($aliasedFields['profile_type']) ?
        (is_object($aliasedFields['profile_type']->getValue($user)) ?
          $aliasedFields['profile_type']->getValue($viewer)->value : null
      ) : null;
      */
      if (empty($profileType)) {
        //return $this->_helper->redirector->gotoRoute(array(
          //'action' => 'profile',
          //'controller' => 'edit',
        //), 'user_extended', false);
      }
      // Just redirect to home
      return $this->_helper->redirector->gotoRoute(array('action' => 'home'), 'user_general', true);
    }  
  }
  
  function resendLoginCodeAction(){
    //$type = $this->_getParam('type');
    $user = Engine_Api::_()->getItem('user',$this->_getParam('user_id',0));
    //validate opt limit set by admin
    $codes = Engine_Api::_()->getDbTable('codes','otpsms');
    $response = $codes->generateCode($user,$type = "login");
    if(!empty($response['error'])){
      echo json_encode(array('error'=>1,'message'=>$response['message']));die;  
    }
    $code = $response['code'];
    //send code to mobile
    Engine_Api::_()->otpsms()->sendMessage("+".$user->country_code.$user->phone_number, $code,"login_template");    
    //send for to reponse
      $form = new Otpsms_Form_Signup_Otpsms();
      $description = $form->getDescription();
    echo json_encode(array('error'=>0,'description'=>$description));die;
  }
  function verifyAction(){
    //verify OTP
    $this->view->form = $form = new Otpsms_Form_Signup_Otpsms();
    $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
    $this->view->user_id = $otpverification->user_id;

    $form->setAction($this->view->url(array('module'=>'otpsms','action'=>'verify-login','controller'=>'index'),'default',true));
    
    $this->view->form->getElement('resend')->setAttrib('onClick','resendLoginOtpCode(this);');
    $this->view->form->getElement('submit')->setAttrib('onClick','sendLoginOptsms(this,"code");return false;');
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('No action taken');
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    
    
    
  }
  function loginAction(){
    // Already logged in
    if(Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('You are already signed in.');
      if( null === $this->_helper->contextSwitch->getCurrentContext() ) {
        $this->_helper->redirector->gotoRoute(array(), 'default', true);;
      }
      return;
    }
    
    // Make form
    $this->view->form = $form = new User_Form_Login();
    $form->setAction($this->view->url(array('return_url' => null), 'user_login'));
    $form->populate(array(
      'return_url' => $this->_getParam('return_url'),
    ));
    
    // Render
    $disableContent = $this->_getParam('disableContent', 0);
    if( !$disableContent ) {
      $this->_helper->content
        ->setContentName("user_auth_login")
        ->setEnabled();
    }
    
    // Not a post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('No action taken');
      return;
    }
    
    // Form not valid
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    extract($form->getValues());
    
    $valid = true;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
    }
    if(!$valid){
      if(is_numeric($email)){
         $valid = true; 
      }  
    }

    if(!$valid){
      $form->addError("Email Address / Phone number is not valid, Please provide a valid Email or phone number.");  
      return;
    }

    
    $user_table = Engine_Api::_()->getDbtable('users', 'user');
    $user_select = $user_table->select()
      ->where('email = ?', $email);          // If post exists
    $user = $user_table->fetchRow($user_select);
    
    // Get ip address
    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    
    // Check if user exists
    if( empty($user) ) {
        $user_table = Engine_Api::_()->getDbtable('users', 'user');
        $user_select = $user_table->select()
            ->where('phone_number = ?', $email);          // If post exists
        $user = $user_table->fetchRow($user_select);
        if( empty($user) ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('No record of a member with that email / phone number was found.');
            $form->addError(Zend_Registry::get('Zend_Translate')->_('No record of a member with that email / phone number was found.'));
            $_SESSION['loginaskjfh'] =
                // Register login
                Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
                    'email' => $email,
                    'ip' => $ipExpr,
                    'timestamp' => new Zend_Db_Expr('NOW()'),
                    'state' => 'no-member',
                ));

            return;
        }else{
            $email = $user->email;
        }
    }

    $isValidPassword = Engine_Api::_()->user()->checkCredential($user->getIdentity(), $password,$user);
    if (!$isValidPassword) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid credentials');
      $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid credentials supplied'));

      // Register bad password login
      Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
        'user_id' => $user->getIdentity(),
        'email' => $email,
        'ip' => $ipExpr,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'state' => 'bad-password',
      ));

      return;
    }

    // Check if user is verified and enabled
    if( !$user->enabled ) {
      if( !$user->verified ) {
        $this->view->status = false;
        
        $token = Engine_Api::_()->user()->getVerifyToken($user->getIdentity());
        $resend_url = $this->_helper->url->url(array('action' => 'resend', 'token'=> $token), 'user_signup', true);
        $translate = Zend_Registry::get('Zend_Translate');
        $error = $translate->translate('This account still requires either email verification.');
        $error .= ' ';
        $error .= sprintf($translate->translate('Click <a href="%s">here</a> to resend the email.'), $resend_url);
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'disabled',
        ));
        
        return;
      } else if( !$user->approved ) {
        $this->view->status = false;
        
        $translate = Zend_Registry::get('Zend_Translate');
        $error = $translate->translate('This account still requires admin approval.');
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'disabled',
        ));
        
        return;
      }
      // Should be handled by hooks or payment
      //return;
    }
    
    //OTP CODE HERE
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $otpAllow = Engine_Api::_()->authorization()->getPermission($user->level_id, 'otpsms', 'verification');
    if( $settings->getSetting('otpsms.login.options',0) != 1 && !empty($otpAllow) && !empty($user->phone_number) && !empty($user->enable_verification) ) {
      // Register login
      Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
        'user_id' => $user->getIdentity(),
        'email' => $email,
        'ip' => $ipExpr,
        'timestamp' => new Zend_Db_Expr('NOW()'),
        'state' => 'OtpVerificationSend',
      ));
      
      
      $otpverification = new Zend_Session_Namespace('Otp_Login_Verification');
      $otpverification->unsetAll();
      //validate opt limit set by admin
      $codes = Engine_Api::_()->getDbTable('codes','otpsms');
      $response = $codes->generateCode($user,$type = "login");
      if(!empty($response['error'])){
        $form->addError($response['message']);
        $otpverification->step = 1;
        $_POST['email'] = null;
        $_POST['password'] = null;
        return;
      }

      $otpverification->unsetAll();
      $otpverification->user_id = $user->getIdentity();
      $otpverification->step = 2;
      $otpverification->email = $email;
      $otpverification->password = $password;
      $otpverification->return_url = $this->_getparam('return_url');
      $otpverification->remember = $this->_getparam('remember',0);
      $code = $response['code'];
      $_POST['email'] = null;
      $_POST['password'] = null;
      //send code to mobile
      Engine_Api::_()->otpsms()->sendMessage("+".$user->country_code.$user->phone_number, $code,"login_template");    
      
     //redirect to outh login page
      return $this->_helper->redirector->gotoRoute(array('action' => 'verify'), 'optsms_verify', true);
     
    }  
    // Handle subscriptions
    if( Engine_Api::_()->hasModuleBootstrap('payment') ) {
      // Check for the user's plan
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
      if( !$subscriptionsTable->check($user) ) {
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'unpaid',
        ));
        // Redirect to subscription page
        $subscriptionSession = new Zend_Session_Namespace('Payment_Subscription');
        $subscriptionSession->unsetAll();
        $subscriptionSession->user_id = $user->getIdentity();
        return $this->_helper->redirector->gotoRoute(array('module' => 'payment',
          'controller' => 'subscription', 'action' => 'index'), 'default', true);
      }
    }
    
    // Run pre login hook
    $event = Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserLoginBefore', $user);
    foreach( (array) $event->getResponses() as $response ) {
      if( is_array($response) ) {
        if( !empty($response['error']) && !empty($response['message']) ) {
          $form->addError($response['message']);
        } else if( !empty($response['redirect']) ) {
          $this->_helper->redirector->gotoUrl($response['redirect'], array('prependBase' => false));
        } else {
          continue;
        }
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'third-party',
        ));

        // Return
        return;
      }
    }

    // Version 3 Import compatibility
    if( empty($user->password) ) {
      $compat = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.compatibility.password');
      $migration = null;
      try {
        $migration = Engine_Db_Table::getDefaultAdapter()->select()
          ->from('engine4_user_migration')
          ->where('user_id = ?', $user->getIdentity())
          ->limit(1)
          ->query()
          ->fetch();
      } catch( Exception $e ) {
        $migration = null;
        $compat = null;
      }
      if( !$migration ) {
        $compat = null;
      }
      
      if( $compat == 'import-version-3' ) {

        // Version 3 authentication
        $cryptedPassword = self::_version3PasswordCrypt($migration['user_password_method'], $migration['user_code'], $password);
        if( $cryptedPassword === $migration['user_password'] ) {
          // Regenerate the user password using the given password
          $user->salt = (string) rand(1000000, 9999999);
          $user->password = $password;
          $user->save();
          Engine_Api::_()->user()->getAuth()->getStorage()->write($user->getIdentity());
          // @todo should we delete the old migration row?
        } else {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid credentials');
          $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid credentials supplied'));
          return;
        }
        // End Version 3 authentication

      } else {
        $form->addError('There appears to be a problem logging in. Please reset your password with the Forgot Password link.');

        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'v3-migration',
        ));
        
        return;
      }
    }

    // Normal authentication
    else {

      $authResult = Engine_Api::_()->user()->authenticate($email, $password,$user);
      $authCode = $authResult->getCode();
      Engine_Api::_()->user()->setViewer();

      if( $authCode != Zend_Auth_Result::SUCCESS ) {
        $this->view->status = false;
        $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid credentials');
        $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid credentials supplied'));
        
        // Register login
        Engine_Api::_()->getDbtable('logins', 'user')->insert(array(
          'user_id' => $user->getIdentity(),
          'email' => $email,
          'ip' => $ipExpr,
          'timestamp' => new Zend_Db_Expr('NOW()'),
          'state' => 'bad-password',
        ));

        return;
      }
    }

    // -- Success! --

    // Register login
    $loginTable = Engine_Api::_()->getDbtable('logins', 'user');
    $loginTable->insert(array(
      'user_id' => $user->getIdentity(),
      'email' => $email,
      'ip' => $ipExpr,
      'timestamp' => new Zend_Db_Expr('NOW()'),
      'state' => 'success',
      'active' => true,
    ));
    $_SESSION['login_id'] = $login_id = $loginTable->getAdapter()->lastInsertId();
    
    // Remember
    if( $remember ) {
      $lifetime = 1209600; // Two weeks
      Zend_Session::getSaveHandler()->setLifetime($lifetime, true);
      Zend_Session::rememberMe($lifetime);
    }

    // Increment sign-in count
    Engine_Api::_()->getDbtable('statistics', 'core')
        ->increment('user.logins');

    // Test activity @todo remove
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() ) {
      $viewer->lastlogin_date = date("Y-m-d H:i:s");
      if( 'cli' !== PHP_SAPI ) {
        $viewer->lastlogin_ip = $ipExpr;
      }
      $viewer->save();
      Engine_Api::_()->getDbtable('actions', 'activity')
          ->addActivity($viewer, $viewer, 'login');
    }

    // Assign sid to view for json context
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Login successful');
    $this->view->sid = Zend_Session::getId();
    $this->view->sname = Zend_Session::getOptions('name');

    // Run post login hook
    $event = Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserLoginAfter', $viewer);

    // Do redirection only if normal context
    if( null === $this->_helper->contextSwitch->getCurrentContext() ) {
      // Redirect by form
      $uri = $form->getValue('return_url');
      if( $uri ) {
        if( substr($uri, 0, 3) == '64-' ) {
          $uri = base64_decode(substr($uri, 3));
        }
        return $this->_redirect($uri, array('prependBase' => false));
      }

      // Redirect by session
      $session = new Zend_Session_Namespace('Redirect');
      if( isset($session->uri) ) {
        $uri  = $session->uri;
        $opts = $session->options;
        $session->unsetAll();
        return $this->_redirect($uri, $opts);
      } else if( isset($session->route) ) {
        $session->unsetAll();
        return $this->_helper->redirector->gotoRoute($session->params, $session->route, $session->reset);
      }

      // Redirect by hook
      foreach( (array) $event->getResponses() as $response ) {
        if( is_array($response) ) {
          if( !empty($response['error']) && !empty($response['message']) ) {
            return $form->addError($response['message']);
          } else if( !empty($response['redirect']) ) {
            return $this->_helper->redirector->gotoUrl($response['redirect'], array('prependBase' => false));
          }
        }
      }

      // Redirect to edit profile if user has no profile type
      /*$aliasedFields = $viewer->fields()->getFieldsObjectsByAlias();
      $profileType = isset($aliasedFields['profile_type']) ?
        (is_object($aliasedFields['profile_type']->getValue($user)) ?
          $aliasedFields['profile_type']->getValue($viewer)->value : null
      ) : null;

      if (empty($profileType)) {
        return $this->_helper->redirector->gotoRoute(array(
          'action' => 'profile',
          'controller' => 'edit',
        ), 'user_extended', false);
      }
      */
      // Just redirect to home
      return $this->_helper->redirector->gotoRoute(array('action' => 'home'), 'user_general', true);
    }
  }
}
