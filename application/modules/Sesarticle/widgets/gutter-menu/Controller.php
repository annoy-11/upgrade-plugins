<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Widget_GutterMenuController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Only sesarticle or user as subject
    if( Engine_Api::_()->core()->hasSubject('sesarticle') ) {
      $this->view->sesarticle = $sesarticle = Engine_Api::_()->core()->getSubject('sesarticle');
      $this->view->owner = $owner = $sesarticle->getOwner();
    } else if( Engine_Api::_()->core()->hasSubject('user') ) {
      $this->view->sesarticle = null;
      $this->view->owner = $owner = Engine_Api::_()->core()->getSubject('user');
    } else {
      return $this->setNoRender();
    }
    
    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_gutter');
  }
}
