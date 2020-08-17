<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Plugin_Core {

	public function onRenderLayoutDefault($event){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();

		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.welcome',1);
		if($actionName == 'home' && $controllerName == 'index' && $moduleName == 'edocument') {
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'edocument', 'controller' => 'index', 'action' => 'browse'), 'edocument_general', false);
			}
		}

		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') .'application/modules/Edocument/externals/scripts/core.js');

		$script = '';
		if($moduleName == 'edocument'){
			$script .=
            "sesJqueryObject(document).ready(function(){
                sesJqueryObject('.core_main_edocument').parent().addClass('active');
                });
            ";
		}
		$script .= "var documentURLedocument = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.documents.manifest', 'documents') . "';";
		 $view->headScript()->appendScript($script);
	}

    public function onUserDeleteBefore($event) {
        $payload = $event->getPayload();
        if( $payload instanceof User_Model_User ) {
            $edocumentTable = Engine_Api::_()->getDbtable('edocuments', 'edocument');
            $edocumentSelect = $edocumentTable->select()->where('owner_id = ?', $payload->getIdentity());
            foreach( $edocumentTable->fetchAll($edocumentSelect) as $edocument ) {
                Engine_Api::_()->edocument()->deleteDocument($edocument);;
            }
        }
    }
}
