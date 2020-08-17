<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'article');
  }
  
	public function onRenderLayoutDefault($event){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();	
		
		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.welcome',1);
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesarticle') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){ 
				$redirector->gotoRoute(array('module' => 'sesarticle', 'controller' => 'index', 'action' => 'home'), 'sesarticle_general', false);
			}
			elseif($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'sesarticle', 'controller' => 'index', 'action' => 'browse'), 'sesarticle_general', false);
			} else if($checkWelcomeEnable == '1') {
			
        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesarticle'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'sesarticle', 'controller' => 'index', 'action' => 'home'), 'sesarticle_general', false);
        }
			}
		}
		
		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Sesarticle/externals/scripts/core.js');
                                
		$script = '';
		if($moduleName == 'sesarticle'){
			$script .=
"sesJqueryObject(document).ready(function(){
     sesJqueryObject('.core_main_sesarticle').parent().addClass('active');
    });
";
		}
		$script .= "var articleURLsesarticle = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.articles.manifest', 'articles') . "';";
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
      // Delete sesarticles
      $sesarticleTable = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');
      $sesarticleSelect = $sesarticleTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $sesarticleTable->fetchAll($sesarticleSelect) as $sesarticle ) {
        Engine_Api::_()->sesarticle()->deleteArticle($sesarticle);;
      }
      // Delete subscriptions
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'sesarticle');
      $subscriptionsTable->delete(array(
        'user_id = ?' => $payload->getIdentity(),
      ));
      $subscriptionsTable->delete(array(
        'subscriber_user_id = ?' => $payload->getIdentity(),
      ));			
    }
  }
}