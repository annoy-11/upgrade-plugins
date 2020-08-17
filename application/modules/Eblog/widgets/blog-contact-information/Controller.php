<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_BlogContactInformationController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('eblog_blog');
    if (!$subject)
      return $this->setNoRender();
      
		$this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website'));
		
		if(!$subject->blog_contact_name && !$subject->blog_contact_email && !$subject->blog_contact_phone && !$subject->blog_contact_website && !$subject->blog_contact_facebook)
			 return $this->setNoRender();
  }
}
