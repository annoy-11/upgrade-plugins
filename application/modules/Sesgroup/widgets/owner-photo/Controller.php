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
 
class Sesgroup_Widget_OwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->title = $this->_getParam('showTitle', 1);
    if (Engine_Api::_()->core()->hasSubject('sesgroup_group')) {
      $item = Engine_Api::_()->core()->getSubject();
      $user = Engine_Api::_()->getItem('user', $item->owner_id);
    }
    $this->view->item = $user;
    if (!$item)
      return $this->setNoRender();
  }

}
