<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Widget_LocationDetectController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $sesweather_widgets = Zend_Registry::isRegistered('sesweather_widgets') ? Zend_Registry::get('sesweather_widgets') : null;
    if(empty($sesweather_widgets)) {
      return $this->setNoRender();
    }
    //get cookie data for auto location
    $headScript = new Zend_View_Helper_HeadScript();
    $this->view->cookiedata = $cookiedata = Engine_Api::_()->sesbasic()->getUserLocationBasedCookieData();
    if (1)
      $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));
    else
      $this->setNoRender();
  }

}
