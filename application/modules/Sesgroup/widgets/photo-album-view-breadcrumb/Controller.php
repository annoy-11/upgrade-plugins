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
 
class Sesgroup_Widget_PhotoAlbumViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->album = $album = Engine_Api::_()->core()->getSubject();
    $group_id = $album->group_id;
    if(!$album->getIdentity())
      return $this->setNoRender();
    $this->view->group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
	}
}