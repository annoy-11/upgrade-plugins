<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('seslistings', 'seslisting');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'listing');
  }

	public function onRenderLayoutDefault($event){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();

		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.welcome',0);
    
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'seslisting') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){
				$redirector->gotoRoute(array('module' => 'seslisting', 'controller' => 'index', 'action' => 'home'), 'seslisting_general', false);
			}
			elseif($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'seslisting', 'controller' => 'index', 'action' => 'browse'), 'seslisting_general', false);
			} else if($checkWelcomeEnable == '1') {

        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'seslisting'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'seslisting', 'controller' => 'index', 'action' => 'home'), 'seslisting_general', false);
        }
			}
		}

		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Seslisting/externals/scripts/core.js');

		$script = '';
		if($moduleName == 'seslisting'){
			$script .=
"sesJqueryObject(document).ready(function(){
     sesJqueryObject('.core_main_seslisting').parent().addClass('active');
    });
";
		}
		$script .= "var listingURLseslisting = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.listings.manifest', 'listings') . "';";
		 $view->headScript()->appendScript($script);
	}
	public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
  public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
    if( $payload instanceof User_Model_User ) {
      // Delete seslistings
      $seslistingTable = Engine_Api::_()->getDbtable('seslistings', 'seslisting');
      $seslistingSelect = $seslistingTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $seslistingTable->fetchAll($seslistingSelect) as $seslisting ) {
        Engine_Api::_()->seslisting()->deleteListing($seslisting);;
      }
      // Delete subscriptions
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'seslisting');
      $subscriptionsTable->delete(array(
        'user_id = ?' => $payload->getIdentity(),
      ));
      $subscriptionsTable->delete(array(
        'subscriber_user_id = ?' => $payload->getIdentity(),
      ));
    }
  }
}
