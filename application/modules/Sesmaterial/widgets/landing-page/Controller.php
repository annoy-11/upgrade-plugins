<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmaterial_Widget_LandingPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
		$this->view->core_settings = $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();
    $this->view->backgroundimage = $settings->getSetting('sesmaterial.landingpage.backgroundimage','');
    $this->view->mainimage = $settings->getSetting('sesmaterial.landingpage.mainimage','');

    $sesmaterial_widget = Zend_Registry::isRegistered('sesmaterial_widget') ? Zend_Registry::get('sesmaterial_widget') : null;
    if(empty($sesmaterial_widget)) {
      return $this->setNoRender();
    }
  }
}
