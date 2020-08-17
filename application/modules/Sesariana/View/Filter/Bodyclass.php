<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bodyclass.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_View_Filter_Bodyclass {

	public function filter($string) {
	
    $layout = Zend_Layout::getMvcInstance();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    // Get body identity
    if( isset($layout->siteinfo['identity']) ) {
      $identity = $layout->siteinfo['identity'];
    } else {
      $identity = $request->getModuleName() . '-' .
      $request->getControllerName() . '-' .
      $request->getActionName();
    }
    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.header.design', 2) == 2 && isset($_COOKIE['sesariana']) && $_COOKIE['sesariana'] == 2){
      $toogleClass = 'sidebar-toggled'; 
    }else if(empty($_COOKIE['sesariana'])){
      $toogleClass = 'sidebar-toggled';
    } else
      $toogleClass = '';
      
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.landingpage.style', 0) && ($moduleName == 'core' && $actionName == 'index' && $controllerName == 'index') ) {
      $class=" sesariana_landing_page";
    } else
      $class="";
      
    if(strpos($string,'<body id="global_page_'.$identity.'"') !== FALSE){
      $string =  str_replace('<body','<body class="'.$toogleClass.$class.'"',$string);
    }
    return $string;
  }
}