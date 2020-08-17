<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

    parent::__construct($application);

    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesytube_Plugin_Core);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		// Include Default Font
		$view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i');
    if(strpos($_SERVER['REQUEST_URI'],'admin/menus') !== FALSE  ){
       $headScript = new Zend_View_Helper_HeadScript();
  	  $headScript->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
      $headScript->appendFile($baseUrl . 'application/modules/Sesytube/externals/scripts/admin.js');
    }


    $this->initViewHelperPath();
    $layout = Zend_Layout::getMvcInstance();
    $layout->getView()
            ->addFilterPath(APPLICATION_PATH . "/application/modules/Sesytube/View/Filter", 'Sesytube_View_Filter_')
            ->addFilter('Bodyclass');

	}

  protected function _initFrontController() {

    $this->initActionHelperPath();
    Zend_Controller_Action_HelperBroker::addHelper(new Sesytube_Controller_Action_Helper_LoginError());
    include APPLICATION_PATH . '/application/modules/Sesytube/controllers/Checklicense.php';
  }
}
