<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Google.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesmediaimporter_Api_Google extends Core_Api_Abstract {
 protected $_google;
 protected $_photos;
 function getData($mediaData,$mediatype){
   $table = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
   $this->_google = $table->getApi();
   $result = array();
   foreach($mediaData["album_id"] as $id){
     $result = $this->loopAlbums($mediaData,$id);
   }
   return $result;
 }
 function picasa_list_pictures( $data, $thumb_max_size = 200,$entryKey = 'feed' )
  {
    $xml = new DOMDocument();
    $xml->loadXML( $data );
    $namespace_media = $xml->getElementsByTagName( 'feed' )->item( 0 )->getAttribute( 'xmlns:media' );
    $pictures = array();
    
    foreach( $xml->getElementsByTagName( 'entry' ) as $entry )
    {
      $elem = $entry->getElementsByTagNameNS( $namespace_media, 'group' )->item( 0 );
      $thumb = array( 'url' => '', 'size' => 0 );
      foreach( $elem->getElementsByTagNameNS( $namespace_media, 'thumbnail' ) as $xml_thumb )
      {
        $thumb_size = (int)$xml_thumb->getAttribute( 'height' );
        $thumb_width = (int)$xml_thumb->getAttribute( 'width' );
        if ( $thumb_width < $thumb_size ) $thumb_size = $thumb_width;
        if( $thumb_size < $thumb_max_size && $thumb_size > $thumb['size'] )
        {
          $thumb['url'] = $xml_thumb->getAttribute( 'url' );
          $thumb['size'] = $thumb_size;
        }
      }
      $content_tag = $elem->getElementsByTagNameNS( $namespace_media, 'content' )->item( 0 );
      
      $picture = array(
        'url'=> str_replace('https://picasaweb.google.com/data/entry/user','https://picasaweb.google.com/data/feed/api/user',$entry->getElementsByTagName('id')->item(0)->nodeValue),
        'id'=> end(explode('/',$entry->getElementsByTagName('id')->item(0)->nodeValue)),
        'title' => $elem->getElementsByTagNameNS( $namespace_media, 'title' )->item( 0 )->nodeValue,
        'thumbnail' => $thumb['url'],
        'url' => $content_tag->getAttribute( 'url' ),
      );		
      
      $pictures ['photos'][]= $picture;
    }
    return $pictures;
  }
 function loopAlbums($mediaData,$id){
    $count = $mediaData['album_count'][$id];
    $extra_params['per_page'] = 20;
    $limit = 20;
    $page = 1;
    $total = ceil($count / $limit);
    $googleTable = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
    $access_token = $googleTable->getApi();
    if(!$access_token){
      return;
    }
    do
    {
      if($page > 1)
      $next = 'start-index='.$page*$limit+1;
      $siteurl = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://"));
      $curl = curl_init();
      $url = 'https://picasaweb.google.com/data/feed/api/user/default/albumid/'.$id.'?imgmax=1600&max-results=20'.$next;
      curl_setopt_array( $curl, 
                       array( CURLOPT_CUSTOMREQUEST => 'GET'
                             , CURLOPT_URL => $url
                             , CURLOPT_HTTPHEADER => array( 'GData-Version: 2'
                                                           , 'Authorization: Bearer '.$access_token )
                             , CURLOPT_REFERER => $siteurl
                             , CURLOPT_RETURNTRANSFER => 1 // means output will be a return value from curl_exec() instead of simply echoed
                       ) );
      $response = curl_exec($curl);
      $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
      curl_close($curl);
      $result = $this->picasa_list_pictures($response,'1600','feed');
      foreach ($result['photos'] as $photo)
      {
        $this->_photos[$id][$photo['id']] = $photo['url'];
      }
      ++$page;
    }
    while($page <= $total);
    return $this->_photos;    
 }
}
