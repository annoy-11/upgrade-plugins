<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Plugin_Core extends Zend_Controller_Plugin_Abstract {
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        $params = $request->getParams();
        if($params['module'] == 'core' && ($params['action'] == 'index') && ($params['controller'] == "search")) {
            $request->setModuleName('advancedsearch');
            $request->setControllerName('index');
        }
    }
	public function onRenderLayoutDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutMobileDefault($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutMobileDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutDefault($event) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
      					 .'application/modules/Advancedsearch/externals/scripts/core.js');
    }

}
