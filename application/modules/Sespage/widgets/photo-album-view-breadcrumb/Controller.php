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
 
class Sespage_Widget_PhotoAlbumViewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->album = $album = Engine_Api::_()->core()->getSubject();
    $page_id = $album->page_id;
    if(!$album->getIdentity())
      return $this->setNoRender();
    $this->view->page = Engine_Api::_()->getItem('sespage_page', $page_id);
	}
}