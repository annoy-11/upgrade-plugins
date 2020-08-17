<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Plugin_Core {

	public function onRenderLayoutDefault() {
	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sesfooter.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';
      
      $headingFontFamily = Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $textFontFamily = Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontfamily');
      $string .= '|'.str_replace('"', '', $textFontFamily);;

      $view->headLink()->appendStylesheet($string);
    }
	}
}