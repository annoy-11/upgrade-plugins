<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Plugin.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmetatag_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event) {
    
    $request = Zend_Controller_Front::getInstance()->getRequest();
    
    if ((substr($request->getPathInfo(), 1, 5) != "admin")) {
    
      $module = $request->getModuleName();
      $controller = $request->getControllerName();
      $action = $request->getActionName();

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
      
      $page_name = $module . '_'.$controller.'_'.$action;
      $http_https = _ENGINE_SSL ? 'https://' : 'http://';
      if(in_array($module, array('sesblog', 'sesarticle', 'sesrecipe', 'seslisting')) && $controller == 'index' && $action == 'view') {
        if(Engine_Api::_()->core()->hasSubject()) {
         $subject = Engine_Api::_()->core()->getSubject();
         $page_name = $page_name.'_'.$subject->style;
        }
      }
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
        if($module == 'user' && $controller == 'index' && $action == 'home') {
          $viewer = Engine_Api::_()->user()->getViewer();
          $checkLevelId = Engine_Api::_()->getDbtable('homepages', 'sesmember')->checkLevelId($viewer->level_id, '0', 'home');
          if($checkLevelId) 
          $page_name = "sesmember_index_".$homepageId;
        }
        if($module == 'user' && $controller == 'profile' && $action == 'index') {
          if(Engine_Api::_()->core()->hasSubject('user')) {
            $subject = Engine_Api::_()->core()->getSubject();
            $checkLevelId = Engine_Api::_()->getDbtable('homepages', 'sesmember')->checkLevelId($subject->level_id, '0', 'profile');
            if($checkLevelId) 
              $page_name = "sesmember_index_".$homepageId;
          }
        }
      }
      
      $enableFacebook = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.enable.facebookogtitle', 1);
      $enableTwitter = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.enable.twittercard', 1);

      $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('name =?', $page_name);
      $results = Engine_Api::_()->getDbtable('pages', 'core')->fetchRow($select);
      $page_id = $results->page_id;
      
      $checkViewPage = false;
      if(Engine_Api::_()->core()->hasSubject()) {
       $subject = Engine_Api::_()->core()->getSubject();
       $checkViewPage = true;
      }
      
      //if(empty($checkViewPage)) {
        if($page_id) {
          $getPageData = Engine_Api::_()->getDbTable('managemetatags', 'sesmetatag')->getPageData(array('page_id' => $page_id));

          if(!empty($getPageData->managemetatag_id) && isset($getPageData->managemetatag_id)) {
            
            
            if($checkViewPage) {
              
              $URL = $http_https . $_SERVER['HTTP_HOST'] . $subject->getHref();
              
              if (strpos($subject->getPhotoUrl(), 'http') === FALSE)
                $image = $http_https . $_SERVER['HTTP_HOST'] . $subject->getPhotoUrl();
              else
                $image = $subject->getPhotoUrl();
                
              if(!empty($subject->getTitle()))
                $title = strip_tags($subject->getTitle());
              else
                $title = strip_tags(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title'));
                
              if(!empty($subject->getDescription())) {
                if(strlen(strip_tags($subject->getDescription())) > 160)
                $description = $view->string()->truncate($view->string()->stripTags(strip_tags($subject->getDescription())), 157).'...';
                else
                $description = strip_tags($subject->getDescription());
              }
//               else if(!empty($getPageData->meta_description))
//                 $description = strip_tags($getPageData->meta_description);
              else
                $description = strip_tags(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.description'));
                
              $description = strip_tags($getPageData->meta_description) . $description;
            } else {
              if (!empty($getPageData->file_id)) {
                $url = Engine_Api::_()->storage()->get($getPageData->file_id, '')->getPhotoUrl();
                $image = $url; //'http://' . $_SERVER['HTTP_HOST'] . $url;
              } else {
                $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.photo', 'public/admin/social_share.jpg');
                $image = $view->baseUrl() . '/' . $nonmetaPhoto;
                $image = $http_https . $_SERVER['HTTP_HOST'] . $image;
                //$image = '';
              }
              
              if(!empty($getPageData->meta_title)) {
                $title = strip_tags($getPageData->meta_title);
              } else
                $title = strip_tags(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title'));
              
              if(!empty($getPageData->meta_description)) {
                $description = strip_tags($getPageData->meta_description);
              } else
                $description = strip_tags(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.description'));
                
              $URL = $http_https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }
            
            if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
            
              $view->doctype('XHTML1_RDFA');
              
              if($enableFacebook) {
                $view->headMeta()->setProperty('og:locale', $view->locale()->getLocale()->__toString());
                $view->headMeta()->setProperty('og:type', 'website');
                $view->headMeta()->setProperty('og:url', $URL);
                $view->headMeta()->setProperty('og:title', $title);
                if($description)
                  $view->headMeta()->setProperty('og:description', $description);
                $view->headMeta()->setProperty('og:image', $image);
              } 
              
              if($enableTwitter) {
                $view->headMeta()->setProperty('twitter:card', 'summary_large_image');
                $view->headMeta()->setProperty('twitter:url', $URL);
                $view->headMeta()->setProperty('twitter:title', $title);
                if($description)
                  $view->headMeta()->setProperty('twitter:description', $description);
                $view->headMeta()->setProperty('twitter:image',$image);
              }
            }
          }
        } else {
        
          $nonmetaTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.title', '');
          
          $nonmetaDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.description', '');
          
          $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmetatag.nonmeta.photo', 'public/admin/social_share.jpg');
          
          
          if (!empty($nonmetaPhoto)) {
            $image = $view->baseUrl() . '/' . $nonmetaPhoto;
            $image = $http_https . $_SERVER['HTTP_HOST'] . $image;
          } else {
            $image = '';
          }

          if(!empty($nonmetaDescription)) {
            $description = $nonmetaDescription;
          } else
            $description = strip_tags(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.description'));
          
          $URL = $http_https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            
          if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
          
            $view->doctype('XHTML1_RDFA');
            
            if($enableFacebook) {
              $view->headMeta()->setProperty('og:locale', $view->locale()->getLocale()->__toString());
              $view->headMeta()->setProperty('og:type', 'website');
              $view->headMeta()->setProperty('og:url', $URL);
              if($nonmetaTitle)
              $view->headMeta()->setProperty('og:title', strip_tags($nonmetaTitle));
              if($description)
                $view->headMeta()->setProperty('og:description', $description);
              $view->headMeta()->setProperty('og:image', $image);
            }
            
            if($enableTwitter) {
              $view->headMeta()->setProperty('twitter:card', 'summary_large_image');
              $view->headMeta()->setProperty('twitter:url', $URL);
              if($nonmetaTitle)
                $view->headMeta()->setProperty('twitter:title', strip_tags($nonmetaTitle));
              if($description)
                $view->headMeta()->setProperty('twitter:description', $description);
              $view->headMeta()->setProperty('twitter:image',$image);
            }
          }
        }
      //}
    }
  }
}
