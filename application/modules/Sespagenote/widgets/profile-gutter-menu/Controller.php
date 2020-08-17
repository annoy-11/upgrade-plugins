<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Widget_ProfileGutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only note or user as subject
    if( Engine_Api::_()->core()->hasSubject('pagenote') ) {
      $this->view->note = $note = Engine_Api::_()->core()->getSubject('pagenote');
      $this->view->owner = $owner = $note->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->note = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }

    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sespagenote_gutter');
  }
}
