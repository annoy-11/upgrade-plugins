<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_FollowButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    if (empty($this->view->viewer_id) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active', 1))
      return $this->setNoRender();
    $sesmember_followbutton = Zend_Registry::isRegistered('sesmember_followbutton') ? Zend_Registry::get('sesmember_followbutton') : null;
    if (empty($sesmember_followbutton))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('user'))
      return $this->setNoRender();
    $this->view->subject = $user_item = Engine_Api::_()->core()->getSubject('user');
    $this->view->user_id = $user_item->getIdentity();
    if ($this->view->user_id == $this->view->viewer_id)
      return $this->setNoRender();
  }

}
