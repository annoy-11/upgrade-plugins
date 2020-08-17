<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespagethm_Widget_LandingPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
		$this->view->core_settings = $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();
    $this->view->backgroundimage = $settings->getSetting('sespagethm.landingpage.backgroundimage','');
    $this->view->mainimage = $settings->getSetting('sespagethm.landingpage.mainimage','');

    $sespagethm_widget = Zend_Registry::isRegistered('sespagethm_widget') ? Zend_Registry::get('sespagethm_widget') : null;
    if(empty($sespagethm_widget)) {
      return $this->setNoRender();
    }
  }
}
