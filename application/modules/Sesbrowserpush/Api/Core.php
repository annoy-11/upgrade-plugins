<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Api_Core extends Core_Api_Abstract {

 function sendPush($params = array(),$tokenids = '') {

   $token =  ($tokenids);
    $notif_arr = (array('data'=>$params,'registration_ids'=>$token));
    $key = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.serverkey','');
    $headers = array(
       'Authorization: key=' . $key,
       'Content-Type: application/json'
   );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Disabling SSL Certificate support temporarly
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notif_arr));

   // Execute post
   $result = curl_exec($ch);
   if ($result === FALSE) {
       // Close connection
       curl_close($ch);
       return FALSE;
   }else{
       // Close connection
       curl_close($ch);
       return TRUE;
   }

 }
  public function sendNotification($values){
      $title = $values['title'];
      $body = $values['description'];
      $href = $values['link'];
      $image = '';
      if($values['file_id']){
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($values['file_id']);
          if( $file ) {
            $image =  $file->map();
            $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
            $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
            if(strpos($image,'http') === false)
              $image = $baseURL.$image;
          }
      }
      if($values['criteria'] == 'all'){
        $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens();
      }else if($values['criteria'] == 'memberlevel'){
         $level = $values['param'];
         $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('level'=>$level));
      }else if($values['criteria'] == 'network'){
          $network = $values['param'];
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('network'=>$network));
      }else if($values['criteria'] == 'user'){
          $user_ids = $values['param'];
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('user_ids'=>$user_ids));
      }else
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('browser'=>$values['criteria']));
      Engine_Api::_()->sesbrowserpush()->sendPush(array('title'=>strip_tags($title),'body'=>$body,'icon'=>$image,'click_action'=>$href),$tokens);
      $values->sent = 1;
      $values->save();
      return true;
  }
}
