<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmetatag_Api_Core extends Core_Api_Abstract {

  public function getWidgitizePagesPhoto($params = array()) {
  
    
    $page_name = $params['module'] . '_'.$params['controller'].'_'.$params['action'];
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('name =?', $page_name);
    $results = Engine_Api::_()->getDbtable('pages', 'core')->fetchRow($select);
    $page_id = $results->page_id;
    $checkViewPage = false;
    if(Engine_Api::_()->core()->hasSubject()) {
     $subject = Engine_Api::_()->core()->getSubject();
     $checkViewPage = true;
    }
    $metatags = array();
    if($page_id) {
      $getPageData = Engine_Api::_()->getDbTable('managemetatags', 'sesmetatag')->getPageData(array('page_id' => $page_id));
      if(!empty($getPageData->managemetatag_id) && isset($getPageData->managemetatag_id)) {
        if($checkViewPage) {
          if (strpos($subject->getPhotoUrl(), 'http') === FALSE)
            $image = 'http://' . $_SERVER['HTTP_HOST'] . $subject->getPhotoUrl();
          else
            $image = $subject->getPhotoUrl();
          if(!empty($subject->getTitle()))
            $title = $subject->getTitle();
          $metatags['image'] = $image;
          $metatags['title'] = $title;
        } else {
          if (!empty($getPageData->file_id)) {
            $url = Engine_Api::_()->storage()->get($getPageData->file_id, '')->getPhotoUrl();
            $image = $url; //'http://' . $_SERVER['HTTP_HOST'] . $url;
          } else {
            $image = '';
          }
          if(!empty($getPageData->meta_title)) {
            $title = $getPageData->meta_title;
          } else
            $title = '';
          $metatags['image'] = $image;
          $metatags['title'] = $title;
        }
      }
    } else {
      $nonmetaTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.title', '');
      $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.photo', '');
      if (!empty($nonmetaPhoto)) {
        $image = $view->baseUrl() . '/' . $nonmetaPhoto;
        $image = 'http://' . $_SERVER['HTTP_HOST'] . $image;
      } else {
        $image = '';
      }
      $metatags['image'] = $image;
      $metatags['title'] = $nonmetaTitle;
    }
    return $metatags;
  }
}