<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_HomeSliderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
     $settings = Engine_Api::_()->getApi('settings', 'core');
     $this->view->staticContent = $settings->getSetting('sesariana.staticcontent', '');
     $this->view->bgimage = $settings->getSetting('sesariana.banner.bgimage', '');
     $this->view->bannerupimage = $settings->getSetting('sesariana.banner.bannerupimage', '');
     $this->view->sesariana_banner_content = explode(',',$settings->getSetting('sesariana.banner.content', ''));
     
  }

}