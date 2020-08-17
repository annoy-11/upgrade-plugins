<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbchat
 * @package    Sesfbchat
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbchat_Widget_ChatController extends Engine_Content_Widget_Abstract
{
   function indexAction(){
        $setting = Engine_Api::_()->getApi('settings', 'core');
        $enable = $setting->getSetting('sesfbchat_enable_messenger', '1');
        if($enable == 0)
            return $this->setNoRender();

        $this->view->pageId = $setting->getSetting('sesfbchat_page_id','');

        $this->view->appId = $setting->getSetting('sesfbchat_app_id','');
        if(!$this->view->pageId)
            return $this->setNoRender();
        $this->view->login_text = $setting->getSetting('sesfbchat_login_text','Hi! How can we help you?');

        $this->view->logout_text= $setting->getSetting('sesfbchat_logout_text','Hi! How can we help you?');

        $this->view->theme_color =  $setting->getSetting('sesfbchat_theme_color','FFFFFF');
        $sesfbchat_widget = Zend_Registry::isRegistered('sesfbchat_widget') ? Zend_Registry::get('sesfbchat_widget') : null;
        if(empty($sesfbchat_widget))
          return $this->setNoRender();
        $this->view->position = $setting->getSetting('sesfbchat_position', '0');
       $device = $setting->getSetting('sesfbchat_devices', '0');
       $detect = Engine_Api::_()->getApi('detect', 'sesfbchat');
        if($device){
           if($device == 2 && !$detect->isMobile() ){
               return $this->setNoRender();
           }else if($device == 1 && $detect->isMobile()){
               return $this->setNoRender();
           }
        }
         $enablestartendtime =  $setting->getSetting('sesfbchat_enable_timing','0');
         if($enablestartendtime){
          $starttime =  $setting->getSetting('sesfbchat_starttime','');
          $endtime = $setting->getSetting('sesfbchat_endtime','');

          if($starttime && $endtime){
             $currentTime = strtotime(date('H:i:s'));
             $renderWidget = false;
             if($currentTime > strtotime(date('H:i:s',strtotime($starttime))) &&  $currentTime <  strtotime(date('H:i:s',strtotime($endtime))) ){
                $renderWidget = true;
             }

             if(!$renderWidget)
              return $this->setNoRender();
          }
         }


        $viewer = $this->view->viewer();
        $user = $setting->getSetting('sesfbchat_messenger_icon', '0');
        $this->view->allowed = false;
        if(!$user){
         if($viewer)
            $this->view->allowed = true;
        }
        if($user == 1){
         if(!$viewer)
            $this->view->allowed = true;
        }
        if($user == 2)
         $this->view->allowed = true;
        if(!$this->view->allowed)
            return $this->setNoRender();

   }
}
