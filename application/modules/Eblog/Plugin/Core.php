<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('blogs', 'eblog');
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
		
		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.welcome',1);
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'eblog') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){ 
				$redirector->gotoRoute(array('module' => 'eblog', 'controller' => 'index', 'action' => 'home'), 'eblog_general', false);
			}
			elseif($checkWelcomeEnable == '2') {
				$redirector->gotoRoute(array('module' => 'eblog', 'controller' => 'index', 'action' => 'browse'), 'eblog_general', false);
			} else if($checkWelcomeEnable == '1') {
			
        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'eblog'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'eblog', 'controller' => 'index', 'action' => 'home'), 'eblog_general', false);
        }
			}
		}
		
		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Eblog/externals/scripts/core.js');
                                
		$script = '';
		if($moduleName == 'eblog'){
			$script .=
"sesJqueryObject(document).ready(function(){
     sesJqueryObject('.core_main_eblog').parent().addClass('active');
    });
";
		}
		$script .= "var blogURLeblog = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.blogs.manifest', 'blogs') . "';";
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
      // Delete eblogs
      $eblogTable = Engine_Api::_()->getDbtable('blogs', 'eblog');
      $eblogSelect = $eblogTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $eblogTable->fetchAll($eblogSelect) as $eblog ) {
        Engine_Api::_()->eblog()->deleteBlog($eblog);;
      }
      // Delete subscriptions
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'eblog');
      $subscriptionsTable->delete(array(
        'user_id = ?' => $payload->getIdentity(),
      ));
      $subscriptionsTable->delete(array(
        'subscriber_user_id = ?' => $payload->getIdentity(),
      ));			
    }
  }
}