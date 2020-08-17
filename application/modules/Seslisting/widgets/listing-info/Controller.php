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

class Seslisting_Widget_ListingInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();

    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
		$customMetaFields = $this->view->customMetaFields = Engine_Api::_()->seslisting()->getCustomFieldMapDataListing($subject);
    if (!count($customMetaFields)) {
      return $this->setNoRender();
    }
  }
}
