<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesssoserver_Api_Core extends Core_Api_Abstract {
    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
  function login($user){
    $userSelected = Engine_Api::_()->getItem('user',$user->getIdentity());
    $value['email'] = $userSelected->email;
    $value['password'] = $_POST['password'];
    $clients = $this->getCients();
   
    foreach($clients as $client){
      $url = trim($client['url'],'/').'/sesssoclient/index/login';
      $value['client_secret'] = $client['client_secret'];
      $value['client_token'] = $client['client_token'];
      $data = $this->callCurl($value,$url);
      if($data)
        setcookie("SSOLoggedinUserId_".str_replace('.','',$this->get_domain(trim($client['url'],'/'))), $data, time() + (86400 * 30), "/",'.'.$this->get_domain($_SERVER["HTTP_HOST"]),
            false, false);
    }
  }    
  function getCients(){
    $table = Engine_Api::_()->getDbTable('clients','sesssoserver');
    $select = $table->select()->where('active =?',1);
    $clients = $table->fetchAll($select);
    return $clients;
  }
  function signup($user){
    //get integrated site
    $clients = $this->getCients();
    if(!count($clients))
      return;
    $userSelected = Engine_Api::_()->getItem('user',$user->getIdentity());
    $value = Engine_Api::_()->fields()->getFieldsValuesByAlias($userSelected);
    $profileType = $value['profile_type'];
    unset($value['profile_type']);
    $value['email'] = $userSelected->email;
    $value['password'] = $_SESSION['sesssopassword'];
    $value['locale'] = $userSelected->locale;
    $value['language'] = $userSelected->language;
    $value['timezone'] = $userSelected->timezone;    
    $value['enabled'] = $userSelected->enabled;
    $value['verified'] = $userSelected->verified;
    $value['approved'] = $userSelected->approved;
    $value['username'] = $userSelected->username;
    $value['displayname'] = $userSelected->displayname;
    if($user->photo_id){
      $file = Engine_Api::_()->getItem('storage_file',$user->photo_id);
      if($file)
        $value['photo_url'] = $this->getBaseUrl(true,$file->map());
    }
    foreach($clients as $client){
      $unserialize = unserialize($client->params);      
      if(array_key_exists('profile_'.$profileType,$unserialize))
        $value['profile_type'] = $unserialize['profile_'.$profileType];
      else{
          $value["profile_type"] = $profileType;
      }
      $url = trim($client->url,'/').'/sesssoclient/index/signup';
      $value['client_secret'] = $client->client_secret;
      $value['client_token'] = $client->client_token;
      $data = $this->callCurl($value,$url);
        if($data)
            setcookie("SSOLoggedinUserId_".str_replace('.','',$this->get_domain(trim($url,'/'))), $data, time() + (86400 * 30), "/",'.'.$this->get_domain($_SERVER["HTTP_HOST"]),
                false, false);
    }
  }
  function callCurl($data = array(),$url){
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($handle);
    curl_close($handle);
    return $content;
  }
  public function getBaseUrl($staticBaseUrl = true,$url = ""){
    if(strpos($url,'http') !== false)
      return $url;
    $http = 'http://';
    if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
       $http = 'https://';
    }
    $baseUrl =  $_SERVER['HTTP_HOST'];
    if(Zend_Registry::get('StaticBaseUrl') != "/")
    $url = str_replace(Zend_Registry::get('StaticBaseUrl'),'',$url);
    $baseUrl = $baseUrl.Zend_Registry::get('StaticBaseUrl') ;
    return $http.str_replace('//','/',$baseUrl.$url);
  }
}