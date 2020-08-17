<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslangtranslator_Plugin_Core {

	public function onRenderLayoutDefault($event) {
	
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $locale = $view->locale()->getLocale()->__toString();
//     $div = '<div id="google_translate_element" style="display:none;"></div>';
//     $scriptg = '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>';
    
    setcookie ( "googtrans" , "/en/$locale" , time ()+ 3600); 
    $script = "
    sesJqueryObject(document).ready(function(e) {
      sesJqueryObject('<div id=\"google_translate_element\" style=\"display:none;\"></div>').appendTo('body');
      sesJqueryObject('<script type=\"text\/javascript\" src=\"\/\/translate.google.com\/translate_a\/element.js?cb=googleTranslateElementInit\"><\/script>').appendTo('body');
    });
    
    //Google provides this function
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: '$locale', autoDisplay: false}, 'google_translate_element');
    }";
    $view->headScript()->appendScript($script);
	}
}