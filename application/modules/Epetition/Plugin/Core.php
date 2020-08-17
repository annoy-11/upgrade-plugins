<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('epetitions', 'epetition');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'blog');
  }
  
	public function onRenderLayoutDefault($event){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();	
		
		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.welcome',0);
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'epetition') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){ 
				$redirector->gotoRoute(array('module' => 'epetition', 'controller' => 'index', 'action' => 'home'), 'epetition_general', false);
			}
			elseif($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'epetition', 'controller' => 'index', 'action' => 'browse'), 'epetition_general', false);
			} else if($checkWelcomeEnable == '1') {
			
        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'epetition'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'epetition', 'controller' => 'index', 'action' => 'home'), 'epetition_general', false);
        }
			}
		}
		
		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Epetition/externals/scripts/core.js');
                                
		$script = '';
		if($moduleName == 'epetition'){
			$script .=
"sesJqueryObject(document).ready(function(){
     sesJqueryObject('.core_main_epetition').parent().addClass('active');
    });
";
		}
		$script .= "var petitionURLepetition = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.manifest', 'petitions') . "';";
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
      // Delete epetitions
      $epetitionTable = Engine_Api::_()->getDbtable('epetitions', 'epetition');
      $epetitionSelect = $epetitionTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $epetitionTable->fetchAll($epetitionSelect) as $epetition ) {
        Engine_Api::_()->epetition()->deleteBlog($epetition);;
      }
      // Delete subscriptions
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'epetition');
      $subscriptionsTable->delete(array(
        'user_id = ?' => $payload->getIdentity(),
      ));
      $subscriptionsTable->delete(array(
        'subscriber_user_id = ?' => $payload->getIdentity(),
      ));			
    }
  }
}
