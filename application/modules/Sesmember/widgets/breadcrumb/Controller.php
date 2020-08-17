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
class Sesmember_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('sesmember_review'))
      return $this->setNoRender();
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.allow.review', 1))
      return $this->setNoRender();
    $this->view->review = $review = $coreApi->getSubject('sesmember_review');
    $this->view->content_item = $event = Engine_Api::_()->getItem('user', $review->user_id);
    $currentTime = time();
    //don't render widget if event ends
    if (strtotime($event->starttime) > ($currentTime))
      return $this->setNoRender();
  }

}
