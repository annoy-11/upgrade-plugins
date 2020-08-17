<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Facebook.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_Api_Facebook extends Core_Api_Abstract {
 protected $_facebook;
 protected $_albums;
 protected $_photos;
 function getData($mediaData,$mediatype){
   $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
     $this->_facebook = $facebookTable->getApi();
    if($mediatype == 'album'){
      $result = array();
      foreach($mediaData["album_id"] as $id){
        $result = $this->loopAlbums($mediaData,$id);
      }
      return $result;
    }else{
      $result = $this->loopPhotos($mediaData); 
      return $result; 
    }
 }
 function loopPhotos($mediaData){
   return $mediaData;
 }
 function file_get_contents_curl($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
 function loopAlbums($mediaData,$id){
    $extra_params = "&limit=20";
    $count = $mediaData['album_count'][$id];
    $limit = 20;
    $total = ceil($count / $limit);
    $fields="id,images,name";
    do
    {
      if(!empty($after))
        $extra_params = $extra_params.'&after='.$after;
      $access_token = $this->_facebook->getAccessToken();
      $album_link = "https://graph.facebook.com/{$id}/photos?access_token={$access_token}&fields={$fields}".$extra_params;
      $album_json = json_decode($this->file_get_contents_curl($album_link),true);
      $after = isset($album_json['paging']['cursors']['after']) ? $album_json['paging']['cursors']['after'] : '';
      foreach ($album_json['data'] as $photo)
      {
        $album_link_photo = "https://graph.facebook.com/{$photo['id']}/?access_token={$access_token}&fields={$fields}".$extra_params;
        $album_json_photo = json_decode($this->file_get_contents_curl($album_link_photo),true);
        $this->_photos[$id][$album_json_photo['id']] = $album_json_photo['images'][0]['source'];;
      }
      ++$page;
    }
    while($page < $total);
    return $this->_photos;    
 }
}
