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

class Sesbrowserpush_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onActivityNotificationCreateAfter($event) {
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.notificationpush','1'))
      return false;
   $notification = $event->getPayload();
   if($notification->subject_id == $notification->user_id)
      return;
   $userToken = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('user_id'=>$notification->user_id));
   if(!$userToken)
    return;
   $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
   $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
   $model = Engine_Api::_()->getApi('core', 'activity');
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
      return false;
    }
    $title = $model->assemble($info->body, $params);
    $dom = new DOMDocument;
    $dom->loadHTML($title);
    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//a/@href');
    $hrefValue = array();
    foreach($nodes as $href)
      $hrefValue[] = $href->nodeValue;  // remove attribute
    
    if(count($hrefValue) > 0)
      $href = $baseURL. $hrefValue[count($hrefValue) - 1];
    else
      $href = $baseURL;
    $user = Engine_Api::_()->getItem('user', $notification->subject_id);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;;
    $photo = $view->itemPhoto($user, 'thumb.icon');
    //echo $photo;die;
    $doc = new DOMDocument();
    @$doc->loadHTML($photo);
    $tags = $doc->getElementsByTagName('img');
    $image = '';
    foreach($tags as $tag){
      $image = $tag->getAttribute('src');
      if(strpos($image,'http') === false)
        $image = $baseURL.$image;
    }
    Engine_Api::_()->sesbrowserpush()->sendPush(array('title'=>strip_tags($title),'body'=>'','icon'=>$image,'click_action'=>$href),$userToken);
    return true;
   }
}