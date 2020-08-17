<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingvideo_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

	  $coreApi = Engine_Api::_()->core();

	  $setting = Engine_Api::_()->getApi('settings', 'core');
	  if (!$coreApi->hasSubject('crowdfundingvideo'))
      return $this->setNoRender();

    $this->view->video = $video = $coreApi->getSubject('crowdfundingvideo');
    $this->view->page = Engine_Api::_()->getItem('crowdfunding', $video->parent_id);
  }

}
