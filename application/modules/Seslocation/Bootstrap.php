<?php

class Seslocation_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
    parent::__construct($application);
      if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
         $locationDataDefault['lat'] = "28.40914860";
         $locationDataDefault['lng'] = "77.04277940";
         $locationDataDefault['title'] = "Sohna Road, Sector 49, Gurugram, Haryana, India";
         
         Engine_Api::_()->getApi('settings', 'core')->setSetting('seslocation_enable', 1);
         Engine_Api::_()->getApi('settings', 'core')->setSetting('seslocation.search.type', 1);
         Engine_Api::_()->getApi('settings', 'core')->setSetting('seslocation.search.miles', 50);
         //remove cookie
         //unset($_COOKIE['seslocation_content_data']);
         //setcookie('seslocation_content_data', null, time() - (86400 * 30));  
         
         //set cookie
        // setcookie('seslocation_content_data', json_encode($locationDataDefault), time() + (86400 * 30));  
         //var_dump($_COOKIE,true);die;

      }
  }
}