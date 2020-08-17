<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {
	
    parent::__construct($application);
    
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesariana_Plugin_Core);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		// $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800|Bitter:400,400i,700|Indie+Flowe');
    if(strpos($_SERVER['REQUEST_URI'],'admin/menus') !== FALSE  ){
       $headScript = new Zend_View_Helper_HeadScript();
  	  $headScript->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
      $headScript->appendFile($baseUrl . 'application/modules/Sesariana/externals/scripts/admin.js');
    }
   
  
    $this->initViewHelperPath();    
    $layout = Zend_Layout::getMvcInstance();
    $layout->getView()
            ->addFilterPath(APPLICATION_PATH . "/application/modules/Sesariana/View/Filter", 'Sesariana_View_Filter_')
            ->addFilter('Bodyclass');
    
	}
	
  protected function _initFrontController() {
  
    $this->initActionHelperPath();
    Zend_Controller_Action_HelperBroker::addHelper(new Sesariana_Controller_Action_Helper_LoginError());
    include APPLICATION_PATH . '/application/modules/Sesariana/controllers/Checklicense.php';
  }
}