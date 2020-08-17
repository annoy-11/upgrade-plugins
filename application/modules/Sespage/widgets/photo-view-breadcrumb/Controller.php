<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_PhotoViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->photo = $photo = Engine_Api::_()->core()->getSubject();
    $page_id = $photo->page_id;
    $album_id = $photo->album_id;
    if(!$photo->getIdentity())
      return $this->setNoRender();
      
    $this->view->album = Engine_Api::_()->getItem('sespage_album', $album_id);
    $this->view->page = Engine_Api::_()->getItem('sespage_page', $page_id);
    
	}
}