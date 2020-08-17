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

class Sesrecipe_Widget_RecipeInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
		$customMetaFields = $this->view->customMetaFields = Engine_Api::_()->sesrecipe()->getCustomFieldMapDataRecipe($subject);
    if (!count($customMetaFields)) {
      return $this->setNoRender();
    }
  }
}