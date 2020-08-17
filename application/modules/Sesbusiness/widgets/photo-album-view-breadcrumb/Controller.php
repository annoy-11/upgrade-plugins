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

class Sesbusiness_Widget_PhotoAlbumViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->album = $album = Engine_Api::_()->core()->getSubject();
    $business_id = $album->business_id;
    if(!$album->getIdentity())
      return $this->setNoRender();
    $this->view->business = Engine_Api::_()->getItem('businesses', $business_id);
	}
}
