<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_Plugin_Core {

	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }

  public function onRenderLayoutDefault($event) {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $buttonStyling = $settings->getSetting('sesbody.buttonstyling', 1);
    $buttonRadius = $settings->getSetting('sesbody.buttonradius', 0).'px';

    //Left / Right side widget heading design
    $heading_design = $settings->getSetting('sesbody.leftrightheadingdesign', 'heading_design_one');
    if($heading_design) {
      $script = "
      sesJqueryObject(document).ready(function(e) {
        var htmlElement = document.getElementsByTagName('body')[0];
        htmlElement.addClass('$heading_design');
      });";
      $view->headScript()->appendScript($script);
    }

    if($settings->getSetting('sesbody.boxradius', 0)) {
      $script = "
      sesJqueryObject(document).ready(function(e) {
        var htmlElement = document.getElementsByTagName('body')[0];
        htmlElement.addClass('boxradius');
      });";
      $view->headScript()->appendScript($script);
    }

    $script = "
    sesJqueryObject(document).ready(function(e) {
      sesJqueryObject(':button').css('border-radius', '$buttonRadius');
      sesJqueryObject(':button').addClass('$buttonStyling');
    });";
    $view->headScript()->appendScript($script);

    $headScript = new Zend_View_Helper_HeadScript();

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sesbody.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';

      $bodyFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_body_fontfamily');
      $string .= str_replace('"', '', $bodyFontFamily);

      $headingFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $tabFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_tab_fontfamily');
      $string .= '|'.str_replace('"', '', $tabFontFamily);;

      $view->headLink()->appendStylesheet($string);

    }
    $view->headScript()->appendScript($script);
  }
}
