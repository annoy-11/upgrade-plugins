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

class Sesariana_Widget_FeaturesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
		 $settings = Engine_Api::_()->getApi('settings', 'core');
     $this->view->heading = $settings->getSetting('sesariana.feature.heading', '');
     $this->view->caption = $settings->getSetting('sesariana.feature.caption', '');
     $this->view->bgimage = $settings->getSetting('sesariana.feature.bgimage', '');
     $this->view->content = $settings->getSetting('sesariana.feature.content', '');
     if(!$this->view->content)
      $this->setNoRender();
  }

}