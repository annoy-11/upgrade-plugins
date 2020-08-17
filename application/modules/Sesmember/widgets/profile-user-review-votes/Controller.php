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
class Sesmember_Widget_ProfileUserReviewVotesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('user'))
      return $this->setNoRender();
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    $this->view->userInfoItem = $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($subject->user_id);
    if (($getUserInfoItem->useful_count == 0 && $getUserInfoItem->cool_count == 0 && $getUserInfoItem->funny_count == 0) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.votes', '1'))
      return $this->setNoRender();
  }

}
