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

class Sesarticle_Widget_ArticleContactInformationController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sesarticle');
    if (!$subject) {
      return $this->setNoRender();
    }
		$this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website'));
		if(!$subject->article_contact_name && !$subject->article_contact_email && !$subject->article_contact_phone && !$subject->article_contact_website && !$subject->article_contact_facebook && !$subject->article_contact_twitter && !$subject->article_contact_linkedin)
			 return $this->setNoRender();

    $this->view->subject = $subject;
  }
}
