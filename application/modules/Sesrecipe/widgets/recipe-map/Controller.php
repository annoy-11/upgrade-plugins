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

class Sesrecipe_Widget_RecipeMapController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)) {
      return $this->setNoRender();
    }
    
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->locationLatLng =  $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($subject->getType(),$subject->getIdentity());
		
    if ((!$subject->location && is_null($subject->location)) || !$locationLatLng) {
      return $this->setNoRender();
    }
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1))
      return $this->setNoRender();
  }
}
