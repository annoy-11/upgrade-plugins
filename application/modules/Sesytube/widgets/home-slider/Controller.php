<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_HomeSliderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
     $settings = Engine_Api::_()->getApi('settings', 'core');
     $this->view->staticContent = $settings->getSetting('sesytube.staticcontent', '');
     $this->view->bgimage = $settings->getSetting('sesytube.banner.bgimage', '');
     $this->view->sesytube_banerdes = $settings->getSetting('sesytube.banerdes', '');
  }
}
