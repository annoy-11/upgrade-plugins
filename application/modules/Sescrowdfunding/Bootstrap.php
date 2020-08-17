<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
  
    parent::__construct($application);
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
    
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sescrowdfunding/externals/scripts/core.js');
      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding_enable_location', 1))
        $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));
    }
  }
  
  protected function _initRouter() {
  
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.pluginactivated')) {
      $integrateothermodulesTable = Engine_Api::_()->getDbTable('integrateothermodules', 'sescrowdfunding');
      $select = $integrateothermodulesTable->select();
      $results = $integrateothermodulesTable->fetchAll($select);
      if(count($results) > 0) {
        foreach ($results as $result) {
          $router->addRoute('sescrowdfunding_browsecrowdfunding_' . $result->getIdentity(), new Zend_Controller_Router_Route($result->content_url . '/browse-crowdfundings', array('module' => 'sescrowdfunding', 'controller' => 'index', 'action' => 'browse-crowdfundings', 'resource_type' => $result->content_type ,'integrateothermodule_id' => $result->integrateothermodule_id)));
        }
        return $router;
      }
    }
  }
}
