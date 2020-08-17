<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Plugin_Core extends Zend_Controller_Plugin_Abstract {

	public function onRenderLayoutDefault() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headScript()->prependFile(Zend_Registry::get('StaticBaseUrl').'externals/jQuery/jquery.min.js');

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('einstaclone.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = '//fonts.googleapis.com/css?family=';

      $bodyFontFamily = Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_body_fontfamily');
      $string .= str_replace('"', '', $bodyFontFamily);

      $headingFontFamily = Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $mainmenuFontFamily = Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_mainmenu_fontfamily');
      $string .= '|'.str_replace('"', '', $mainmenuFontFamily);

      $tabFontFamily = Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_tab_fontfamily');
      $string .= '|'.str_replace('"', '', $tabFontFamily);;

      $view->headLink()->appendStylesheet($string);
    }
	}
}
