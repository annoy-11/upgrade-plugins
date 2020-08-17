<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AuthController.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_AuthController extends Core_Controller_Action_Standard
{
  public function init(){
    //set session for direct
    if(!empty($_GET['direct']) || $this->_getParam('direct')) 
      $_SESSION['sesmediaadv_direct'] = true;
    else if(empty($_GET['code']))
        $_SESSION['sesmediaadv_direct'] = false;
  }
  public function px500Action(){ 
    // Clear
    unset($_SESSION['px500_lock']);
    unset($_SESSION['px500_auth_token']);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $flickrTable = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter');
    $flickr = $flickrTable->getApi();
    $settings = Engine_Api::_()->getDbtable('settings', 'core');

    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $this->view->error = true;
    $this->view->success = false;
    // Enabled?
    if( !$flickr) {
      $this->view->error = true;
    }
    $api_key = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumerkey','');
    $api_secret = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumersecret','');
    $permissions = "read";
     $siteURL = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/px500';
    $connection = new FHpxOAuth($api_key, $api_secret);
    
    /* Get temporary credentials. */
    $request_token = $connection->getRequestToken($siteURL);
    if (empty($_SESSION['px500_access_token']) || empty($_SESSION['px500_access_token']['oauth_token']) || empty($_SESSION['px500_access_token']['oauth_token_secret'])) {
      /* Save temporary credentials to session. */
      $_SESSION['px500_access_token']['oauth_token'] = $token = $request_token['oauth_token'];
      $_SESSION['px500_access_token']['oauth_token_secret'] = $request_token['oauth_token_secret'];
      
      /* If last connection failed don't display authorization link. */
      switch ($connection->http_code) {
        case 200:
          /* Build authorize URL and redirect user to Twitter. */
          $url = $connection->getAuthorizeURL($token);
          header('Location: ' . $url); 
          break;
        default:
          /* Show notification if something went wrong. */
          echo 'Could not connect to 500px. Refresh the page or try again later.';
      }
    }
    
    $access_token = $_SESSION['px500_access_token'];

    /* Create a TwitterOauth object with consumer/user tokens. */
    $connection = new FHpxOAuth($api_key, $api_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $decode  = $connection->get('users', array());
    
    // Already connected        
    if($decode && !empty($decode->user->id)) {
        $userNsid = $decode->user->id;
        $fullname = $decode->user->fullname;
        $this->view->success = true;
        $reqtoken = $access_token;
        $reqtokensecret = $_SESSION['px500_oauth_token_secret'] ? $_SESSION['px500_oauth_token_secret'] : 0;
        // Attempt to connect account
        $info = $flickrTable->select()
            ->from($flickrTable)
            ->where('user_id = ?', $viewer->getIdentity())
            ->limit(1)
            ->query()
            ->fetch();
        if( empty($info) ) {
          $flickrTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'px_uid' => $userNsid,
            'access_token' => $access_token['oauth_token'],
            'code' => $reqtokensecret,
            'expires' => 0,
          ));
        } else {
          // Save info to db
          $flickrTable->update(array(
            'px_uid' => $userNsid,
            'access_token' => $access_token['oauth_token'],
            'code' => $reqtokensecret,
            'expires' => 0,
          ), array(
            'user_id = ?' => $viewer->getIdentity(),
          ));
        }        
        if (isset($decode->user->userpic_https_url))           
         $photo =  str_replace('100','300',$decode->user->userpic_https_url);
        
        
        $_SESSION['sesmediaimporter_px500']['inphoto_url'] = $photo;
        $_SESSION['sesmediaimporter_px500']['in_id'] = $userNsid;
        $_SESSION['sesmediaimporter_px500']['in_name'] = $fullname;
        $_SESSION['sesmediaimporter_px500']['in_username'] = ((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://")."500px.com/".$decode->user->username;
    }
    // Not connected
    else { 
      die("Hmm, something went wrong...\n");
    }
  }
  
  public function facebookAction()
  {
    // Clear
    if( null !== $this->_getParam('clear') ) {
      unset($_SESSION['facebook_lock']);
      unset($_SESSION['facebook_uid']);
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
    $facebook = $facebookTable->getApi();
    $settings = Engine_Api::_()->getDbtable('settings', 'core');

    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $this->view->error = true;
    $this->view->success = false;
    // Enabled?
    if( !$facebook || 'none' == $settings->sesmediaimporter_facebook_enable ) {
      $this->view->error = true;
    }
    
    // Already connected
    if( $facebook->getUser() ) {
       $code = $facebook->getPersistentData('code');
        $this->view->success = true;
        // Attempt to connect account
        $info = $facebookTable->select()
            ->from($facebookTable)
            ->where('user_id = ?', $viewer->getIdentity())
            ->limit(1)
            ->query()
            ->fetch();
        if( empty($info) ) {
          $facebookTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'facebook_uid' => $facebook->getUser(),
            'access_token' => $facebook->getAccessToken(),
            'code' => $code,
            'expires' => 0,
          ));
        } else {
          // Save info to db
          $facebookTable->update(array(
            'facebook_uid' => $facebook->getUser(),
            'access_token' => $facebook->getAccessToken(),
            'code' => $code,
            'expires' => 0,
          ), array(
            'user_id = ?' => $viewer->getIdentity(),
          ));
        }
        $apiInfo = $facebook->api('/me?fields=name');  
        $fbphoto_url = "http://graph.facebook.com/".$apiInfo['id'] ."/picture?type=large&redirect=false";
        $fbphoto_url = @$this->file_get_contents_curl($fbphoto_url);
        $fbphoto_url = json_decode($fbphoto_url,true);
        if(isset($fbphoto_url['data']['url'])){
          $fbphoto_url = $fbphoto_url['data']['url'];
        }else{
          $fbphoto_url = '';
        } 
        
        $_SESSION['sesmediaimporter_facebook']['fbphoto_url'] = $fbphoto_url;
        $_SESSION['sesmediaimporter_facebook']['fb_id'] = $apiInfo['id'];
        $_SESSION['sesmediaimporter_facebook']['fb_name'] = $apiInfo['name'];
        
    }

    // Not connected
    else {
      
      // Okay
      if( !empty($_GET['code']) ) {
       $this->view->error = true;
      }
      
      // Error
      else if( !empty($_GET['error']) ) {
       $this->view->error = true;;
      }

      // Redirect to auth page
      else {
        $url = $facebook->getLoginUrl(array(
          'redirect_uri' => (_ENGINE_SSL ? 'https://' : 'http://') 
              . $_SERVER['HTTP_HOST'] . $this->view->url(),
          'scope' => join(',', array(
            'email',
            'user_photos',
          )),
        ));
        return $this->_helper->redirector->gotoUrl($url, array('prependBase' => false));
      }
    }
  }
  function file_get_contents_curl($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
  public function instagramAction(){
      
    
    // Clear
    if( null !== $this->_getParam('clear') ) {
      unset($_SESSION['instagram_lock']);
      unset($_SESSION['instagram_token']);
    }
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
    $instagram = $instagramTable->getApi('auth');
    $settings = Engine_Api::_()->getDbtable('settings', 'core');

    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $this->view->error = true;
    $this->view->success = false;
    // Enabled?
    if( !$instagram) {
      $this->view->error = true;
    }
    
    // Already connected
    if(!empty($_GET['code'])) {
        $code = $_GET['code'];
        $data = $instagram->getOAuthToken($code);
        $this->view->success = true;
        // Attempt to connect account
        $info = $instagramTable->select()
            ->from($instagramTable)
            ->where('user_id = ?', $viewer->getIdentity())
            ->limit(1)
            ->query()
            ->fetch();
        if( empty($info) ) {
          $instagramTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'instagram_uid' => $data->user->id,
            'access_token' => $data->access_token,
            'code' => $code,
            'expires' => 0,
          ));
        } else {
          // Save info to db
          $instagramTable->update(array(
            'instagram_uid' => $data->user->id,
            'access_token' => $data->access_token,
            'code' => $code,
            'expires' => 0,
          ), array(
            'user_id = ?' => $viewer->getIdentity(),
          ));
        }        
        $_SESSION['sesmediaimporter_instagram']['inphoto_url'] = $data->user->profile_picture;
        $_SESSION['sesmediaimporter_instagram']['in_id'] = $data->user->id;
        $_SESSION['sesmediaimporter_instagram']['in_name'] = $data->user->full_name;
        $_SESSION['sesmediaimporter_instagram']['in_username'] = $data->user->username;
    }
    // Not connected
    else { 
      // Okay
      if( !empty($_GET['code']) )
       $this->view->error = true;
      // Error
      else if( !empty($_GET['error']) ) 
       $this->view->error = true;
      // Redirect to auth page
      else {
        $url = $instagram->getLoginUrl();
        return $this->_helper->redirector->gotoUrl($url, array('prependBase' => false));
      }
    }
  }
  public function flickrAction(){    
    // Clear
    unset($_SESSION['flickr_lock']);
    unset($_SESSION['flickr_lock']);
    unset($_SESSION['phpFlickr_auth_token']);
    unset($_SESSION['phpFlickr_auth_token']);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
    $flickr = $flickrTable->getApi();
    $settings = Engine_Api::_()->getDbtable('settings', 'core');

    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $this->view->error = true;
    $this->view->success = false;
    // Enabled?
    if( !$flickr) {
      $this->view->error = true;
    }
    $api_key = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientid','');
    $api_secret = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientsecret','');
    $permissions = "read";
     $siteURL = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/flickr';
    $flickr = new Flickr($api_key, $api_secret, $siteURL);
    
    //$f = new phpFlickr($api_key, $api_secret,$siteURL);
    //http://localhost/ses/sesmediaimporter/auth/flickr?oauth_token=72157685559275755-a6f8a01cec5bfc3a&oauth_verifier=9682e5a764a51018
    
    
    // Already connected
    if($flickr->authenticate('read')) {
        $userNsid = $flickr->getOauthData(Flickr::USER_NSID);
        $fullname = $flickr->getOauthData(Flickr::USER_FULL_NAME);
        $_SESSION['phpFlickr_auth_token'] = $reqtoken = $flickr->getOauthData(Flickr::OAUTH_REQUEST_TOKEN);
        $reqtokensecret = $flickr->getOauthData(Flickr::OAUTH_REQUEST_TOKEN_SECRET);
        $this->view->success = true;
        // Attempt to connect account
        $info = $flickrTable->select()
            ->from($flickrTable)
            ->where('user_id = ?', $viewer->getIdentity())
            ->limit(1)
            ->query()
            ->fetch();
        if( empty($info) ) {
          $flickrTable->insert(array(
            'user_id' => $viewer->getIdentity(),
            'flickr_uid' => $userNsid,
            'access_token' => $reqtoken,
            'code' => $reqtokensecret,
            'expires' => 0,
          ));
        } else {
          // Save info to db
          $flickrTable->update(array(
            'flickr_uid' => $userNsid,
            'access_token' => $reqtoken,
            'code' => $reqtokensecret,
            'expires' => 0,
          ), array(
            'user_id = ?' => $viewer->getIdentity(),
          ));
        }        
        $getInfo = $flickr->call('flickr.people.getInfo',array('user_id'=>$userNsid));
        if (isset($getInfo["person"]['iconfarm']) && $getInfo["person"]['iconfarm'] > 0)           
         $photo =  sprintf(((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://").'farm%s.staticflickr.com/%s/buddyicons/%s.jpg', $getInfo["person"]["iconfarm"], $getInfo["person"]["iconserver"], $userNsid);
        else
         $photo =  ((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://").'www.flickr.com/images/buddyicon.gif';
        
        $_SESSION['sesmediaimporter_flickr']['inphoto_url'] = $photo;
        $_SESSION['sesmediaimporter_flickr']['in_id'] = $userNsid;
        $_SESSION['sesmediaimporter_flickr']['in_name'] = $fullname;
        $_SESSION['sesmediaimporter_flickr']['in_username'] = ((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://")."www.flickr.com/".$userNsid;
    }
    // Not connected
    else { 
      die("Hmm, something went wrong...\n");
    }
  }
   public function googleAction(){    
    // Clear
    unset($_SESSION['google_lock']);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    
    $settings = Engine_Api::_()->getDbtable('settings', 'core');
    $table = Engine_Api::_()->getDbTable('google','sesmediaimporter');
    $db = Engine_Db_Table::getDefaultAdapter();
    $ipObj = new Engine_IP();
    $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
    $this->view->error = true;
    $this->view->success = false;
    $api_key = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.google.clientid','');
    $api_secret = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.google.clientsecret','');
    $siteURL = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl').'sesmediaimporter/auth/google';
    // Already connected
    if(!empty($_GET['code'])) {
        $code = $_GET['code'];
        $clientId = $api_key;
        $clientSecret = $api_secret;
        $referer = $siteURL;
        
        $postBody = 'code='.urlencode($_GET['code'])
                  .'&grant_type=authorization_code'
                  .'&redirect_uri='.urlencode($referer)
                  .'&client_id='.urlencode($clientId)
                  .'&client_secret='.urlencode($clientSecret);
    
        $curl = curl_init();
        curl_setopt_array( $curl,
                         array( CURLOPT_CUSTOMREQUEST => 'POST'
                               , CURLOPT_URL => 'https://accounts.google.com/o/oauth2/token'
                               , CURLOPT_HTTPHEADER => array( 'Content-Type: application/x-www-form-urlencoded'
                                                             , 'Content-Length: '.strlen($postBody)
                                                             , 'User-Agent: YourApp/0.1 +http://yoursite.com/yourapp'
                                                             )
                               , CURLOPT_POSTFIELDS => $postBody                              
                               , CURLOPT_REFERER => $referer
                               , CURLOPT_RETURNTRANSFER => 1 // means output will be a return value from curl_exec() instead of simply echoed
                               , CURLOPT_TIMEOUT => 12 // max seconds to wait
                               , CURLOPT_FOLLOWLOCATION => 0 // don't follow any Location headers, use only the CURLOPT_URL, this is for security
                               , CURLOPT_FAILONERROR => 0 // do not fail verbosely fi the http_code is an error, this is for security
                               , CURLOPT_SSL_VERIFYPEER => 1 // do verify the SSL of CURLOPT_URL, this is for security
                               , CURLOPT_VERBOSE => 0 // don't output verbosely to stderr, this is for security
                         ) );
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl); 
        $response = json_decode($response,true);
         
        if(empty($response['access_token'])){
          $this->view->error = true;
          return;  
        }
         $accessToken = $response['access_token'];
         $refreshToken = $response['refresh_token'];
        
        // get user info
        $q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$accessToken;
        $json = $this->file_get_contents_curl($q);
        $userInfoArray = json_decode($json,true);
        if(!empty($userInfoArray['id'])){
          $googleid = $userInfoArray['id'];
          $googleName = $userInfoArray['name'];
          $picture = $userInfoArray['picture'];
          $link = $userInfoArray['link'];
        }else{
          $this->view->error = true;
          return;  
        }
        // Attempt to connect account
        $info = $table->select()
            ->from($table)
            ->where('user_id = ?', $viewer->getIdentity())
            ->limit(1)
            ->query()
            ->fetch();
        if( empty($info) ) {
          $table->insert(array(
            'user_id' => $viewer->getIdentity(),
            'google_uid' => $googleid,
            'access_token' => $accessToken,
            'code' => $refreshToken,
            'expires' => 0,
          ));
        } else {
          // Save info to db
          $table->update(array(
            'google_uid' => $googleid,
            'access_token' => $accessToken,
            'code' => $refreshToken,
            'expires' => 0,
          ), array(
            'user_id = ?' => $viewer->getIdentity(),
          ));
        }        
        $this->view->success = true;
        $_SESSION['sesmediaimporter_google']['inphoto_url'] = $picture;
        $_SESSION['sesmediaimporter_google']['in_id'] = $googleid;
        $_SESSION['sesmediaimporter_google']['in_name'] = $googleName;
        $_SESSION['sesmediaimporter_google']['in_username'] = $link;
    }
    // Not connected
    else { 
      // Okay
      if( !empty($_GET['code']) )
       $this->view->error = true;
      // Error
      else if( !empty($_GET['code']) ) 
       $this->view->error = true;
      // Redirect to auth page
      else {
        $url = "https://accounts.google.com/o/oauth2/auth?scope=https://picasaweb.google.com/data https://www.googleapis.com/auth/userinfo.profile&response_type=code&access_type=offline&redirect_uri=".$siteURL."&approval_prompt=force&client_id=".$api_key;
        return $this->_helper->redirector->gotoUrl($url, array('prependBase' => false));
      }
    }
  }
  
}
