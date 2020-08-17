<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seschristmas_Widget_WelcomeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $api_settings = Engine_Api::_()->getApi('settings', 'core');
    $snoweffect = $api_settings->getSetting('seschristmas.snoweffect', 1);
    if (empty($snoweffect)) {
      return $this->setNoRender();
    }

    $this->view->snowimages = $api_settings->getSetting('seschristmas.snowimages', 1);
    if (!$api_settings->getSetting('seschristmas.welcomechristmas')) {
      return $this->setNoRender();
    }
    $this->view->snowquantity = $api_settings->getSetting('seschristmas.snowquantity', 30);
  }

}

