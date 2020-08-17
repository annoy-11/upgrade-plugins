<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Account.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Plugin_Signup_Account extends Core_Plugin_FormSequence_Abstract {
    protected $_name = 'account';
    protected $_formClass = 'User_Form_Signup_Account';
    protected $_script = array('signup/form/account.tpl', 'user');
    protected $_adminFormClass = 'User_Form_Admin_Signup_Account';
    protected $_adminScript = array('admin-signup/account.tpl', 'user');
    public $email = null;
    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
    public function onView() {
        if (!empty($_SESSION['facebook_signup']) ||
                !empty($_SESSION['twitter_signup']) ||
                !empty($_SESSION['janrain_signup']) || !empty($_SESSION['linkedin_signup']) || !empty($_SESSION['instagram_signup']) || !empty($_SESSION['google_signup']) || !empty($_SESSION['yahoo_signup']) || !empty($_SESSION['pinterest_signup']) || !empty($_SESSION['flickr_signup'])) {
            
            // Attempt to preload information
            if (!empty($_SESSION['twitter_signup'])) {
                try {
                    $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
                    $twitter = $twitterTable->getApi();
                    $settings = Engine_Api::_()->getDbtable('settings', 'core');
                    if ($twitter && $settings->core_twitter_enable) {
                        $accountInfo = $twitter->account->verify_credentials();

                        // General
                        $this->getForm()->populate(array(
                            //'email' => $apiInfo['email'],
                            'username' => preg_replace('/[^A-Za-z]/', '', $accountInfo->name), // $accountInfo->screen_name
                            // 'timezone' => $accountInfo->utc_offset, (doesn't work)
                            'language' => $accountInfo->lang,
                        ));
                    }
                } catch (Exception $e) {
                    // Silence?
                }
            }
            if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessociallogin')){
              // Attempt to preload information
              if (!empty($_SESSION['facebook_signup'])) {
        try {
          $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
          $facebook = $facebookTable->getApi();
          $settings = Engine_Api::_()->getDbtable('settings', 'core');
          if ($facebook && $settings->core_facebook_enable) {
            // Get email address
            $apiInfo = $facebook->api('/me?fields=name,gender,email,locale');
            // General
            $form = $this->getForm();

            if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
              $emailEl->setValue($apiInfo['email']);
            }
            if (($usernameEl = $form->getElement('username')) && !$usernameEl->getValue()) {
              $usernameEl->setValue(preg_replace('/[^A-Za-z]/', '', $apiInfo['name']));
            }

            // Locale
            $localeObject = new Zend_Locale($apiInfo['locale']);
            if (($localeEl = $form->getElement('locale')) && !$localeEl->getValue()) {
              $localeEl->setValue($localeObject->toString());
            }
            if (($languageEl = $form->getElement('language')) && !$languageEl->getValue()) {
              if (isset($languageEl->options[$localeObject->toString()])) {
                $languageEl->setValue($localeObject->toString());
              } else if (isset($languageEl->options[$localeObject->getLanguage()])) {
                $languageEl->setValue($localeObject->getLanguage());
              }
            }
          }
        } catch (Exception $e) {
          // Silence?
        }
      }
            }
            if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessociallogin')){
              // Attempt to preload information
              if (!empty($_SESSION['facebook_signup'])) {
                  try {
                      $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sessociallogin');
                      $facebook = $facebookTable->getApi();
                      $settings = Engine_Api::_()->getDbtable('settings', 'core');
                      if ($facebook) {
                          // Get email address
                          $apiInfo = $facebook->api('/me?fields=name,gender,email,locale');
                          // General
                          $form = $this->getForm();
  
                          if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
                              $emailEl->setValue($apiInfo['email']);
                          }
                          if (($usernameEl = $form->getElement('username')) && !$usernameEl->getValue()) {
                              $usernameEl->setValue(preg_replace('/[^A-Za-z]/', '', $apiInfo['name']));
                          }
  
                          // Locale
                          $localeObject = new Zend_Locale($apiInfo['locale']);
                          if (($localeEl = $form->getElement('locale')) && !$localeEl->getValue()) {
                              $localeEl->setValue($localeObject->toString());
                          }
                          if (($languageEl = $form->getElement('language')) && !$languageEl->getValue()) {
                              if (isset($languageEl->options[$localeObject->toString()])) {
                                  $languageEl->setValue($localeObject->toString());
                              } else if (isset($languageEl->options[$localeObject->getLanguage()])) {
                                  $languageEl->setValue($localeObject->getLanguage());
                              }
                          }
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }
              
              if (!empty($_SESSION['linkedin_signup'])) {
                  try {
                      $linkedinTable = Engine_Api::_()->getDbtable('linkedin', 'sessociallogin');
                      $linkedin = $linkedinTable->getApi();
                      if ($linkedin && $linkedinTable->isConnected()) {
                          // General
                          $form = $this->getForm();
                          if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
                              $emailEl->setValue($_SESSION['signup_fields']['email']);
                          }
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }
  
              if (!empty($_SESSION['pinterest_signup'])) {
                  try {
                      if (1) {
                          // General
                          $form = $this->getForm();
                         // if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
                        //      $emailEl->setValue($_SESSION['signup_fields']['email']);
                         // }
                          if (($usernameEl = $form->getElement('username')) && !$usernameEl->getValue()) {
                              $usernameEl->setValue($_SESSION['signup_fields']['username']);
                          }
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }
              
              if (!empty($_SESSION['flickr_signup'])) {
                  try {
                      if (1) {
                          // General
                          $form = $this->getForm();
                         // if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
                        //      $emailEl->setValue($_SESSION['signup_fields']['email']);
                         // }
                          if (($usernameEl = $form->getElement('username')) && !$usernameEl->getValue()) {
                              $usernameEl->setValue($_SESSION['signup_fields']['username']);
                          }
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }
              
              if (!empty($_SESSION['instagram_signup'])) {
                  try {
                      $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sessociallogin');
                      $instagram = $instagramTable->getApi();
                      $settings = Engine_Api::_()->getDbtable('settings', 'core');
                      if ($instagram && $instagramTable->isConnected()) {
                          // General
                          $form = $this->getForm();
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }
  
              if (!empty($_SESSION['google_signup'])) {
                  try {
                      $googleTable = Engine_Api::_()->getDbtable('google', 'sessociallogin');
                      if ($googleTable->isConnected()) {
                          // General
                          $form = $this->getForm();
                          if (($emailEl = $form->getElement('email')) && !$emailEl->getValue()) {
                              $emailEl->setValue($_SESSION['signup_fields']['email']);
                          }
                      }
                  } catch (Exception $e) {
                      // Silence?
                  }
              }  
            }
            // Attempt to preload information
              if (!empty($_SESSION['janrain_signup']) &&
                      !empty($_SESSION['janrain_signup_info'])) {
                try {
                    $form = $this->getForm();
                    $info = $_SESSION['janrain_signup_info'];

                    if (($emailEl = $form->getElement('email')) && !$emailEl->getValue() && !empty($info['verifiedEmail'])) {
                        $emailEl->setValue($info['verifiedEmail']);
                    }
                    if (($emailEl = $form->getElement('email')) && !$emailEl->getValue() && !empty($info['email'])) {
                        $emailEl->setValue($info['email']);
                    }

                    if (($usernameEl = $form->getElement('username')) && !$usernameEl->getValue() && !empty($info['preferredUsername'])) {
                        $usernameEl->setValue(preg_replace('/[^A-Za-z]/', '', $info['preferredUsername']));
                    }
                } catch (Exception $e) {
                    // Silence?
                }
            }
        }
    }

    public function onProcess() {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $random = ($settings->getSetting('user.signup.random', 0) == 1);
        $emailadmin = ($settings->getSetting('user.signup.adminemail', 0) == 1);
        if ($emailadmin) {
            // the signup notification is emailed to the first SuperAdmin by default
            $users_table = Engine_Api::_()->getDbtable('users', 'user');
            $users_select = $users_table->select()
                    ->where('level_id = ?', 1)
                    ->where('enabled >= ?', 1);
            $super_admin = $users_table->fetchRow($users_select);
        }
        $data = $this->getSession()->data;

        // Add email and code to invite session if available
        $inviteSession = new Zend_Session_Namespace('invite');
        if (isset($data['email'])) {
            $inviteSession->signup_email = $data['email'];
        }
        if (isset($data['code'])) {
            $inviteSession->signup_code = $data['code'];
        }

        if ($random) {
            $data['password'] = Engine_Api::_()->user()->randomPass(10);
        }

        if (!empty($data['language'])) {
            $data['locale'] = $data['language'];
        }

        // Create user
        // Note: you must assign this to the registry before calling save or it
        // will not be available to the plugin in the hook
        $this->_registry->user = $user = Engine_Api::_()->getDbtable('users', 'user')->createRow();
        $user->setFromArray($data);
        $user->save();

        Engine_Api::_()->user()->setViewer($user);

        // Increment signup counter
        Engine_Api::_()->getDbtable('statistics', 'core')->increment('user.creations');

        if ($user->verified && $user->enabled) {
            // Create activity for them
            Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'signup');
            // Set user as logged in if not have to verify email
            Engine_Api::_()->user()->getAuth()->getStorage()->write($user->getIdentity());
        }

        $mailType = null;
        $mailParams = array(
            'host' => $_SERVER['HTTP_HOST'],
            'email' => $user->email,
            'date' => time(),
            'recipient_title' => $user->getTitle(),
            'recipient_link' => $user->getHref(),
            'recipient_photo' => $user->getPhotoUrl('thumb.icon'),
            'object_link' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_login', true),
        );

        // Add password to email if necessary
        if ($random) {
            $mailParams['password'] = $data['password'];
        }

        // Mail stuff
        switch ($settings->getSetting('user.signup.verifyemail', 0)) {
            case 0:
                // only override admin setting if random passwords are being created
                if ($random) {
                    $mailType = 'core_welcome_password';
                }
                if ($emailadmin) {
                    $mailAdminType = 'notify_admin_user_signup';
                    $siteTimezone = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.timezone', 'America/Los_Angeles');
                    $date = new DateTime("now", new DateTimeZone($siteTimezone));
                    $mailAdminParams = array(
                        'host' => $_SERVER['HTTP_HOST'],
                        'email' => $user->email,
                        'date' => $date->format('F j, Y, g:i a'),
                        'recipient_title' => $super_admin->displayname,
                        'object_title' => $user->displayname,
                        'object_link' => $user->getHref(),
                    );
                }
                break;

            case 1:
                // send welcome email
                $mailType = ($random ? 'core_welcome_password' : 'core_welcome');
                if ($emailadmin) {
                    $mailAdminType = 'notify_admin_user_signup';
                    $siteTimezone = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.timezone', 'America/Los_Angeles');
                    $date = new DateTime("now", new DateTimeZone($siteTimezone));
                    $mailAdminParams = array(
                        'host' => $_SERVER['HTTP_HOST'],
                        'email' => $user->email,
                        'date' => $date->format('F j, Y, g:i a'),
                        'recipient_title' => $super_admin->displayname,
                        'object_title' => $user->getTitle(),
                        'object_link' => $user->getHref(),
                    );
                }
                break;

            case 2:
                // verify email before enabling account
                $verify_table = Engine_Api::_()->getDbtable('verify', 'user');
                $verify_row = $verify_table->createRow();
                $verify_row->user_id = $user->getIdentity();
                $verify_row->code = md5($user->email
                        . $user->creation_date
                        . $settings->getSetting('core.secret', 'staticSalt')
                        . (string) rand(1000000, 9999999));
                $verify_row->date = $user->creation_date;
                $verify_row->save();

                $mailType = ($random ? 'core_verification_password' : 'core_verification');

                $mailParams['object_link'] = Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
                    'action' => 'verify',
                    'token' => Engine_Api::_()->user()->getVerifyToken($user->getIdentity()),
                    'verify' => $verify_row->code
                        ), 'user_signup', true);

                if ($emailadmin) {
                    $mailAdminType = 'notify_admin_user_signup';

                    $mailAdminParams = array(
                        'host' => $_SERVER['HTTP_HOST'],
                        'email' => $user->email,
                        'date' => date("F j, Y, g:i a"),
                        'recipient_title' => $super_admin->displayname,
                        'object_title' => $user->getTitle(),
                        'object_link' => $user->getHref(),
                    );
                }
                break;

            default:
                // do nothing
                break;
        }

        if (!empty($mailType)) {
            $this->_registry->mailParams = $mailParams;
            $this->_registry->mailType = $mailType;
            // Moved to User_Plugin_Signup_Fields
            // Engine_Api::_()->getApi('mail', 'core')->sendSystem(
            //   $user,
            //   $mailType,
            //   $mailParams
            // );
        }

        if (!empty($mailAdminType)) {
            $this->_registry->mailAdminParams = $mailAdminParams;
            $this->_registry->mailAdminType = $mailAdminType;
            // Moved to User_Plugin_Signup_Fields
            // Engine_Api::_()->getApi('mail', 'core')->sendSystem(
            //   $user,
            //   $mailType,
            //   $mailParams
            // );
        }

        // Attempt to connect facebook
        
        
        if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessociallogin')){
          if (!empty($_SESSION['facebook_signup'])) {
              try {
                $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sessociallogin');
                $facebook = $facebookTable->getApi();
                $settings = Engine_Api::_()->getDbtable('settings', 'core');
                $enable = $settings->getSetting('sessociallogin.facebook.enable', '0');
                if ($facebook && $enable) {
                    $facebookTable->insert(array(
                        'user_id' => $user->getIdentity(),
                        'facebook_uid' => $facebook->getUser(),
                        'access_token' => $facebook->getAccessToken(),
                        //'code' => $code,
                        'expires' => 0, // @todo make sure this is correct
                    ));
                }
              } catch (Exception $e) {
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
            unset($_SESSION['facebook_signup']);
          }
          // Attempt to connect linkedin
          if (!empty($_SESSION['linkedin_signup'])) {
              try {
                  $linkedinTable = Engine_Api::_()->getDbtable('linkedin', 'sessociallogin');
                  if ($linkedinTable->isConnected()) {
                      $linkedinTable->insert(array(
                          'user_id' => $user->getIdentity(),
                          'linkedin_uid' => $_SESSION['linkedin_uid'],
                          'access_token' => $_SESSION['linkedin_token'],
                          'code' => $_SESSION['linkedin_secret'],
                          'expires' => 0,
                      ));
                  }
              } catch (Exception $e) {
                  throw $e;
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['linkedin_signup']);
          }
  
          // Attempt to connect yahoo
          if (!empty($_SESSION['yahoo_signup'])) {
              try {
                  $yahooTable = Engine_Api::_()->getDbtable('yahoo', 'sessociallogin');
                  $yahooTable->insert(array(
                      'user_id' => $user->getIdentity(),
                      'yahoo_uid' => $_SESSION['yahoo_uid'],
                  ));
              } catch (Exception $e) {
                  throw $e;
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['yahoo_signup']);
          }
  
          // Attempt to connect pinterest
          if (!empty($_SESSION['pinterest_signup'])) {
              try {
                  $pinterestTable = Engine_Api::_()->getDbtable('pinterest', 'sessociallogin');
                  $pinterestTable->insert(array(
                      'user_id' => $user->getIdentity(),
                      'pinterest_uid' => $_SESSION['pinterest_uid'],
                  ));
              } catch (Exception $e) {
                  throw $e;
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['pinterest_signup']);
          }
  
          // Attempt to connect instagram
          if (!empty($_SESSION['instagram_signup'])) {
              try {
                  $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sessociallogin');
                  $instagram = $instagramTable->getApi();
                  $settings = Engine_Api::_()->getDbtable('settings', 'core');
                  if ($instagram) {
                      $instagramTable->insert(array(
                          'user_id' => $user->getIdentity(),
                          'instagram_uid' => $_SESSION['instagram_uid'],
                          'access_token' => $_SESSION['instagram_token'],
                          'code' => $_SESSION['instagram_code'],
                          'expires' => 0,
                      ));
                  }
              } catch (Exception $e) {
                  throw $e;
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['instagram_signup']);
          }
  
          // Attempt to connect google
          if (!empty($_SESSION['google_signup'])) {
              try {
                  $googleTable = Engine_Api::_()->getDbtable('google', 'sessociallogin');
                  if ($googleTable->isConnected()) {
                      $googleTable->insert(array(
                          'user_id' => $user->getIdentity(),
                          'google_uid' => $_SESSION['google_uid'],
                          'access_token' => $_SESSION['access_token'],
                          'code' => $_SESSION['refresh_token'],
                          'expires' => 0,
                      ));
                  }
              } catch (Exception $e) {
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['google_signup']);
          }
          // Attempt to connect vk
          if (!empty($_SESSION['vk_signup'])) {
              try {
                  $vkTable = Engine_Api::_()->getDbtable('vk', 'sessociallogin');
                  if ($vkTable->isConnected()) {
                      $vkTable->insert(array(
                          'user_id' => $user->getIdentity(),
                          'vk_uid' => $_SESSION['vk_uid'],
                          'access_token' => $_SESSION['access_token'],
                          'code' => 0,
                          'expires' => 0,
                      ));
                  }
              } catch (Exception $e) {
                  // Silence
                  if ('development' == APPLICATION_ENV) {
                      echo $e;
                  }
              }
              unset($_SESSION['vk_signup']);
          }
           // Attempt to connect flickr
          if (!empty($_SESSION['flickr_signup'])) {
            try {
                $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sessociallogin');
                if ($flickrTable->isConnected()) {
                    $flickrTable->insert(array(
                        'user_id' => $user->getIdentity(),
                        'flickr_uid' => $_SESSION['flickr_uid'],
                        'access_token' => $_SESSION['access_token'],
                        'code' => $_SESSION['code'],
                        'expires' => 0,
                    ));
                }
            } catch (Exception $e) {
                // Silence
                if ('development' == APPLICATION_ENV) {
                    echo $e;
                }
            }
            unset($_SESSION['flickr_signup']);
        }
        }else{
          if (!empty($_SESSION['facebook_signup'])) {
            try {
                $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
                $facebook = $facebookTable->getApi();
                $settings = Engine_Api::_()->getDbtable('settings', 'core');
                if ($facebook && $settings->core_facebook_enable) {
                    $facebookTable->insert(array(
                        'user_id' => $user->getIdentity(),
                        'facebook_uid' => $facebook->getUser(),
                        'access_token' => $facebook->getAccessToken(),
                        //'code' => $code,
                        'expires' => 0, // @todo make sure this is correct
                    ));
                }
            } catch (Exception $e) {
                // Silence
                if ('development' == APPLICATION_ENV) {
                    echo $e;
                }
            }
          unset($_SESSION['facebook_signup']);
        }  
        }
        // Attempt to connect twitter
        if (!empty($_SESSION['twitter_signup'])) {
            try {
                $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
                $twitter = $twitterTable->getApi();
                $twitterOauth = $twitterTable->getOauth();
                $settings = Engine_Api::_()->getDbtable('settings', 'core');
                if ($twitter && $twitterOauth && $settings->core_twitter_enable) {
                    $accountInfo = $twitter->account->verify_credentials();
                    $twitterTable->insert(array(
                        'user_id' => $user->getIdentity(),
                        'twitter_uid' => $accountInfo->id,
                        'twitter_token' => $twitterOauth->getToken(),
                        'twitter_secret' => $twitterOauth->getTokenSecret(),
                    ));
                }
            } catch (Exception $e) {
                // Silence?
                if ('development' == APPLICATION_ENV) {
                    echo $e;
                }
            }
            unset($_SESSION['twitter_signup']);
        }

        // Attempt to connect twitter
        if (!empty($_SESSION['janrain_signup'])) {
            try {
                $janrainTable = Engine_Api::_()->getDbtable('janrain', 'user');
                $settings = Engine_Api::_()->getDbtable('settings', 'core');
                $info = $_SESSION['janrain_signup_info'];
                if ($settings->core_janrain_enable) {
                    $janrainTable->insert(array(
                        'user_id' => $user->getIdentity(),
                        'identifier' => $info['identifier'],
                        'provider' => $info['providerName'],
                        'token' => (string) @$_SESSION['janrain_signup_token'],
                    ));
                }
            } catch (Exception $e) {
                // Silence?
                if ('development' == APPLICATION_ENV) {
                    echo $e;
                }
            }
        }
    }
    public function onSubmit(Zend_Controller_Request_Abstract $request)
    {
      if( $request->isPost() ){
        $params = $request->getParams();
        if(!empty($params['otp_field_type']) && $params['otp_field_type'] == "phone"){
           $emailField = $this->getForm()->getElement($this->getForm()->getEmailElementFieldName());
           $emailField->setAllowEmpty(true);
           $phoneNumber = $params['phone_number'];
           $emailField->clearDecorators();
           $emailField->setRequired(false);
           $teplate = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.email.format', 'se[phonenumber]@'.$this->get_domain($_SERVER["HTTP_HOST"]));
           $email = str_replace('[PHONE_NUMBER]', $phoneNumber, $teplate);
           $request->setPost($this->getForm()->getEmailElementFieldName(), $email);
        }else {
            $otpsms_signup_phonenumber = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.signup.phonenumber', '1');
            $otpsms_choose_phonenumber = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.choose.phonenumber', '0');
            $otpsms_required_phonenumber = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.required.phonenumber', '1');
            $phone = $this->getForm()->getElement('phone_number');
            //$phone->clearDecorators();
            if ($otpsms_signup_phonenumber == 1 && $otpsms_choose_phonenumber == 0 && $otpsms_required_phonenumber == 1) {
                if($phone) {
                    $phone->setAllowEmpty(false);
                    $phone->setRequired(true);
                }
            }else{
                if($phone) {
                    $phone->setAllowEmpty(true);
                    $phone->setRequired(false);
                }
            }
        }
      }
      
       // Form was valid
      if( $this->getForm()->isValid($request->getPost()) )
      {
        //set value in session
        $phone_number = $request->getParam("phone_number");
        $otpsmsverification = new Zend_Session_Namespace('Otpsms_Verification');
        $otpsmsverification->unsetAll();
        if( $phone_number ) {
          $country_code = $request->getParam("country_code");
          $otpsmsverification->phone_number = "+".$country_code . $phone_number;
        } else {
          $otpsmsverification->unsetAll();
        }
        
        $this->getSession()->data = $this->getForm()->getValues();
        $this->setActive(false);
        $this->onSubmitIsValid();
        return true;
      }
  
      // Form was not valid
      else {
          $emailField = $this->getForm()->getElement($this->getForm()->getEmailElementFieldName());
          $emailField->setAllowEmpty(false);
          $emailField->setRequired(true);
          if($phone) {
              $phone = $this->getForm()->getElement('phone_number');
              $phone->setAllowEmpty(false);
              $phone->setRequired(true);
          }
          $this->getSession()->active = true;
          $this->onSubmitNotIsValid();
          return false;
      }
    }
    public function onAdminProcess($form) {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $values = $form->getValues();
        $settings->user_signup = $values;
        if ($values['inviteonly'] == 1) {
            $step_table = Engine_Api::_()->getDbtable('signup', 'user');
            $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'User_Plugin_Signup_Invite'));
            $step_row->enable = 0;
        }
        $form->addNotice('Your changes have been saved.');
    }
}
class User_Plugin_Signup_Account extends Otpsms_Plugin_Signup_Account{
  function init(){

  }
}
class Sessociallogin_Plugin_Signup_Account extends Otpsms_Plugin_Signup_Account{
    function init(){

    }
}