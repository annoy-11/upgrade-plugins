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


class Sesseo_Api_Core extends Core_Api_Abstract {

    public function generateAllSitemapFile() {

        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $contentsTable = Engine_Api::_()->getDbTable('contents', 'sesseo');
        $contentsTableName = $contentsTable->info('name');

        $select = $contentsTable->select()->where('enabled =?', '1');
        $results = $contentsTable->fetchAll($select);

        foreach($results as $result) {

            if($result->resource_type != 'menu_urls') {
                $content = Engine_Api::_()->getItem('sesseo_content', $result->content_id);
                $sitemapArray = Engine_Api::_()->sesseo()->getContentSitemap($result->resource_type, $content);

                if(empty($sitemapArray))
                    continue;

                //Check file is exist or not.
                $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
                if (!file_exists($filepath)) {
                    @mkdir($filepath);
                    @chmod($filepath, 0777);
                }
                $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap_'.$result->resource_type.'.xml';
                $params = array();
                foreach ($sitemapArray as $key => $sitemapContent) {
                    $container = new Zend_Navigation($sitemapContent);
                    $sitemap = $view->sitemap($container)->render();
                    $params['data'] = $view->sitemap($container)->render();
                    file_put_contents($siteFileName, $sitemap);
                    @chmod($siteFileName, 0777);

                    $this->makeCompressContentFile($params, $content);
                }
                $content->modified_date = gmdate('Y-m-d H:i:s');
                $content->save();
                $this->makeCommonSitemapFile();
            } else {
                $content = Engine_Api::_()->getItem('sesseo_content', $result->content_id);
                $sitemapArray = Engine_Api::_()->sesseo()->getMenusSitemap();

                if(empty($sitemapArray))
                    continue;

                //Check file is exist or not.
                $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
                if (!file_exists($filepath)) {
                    @mkdir($filepath);
                    @chmod($filepath, 0777);
                }
                $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap_'.$result->resource_type.'.xml';
                $params = array();
                foreach ($sitemapArray as $key => $sitemapContent) {
                    $container = new Zend_Navigation($sitemapContent);
                    $sitemap = $view->sitemap($container)->render();
                    $params['data'] = $view->sitemap($container)->render();
                    file_put_contents($siteFileName, $sitemap);
                    @chmod($siteFileName, 0777);

                    $this->makeCompressContentFile($params, $content);
                }
                $content->modified_date = gmdate('Y-m-d H:i:s');
                $content->save();
                $this->makeCommonSitemapFile();
            }
        }

    }

    public function makeCompressContentFile($params, $content) {
        //Check file is exist or not.
        $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
        if (!file_exists($filepath)) {
            @mkdir($filepath);
            @chmod($filepath, 0777);
        }
        $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap_'.$content->resource_type.'.xml.gz';
        $gzdata = gzencode($params['data'], 9);
        file_put_contents($siteFileName, $gzdata);
        @chmod($siteFileName, 0777);
    }

  public function makeCommonSitemapFile() {

    $contentsTable = Engine_Api::_()->getDbTable('contents', 'sesseo');
    $contentsTableName = $contentsTable->info('name');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $select = $contentsTable->select()->where('enabled =?', 1);
    $results = $contentsTable->fetchAll($select);

    $filePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';

    $allContentXMLArray = array();

    foreach($results as $result) {
        //Check file is exist or not.
        $file_path = $filePath .DIRECTORY_SEPARATOR . 'sitemap_'.$result->resource_type.'.xml.gz';
        $siteFileName = $view->absoluteUrl($view->baseUrl('public/sesseo/sitemap_'.$result->resource_type.'.xml.gz'));
        if(file_exists($file_path)) {
            $allContentXMLArray[] = array(
                'uri' => $siteFileName,
                'lastmod'   => $result->modified_date,
            );
        }
    }
    $container = new Zend_Navigation($allContentXMLArray);
    $sitemap = $view->sitemap($container)->render();
    $params['data'] = $view->sitemap($container)->render();

    //Check file is exist or not.
    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
    if (!file_exists($filepath)) {
        @mkdir($filepath);
        @chmod($filepath, 0777);
    }
    $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap'.'.xml';
    file_put_contents($siteFileName, $sitemap);
    @chmod($siteFileName, 0777);
    $this->makeCompressCommonFile($params);
  }

  public function makeCompressCommonFile($params) {
    //Check file is exist or not.
    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
    if (!file_exists($filepath)) {
        @mkdir($filepath);
        @chmod($filepath, 0777);
    }
    $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap'.'.xml.gz';
    $gzdata = gzencode($params['data'], 9);
    file_put_contents($siteFileName, $gzdata);
    @chmod($siteFileName, 0777);
  }

    public function getContentSitemap($resource_type, $content) {
        $authApi = Engine_Api::_()->authorization();
        $coreSearchTable = Engine_Api::_()->getDbTable('search', 'core');
        $coreSearchTableName = $coreSearchTable->info('name');

        $select = $coreSearchTable->select()->where("type = ?", $resource_type)->order('id DESC');

        if(!empty($content->limit))
            $select->limit($content->limit);

        $results = $coreSearchTable->fetchAll($select);

        $sitemapArray = array();
        foreach($results as $results) {

            $resource = Engine_Api::_()->getItem($results->type, $results->id);
            if(isset($resource->modified_date)) {
                $date =  $resource->modified_date;
            } elseif(isset($resource->creation_date)) {
                $date =  $resource->creation_date;
            } else {
                $date = gmdate('Y-m-d H:i:s');
            }
            if($resource && $authApi->isAllowed($resource, 'everyone', 'view') && $resource->getHref()) {
                $sitemapArray[]  = array(
                    'uri' => $resource->getHref(),
                    'priority' => $content->priority,
                    'changefreq' => $content->frequency,
                    'lastmod' => $date,
                );
            }
        }
        $sitemapArray = array_chunk($sitemapArray, '1000');
        return $sitemapArray;

    }

    public function submitCurlSitemap() {
        //https://stackoverflow.com/questions/40355759/zf2-log-curl-requests
        //https://framework.zend.com/manual/2.4/en/modules/zend.http.client.adapters.html
        //Zend_Http_Client automatically handles HTTP redirections, and will follow up to 5 redirections. This can be changed by setting the 'maxredirects' configuration parameter.
        $client = new Zend_Http_Client();
        $client->setUri($URL);
        $response = $client->request('GET');
        $status = $response->getStatus();
        return $status;
    }

    public function getMenusSitemap() {

        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        $sesseo_select_menus = Engine_Api::_()->getApi('settings','core')->getSetting('sesseo_select_menus','');
        $sesseo_select_menus = json_decode($sesseo_select_menus);

        $coreMenusApi = Engine_Api::_()->getApi('menus', 'core');
        $menustable = Engine_Api::_()->getDbTable('menus', 'core');
        $select = $menustable->select()->where('id IN (?)', $sesseo_select_menus);
        $allmenus = $menustable->fetchAll($select);
        $navigation = new Zend_Navigation();
        foreach($allmenus as $allmenu) {
            $pages = $coreMenusApi->getMenuParams($allmenu->name);
            $navigation->addPages($pages);
        }
        $checkURLValidator = new Zend_Validate_Sitemap_Loc();
        $allURLs = array();
        foreach($navigation as $urls) {
            if ($checkURLValidator->isValid($view->absoluteUrl($urls->getHref())))
                $allURLs[] = $view->absoluteUrl($urls->getHref());
        }

        if(count($allURLs) > 0) {
            $sitemapArray = array();
            foreach($allURLs as $results) {
                $sitemapArray[]  = array(
                    'uri' => $results,
                    'priority' => $content->priority,
                    'changefreq' => $content->frequency,
                    'lastmod' => gmdate('Y-m-d H:i:s'),
                );
            }
            $sitemapArray = array_chunk($sitemapArray, '1000');
        }
        return $sitemapArray;
    }

//   public function getWidgitizePagesPhoto($params = array()) {
//
//     $page_name = $params['module'] . '_'.$params['controller'].'_'.$params['action'];
//     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
//     $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('name =?', $page_name);
//     $results = Engine_Api::_()->getDbtable('pages', 'core')->fetchRow($select);
//     $page_id = $results->page_id;
//     $checkViewPage = false;
//     if(Engine_Api::_()->core()->hasSubject()) {
//      $subject = Engine_Api::_()->core()->getSubject();
//      $checkViewPage = true;
//     }
//     $metatags = array();
//     if($page_id) {
//       $getPageData = Engine_Api::_()->getDbTable('managemetatags', 'sesseo')->getPageData(array('page_id' => $page_id));
//       if(!empty($getPageData->managemetatag_id) && isset($getPageData->managemetatag_id)) {
//         if($checkViewPage) {
//           if (strpos($subject->getPhotoUrl(), 'http') === FALSE)
//             $image = 'http://' . $_SERVER['HTTP_HOST'] . $subject->getPhotoUrl();
//           else
//             $image = $subject->getPhotoUrl();
//           if(!empty($subject->getTitle()))
//             $title = $subject->getTitle();
//           $metatags['image'] = $image;
//           $metatags['title'] = $title;
//         } else {
//           if (!empty($getPageData->file_id)) {
//             $url = Engine_Api::_()->storage()->get($getPageData->file_id, '')->getPhotoUrl();
//             $image = $url; //'http://' . $_SERVER['HTTP_HOST'] . $url;
//           } else {
//             $image = '';
//           }
//           if(!empty($getPageData->meta_title)) {
//             $title = $getPageData->meta_title;
//           } else
//             $title = '';
//           $metatags['image'] = $image;
//           $metatags['title'] = $title;
//         }
//       }
//     } else {
//       $nonmetaTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesseo.nonmeta.title', '');
//       $nonmetaPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesseo.nonmeta.photo', '');
//       if (!empty($nonmetaPhoto)) {
//         $image = $view->baseUrl() . '/' . $nonmetaPhoto;
//         $image = 'http://' . $_SERVER['HTTP_HOST'] . $image;
//       } else {
//         $image = '';
//       }
//       $metatags['image'] = $image;
//       $metatags['title'] = $nonmetaTitle;
//     }
//     return $metatags;
//   }
}
