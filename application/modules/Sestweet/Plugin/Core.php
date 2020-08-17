<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestweet_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event, $mode = null) {
  
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    
    $sestwwet_core_cersion = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.coreversion');
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules', 'version')
            ->where('name = ?', 'core');
    $results = $select->query()->fetchObject();

    if(version_compare($results->version, $sestwwet_core_cersion) > 0) {
      Engine_Api::_()->sestweet()->tweetCode();
      Engine_Api::_()->sestweet()->tweetCodeInViewHelper();
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sestweet.coreversion', $results->version);
    }

    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet_textselection', 1)) {
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') .'application/modules/Sestweet/externals/scripts/core.js');
      if(empty($_GET["format"])){
        $tweetDiv = $view->partial('tweet-text.tpl', 'sestweet', array());	
        $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $tweetDiv = preg_replace($search, $replace, $tweetDiv);
        $script .= "sesJqueryObject(window).load(function () {
           sesJqueryObject('".$tweetDiv."').appendTo('body');
        });
        ";
      }
      $script .=
      "var sestweet_twitter_handler = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.twitterhandler', 'yourname')."';
      var sestweet_enabletwitter = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.enabletwitter', 1)."';
      var sestweet_enablefacebook = '".Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.enablefacebook', 1)."';
      ";
    }
    
    $view->headScript()->appendScript($script);
    
		if(Engine_Api::_()->core()->hasSubject()) {
		 $pageUrl =  $view->absoluteUrl($view->subject()->getHref());
      $script = "
        sesJqueryObject(document).ready(function(){
          if(sesJqueryObject('div[name=\"sestweet_tweet\"]').find('a').length){
            var sestweet_url = sesJqueryObject('div[name=\"sestweet_tweet\"]').find('a').attr('href').replace('sestweet_page_url', '".$pageUrl."');
            sesJqueryObject('div[name=\"sestweet_tweet\"]').find('a').attr('href', sestweet_url);
          }
        });";
      $view->headScript()->appendScript($script);
		}
  }
	public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
}
