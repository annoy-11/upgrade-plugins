<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Widget_GutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only discussion or user as subject
    if( Engine_Api::_()->core()->hasSubject('discussion') ) {
      $this->view->discussion = $discussion = Engine_Api::_()->core()->getSubject('discussion');
      $this->view->owner = $owner = $discussion->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->discussion = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }

    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesdiscussion_gutter');
  }
}
