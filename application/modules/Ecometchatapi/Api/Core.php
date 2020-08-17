<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Api_Core extends Core_Api_Abstract
{
    /*Comet Chat Code*/
    public function getUserPhotoUrl($viewer){
        return $this->getBaseUrl($viewer->getPhotoUrl());
    }
    public function getUserProfileUrl($viewer){
        return $this->getBaseUrl($viewer->getHref());
    }
    public function getBaseUrl($url = ""){

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
        //}
        return $http.str_replace('//','/',$baseUrl.$url);
    }
    function sendRequestCometChat($params = array()){
        $key = Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.key', '');
        $appId = Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.id', '');
        if(!$key){
            return false;
        }
        $ch = curl_init();
        if($params['dataType'])
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params['dataType']);

        curl_setopt($ch, CURLOPT_URL,$params['url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params['postData']));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            'apikey:'.$key,
            'appid:'.$appId
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return $server_output;
    }
}
