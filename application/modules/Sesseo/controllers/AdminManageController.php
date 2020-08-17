<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_sitemap');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();

    $contentable = Engine_Api::_()->getDbTable('contents', 'sesseo');
    if (is_array($availableTypes) && count($availableTypes) > 0) {

      $options = array();
      foreach ($availableTypes as $index => $type) {

        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);

        $hasType = Engine_Api::_()->getDbTable('contents', 'sesseo')->hasType(array('resource_type' => $type));
        if (!$hasType) {

            $values = array('resource_type' => $type, 'title' => $this->view->translate($ITEM_TYPE), 'frequency' => 'always', 'priority' => '0.5', 'limit' => '0', 'enabled' => 1);
            $row = $contentable->createRow();
            $row->setFromArray($values);
            $row->save();
        }
      }
    }

    $this->view->formFilter = $formFilter = new Sesseo_Form_Admin_Manage_Sitemap();

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'content_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    $select = Engine_Api::_()->getDbtable('contents', 'sesseo')->select();

    if (!empty($values['title']))
      $select->where('title LIKE ?', '%' . $values['title'] . '%');

    if (isset($_GET['enabled']) && $_GET['enabled'] != '')
      $select->where('enabled = ?', $values['enabled']);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function submitAction() {

    set_time_limit(999999);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sesseo_Form_Admin_Manage_Submit();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();

      $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
      $sitemapFileURL = $view->absoluteUrl($view->baseUrl('public/sesseo/sitemap.xml'));

      if(!empty($values['regenerate_sitemap'])) {
        Engine_Api::_()->sesseo()->generateAllSitemapFile();
      }

      if(!file_exists($filepath .DIRECTORY_SEPARATOR.'sitemap'.'.xml')) {
        $form->addError("Sitemap file is not exist. First you Generate Sitemap File.");
        return;
      }
      try {
        if(in_array('google', $values['search_engine'])) {
            $URL = "http://www.google.com/webmasters/sitemaps/ping?sitemap=".$sitemapFileURL;
            Engine_Api::_()->sesseo()->submitCurlSitemap($URL);
        }
        if(in_array('bing', $values['search_engine'])) {
            $url = "http://www.bing.com/webmaster/ping.aspx?siteMap=".$sitemapUrl;
            Engine_Api::_()->sesseo()->submitCurlSitemap($URL);
        }
      } catch (Exception $e) {
      }

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesseo_sitemap_modifieddate', date('Y-m-d H:i:s'));
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 50,
        'parentRefresh' => 50,
        'messages' => array('You have successfully submit sitemap file.')
      ));
    }
  }


  public function generateallAction() {

    Engine_Api::_()->sesseo()->generateAllSitemapFile();
    return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully create sitemap file for this content.')
    ));
  }

  public function generateAction() {

    $id = $this->_getParam('content_id');
    $content = Engine_Api::_()->getItem('sesseo_content', $id);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $resource_type = $content->resource_type;
    if(empty($resource_type))
        return;

    $authApi = Engine_Api::_()->authorization();


    if($resource_type != 'menu_urls') {
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
    } else {
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
    }

    if(empty($sitemapArray))
        return;

    //Check file is exist or not.
    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo';
    if (!file_exists($filepath)) {
        @mkdir($filepath);
        @chmod($filepath, 0777);
    }
    $siteFileName = $filepath .DIRECTORY_SEPARATOR.'sitemap_'.$resource_type.'.xml';

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

    return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully create sitemap file for this content.')
    ));
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

  public function downloadxmlAction() {
    header("Content-Type: application/xml;");
    header("Content-Disposition: attachment; filename=sitemap.xml;");
    readfile("public/sesseo/sitemap.xml");
    exit();
    return;
  }

  public function downloadgzipAction() {
    header("Content-Type: application/xml;");
    header("Content-Disposition: attachment; filename=sitemap.xml.gz;");
    readfile("public/sesseo/sitemap.xml.gz");
    exit();
    return;
  }

  public function enabledAction() {

    $id = $this->_getParam('content_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesseo_content', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesseo/manage');
  }

  public function selectedmenusAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $content = Engine_Api::_()->getItem('sesseo_content', $this->_getParam('content_id'));
    $form = $this->view->form = new Sesseo_Form_Admin_Manage_Selectedmenus();
    $form->execute->setLabel('Save Changes');
    $form->populate($content->toArray());
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $sesseo_select_menus = json_encode($values['sesseo_select_menus']);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sesseo.select.menus', $sesseo_select_menus);
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully select menus.')
      ));
    }
  }

  public function editAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $content = Engine_Api::_()->getItem('sesseo_content', $this->_getParam('content_id'));
    $form = $this->view->form = new Sesseo_Form_Admin_Manage_EditSettings();
    $form->execute->setLabel('Save Changes');
    $form->populate($content->toArray());
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $content->setFromArray($values);
        $content->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully edit entry.')
      ));
    }
  }
}
