<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
    parent::__construct($application);
		$baseURL = Zend_Registry::get('StaticBaseUrl');	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

		 if(strpos(str_replace('/','',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),str_replace('/','',$_SERVER['SERVER_NAME'].'admin'))=== FALSE){
			$this->initViewHelperPath();
			$headScript = new Zend_View_Helper_HeadScript();
		
			$headScript->appendFile($baseURL
								. 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
						

		 }
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sescontentcoverphoto/controllers/Checklicense.php';
  }
}
