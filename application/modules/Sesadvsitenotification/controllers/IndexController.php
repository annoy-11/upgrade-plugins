<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvsitenotification_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
  public function notificationAction(){
    $user = Engine_Api::_()->user()->getViewer();
    $notificationArray['notifications'] = array();
    $notificationArray['notification_id'] = $this->_getParam('notification_id',0);
    if(!$user->getIdentity()){
      echo json_encode($notificationArray);die;  
    }
   
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.enable','1'))
      {
        echo json_encode($notificationArray);die;  
      }
   //get notifications
    $enable_type = array();

    foreach (Engine_Api::_()->getDbtable('NotificationTypes', 'activity')->getNotificationTypes() as $type) {
      $enable_type[] = $type->type;
    }
    
    $table = Engine_Api::_()->getDbtable('notifications', 'activity');
    $select = $table->select()
            ->where('user_id = ?', $user->getIdentity())
            ->where('type IN(?)', $enable_type)
            ->order('notification_id DESC')
            ->limit(5);
    if($this->_getParam('notification_id',0))
      $select->where('notification_id > ?',$this->_getParam('notification_id'));
    else{
      $select->where('date between "'.date('Y-m-d H:i:s',time() - 20) .'" AND "'.date('Y-m-d H:i:s').'"'); 
    }
    
    $notifications = $table->fetchAll($select);
    if(!count($notifications)){
      echo json_encode($notificationArray);die;  
    }
    
     $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
     $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
     $model = Engine_Api::_()->getApi('core', 'activity');
     
   if(count($notifications))
     $notificationArray['notification_id'] = $notifications[0]->notification_id;
    $videoURLsesbasic =  Engine_Api::_()->getApi('settings', 'core')->getSetting('video.video.manifest', 'video');
    $sesvideo =  Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo');
    $sesalbum =  Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum');
    $getImageHref = $imageSource = $type = '';
    foreach($notifications as $notification){
      $params = array_merge(
        $notification->toArray(),
        (array) $notification->params,
        array(
          'user' => $notification->getUser(),
          'object' => $notification->getObject(),
          'subject' => $notification->getSubject(),
        )
      );
      $info = Engine_Api::_()->getDbtable('notificationTypes', 'activity')->getNotificationType($notification->type);
      if( !$info )
      {
        continue;
      }
      $title = $model->assemble($info->body, $params);
      $dom = new DOMDocument;
      $dom->loadHTML($title);
      $xpath = new DOMXPath($dom);
      $nodes = $xpath->query('//a/@href');
      $hrefValue = array();
      $parentNodeValue = '';
      $counter = 0;
      foreach($nodes as $href){
        if($counter == 0) 
         $parentNodeValue =  $href->parentNode->nodeValue;
        $counter++;
        $hrefValue[] = $href->nodeValue;  // remove attribute
      }
      if(count($hrefValue) > 0)
        $href = $baseURL. $hrefValue[count($hrefValue) - 1];
      else
        $href = $baseURL;
        
      $user = Engine_Api::_()->getItem('user', $notification->subject_id);
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;;
      $photo = $view->itemPhoto($user, 'thumb.icon');
      $doc = new DOMDocument();
      @$doc->loadHTML($photo);
      $tags = $doc->getElementsByTagName('img');
      $image = '';
      foreach($tags as $tag){
        $image = $tag->getAttribute('src');
        if(strpos($image,'http') === false)
          $image = $baseURL.$image;
      }
      if($notification->object_type == "video" && $sesvideo){
        $videoItem = Engine_Api::_()->getItem($notification->object_type,$notification->object_id);
        if($videoItem){
          $getImageHref = $videoItem->getHref();
          $getImageHref = str_replace($videoURLsesbasic,$videoURLsesbasic.'/imageviewerdetail',$getImageHref);
          $imageSource = $videoItem->getPhotoUrl();
          $type = 'video';
        }
      }else if($notification->object_type == "album_photo" && $sesalbum){
        $photoItem = Engine_Api::_()->getItem($notification->object_type,$notification->object_id);
        if($photoItem){
          $getImageHref = Engine_Api::_()->sesalbum()->getImageViewerHref($photoItem,array());
          $imageSource = $photoItem->getPhotoUrl();
          $type = 'photo';
        }
      }
			$title = strip_tags($title);
      $notificationArray['notifications'][] = array('notification_id'=>$notification->getIdentity(),'title'=>(str_replace($parentNodeValue,'<span  class="sesadvnotification-username">'.$parentNodeValue.'</span>',$title)),'body'=>'','icon'=>$image,'click_action'=>$href,'type'=>'notification_type_'.$notification->type,'parentNodeValue'=>$parentNodeValue,'lightbox_type'=>$type,'imageSource'=>$imageSource,'getImageHref'=>$getImageHref);
    }
     echo json_encode($notificationArray);die;  
  }
}
