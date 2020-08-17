<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_PhotoViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
    $business_id = $photo->business_id;
    $album_id = $photo->album_id;
    if(!$photo->getIdentity())
      return $this->setNoRender();

    $this->view->album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
    $this->view->business = Engine_Api::_()->getItem('businesses', $business_id);

	}
}
