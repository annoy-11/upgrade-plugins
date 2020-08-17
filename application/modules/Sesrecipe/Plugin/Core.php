<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('recipes', 'sesrecipe');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'recipe');
  }
  
	public function onRenderLayoutDefault($event){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();	
		
		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.welcome',1);
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesrecipe') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){ 
				$redirector->gotoRoute(array('module' => 'sesrecipe', 'controller' => 'index', 'action' => 'home'), 'sesrecipe_general', false);
			}
			elseif($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'sesrecipe', 'controller' => 'index', 'action' => 'browse'), 'sesrecipe_general', false);
			} else if($checkWelcomeEnable == '1') {
			
        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesrecipe'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'sesrecipe', 'controller' => 'index', 'action' => 'home'), 'sesrecipe_general', false);
        }
			}
		}
		
		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Sesrecipe/externals/scripts/core.js');
                                
		$script = '';
		if($moduleName == 'sesrecipe'){
			$script .=
"sesJqueryObject(document).ready(function(){
     sesJqueryObject('.core_main_sesrecipe').parent().addClass('active');
    });
";
		}
		$script .= "var recipeURLsesrecipe = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.recipes.manifest', 'recipes') . "';";
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
      // Delete sesrecipes
      $sesrecipeTable = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
      $sesrecipeSelect = $sesrecipeTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $sesrecipeTable->fetchAll($sesrecipeSelect) as $sesrecipe ) {
        Engine_Api::_()->sesrecipe()->deleteRecipe($sesrecipe);;
      }
      // Delete subscriptions
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'sesrecipe');
      $subscriptionsTable->delete(array(
        'user_id = ?' => $payload->getIdentity(),
      ));
      $subscriptionsTable->delete(array(
        'subscriber_user_id = ?' => $payload->getIdentity(),
      ));			
    }
  }
}