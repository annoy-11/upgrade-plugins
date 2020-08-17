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

class Seslisting_Widget_ListingContactInformationController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('seslisting');
    if (!$subject) {
      return $this->setNoRender();
    }
		$this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website'));
		if(!$subject->listing_contact_name && !$subject->listing_contact_email && !$subject->listing_contact_phone && !$subject->listing_contact_website && !$subject->listing_contact_facebook && !$subject->listing_contact_twitter && !$subject->listing_contact_linkedin)
			 return $this->setNoRender();

    $this->view->subject = $subject;
  }
}
