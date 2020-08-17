<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_GutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only seslisting or user as subject
    if( Engine_Api::_()->core()->hasSubject('seslisting') ) {
      $this->view->seslisting = $seslisting = Engine_Api::_()->core()->getSubject('seslisting');
      $this->view->owner = $owner = $seslisting->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->seslisting = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }

    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seslisting_gutter');
  }
}
