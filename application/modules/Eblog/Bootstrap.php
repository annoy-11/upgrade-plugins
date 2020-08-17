<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Eblog_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $headScript = new Zend_View_Helper_HeadScript();
      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog_enable_location', 1))
        $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));
    }
    /*for redirect old action for non login user start */
    if(Zend_Auth::getInstance()->getIdentity() && isset($_SESSION['redirect_url']) && !empty($_SESSION['redirect_url']))
    {
      $redirect_url=$_SESSION['redirect_url'];
      unset($_SESSION['redirect_url']);
      header("Location: ".$redirect_url);
    }
    /*for redirect old action for non login user end */
  }

  protected function _initRouter() {
  
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.pluginactivated')) {
      $integrateothermodulesTable = Engine_Api::_()->getDbTable('integrateothermodules', 'eblog');
      $select = $integrateothermodulesTable->select();
      $results = $integrateothermodulesTable->fetchAll($select);
      if(count($results) > 0) {
        foreach ($results as $result) {
          $router->addRoute('eblog_browseblog_' . $result->getIdentity(), new Zend_Controller_Router_Route($result->content_url . '/browse-blogs', array('module' => 'eblog', 'controller' => 'index', 'action' => 'browse-blogs', 'resource_type' => $result->content_type ,'integrateothermodule_id' => $result->integrateothermodule_id)));
        }
        return $router;
      }
    }
  }
  
  protected function _initFrontController() {
    $this->initActionHelperPath();
    include APPLICATION_PATH . '/application/modules/Eblog/controllers/Checklicense.php';
  }
}
