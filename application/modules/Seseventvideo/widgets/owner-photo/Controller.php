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
class Seseventvideo_Widget_OwnerPhotoController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('seseventvideo_video'))
      $item = Engine_Api::_()->core()->getSubject('seseventvideo_video');
    $user = Engine_Api::_()->getItem('user', $item->owner_id);
    $this->view->item = $user;
    if (!$item)
      return $this->setNoRender();
  }
}