<?php

class Sesquote_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {

    parent::__construct($application);

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesquote/externals/scripts/core.js');
    }
  }

  protected function _initRouter() {

    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.pluginactivated')) {
      $integrateothermodulesTable = Engine_Api::_()->getDbTable('integrateothermodules', 'sesquote');
      $select = $integrateothermodulesTable->select();
      $results = $integrateothermodulesTable->fetchAll($select);
      if(count($results) > 0) {
        foreach ($results as $result) {
          $router->addRoute('sesquote_browsequote_' . $result->getIdentity(), new Zend_Controller_Router_Route($result->content_url . '/browse-quotes', array('module' => 'sesquote', 'controller' => 'index', 'action' => 'browse-quotes', 'resource_type' => $result->content_type ,'integrateothermodule_id' => $result->integrateothermodule_id)));
        }
        return $router;
      }
    }
  }

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesquote/controllers/Checklicense.php';
  }
}
