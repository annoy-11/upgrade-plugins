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

class Sesrecipe_Widget_ReviewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('sesrecipe_review'))
      return $this->setNoRender();

    $this->view->review = $review = $coreApi->getSubject('sesrecipe_review');
    $this->view->content_item = Engine_Api::_()->getItem('sesrecipe_recipe', $review->recipe_id);
  }

}
