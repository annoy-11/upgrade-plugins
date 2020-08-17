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
class Sesmember_Widget_ReviewOwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.allow.review', 1))
      return $this->setNoRender();
    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('sesmember_review'))
      $item = Engine_Api::_()->core()->getSubject('sesmember_review');
    $this->view->content_item = Engine_Api::_()->getItem('user', $item->user_id);
    $currentTime = time();
    $user = Engine_Api::_()->getItem('user', $item->owner_id);
    $this->view->item = $user;
    if (!$item)
      return $this->setNoRender();
  }

}
