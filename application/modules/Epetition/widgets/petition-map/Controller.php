<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_PetitionMapController extends Engine_Content_Widget_Abstract {

  public function indexAction()
  {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.location', 1)) {
      return $this->setNoRender();
    }
    
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->locationLatLng =  $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($subject->getType(),$subject->getIdentity());
		
    if ((!$subject->location && is_null($subject->location)) || !$locationLatLng) {
      return $this->setNoRender();
    }
  }
}
