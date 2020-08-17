<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

class Sesgroup_Widget_FollowButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
			
    $this->view->viewer_id = $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('sesgroup_group'))
      return $this->setNoRender();
    $this->view->subject = $group = Engine_Api::_()->core()->getSubject('sesgroup_group');
    if ($group->owner_id == $viewerId || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.follow', 1))
      return $this->setNoRender();
		
  }

}
