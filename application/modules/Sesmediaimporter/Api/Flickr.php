<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Flickr.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesmediaimporter_Api_Flickr extends Core_Api_Abstract {
 protected $_flickr;
 protected $_photos;
 function getData($mediaData,$mediatype){
   $table = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
   $this->_flickr = $table->getApi();
   $result = array();
   foreach($mediaData["album_id"] as $id){
     $result = $this->loopAlbums($mediaData,$id);
   }
   return $result;
 }
 function loopAlbums($mediaData,$id){
    $count = $mediaData['album_count'][$id];
    $extra_params['per_page'] = 20;
    $limit = 20;
    $page = 1;
    $total = ceil($count / $limit);
    do
    {
      if(!empty($after))
        $extra_params['page'] = $after;
      $result = $this->_flickr->call('flickr.galleries.getPhotos',array_merge(array('gallery_id'=>$id),$extra_params));
      $after = (isset($this->gallerydata['photos']['page']) && $this->gallerydata['photos']['page'] != $this->gallerydata['photos']['pages']) ? $this->gallerydata['photos']['page'] + 1 : '';
      foreach ($result['photos']['photo'] as $photo)
      {
        $album_link_photo = $this->_flickr->buildPhotoURL($photo);
        $this->_photos[$id][$photo['id']] = $album_link_photo;
      }
      ++$page;
    }
    while($page < $total);
    return $this->_photos;    
 }
}
