<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_ReviewOwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('sesarticlereview'))
      $item = Engine_Api::_()->core()->getSubject('sesarticlereview');

    $user = Engine_Api::_()->getItem('user', $item->owner_id);
    $this->view->item = $user;
    if (!$item)
      return $this->setNoRender();
  }

}
