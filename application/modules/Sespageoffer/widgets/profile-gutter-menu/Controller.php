<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Widget_ProfileGutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only offer or user as subject
    if( Engine_Api::_()->core()->hasSubject('pageoffer') ) {
      $this->view->offer = $offer = Engine_Api::_()->core()->getSubject('pageoffer');
      $this->view->owner = $owner = $offer->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->offer = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }

    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sespageoffer_gutter');
  }
}
