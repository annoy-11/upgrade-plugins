<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_GutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only sesrecipe or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesrecipe_recipe') ) {
      $this->view->sesrecipe = $sesrecipe = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
      $this->view->owner = $owner = $sesrecipe->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesrecipe = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
    
    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesrecipe_gutter');
  }
}
