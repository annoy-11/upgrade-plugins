<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesalbum
 * @package    Sesalbum
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesalbum_Bootstrap extends Engine_Application_Bootstrap_Abstract {
  public function __construct($application) {
    parent::__construct($application);
		$baseURL = Zend_Registry::get('StaticBaseUrl');	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headTranslate(array(
		'Album Favorited Successfully', 'Album Unfavorited Successfully', 'Photo Liked Successfully', 'Photo Unliked Successfully', 'Unmark as Featured', 'Mark Featured', 'Unmark as Sponsored', 'Mark Sponsored', 'Photo Unfavorited Successfully', 'Photo Favorited Successfully', 'Album Liked Successfully', 'Album Unliked Successfully'
		));
		 if(strpos(str_replace('/','',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),str_replace('/','',$_SERVER['SERVER_NAME'].'admin'))=== FALSE){
			$this->initViewHelperPath();
			$headScript = new Zend_View_Helper_HeadScript();
			$headScript->appendFile($baseURL
								 .'application/modules/Sesalbum/externals/scripts/core.js');			
			$headScript->appendFile($baseURL
								. 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
						
			$headScript
			->appendFile($baseURL . 'externals/moolasso/Lasso.js')
			->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/Lasso.Crop.js');
		if (APPLICATION_ENV == 'production')
			$headScript
				->appendFile($baseURL . 'externals/autocompleter/Autocompleter.min.js');
		else
			$headScript
				->appendFile($baseURL . 'externals/autocompleter/Observer.js')
				->appendFile($baseURL . 'externals/autocompleter/Autocompleter.js')
				->appendFile($baseURL . 'externals/autocompleter/Autocompleter.Local.js')
				->appendFile($baseURL. 'externals/autocompleter/Autocompleter.Request.js');
      $headScript->appendFile($baseURL. 'application/modules/Sesbasic/externals/scripts/tagger.js');
		 }
  }
	
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesalbum/controllers/Checklicense.php';
  }

  protected function _initRouter() {
  
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum.pluginactivated')) {
      $integrateothermodulesTable = Engine_Api::_()->getDbTable('integrateothersmodules', 'sesalbum');
      $select = $integrateothermodulesTable->select();
      $results = $integrateothermodulesTable->fetchAll($select);
      if(count($results) > 0) {
        foreach ($results as $result) {
          $router->addRoute('sesalbum_browsealbum_' . $result->getIdentity(), new Zend_Controller_Router_Route($result->content_url . '/browse-albums', array('module' => 'sesalbum', 'controller' => 'index', 'action' => 'browse-albums', 'resource_type' => $result->content_type ,'integrateothersmodule_id' => $result->integrateothersmodule_id)));
        }
        return $router;
      }
    }
  }
}
