<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_JobContactInformationController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sesjob_job');
    if (!$subject) {
      return $this->setNoRender();
    }
		$this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website'));
		if(!$subject->job_contact_name && !$subject->job_contact_email && !$subject->job_contact_phone && !$subject->job_contact_website && !$subject->job_contact_facebook && !$subject->job_contact_twitter && !$subject->job_contact_linkedin)
			 return $this->setNoRender();

    $this->view->subject = $subject;
  }
}
