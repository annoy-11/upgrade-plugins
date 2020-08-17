<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_ReviewOwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('sesrecipe_review'))
      $item = Engine_Api::_()->core()->getSubject('sesrecipe_review');

    $user = Engine_Api::_()->getItem('user', $item->owner_id);
    $this->view->item = $user;
    if (!$item)
      return $this->setNoRender();
  }

}
