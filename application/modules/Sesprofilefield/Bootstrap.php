<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
  
    parent::__construct($application);
    
// 		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
// 		$view->headTranslate(array('Location'));

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesprofilefield/externals/scripts/core.js');
    }
  }
  
  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesprofilefield/controllers/Checklicense.php';
  }
}
