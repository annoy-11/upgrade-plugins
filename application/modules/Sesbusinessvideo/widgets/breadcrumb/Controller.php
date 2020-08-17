<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessvideo_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

	  $coreApi = Engine_Api::_()->core();

	  $setting = Engine_Api::_()->getApi('settings', 'core');
	  if (!$coreApi->hasSubject('businessvideo'))
      return $this->setNoRender();

    $this->view->video = $video = $coreApi->getSubject('businessvideo');
    $this->view->business = Engine_Api::_()->getItem('businesses', $video->parent_id);
  }

}
