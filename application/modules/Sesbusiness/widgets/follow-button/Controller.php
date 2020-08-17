<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesbusiness_Widget_FollowButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('businesses'))
      return $this->setNoRender();
    $this->view->subject = $business = Engine_Api::_()->core()->getSubject('businesses');
    if ($business->owner_id == $viewerId || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.follow', 1))
      return $this->setNoRender();

  }

}
