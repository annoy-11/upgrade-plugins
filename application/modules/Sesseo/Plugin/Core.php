<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event) {

    $request = Zend_Controller_Front::getInstance()->getRequest();

    if ((substr($request->getPathInfo(), 1, 5) != "admin")) {

      $module = $request->getModuleName();
      $controller = $request->getControllerName();
      $action = $request->getActionName();

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $page_name = $module . '_'.$controller.'_'.$action;
      $http_https = _ENGINE_SSL ? 'https://' : 'http://';
      if($module == 'sesblog' && $controller == 'index' && $action == 'view') {
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

        $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('name =?', $page_name);
        $results = Engine_Api::_()->getDbtable('pages', 'core')->fetchRow($select);
        $page_id = $results->page_id;

        $checkViewPage = false;
        if(Engine_Api::_()->core()->hasSubject()) {
            $subject = Engine_Api::_()->core()->getSubject();
            $checkViewPage = true;
        }

        if($page_id) {
          $getPageData = Engine_Api::_()->getDbTable('managemetatags', 'sesseo')->getPageData(array('page_id' => $page_id));

          if(!empty($getPageData->managemetatag_id) && isset($getPageData->managemetatag_id)) {

            if($checkViewPage) {
              $URL = $http_https . $_SERVER['HTTP_HOST'] . $subject->getHref();

              if (strpos($subject->getPhotoUrl(), 'http') === FALSE)
                $image = $http_https . $_SERVER['HTTP_HOST'] . $subject->getPhotoUrl();
              else
                $image = $subject->getPhotoUrl();

            } else {
              if (!empty($getPageData->file_id)) {
                $url = Engine_Api::_()->storage()->get($getPageData->file_id, '')->getPhotoUrl();
                $image = $url; //'http://' . $_SERVER['HTTP_HOST'] . $url;
              } else {
                $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesseo.nonmeta.photo', 'public/admin/social_share.jpg');
                $image = $view->baseUrl() . '/' . $nonmetaPhoto;
                $image = $http_https . $_SERVER['HTTP_HOST'] . $image;
              }
              $URL = $http_https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }

            //Roboto tag
            if($getPageData->roboto_tags == 1) {
                $view->headMeta()->setProperty('robots', 'index, follow');
            } elseif($getPageData->roboto_tags == 2) {
                $view->headMeta()->setProperty('robots', 'index, nofollow');
            } elseif($getPageData->roboto_tags == 3) {
                $view->headMeta()->setProperty('robots', 'noindex, follow');
            } elseif($getPageData->roboto_tags == 4) {
                $view->headMeta()->setProperty('robots', 'noindex,nofollow');
            }

            //Add custom tags
            if($getPageData->tags) {
                $view->layout()->headIncludes = $getPageData->tags;
            }

            //Add Image
            if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
                $view->doctype('XHTML1_RDFA');
                $view->headMeta()->setProperty('og:image', $image);
            }
          }
        }

        //Hreflang is an HTML <link> or <link> tag attribute that tells search engines the relationship between pages in different languages on your website. Google uses the attribute to serve the correct regional or language URLs in its search results based on the searcher's country and language preferences.
        if($settings->getSetting('sesseo.enable.hreflang', 1)) {
            $translate = Zend_Registry::get('Zend_Translate');
            $languages = $translate->getList();
            foreach($languages as $language) {
                $view->headLink(array('rel' =>"alternate", 'hreflang' => $language, 'href' => $view->absoluteUrl($view->url().'?locale='.$language)),'PREPEND');
            }
        }

        //A canonical URL lets you tell search engines that certain similar URLs are actually the same. Sometimes you have products or content that can be found on multiple URLs — or even multiple websites, but by using canonical URLs (HTML link tags with the attribute rel=canonical), you can have these on your site without harming your rankings.
        if($settings->getSetting('sesseo.enable.canonical', 1)) {
            $view->headLink(array('rel' => 'canonical', 'href' => $view->absoluteUrl($view->url())),'PREPEND');
        }


        //OpenSearch is a collection of simple formats for the sharing of search results. The OpenSearch description document format can be used to describe a search engine so that it can be used by search client applications.
        if ($settings->getSetting("sesseo.enable.opensearchdes", 1)) {
            if(file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'osdd.xml')) {
                $view->headLink(array('rel' => 'search', 'href' => 'osdd.xml', 'type' => 'application/opensearchdescription+xml'),'PREPEND');
            }
        }
    }
  }
}
