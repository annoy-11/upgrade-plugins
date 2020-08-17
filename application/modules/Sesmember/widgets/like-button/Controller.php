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
class Sesmember_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    if (empty($viewerId))
      return $this->setNoRender();
    if (!Engine_Api::_()->core()->hasSubject('user'))
      return $this->setNoRender();
    $this->view->subject = $user_item = Engine_Api::_()->core()->getSubject('user');
    $this->view->user_id = $user_item->getIdentity();
    if ($this->view->user_id == $viewerId)
      return $this->setNoRender();
    $this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($user_item, $viewer);
  }

}
