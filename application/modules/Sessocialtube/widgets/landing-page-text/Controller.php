<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessocialtube_Widget_LandingPageTextController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $contentText = '<div class="socialtube_lp_text_block">
	<div style="margin:0 auto;text-align:center;">
  	<h2 style="font-size:30px;font-weight:normal;margin-bottom:20px;text-transform:uppercase;">HELP US MAKE BETTER</h2>
    <p style="padding:0 100px;font-size:20px;margin-bottom:20px;">You can help us make Videos even better by uploading your own content. Simply register for an account, select which content you want to contribute and then use our handy upload tool to add them to our library.</p>
    <ul>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/media.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 1) Select a Media</p>
      </li>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/media-upload.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 1) Upload to video</p>
      </li>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/thumbsup.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 3) Feel Awesome</p>
      </li>
    </ul>
  </div>
</div>';

    $languages = Zend_Locale::getTranslationList('language', Zend_Registry::get('Locale'));
    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    $local_language = $this->view->locale()->getLocale()->__toString(); 
    $local_language = explode('_', $local_language);
    $language = @$local_language[0] . @$local_language[1];
    if(count($languageList) == '1') {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessocialtube.landinapagetext.en", $contentText);
    } else {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessocialtube.landinapagetext.$language", $contentText);
    }
  }

}
