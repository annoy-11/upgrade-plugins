<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

      
	  $coreApi = Engine_Api::_()->core();

	  $setting = Engine_Api::_()->getApi('settings', 'core');
	  if (!$coreApi->hasSubject('seseventvideo_video'))
      return $this->setNoRender();

    $this->view->video = $video = $coreApi->getSubject('seseventvideo_video');
    $this->view->event = Engine_Api::_()->getItem('sesevent_event', $video->parent_id);
  }

}
