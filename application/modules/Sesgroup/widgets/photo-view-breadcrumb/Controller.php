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
 
class Sesgroup_Widget_PhotoViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
    $group_id = $photo->group_id;
    $album_id = $photo->album_id;
    if(!$photo->getIdentity())
      return $this->setNoRender();
      
    $this->view->album = Engine_Api::_()->getItem('sesgroup_album', $album_id);
    $this->view->group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    
	}
}