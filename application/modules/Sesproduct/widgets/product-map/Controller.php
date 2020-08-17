<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_ProductMapController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1))
      return $this->setNoRender();
      
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)) {
      return $this->setNoRender();
    }

    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->locationLatLng =  $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($subject->getType(),$subject->getIdentity());

    if ((!$subject->location && is_null($subject->location)) || !$locationLatLng) {
      return $this->setNoRender();
    }
  }
}
