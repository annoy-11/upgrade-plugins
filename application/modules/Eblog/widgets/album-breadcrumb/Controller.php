<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_AlbumBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (!Engine_Api::_()->core()->hasSubject('eblog_album'))
      return $this->setNoRender();
      
    $this->view->album = Engine_Api::_()->core()->getSubject('eblog_album');
    $this->view->content_item = Engine_Api::_()->getItem('eblog_blog', $this->view->album->blog_id);
    $this->view->tab_id = Engine_Api::_()->sesbasic()->getWidgetTabId(array('name' => 'eblog.profile-photos'));
  }
}
