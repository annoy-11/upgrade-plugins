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

class Sesrecipe_Widget_RecipeContactInformationController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sesrecipe_recipe');
    if (!$subject) {
      return $this->setNoRender();
    }
		$this->view->info = $this->_getParam('show_criteria',array('name','email','phone','facebook','linkedin','twitter','website'));
		if(!$subject->recipe_contact_name && !$subject->recipe_contact_email && !$subject->recipe_contact_phone && !$subject->recipe_contact_website && !$subject->recipe_contact_facebook && !$subject->recipe_contact_twitter && !$subject->recipe_contact_linkedin)
			 return $this->setNoRender();

    $this->view->subject = $subject;
  }
}
