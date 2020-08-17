<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initRouter() {
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.pluginactivated')) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $headScript = new Zend_View_Helper_HeadScript();
      $coreContentTable = Engine_Api::_()->getDbTable('content', 'core');
      $select = $coreContentTable->select()->where('name = ?', 'sespagebuilder.advancedmenu-generic')->where('page_id = ?', 1);
      $result = $coreContentTable->fetchRow($select);
      if (count($result) > 0) {
        $view->headLink()->appendStylesheet($baseURL . 'application/modules/Sespagebuilder/externals/styles/styles.css');
      }

      $fixedPageTable = Engine_Api::_()->getDbTable('pagebuilders', 'sespagebuilder');
      $selectTable = $fixedPageTable->select();
      $fixedPages = $fixedPageTable->fetchAll($selectTable);
      foreach ($fixedPages as $fixedPage) {
        $router->addRoute('sespagebuilder_index_' . $fixedPage->pagebuilder_id, new Zend_Controller_Router_Route($fixedPage->pagebuilder_url, array('module' => 'sespagebuilder', 'controller' => 'index', 'action' => 'index', 'pagebuilder_id' => $fixedPage->pagebuilder_id)));
      }
      return $router;
    }
  }

}
