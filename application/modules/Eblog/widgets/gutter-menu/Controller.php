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

class Eblog_Widget_GutterMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if(!Engine_Api::_()->core()->hasSubject('eblog_blog'))
      return $this->setNoRender();
    
    $this->view->gutterNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_gutter');
  }
}
