<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileMapController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.location', 1)) {
      return $this->setNoRender();
    }

    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->location =  $location = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($subject->getType(),$subject->getIdentity());

    if ((!$subject->location && is_null($subject->location)) || !$location) {
      return $this->setNoRender();
    }
  }
}
