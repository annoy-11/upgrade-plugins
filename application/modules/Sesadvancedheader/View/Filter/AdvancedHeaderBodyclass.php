<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bodyclass.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_View_Filter_AdvancedHeaderBodyclass {

	public function filter($string) {

    $layout = Zend_Layout::getMvcInstance();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    // Get body identity
    if( isset($layout->siteinfo['identity']) ) {
      $identity = $layout->siteinfo['identity'];
    } else {
      $identity = $request->getModuleName() . '-' .
      $request->getControllerName() . '-' .
      $request->getActionName();
    }

    $designIdName=array('', 'one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve', 'thirteen', 'fourteen', 'fifteen');
    $headerDesign = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvheader.design', '1');
    $class=" header_".$designIdName[$headerDesign];

    if(strpos($string,'<body id="global_page_'.$identity.'"') !== FALSE){
      $string =  str_replace('<body','<body class="'.$class.'"',$string);
    }
    return $string;
  }
}
