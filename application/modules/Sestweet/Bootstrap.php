<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestweet_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
  
    parent::__construct($application);
    
		$baseURL = Zend_Registry::get('StaticBaseUrl');	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    
    $script = '';
    $script .=
    "
    var sesencodeCurrentUrl = '".$urlencode."';
    var sestweet_bordercolor = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.bordercolor', '#1da1f2')."';
    var sestweet_borderwidth = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.borderwidth', '1px')."';
    var sestweet_text = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.text', 'Click To Tweet')."';
    var sestweet_fontsize = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.fontsize', '20px')."';
    var sestweet_widgthinper = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.widgthinper', 'Click To Tweet')."';
    var sestweet_twitter_handler = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.twitterhandler', 'yourname')."';
    ";
		$view->headScript()->appendScript($script);
		
  }
}